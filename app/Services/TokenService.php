<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class TokenService
{
    public static function getToken($userId)
    {
        $user = DB::table('hsglb_usuarios')
            ->where('IDUSUARIO', $userId)
            ->select('hsglb_usuarios.TOKENWEB AS token')
            ->get()
            ->first();

        return isset($user) ? $user->token : null;
    }
}
