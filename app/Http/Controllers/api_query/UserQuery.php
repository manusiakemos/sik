<?php

/**
 * Created by PhpStorm.
 * User: MrCatz
 * Date: 21/11/17
 * Time: 12.12
 */

namespace App\Http\Controllers\api_query;
use Illuminate\Support\Facades\DB;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserQuery extends BaseQuery
{

    var $bidan_id,$bidan_nik,$bidan_password;
    var $kk_ibu;
    var $no_kk ,$ktp_ibu,$nama_ibu,$ktp_ayah,$nama_ayah,$nama_anak,$jk_anak,$anak_ke,$alamat;
    var $puskesmas_id;

    function login(){

        $bidan = $this->MYSQL('_bidan')
            ->where('bidan_nik',$this->bidan_nik)
            ->first();

        if($bidan && Hash::check($this->bidan_password, $bidan->bidan_password)){
            return $bidan;
        }


        return false;

    }

    function get_puskesmas(){

        $puskesmas = $this->MYSQL('_puskesmas')
            ->leftJoin('_kecamatan','_puskesmas.kecamatan_id','=','_kecamatan.kecamatan_id')
            ->where('_puskesmas.puskesmas_id',$this->puskesmas_id)
            ->first();

        return $puskesmas;

    }

    function get_point(){

        $progress = $this->MYSQL('_process_detail')
            ->where('bidan_id',$this->bidan_id)
            ->sum('ppd_point');

        $reward = $this->MYSQL('_reward')
            ->where('bidan_id',$this->bidan_id)
            ->sum('reward_point');

        return (string) ($progress - $reward);

    }

    function get_progress(){

        $bidan = $this->MYSQL('_pregnancy_process')
            ->where('pp_noktp_ibu',$this->kk_ibu)
            ->get();

        return $bidan;

    }

    function check_process(){

        $data = $this->MYSQL('_pregnancy_process')
            ->where('pp_noktp_ibu',$this->kk_ibu)
            ->where('pp_status','=','new')
            ->first();

        return !$data;

    }

    function add_process(){

        $id = DB::table('_pregnancy_process')
            ->insertGetId(
                [
                    'pp_code' => "",
                    'pp_nokk' => $this->no_kk,
                    'pp_noktp_ibu' => $this->ktp_ibu,
                    'pp_nama_ibu' => $this->nama_ibu,
                    'pp_noktp_ayah' => $this->ktp_ayah,
                    'pp_nama_ayah' => $this->nama_ayah,
                    'pp_nama_anak' => $this->nama_anak,
                    'pp_jk_anak' => $this->jk_anak,
                    'pp_anak_ke' => $this->anak_ke,
                    'pp_alamat' => $this->alamat,
                    'pp_status' => 'new',
                    'created_by' => $this->bidan_id,
                    'created_at' => $this->now()
                ]
            );

        return $id;

    }

    function get_history($page){

        $limit = 6;
        $skip = ($page - 1) * $limit;

        $process = $this->MYSQL('_process_detail')
            ->select(DB::raw('_process_detail.ppd_id as id
            , _process_detail.ppd_note as note
            ,_process_detail.ppd_point as point
            ,_process_detail.ppd_status as status
            ,_process_detail.ppd_date as date
            ,_process_detail.created_at as date_order
            ,_pregnancy_process.pp_noktp_ibu as nik_patient
            ,_pregnancy_process.pp_nama_ibu as name_patient'))
            ->join('_pregnancy_process','_process_detail.pp_id','=','_pregnancy_process.pp_id')
            ->where('_process_detail.bidan_id',$this->bidan_id);

        $data = $this->MYSQL('_reward')
            ->select(DB::raw("_reward.reward_id as id
            , '-' as note
            ,_reward.reward_point as point
            , 'reward' as status
            ,_reward.reward_date as date
            ,_reward.created_at as date_order
            , '-' as nik_patient
            , '-' as name_patient"))
            ->where('_reward.bidan_id',$this->bidan_id)
            ->union($process)
            ->skip($skip)
            ->take($limit)
            ->orderBy('date_order','DESC')
            ->get();

        return $data;

    }






}