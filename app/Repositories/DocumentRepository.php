<?php

namespace App\Repositories;

use App\Repositories\Traits\WithSingleColumnUpdate;
use App\Services\LogService;
use Illuminate\Support\Facades\DB;
use Storage;
use Str;

class DocumentRepository
{
    use WithSingleColumnUpdate;

    private $table = 'documents';

    private $baseQuery;

    public function __construct()
    {
        $this->baseQuery = DB::table($this->table)
            ->leftJoin('document_types', 'document_types.id', '=', 'documents.document_type_id')
            ->leftJoin('folders', 'folders.id', '=', 'documents.folder_id')
            ->select(
                $this->table . '.id AS id',
                $this->table . '.note AS description',
                $this->table . '.note AS note',
                $this->table . '.number AS number',
                $this->table . '.date AS date',
                $this->table . '.path AS path',
                $this->table . '.filename AS filename',
                $this->table . '.validity_start AS validityStart',
                $this->table . '.validity_end AS validityEnd',
                'document_types.id AS documentTypeId',
                'document_types.description AS documentTypeDescription',
                'folders.id AS folderId',
                'folders.description AS folderDescription',
                $this->table . '.created_at AS createdAt',
                $this->table . '.updated_at AS updatedAt',
                DB::raw('(SELECT GROUP_CONCAT(tag) FROM document_tags WHERE document_id = documents.id) AS tags'),
                DB::raw('(SELECT GROUP_CONCAT(persons.name) FROM `document_persons` INNER JOIN persons ON document_persons.person_id = persons.id
                             WHERE document_id = documents.id) AS persons')
            );
    }

