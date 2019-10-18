<?php

namespace App\Http\Controllers;

use App\Events\NewBornEvent;
use App\Events\RequestPoinEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Ixudra\Curl\Facades\Curl;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        abort(403, 'Only For Testing Purpose');
//        broadcast(new NewBornEvent(1));
    }

    public function test()
    {
//        Curl::to('https://sik.tabalongkab.go.id/api/broadcast/born')
//            ->asJson()
//            ->post();
        abort(403, 'Only For Testing Purpose');
//        Artisan::call('reset:app');
//        broadcast(new RequestPoinEvent());
    }

    public function broadcast($event)
    {
        if ($event == 'poin') {
            broadcast(new RequestPoinEvent());
        } else {
            broadcast(new NewBornEvent());
        }
    }
}

