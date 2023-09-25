<?php

namespace App\Http\Controllers;

use Http;
use Illuminate\Routing\Controller;

class MainController extends Controller
{
    public function dashboard()
    {
        // return view('dashboard');
        return redirect()->route('document.table');
    }
}
