<?php

namespace App\Repositories;


use App\Model\Arsip;
use App\Model\Berita;
use App\Model\Bidan;
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

    public static function getHistory($page, $bidan_id)
    {
        $limit = 6;
        $skip = ($page - 1) * $limit;

        $process = PregnancyProcessDetail::select(DB::raw('_process_detail.ppd_id as id
            , _process_detail.ppd_note as note
            ,_process_detail.ppd_point as point
            ,_process_detail.ppd_status as status
            ,_process_detail.ppd_date as date
            ,_process_detail.created_at as date_order
            ,_pregnancy_process.pp_noktp_ibu as nik_patient
            ,_pregnancy_process.pp_nama_ibu as name_patient'))
            ->join('_pregnancy_process', '_process_detail.pp_id', '=', '_pregnancy_process.pp_id')
            ->where('_process_detail.bidan_id', $bidan_id);

        $data = Reward::select(DB::raw("_reward.reward_id as id
            , '-' as note
            ,_reward.reward_point as point
            , 'reward' as status
            ,_reward.reward_date as date
            ,_reward.created_at as date_order
            , '-' as nik_patient
            , '-' as name_patient"))
            ->where('_reward.bidan_id', $bidan_id)
            ->where('_reward.reward_status', 'verify')
            ->union($process)
            ->skip($skip)
            ->take($limit)
            ->orderBy('date_order', 'DESC')
            ->get();

        return $data;
    }

    public static function sortRewardByStatus($status)
    {
//        $tickets = Ticket::whereHas('user', function ($query) use ($request) {
//            $query->where('name', 'like', "%{$request->name}%");
//        });
        return Reward::with('bidan')
            ->where('reward_status', $status)
            ->latest();
    }
}