<?php

namespace App\Repositories\Traits;

use App\Services\LogService;
use DB;

trait WithSingleColumnUpdate
{
    public function updateSingleColumn($data)
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
                    $data['columnName'] => $data['columnValue'],
                    'updated_at' => now(),
                ]
            );
    }
}
