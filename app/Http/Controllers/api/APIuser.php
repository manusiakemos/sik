<?php
/**
 * Created by PhpStorm.
 * User: MrCatz
 * Date: 21/11/17
 * Time: 11.30
 */

namespace App\Http\Controllers\api;

use App\Http\Controllers\api_query\NotificationQuery;
use App\Http\Controllers\Controller;
use App\Http\Controllers\api_query\UserQuery;
use App\Http\Controllers\api_query\SettingQuery;


use Illuminate\Http\Request;
use App\Http\Controllers\api_function\function_general;


class APIuser extends Controller {


    public function post(Request $request){

        $json = array();
        $user = new UserQuery();
        $setting = new SettingQuery();
        $util = new function_general();
        $notif = new NotificationQuery();

        $page = isset($request->page) ? $request->page : 1;

        if(isset($request->act)) {

            switch ($request->act) {

                case "tes":

                    $user->bidan_id = $request->bidan_id;
                    $json = $util->response(true, "tes");
                    $json['point'] = $user->get_point();
                    break;

                case "notif":

                    $notif->title = $request->title;
                    $notif->body = $request->body;
                    $notif->cat = $request->cat;
                    $notif->type = $request->type;
                    $notif->dataId = $request->dataId;
                    $notif->method = $request->metode;

                    if(isset($request->pegawai_id) && !empty($request->pegawai_id)){
                        $data = $notif->send_notif_single($request->pegawai_id);
                    }else{
                        $data = $notif->send_notif_all();
                    }

                    $json = $data;


                    break;

                case "login":

                    if ($setting->get_value('','maintenance_'.$request->channel) == "1") {

                        $json = $util->response(true, "Maaf, Kami sedang melakukan maintanance server untuk meningkatkan layanan");
                        $json['data_user']['login_status'] = "maintenance";

                    }else{

                        if ($request->app_version < $setting->get_value('','app_version_'.$request->channel) ) {

                            if($request->channel == "android"){
                                $store = "Playstore";
                            }else{
                                $store = "Appstore";
                            }

                            $json = $util->response(true, "Versi aplikasi terbaru telah tersedia, silahkan update aplikasi melalui ".$store." TANPA UNINSTALL/MENGHAPUS aplikasi.");
                            $json['data_user']['login_status'] = "update";

                        }else{

                            $user->bidan_nik = $request->username;
                            $user->bidan_password = $request->password;
                            $login = $user->login();

                            if ($login) {

                                if($login->puskesmas_id != null){
                                    $user->puskesmas_id = $login->puskesmas_id;
                                    $login->puskesmas = $user->get_puskesmas();
                                }else{
                                    $login->puskesmas = null;
                                }

                                $user->bidan_id = $request->bidan_id;
                                $json = $util->response(true,'Login berhasil');
                                $json['data_bidan'] = $login;
                                $json['data_bidan']->login_status = "active";
                                $json['data_bidan']->point = $user->get_point();


                            }else{
                                $json = $util->response(false,"NIK atau password salah!");
                            }

                        }

                    }



                    break;

                case "find_patient":

                    $user->kk_ibu = $request->kk_ibu;
                    $data = $user->get_progress();

                    if(COUNT($data)>0){
                        $json = $util->response(true,'data ditemukan');
                        $json['data_task'] = $data;
                    }else{
                        $json = $util->response(false,"Pasien tidak ditemukan!");
                    }

                    break;

                case "add_patient":

                    $user->bidan_id = $request->bidan_id;
                    $user->no_kk = $request->no_kk;
                    $user->ktp_ibu = $request->ktp_ibu;
                    $user->nama_ibu = $request->nama_ibu;
                    $user->ktp_ayah = $request->ktp_ayah;
                    $user->nama_ayah = $request->nama_ayah;
                    $user->nama_anak = $request->nama_anak;
                    $user->jk_anak = $request->jk_anak;
                    $user->anak_ke = $request->anak_ke;
                    $user->alamat = $request->alamat;

                    if($user->check_process()){

                        $id = $user->add_process();
                        $json = $util->response(true,'Pasien berhasil ditambahkan!');

                    }else{
                        $json = $util->response(false,"Pasien dengan no ktp ". $user->ktp_ibu . " sudah pernah ditambahkan dan masih dalam process check up!");
                    }


                    break;

                case "history":

                    $user->bidan_id = $request->bidan_id;
                    $data = $user->get_history($page);

                    if(COUNT($data)>0){
                        for ($i=0;$i<COUNT($data);$i++){
                            $data[$i]->date = $util->date_indo($data[$i]->date,"dd FF YYYY");
                        }
                        $json = $util->response(true,'data ditemukan');
                        $json['data_history'] = $data;
                    }else{
                        $json = $util->response(false,"History tidak ditemukan!");
                    }


                    break;





                case "logout":

                    $user->user_id = $request->user_id;
                    $user->remove_login_key();
                    $json = $util->response(true,'Logout berhasil.');

                    break;

                case "profile":

                    $user->user_id = $request->user_id;
                    $dataUser = $user->get_user_by_id();
                    $json = $util->response(true,'Profile ditemukan');

                    if($dataUser->Tipe == 'kontrak'){
                        unset($dataUser->TMTCPNS);
                        unset($dataUser->TMTPNS);
                        unset($dataUser->TMTESELON);
                        unset($dataUser->Jabatan);
                        unset($dataUser->Eselon);
                        unset($dataUser->Golongan);
                        unset($dataUser->Fungsional);
                    }

                    $result = array();
                    $x = 0;
                    foreach ($dataUser as $i => $item){

                        $result[$x]['key'] = $i;
                        if($item == null) {
                            $result[$x]['value'] = "-";
                        }else{

                            if($dataUser->Tipe == 'kontrak' && $i == 'NIP'){
                                $result[$x]['key'] = 'NIK';
                            }

                            if($i == 'TTL'){
                                $r = explode(", ",$item);
                                $date = $util->date_indo($r[1],"dd FF YYYY");
                                $result[$x]['value'] = ucwords($r[0]) . ", " .$date;
                            }else if($i == 'Unit'){
                                $user->subunit_id = $item;
                                $subunit = $user->get_user_sub_unit();
                                if($subunit){
                                    $result[$x]['value'] = $subunit->subunit_nama;
                                }else{
                                    $result[$x]['value'] = "-";
                                }
                            }else if($i == 'Nama'){
                                $nama = str_replace("-- ","",$item);
                                $nama = str_replace(", --","",$nama);
                                $result[$x]['value'] = $nama;
                            }else if($i == 'Jurusan'){
                                $result[$x]['value'] = strtoupper($item);
                            }else if($i == 'Tipe'){
                                $result[$x]['value'] = strtoupper($item);
                            }else if($i == 'TMTCPNS' || $i == 'TMTPNS' || $i == 'TMTESELON'){
                                $result[$x]['value'] = $util->date_indo($item,"dd FF YYYY");
                            }else{
                                $result[$x]['value'] = $item;
                            }

                        }

                        $x++;

                    }

                    if($dataUser->Tipe == 'kontrak'){
                        $kontrak = $user->get_kontrak_by_pegawai();
                        $resultKontrak = array();
                        $x = 0;
                        foreach ($kontrak as $i => $item){

                            $resultKontrak[$x]['key'] = $i;
                            if($item == null) {
                                $resultKontrak[$x]['value'] = "-";
                            }else{
                                if($i == 'TMTSK'){
                                    $resultKontrak[$x]['value'] = $util->date_indo($item,"dd FF YYYY");
                                }else{
                                    $resultKontrak[$x]['value'] = $item;
                                }

                            }
                            $x++;

                        }
                        $result = array_merge($result,$resultKontrak);
                    }


                    $json['data_profile'] = $result;

                    break;

                case "edit_photo":

                    $user->user_id = $request->user_id;

                    if ($request->hasFile('image') && $request->file('image')->isValid()) {

                        $upload_directory = public_path() . '/images/';
                        $imageName = 'user-' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
                        $user->user_photo = $imageName;
                        $user->update_photo();

                        $request->file('image')->move($upload_directory,$imageName);

                        $json = $util->response(true,'Gambar telah di update.');
                        $json['data_user']['user_photo'] = $util->image_url($imageName);

                    } else {

                        return $util->response(false, 'Image not valid!');

                    }


                    break;

                case "edit_password":

                    $user->user_id = $request->user_id;
                    $user->user_password = $request->user_password;

                    $user->update_password();
                    $json = $util->response(true,'Password telah di update.');
                    $json['data_user']['password'] = $user->user_password;


                    break;

                default:

                    $json = $util->response(false, 'Act not found!');

                    break;
            }

        }else{

            $json = $util->response(false,'Act must be setted!');

        }


        return $json;

    }



}