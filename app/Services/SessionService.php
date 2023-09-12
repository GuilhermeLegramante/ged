<?php

namespace App\Services;

class SessionService
{
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['idusuario'])) {
            session()->put('userId', $_SESSION['idusuario']);

            session()->put('username', $_SESSION['nomeusuario']);

            session()->put('client', $_SESSION['cliente']);
        }
    }
}
