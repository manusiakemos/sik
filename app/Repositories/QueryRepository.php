<?php

namespace App\Repositories;


use App\Model\Arsip;
use App\Model\Berita;
use App\Model\Kecamatan;
use App\Model\Kelurahan;
use App\Model\PregnancyProcessDetail;
use App\Model\Reward;
use App\Model\Setting;
use Illuminate\Support\Facades\DB;

class QueryRepository
{
    public static function kelurahanTabalong()
    {
        return Kelurahan::tabalong();
    }

    public static function kecamatanTabalong()
    {
        return Kecamatan::where('kabupaten_id', 6309);
    }

    public static function sortRewardByBidan($bidan_id)
    {
        return Reward::where('bidan_id', $bidan_id);
    }

    public static function poinRewardCash($bidan_id)
    {
        $select = 'sum(reward_point) as cash';
        return Reward::selectRaw($select)->where("bidan_id", $bidan_id);
    }

    public static function poinRewardBalance($bidan_id)
    {
        $select = 'sum(ppd_point) as balance';
        return PregnancyProcessDetail::selectRaw($select)->where("bidan_id", $bidan_id);
    }

    public static function rewardSetting()
    {
        return Setting::where('setting_name', 'reward');
    }
}