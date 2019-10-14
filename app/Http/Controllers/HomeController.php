<?php

namespace App\Http\Controllers;

use App\Events\NewBornEvent;
use App\Events\RequestPoinEvent;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        broadcast(new NewBornEvent(1));
    }

    public function test()
    {
        Curl::to('https://sik.tabalongkab.go.id/api/broadcast/born')
            ->asJson()
            ->post();
//        broadcast(new RequestPoinEvent());
    }

    public function broadcast($event)
    {
//        sendMessage();
        if ($event == 'poin') {
            broadcast(new RequestPoinEvent());
        } else {
            broadcast(new NewBornEvent());
        }
//        return "Test Helper";
    }
}