    public function all(string $search = null, string $sortBy = 'id', string $sortDirection = 'asc', string $perPage = '30')
    {
        return $this->baseQuery
            ->having($this->table . '.id', 'like', '%' . $search . '%')
            ->orHaving($this->table . '.note', 'like', '%' . $search . '%')
            ->orHaving($this->table . '.number', 'like', '%' . $search . '%')
            ->orHavingRaw('tags like ?', ['%' . $search . '%'])
            ->orHavingRaw('persons like ?', ['%' . $search . '%'])
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage);
    }

    public function allWithFilter(array $filter = [], string $sortBy = 'id', string $sortDirection = 'asc', string $perPage = '30')
    {
        $query = DB::table($this->table)
            ->leftJoin('document_types', 'document_types.id', '=', 'documents.document_type_id')
            ->leftJoin('folders', 'folders.id', '=', 'documents.folder_id')
            ->select(
                $this->table . '.id AS id',
                $this->table . '.note AS description',
                $this->table . '.note AS note',
                $this->table . '.number AS number',
                $this->table . '.date AS date',
                $this->table . '.path AS path',
                $this->table . '.filename AS filename',
                $this->table . '.validity_start AS validityStart',
                $this->table . '.validity_end AS validityEnd',
                'document_types.id AS documentTypeId',
                'document_types.description AS documentTypeDescription',
                $this->table . '.folder_id AS folderId',
                'folders.description AS folderDescription',
                $this->table . '.created_at AS createdAt',
                $this->table . '.updated_at AS updatedAt',
                DB::raw('(SELECT GROUP_CONCAT(tag) FROM document_tags WHERE document_id = documents.id) AS tags'),
                DB::raw('(SELECT GROUP_CONCAT(persons.name) FROM `document_persons` INNER JOIN persons ON document_persons.person_id = persons.id
                             WHERE document_id = documents.id) AS persons')
            );

        $query = $query->having($this->table . '.note', 'like', '%' . $filter['note'] . '%');

        if (isset($filter['number'])) {
            $query = $query->having($this->table . '.number', 'like', '%' . $filter['number'] . '%');
        }

        if (isset($filter['date'])) {
            $query = $query->having($this->table . '.date', 'like', '%' . $filter['date'] . '%');
        }

        if (isset($filter['validityStart'])) {
            $query = $query->having($this->table . '.validity_start', 'like', '%' . $filter['validityStart'] . '%');
        }

        if (isset($filter['validityEnd'])) {
            $query = $query->having($this->table . '.validity_end', 'like', '%' . $filter['validityEnd'] . '%');
        }

        if (isset($filter['documentTypeId'])) {
            $query = $query->having('document_types.id', '=', $filter['documentTypeId']);
        }

        if (isset($filter['folderId'])) {
            $query = $query->having($this->table . '.folder_id', '=', $filter['folderId']);
        }

        if (isset($filter['person'])) {
            $query = $query->havingRaw('persons like ?', ['%' . $filter['person'] . '%']);
        }

        if (count($filter['tags']) > 0) {

            $tag = '';

            foreach ($filter['tags'] as $key => $value) {
                $tag = $tag . ',' . $value;
            }

            $query = $query->havingRaw('tags like ?', ['%' . $tag . '%']);
        }

        return $query
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage);
    }

    public function allSimplified()
    {
        return $this->baseQuery->get();
    }

    public function save($data)
    {

        LogService::saveLog(
            session()->get('userId'),
            $this->table,
            'I',
            date('Y-m-d H:i:s'),
            json_encode($data),
            null
        );

        $path = $this->uploadFile($data['file']);

        $registerId = DB::table($this->table)
            ->insertGetId(
                [
                    'note' => $data['note'],
                    'number' => isset($data['number']) ? $data['number'] : null,
                    'date' => isset($data['date']) ? $data['date'] : null,
                    'path' => $path,
                    'filename' => $data['file']->getClientOriginalName(),
                    'validity_start' => isset($data['validityStart']) ? $data['validityStart'] : null,
                    'validity_end' => isset($data['validityEnd']) ? $data['validityEnd'] : null,
                    'document_type_id' => isset($data['documentTypeId']) ? $data['documentTypeId'] : null,
                    'folder_id' => isset($data['folderId']) ? $data['folderId'] : null,
                    'user_id' => session()->get('userId'),
                    'created_at' => now(),
                ]
            );

        if (isset($data['tags'])) {
            $this->insertTags($data['tags'], $registerId);
        }

        if (isset($data['persons'])) {
            $this->insertPersons($data['persons'], $registerId);
        }

        return $registerId;
    }

    public function update($data)
    {
        $oldData = $this->findById($data['recordId']);

        LogService::saveLog(
            session()->get('userId'),
            $this->table,
            'U',
            date('Y-m-d H:i:s'),
            json_encode($oldData),
            json_encode($data)
        );

        if (isset($data['file'])) {
            $path = $this->uploadFile($data['file']);
            $filename = $data['file']->getClientOriginalName();
        } else {
            $path = $data['storedFilePath'];
            $filename = $data['storedFilename'];
        }

        DB::table($this->table)
            ->where('id', $data['recordId'])
            ->update(
                [
                    'note' => $data['note'],
                    'number' => isset($data['number']) ? $data['number'] : null,
                    'date' => isset($data['date']) ? $data['date'] : null,
                    'path' => $path,
                    'filename' => $filename,
                    'validity_start' => isset($data['validityStart']) ? $data['validityStart'] : null,
                    'validity_end' => isset($data['validityEnd']) ? $data['validityEnd'] : null,
                    'document_type_id' => isset($data['documentTypeId']) ? $data['documentTypeId'] : null,
                    'folder_id' => isset($data['folderId']) ? $data['folderId'] : null,
                    'updated_at' => now(),
                ]
            );

        if (isset($data['tags'])) {
            $this->insertTags($data['tags'], $data['recordId']);
        }

        if (isset($data['persons'])) {
            $this->insertPersons($data['persons'], $data['recordId']);
        }
    }

    public function delete($data)
    {
        $oldData = $this->findById($data['recordId']);

        LogService::saveLog(
            session()->get('userId'),
            $this->table,
            'D',
            date('Y-m-d H:i:s'),
            json_encode($oldData),
            null
        );

        $document = DB::table($this->table)
            ->where('id', $data['recordId'])
            ->select('path')
            ->get()
            ->first();

        Storage::disk('s3')->delete($document->path);

        DB::table('document_tags')
            ->where('document_id', $data['recordId'])
            ->delete();

        DB::table($this->table)
            ->where('id', $data['recordId'])
            ->delete();
    }

    public function findById($id)
    {
        $document = $this->baseQuery
            ->where($this->table . '.id', $id)
            ->get()
            ->first();

        $tags = DB::table('document_tags')
            ->where('document_tags.document_id', $id)
            ->select(
                'document_tags.tag AS tag',
            )->get();

        $document->tags = $tags;

        $persons = DB::table('document_persons')
            ->join('persons', 'persons.id', '=', 'document_persons.person_id')
            ->where('document_persons.document_id', $id)
            ->select(
                'persons.id AS id',
                'persons.name AS name',
            )->get();

        $document->persons = $persons;

        return $document;
    }

    private function uploadFile($file)
    {
        $path = '_ged/cacequicm/documentos';

        $filename = Str::random(4) . '_' . $file->getClientOriginalName();

        // Salva localmente o arquivo também
        Storage::putFileAs($path, $file, $filename);

        return Storage::disk('s3')->putFileAs($path, $file, $filename, 'public');
    }

    private function insertTags($tags, $documentId)
    {
        DB::table('document_tags')
            ->where('document_id', $documentId)
            ->delete();

        foreach ($tags as $tag) {
            DB::table('document_tags')
                ->insert(
                    [
                        'document_id' => $documentId,
                        'tag' => $tag,
                        'user_id' => session()->get('userId'),
                        'created_at' => now(),
                    ]
                );
        }
    }

    private function insertPersons($persons, $documentId)
    {
        DB::table('document_persons')
            ->where('document_id', $documentId)
            ->delete();

        foreach ($persons as $person) {
            DB::table('document_persons')
                ->insert(
                    [
                        'document_id' => $documentId,
                        'person_id' => $person['id'],
                        'user_id' => session()->get('userId'),
                        'created_at' => now(),
                    ]
                );
        }
    }

    public function totalDocumentsByFilter($users = [], $initialDate, $finalDate)
    {
        $query = DB::table('documents')
            ->whereBetween('created_at', [$initialDate, $finalDate]);

        if (count($users) > 0) {
            $query = $query->whereIn('user_id', $users);
        }

        return $query->count();
    }
}
