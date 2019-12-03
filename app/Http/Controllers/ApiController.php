<?php

namespace App\Http\Controllers;

use App\Http\Resources\SelectDataResource;
use App\Model\Bidan;
use App\Model\Puskesmas;
use App\Repositories\QueryRepository;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use Yajra\DataTables\DataTables;

class ApiController extends Controller
{
    public function kelurahanTabalong()
    {
        $data = QueryRepository::kelurahanTabalong()->get();
        return SelectDataResource::get($data, "kelurahan_id", "kelurahan_nama");
    }

    public function kecamatanTabalong()
    {
        $data = QueryRepository::kecamatanTabalong()->get();
        return SelectDataResource::get($data, "kecamatan_id", "kecamatan_nama");
    }

    public function selectPegawai(Request $request)
    {
        $url = 'https://e-office.tabalongkab.go.id/api_web/pegawai-dt/select-admin';
        $token = 'ivebeenhoesandpoppinpilliesmanifeeljustlikearockstar';
        $response = Curl::to($url)
            ->withHeaders([
                'Authorization', 'Authorization: Bearer ' . $token,
            ])
            ->withData($request->all())
            ->asJsonResponse()
            ->post();
        return response()->json($response);
    }

    public function puskesmasList()
    {
        return SelectDataResource::get(Puskesmas::all(), 'puskesmas_id', 'puskesmas_nama');
    }

    public function selectBidan()
    {
        try {
            return DataTables::of(Bidan::joinAll())
                ->addColumn('action', function ($value) {
                    $type = 'pilih';
                    return view('action.bidan', compact('value', 'type'));
                })
                ->toJson();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function selectStatus()
    {
        $role = auth()->user()->user_level;
//        'bidan','capil','kominfo'
//        'new','born','done','send'
        $select = [];
        if($role == 'capil'){
             $select = [
                [
                    'value' => 'born',
                    'text' => 'Melahirkan'
                ],
                [
                    'value' => 'done',
                    'text' => 'Diproses'
                ],
            ];
        }elseif ($role == 'kominfo'){
             $select = [
                [
                    'value' => 'done',
                    'text' => 'Diproses'
                ],
                [
                    'value' => 'send',
                    'text' => 'Dikirim'
                ],
            ];
        }

        return response()->json($select);
    }
}
