<?php

namespace App\Repositories;

use DB;

class ProductivityResumeRepository
{

    public function getReportData($users = [], $initialDate, $finalDate, $groupedByUser = false)
    {
        $query = DB::table('documents')
            ->join('users', 'users.id', '=', 'documents.user_id')
            ->whereBetween('documents.created_at', [$initialDate, $finalDate]);

        if (count($users) > 0) {
            $query = $query->whereIn('documents.user_id', $users);
        }

        $query = $query->select(
            'documents.id AS id',
            'documents.note AS description',
            'documents.number AS number',
            'documents.created_at AS createdAt',
            'users.name AS username',
        )->get();

        if($groupedByUser){
          return $query->groupBy('username');
        } else {
            return $query;
        }
    }
}
