<?php

namespace App\Http\Controllers;

use App\Events\NewBornEvent;
use App\Events\RequestPoinEvent;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(Request $request)
    {
       broadcast(new NewBornEvent(1));
    }

    public function test()
    {
//        sendMessage();
        broadcast(new RequestPoinEvent());
//        return "Test Helper";
    }
}

