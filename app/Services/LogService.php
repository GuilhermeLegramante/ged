<?php

namespace App\Services;

use File;
use Illuminate\Support\Facades\DB;

class LogService
{
    public static function saveLog($userId, $table, $operation, $datetime, $originalData, $modifiedData)
    {
        File::append(
            storage_path('/logs/operations.log'),
            '[' . $datetime . ']' . PHP_EOL .
            'ID DO USUÁRIO: ' . $userId . PHP_EOL .
            'TABELA: ' . $table . PHP_EOL .
            'OPERAÇÃO: ' . $operation . PHP_EOL .
            'DADOS ORIGINAIS: ' . $originalData . PHP_EOL .
            'DADOS MODIFICADOS: ' . $modifiedData . PHP_EOL . PHP_EOL
        );
    }

    public static function query()
    {
        DB::listen(function ($query) {
            File::append(
                storage_path('/logs/query.log'),
                '[' . date('Y-m-d H:i:s') . ']' . PHP_EOL . $query->sql . ' [' . implode(', ', $query->bindings) . ']' . PHP_EOL . PHP_EOL
            );
        });
    }
}
