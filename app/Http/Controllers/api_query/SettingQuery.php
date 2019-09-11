<?php
/**
 * Created by PhpStorm.
 * User: MrCatz
 * Date: 21/11/17
 * Time: 13.12
 */

namespace App\Http\Controllers\api_query;
use Illuminate\Support\Facades\DB;

class SettingQuery
{

    function get_value($type = '',$name){

        if($type==''){
            $type = 'General';
        }


        $setting = DB::table('_setting')
            ->where('setting_type','=',$type)
            ->where('setting_name','=',$name)
            ->first();

        return $setting->setting_value;

    }


}