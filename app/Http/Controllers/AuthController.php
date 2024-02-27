<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use DB;
use Illuminate\Support\Facades\Session;
use PDF;
use setasign\Fpdi\Fpdi;

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

    public function countPages()
    {
        // $file = readfile('https://hardsoft.s3.sa-east-1.amazonaws.com/_ged/cacequicm/documentos/t7bl_Contrato%20GED%20Cacequi%20CM.pdf');

        // $number = preg_match_all("/\/Page\W/", $file, $dummy);
        // dd('$number');

        // dd($file);

        // $pdf = PDF::loadFile($file);

        // dd($pdf);
    }
}
