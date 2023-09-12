<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $logged = $this->makeAuth($request->login, sha1(strtoupper($request->password)));

        if ($logged) {
            Session::put('isLogged', true);

            return redirect()->route('dashboard');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Nome de usuário ou senha incorretos!');
        }
    }

    public function makeAuth($login, $password)
    {
        $user = DB::table('users')
            ->where('login', '=', $login)
            ->where('password', '=', $password)->get()->first();

        if ($user != null) {
            Session::put('userId', $user->id);
            Session::put('username', $user->name);
        }

        return $user != null;
    }

    public function logout()
    {
        session_start();

        session_destroy();

        session()->flush();

        return redirect()
            ->route('login')
            ->with('success', 'Log out realizado com sucesso!');
    }
}
