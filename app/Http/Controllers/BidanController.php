<?php

namespace App\Http\Controllers;

use App\Http\Resources\BidanResource;
use App\Model\Bidan;
use App\Model\Kecamatan;
use App\Model\Kelurahan;
use App\Model\PregnancyProcessDetail;
use App\Model\Puskesmas;
use App\Model\Reward;
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
            ->editColumn('bidan_pns', function ($value) {
                return boolean_text($value->bidan_pns, 'Ya', 'Tidak');
            })
            ->editColumn('bidan_statis', function ($value) {
                return boolean_text($value->bidan_statis, 'Ya', 'Tidak');
            })
            ->addColumn('poin', function ($value) {
                $balance = PregnancyProcessDetail::selectRaw('sum(ppd_point) as agg')
                    ->where('bidan_id', $value->bidan_id);
//                    ->first();
                $debt = Reward::union($balance)
                    ->selectRaw('sum(reward_point) as agg')
                    ->where('bidan_id', $value->bidan_id)
                    ->where('reward_status', '<>', 'cancel')
                    ->get();
                if (count($debt) > 1) {
                    $data = floatval($debt[1]->agg) - floatval($debt[0]->agg);
                } else {
                    $balance = PregnancyProcessDetail::selectRaw('sum(ppd_point) as agg')
                        ->where('bidan_id', $value->bidan_id)
                        ->first();

                    $data = $balance->agg;
                }

//                $data = floatval($debt[1] ? $debt[1]->agg : 0) - floatval($debt[0]->agg);
                return $data ? $data : 0;
            })
            ->rawColumns(['action', 'bidan_alamat'])
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
//                "bidan_statis" => "required",
                "bidan_nik" => "required",
//                "bidan_nip" => "required",
//                "bidan_nomor" => "required",
                "bidan_alamat" => "required",
                "bidan_nama" => "required",
                "bidan_telp" => "required",
            ]);
        } else {
            $this->validate($request, [
//                "kelurahan_id" => "required",
//                "puskesmas_id" => "required",
                "bidan_statis" => "required",
//                "bidan_nik" => "required",
//                "bidan_nip" => "required",
//                "bidan_nomor" => "required",
                "bidan_alamat" => "required",
                "bidan_nama" => "required",
                "bidan_telp" => "required",
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|string
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->rules($request);
        $username = $request->bidan_nik;

        $db = new Bidan;
        if ($request->bidan_statis) {
            $db->puskesmas_id = $request->puskesmas_id;
            $db->kelurahan_id = "";
            $db->bidan_statis = true;
        } else {
            $db->kelurahan_id = $request->kelurahan_id;
            $db->puskesmas_id = "";
            $db->bidan_statis = false;
        }

        if ($request->bidan_pns) {
//            $username = $request->bidan_nik;
            $db->bidan_nip = $request->bidan_nip;
            $db->bidan_nomor = "";
            $db->bidan_pns = true;
        } else {
//            $username = $request->bidan_nik;
            $db->bidan_nomor = $request->bidan_nomor;
            $db->bidan_nip = "";
            $db->bidan_pns = false;
        }
        $db->bidan_nik = $request->bidan_nik;
        $db->bidan_nama = $request->bidan_nama;
        $db->bidan_alamat = $request->bidan_alamat;
        $db->bidan_telp = $request->bidan_telp;
        if(auth()->user()->user_level == 'puskesmas'){
            $db->scopes_puskesmas_id = auth()->user()->puskesmas_id;
        }else{
            if ($request->bidan_statis) {
                $db->scopes_puskesmas_id = $request->puskesmas_id;
            } else {
                $kelurahan = Kelurahan::find($request->kelurahan_id);
                $kecamatan = Kecamatan::find($kelurahan->kecamatan_id);
                $puskesmas = Puskesmas::where('kecamatan_id', $kecamatan->kecamatan_id)->first();
                $db->scopes_puskesmas_id = $puskesmas->puskesmas_id;
            }
        }
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
        $username = $request->bidan_nik;
        $db = Bidan::find($id);
        if ($request->bidan_statis) {
            $db->puskesmas_id = $request->puskesmas_id;
            $db->kelurahan_id = "";
            $db->bidan_statis = true;
        } else {
            $db->kelurahan_id = $request->kelurahan_id;
            $db->puskesmas_id = "";
            $db->bidan_statis = false;
        }
        if ($request->bidan_pns) {
            $db->bidan_nip = $request->bidan_nip;
            $db->bidan_nomor = "";
            $db->bidan_pns = true;
        } else {
            $db->bidan_nomor = $request->bidan_nomor;
            $db->bidan_nip = "";
            $db->bidan_pns = false;
        }

        if(auth()->user()->user_level == 'puskesmas'){
            $db->scopes_puskesmas_id = auth()->user()->puskesmas_id;
        }else{
            if ($request->bidan_statis) {
                $db->scopes_puskesmas_id = $request->puskesmas_id;
            } else {
                $kelurahan = Kelurahan::find($request->kelurahan_id);
                $kecamatan = Kecamatan::find($kelurahan->kecamatan_id);
                $puskesmas = Puskesmas::where('kecamatan_id', $kecamatan->kecamatan_id)->first();
                $db->scopes_puskesmas_id = $puskesmas->puskesmas_id;
            }
        }

        $db->bidan_nik = $request->bidan_nik;
        $db->bidan_nama = $request->bidan_nama;
        $db->bidan_telp = $request->bidan_telp;
        $db->bidan_alamat = $request->bidan_alamat;
        if ($db->save()) {
            $user = User::where('bidan_id', $db->bidan_id)->first();
            $user->bidan_id = $db->bidan_id;
            $user->username = $username;
            $user->api_token = Str::random(60);
            $user->password = bcrypt($username);
            $user->user_level = 'bidan';
            $user->save();
            return $user->save() ? responseJson('Bidan berhasil diupdate') : '';
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Bidan::destroy($id);
        User::where('bidan_id', $id)->delete();
        return responseJson('Bidan berhasil diupdate');

    }
}
