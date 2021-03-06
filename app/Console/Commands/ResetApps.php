<?php

namespace App\Console\Commands;

use App\Model\Arsip;
use App\Model\ArsipDetail;
use App\Model\Bidan;
use App\Model\PregnancyProcess;
use App\Model\PregnancyProcessDetail;
use App\Model\Reward;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ResetApps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:app';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset Application';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        User::truncate();
//        Artisan::call("db:seed");
        Reward::truncate();
        PregnancyProcess::truncate();
        PregnancyProcessDetail::truncate();
        Bidan::truncate();
        User::where('user_level', 'bidan')->delete();
    }
}
