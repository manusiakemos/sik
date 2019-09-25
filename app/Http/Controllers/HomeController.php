<?php

namespace App\Http\Controllers;

use App\Events\NewBornEvent;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(Request $request)
    {
       broadcast(new NewBornEvent(1));
    }
}
