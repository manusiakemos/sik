<?php
/**
 * Created by PhpStorm.
 * User: MrCatz
 * Date: 04/10/18
 * Time: 12.31
 */

namespace App\Http\Controllers\api_query;

use Illuminate\Support\Facades\DB;
use Ixudra\Curl\Facades\Curl;

class NotificationQuery extends BaseQuery
{

    const API_KEY = "AIzaSyDkKUog0COXivrdok0eylkecRuyEfR3gTo";
    var $title = "title";
    var $body = "body";
    var $cat = "cat";
    var $type = "type";
    var $dataId = "dataId";
    var $value = "value";
    var $keyValue = "keyValue";
    var $typeValue = "typeValue";
    var $method = "method";

    function send_notif_single($pegawai_id)
    {

        $ios_notif = $this->send_notif_single_by_channel($pegawai_id,"ios");
        $android_notif = $this->send_notif_single_by_channel($pegawai_id,"android");

        return array('ios' => $ios_notif,'android' => $android_notif);

    }

    function send_notif_multi($pegawai_id_array = array())
    {

        $ios_notif = $this->send_notif_multi_by_channel($pegawai_id_array,"ios");
        $android_notif = $this->send_notif_multi_by_channel($pegawai_id_array,"android");

        return array('ios' => $ios_notif,'android' => $android_notif);

    }

    function send_notif_all()
    {

        $ios_notif = $this->send_notif_all_by_channel("ios");
        $android_notif = $this->send_notif_all_by_channel("android");

        return array('ios' => $ios_notif,'android' => $android_notif);

    }

    function send_notif_by_skpd($skpd_id)
    {

        $ios_notif = $this->send_notif_by_skpd_by_channel($skpd_id, "ios");
        $android_notif = $this->send_notif_by_skpd_by_channel($skpd_id,"android");

        return array('ios' => $ios_notif,'android' => $android_notif);

    }

    private function send_notif_single_by_channel($pegawai_id, $channel = "android")
    {


        $data = DB::table('abs_login_session')
            ->where('pegawai_id', '=', $pegawai_id)
            ->where('app_id', '=', env('APP_ID'))
            ->where('ls_firebase_reg_id', '<>', null)
            ->where('ls_channel', '=', $channel)
            ->get();

        $code = array();
        if (COUNT($data) > 0) {
            for($i=0;$i<COUNT($data);$i++){
                $code[$i] = $data[$i]->ls_firebase_reg_id;
            }
        }

        return $this->post_notif($code, $channel);

    }

    private function send_notif_multi_by_channel($pegawai_id_array = array(), $channel = "android")
    {

        $data = DB::table('abs_login_session')
            ->whereIn('pegawai_id', $pegawai_id_array)
            ->where('app_id', '=', env('APP_ID'))
            ->where('ls_firebase_reg_id', '<>', null)
            ->where('ls_channel', '=', $channel)
            ->get();


        $code = array();
        if (COUNT($data) > 0) {
            for($i=0;$i<COUNT($data);$i++){
                $code[$i] = $data[$i]->ls_firebase_reg_id;
            }
        }


        return $this->post_notif($code, $channel);

    }

    private function send_notif_all_by_channel($channel = "android")
    {

        $data = DB::table('abs_login_session')
            ->where('app_id', '=', env('APP_ID'))
            ->where('ls_firebase_reg_id', '<>', null)
            ->where('ls_channel', '=', $channel)
            ->get();

        $code = array();
        if (COUNT($data) > 0) {
            for($i=0;$i<COUNT($data);$i++){
                $code[$i] = $data[$i]->ls_firebase_reg_id;
            }
        }


        return $this->post_notif($code, $channel);

    }

    private function send_notif_by_skpd_by_channel($skpd_id, $channel = "android")
    {

        $data = DB::table('abs_login_session')
            ->join('tb_pegawai','abs_login_session.pegawai_id','=','tb_pegawai.pegawai_id')
            ->where('tb_pegawai.skpd_id', '=', $skpd_id)
            ->where('abs_login_session.app_id', '=', env('APP_ID'))
            ->where('abs_login_session.ls_firebase_reg_id', '<>', null)
            ->where('abs_login_session.ls_channel', '=', $channel)
            ->get();

        $code = array();
        if (COUNT($data) > 0) {
            for($i=0;$i<COUNT($data);$i++){
                $code[$i] = $data[$i]->ls_firebase_reg_id;
            }
        }


        return $this->post_notif($code, $channel);

    }

    private function post_notif($fcm_code_pegawai = array(), $channel = "android")
    {

        $result = array();

        $dataSlice = array_chunk($fcm_code_pegawai,1000);
        for($i=0;$i<COUNT($dataSlice);$i++){
            $dataToSend = $dataSlice[$i];

            if($channel == "android"){

                $message = array("priority" => "high",
                    "mutable_content" => true,
                    "data" => array(
                        "title" => $this->title,
                        "text" => $this->body,
                        "cat" => $this->cat,
                        "type" => $this->type,
                        "dataId" => $this->dataId,
                        "value" => $this->value,
                        "keyValue" => $this->keyValue,
                        "typeValue" => $this->typeValue,
                        "method" => $this->method
                    ),
                    "registration_ids" => $dataToSend

                );

            }else{

                $message = array("priority" => "high",
                    "mutable_content" => true,
                    "notification" => array(
                        "title" => $this->title,
                        "body" => $this->body
                    ),
                    "data" => array(
                        "title" => $this->title,
                        "text" => $this->body,
                        "cat" => $this->cat,
                        "type" => $this->type,
                        "dataId" => $this->dataId,
                        "value" => $this->value,
                        "keyValue" => $this->keyValue,
                        "typeValue" => $this->typeValue,
                        "method" => $this->method
                    ),
                    "registration_ids" => $dataToSend

                );

            }



            $response = Curl::to('https://fcm.googleapis.com/fcm/send')
                ->withHeader('Content-Type: application/json')
                ->withHeader('Authorization: key = ' . self::API_KEY)
                ->withData($message)
                ->asJson()
                ->post();

            $result[$i] = $response;


        }

        if(COUNT($result) == 0){
            return array('status' => false,'text' => 'semua pegawai tidak login!');
        }

        return $result;

    }

}