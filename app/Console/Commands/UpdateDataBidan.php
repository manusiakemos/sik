<?php

namespace App\Console\Commands;

use App\Model\Bidan;
use App\Model\Kelurahan;
use App\Model\Puskesmas;
use Illuminate\Console\Command;

class UpdateDataBidan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bidan:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Data Bidan';

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
//        ambil data bidan
        $bidans  = Bidan::where('bidan_id', '>', 11)->get();

        foreach ($bidans as $bidan){
            $db = Bidan::find($bidan->bidan_id);
            if($db->puskesmas_id == 0){
                $kelurahan = Kelurahan::find($db->kelurahan_id);
                $puskesmas = Puskesmas::where('kecamatan_id', $kelurahan->kecamatan_id)->first();
            }else{
                $puskesmas = Puskesmas::find($db->puskesmas_id);
            }
            $db->scopes_puskesmas_id = $puskesmas->puskesmas_id;
            $db->save();
        }
    }
}
