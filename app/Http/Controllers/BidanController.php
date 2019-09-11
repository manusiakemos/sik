<?php

namespace App\Http\Controllers;

use App\Http\Resources\BidanResource;
use App\Model\Bidan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class BidanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index()
    {
        return DataTables::of(Bidan::joinAll())
            ->addColumn('action', function ($value) {
                return view('action.bidan', compact('value'));
            })
           /* ->addColumn('nama_kelurahan', function ($value){
                return $value->kelurahan ? $value->kelurahan->kelurahan_nama : '-';
            })*/
            ->toJson();
    }

    /**
     * @param $request
     * @param string $id
     * @throws \Illuminate\Validation\ValidationException
     */
    public function rules($request, $id = "")
    {
        if ($id) {
            $this->validate($request, [
//                "kelurahan_id" => "required",
//                "puskesmas_id" => "required",
                "bidan_statis" => "required",
                "bidan_nik" => "required",
//                "bidan_nip" => "required",
//                "bidan_nomor" => "required",
                "bidan_nama" => "required",
                "bidan_telp" => "required",
            ]);
        } else {
            $this->validate($request, [
//                "kelurahan_id" => "required",
//                "puskesmas_id" => "required",
                "bidan_statis" => "required",
                "bidan_nik" => "required",
//                "bidan_nip" => "required",
//                "bidan_nomor" => "required",
                "bidan_nama" => "required",
                "bidan_telp" => "required",
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|string
     */
    public function store(Request $request)
    {
        $this->rules($request);
        $username = "";

        $db = new Bidan;
        if($request->bidan_statis){
            $db->puskesmas_id = $request->puskesmas_id;
            $db->kelurahan_id = "";
            $db->bidan_statis = true;
        }else{
            $db->kelurahan_id = $request->kelurahan_id;
            $db->puskesmas_id = "";
            $db->bidan_statis = false;
        }

        if($request->bidan_pns){
            $username = $request->bidan_nip;
            $db->bidan_nip = $request->bidan_nip;
            $db->bidan_nomor = "";
            $db->bidan_pns = true;
        }else{
            $username = $request->bidan_nomor;
            $db->bidan_nomor = $request->bidan_nomor;
            $db->bidan_nip = "";
            $db->bidan_pns = false;
        }
        $db->bidan_nik = $request->bidan_nik;
        $db->bidan_nama = $request->bidan_nama;
        $db->bidan_telp = $request->bidan_telp;
        if ($db->save()) {
            $user = new User;
            $user->bidan_id = $db->bidan_id;
            $user->username = $username;
            $user->api_token = Str::random(60);
            $user->password = bcrypt($username);
            $user->user_level = 'bidan';
            $user->save();
            return responseJson('Bidan berhasil ditambahkan');
        }

    }

    /**
     * @param $id
     * @return BidanResource
     */
    public function show($id)
    {
        return new BidanResource(Bidan::with(['puskesmas', 'user', 'kelurahan'])->find($id));
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|string
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->rules($request, $id);
        $db = Bidan::find($id);
        if($request->bidan_statis){
            $db->puskesmas_id = $request->puskesmas_id;
            $db->kelurahan_id = "";
            $db->bidan_statis = true;
        }else{
            $db->kelurahan_id = $request->kelurahan_id;
            $db->puskesmas_id = "";
            $db->bidan_statis = false;
        }
        if($request->bidan_pns){
            $db->bidan_nip = $request->bidan_nip;
            $db->bidan_nomor = "";
            $db->bidan_pns = true;
        }else{
            $db->bidan_nomor = $request->bidan_nomor;
            $db->bidan_nip = "";
            $db->bidan_pns = false;
        }
        $db->bidan_nik = $request->bidan_nik;
        $db->bidan_nama = $request->bidan_nama;
        $db->bidan_telp = $request->bidan_telp;
        return $db->save() ? responseJson('Bidan berhasil diupdate') : '';
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Bidan::findOrFail($id)->delete();
        return responseJson('Bidan berhasil diupdate');

    }
}
