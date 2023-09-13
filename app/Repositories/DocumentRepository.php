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
            ->select(
                $this->table . '.id AS id',
                $this->table . '.note AS description',
                $this->table . '.number AS number',
                $this->table . '.date AS date',
                $this->table . '.path AS path',
                $this->table . '.filename AS filename',
                'document_types.id AS documentTypeId',
                'document_types.description AS documentTypeDescription',
                $this->table . '.created_at AS createdAt',
                $this->table . '.updated_at AS updatedAt',
            );
    }

    public function all(string $search = null, string $sortBy = 'id', string $sortDirection = 'asc', string $perPage = '30')
    {
        return $this->baseQuery
            ->where([
                [$this->table . '.id', 'like', '%' . $search . '%'],
            ])
            ->orWhere([
                [$this->table . '.note', 'like', '%' . $search . '%'],
            ])
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

        $registerId = DB::table($this->table)
            ->insertGetId(
                [
                    'note' => $data['note'],
                    'number' => isset($data['number']) ? $data['number'] : null,
                    'date' => isset($data['date']) ? $data['date'] : null,
                    'path' => $data['path'],
                    'filename' => isset($data['filename']) ? $data['filename'] : null,
                    'document_type_id' => isset($data['document_type_id']) ? $data['document_type_id'] : null,
                    'user_id' => session()->get('userId'),
                    'created_at' => now(),
                ]
            );

        if (isset($data['tags'])) {
            $this->insertTags($data['tags'], $data['recordId']);
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

        $path = $this->uploadFile($data['file']);

        DB::table($this->table)
            ->where('id', $data['recordId'])
            ->update(
                [
                    'note' => $data['note'],
                    'number' => isset($data['number']) ? $data['number'] : null,
                    'date' => isset($data['date']) ? $data['date'] : null,
                    'path' => $path,
                    'filename' => isset($data['filename']) ? $data['file'] : null,
                    'document_type_id' => isset($data['document_type_id']) ? $data['document_type_id'] : null,
                    'updated_at' => now(),
                ]
            );

        if (isset($data['tags'])) {
            $this->insertTags($data['tags'], $data['recordId']);
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

        DB::table($this->table)
            ->where('id', $data['recordId'])
            ->delete();
    }

    public function findById($id)
    {
        return $this->baseQuery
            ->where($this->table . '.id', $id)
            ->get()
            ->first();
    }

    private function uploadFile($file)
    {
        $path = '_ged/cacequicm/documentos';

        $filename = Str::random(4) . '_' . $file->getClientOriginalName();

        return Storage::disk('s3')->putFileAs($path, $file, $filename);
    }

    private function insertTags($tags, $documentId)
    {
        DB::table('document_tags')
            ->where('document_id', $documentId)
            ->delete();

        foreach ($tags as $key => $tag) {
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
}
