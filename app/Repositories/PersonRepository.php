<?php

namespace App\Repositories;

use App\Repositories\Traits\WithSingleColumnUpdate;
use App\Services\LogService;
use Illuminate\Support\Facades\DB;

class PersonRepository
{
    use WithSingleColumnUpdate;

    private $table = 'persons';

    private $baseQuery;

    public function __construct()
    {
        $this->baseQuery = DB::table($this->table)
            ->leftJoin('personal_documents', 'personal_documents.person_id', '=', 'persons.id')
            ->select(
                $this->table . '.id AS id',
                $this->table . '.name AS description',
                $this->table . '.name AS name',
                $this->table . '.email AS email',
                $this->table . '.phone AS phone',
                'personal_documents.number AS personalDocumentNumber',
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
                [$this->table . '.name', 'like', '%' . $search . '%'],
            ])
            ->orWhere([
                ['personal_documents.number', 'like', '%' . $search . '%'],
            ])
            ->orderBy($sortBy, $sortDirection)
            ->groupBy('personal_documents.id')
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
                    'name' => $data['name'],
                    'email' => isset($data['email']) ? $data['email'] : null,
                    'phone' => isset($data['phone']) ? $data['phone'] : null,
                    'user_id' => session()->get('userId'),
                    'created_at' => now(),
                ]
            );

        if (isset($data['document'])) {
            DB::table('personal_documents')
                ->insert(
                    [
                        'user_id' => session()->get('userId'),
                        'person_id' => $registerId,
                        'number' => $data['document'],
                        'created_at' => now(),
                    ]
                );
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

        DB::table($this->table)
            ->where('id', $data['recordId'])
            ->update(
                [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'user_id' => session()->get('userId'),
                    'updated_at' => now(),
                ]
            );

        if (isset($data['document'])) {
            DB::table('personal_documents')
                ->where('person_id', $data['recordId'])
                ->delete();

            DB::table('personal_documents')
                ->insert(
                    [
                        'user_id' => session()->get('userId'),
                        'person_id' => $data['recordId'],
                        'number' => $data['document'],
                        'created_at' => now(),
                    ]
                );
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

        DB::table('personal_documents')
            ->where('person_id', $data['recordId'])
            ->delete();

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
}
