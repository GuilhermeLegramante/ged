<?php

namespace App\Http\Controllers;

class PersonController extends Controller
{
    public function table()
    {
        return view('parent.person-table');
    }
}
