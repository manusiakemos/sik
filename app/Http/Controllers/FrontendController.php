<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function admin()
    {
        return view('layouts.stisla_vue');
    }

    public function home()
    {
        return view('layouts.master');
    }

}
