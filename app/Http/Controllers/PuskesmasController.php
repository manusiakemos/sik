<?php

namespace App\Http\Controllers;

use App\Http\Resources\PuskesmasResource;
use App\Model\Kecamatan;
use App\Model\Puskesmas;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PuskesmasController extends Controller
{

    public function index()
    {
        try {
            return DataTables::of(Puskesmas::with('kecamatan'))
                ->addColumn('action', function ($value) {
                    return view('action.puskesmas', compact('value'));
                })
                ->toJson();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function store(Request $request)
    {
        $db = new Puskesmas;
        $db->puskesmas_nama = $request->puskesmas_nama;
        $db->puskesmas_no = $request->puskesmas_no;
        $db->kecamatan_id = $request->kecamatan_id;
        $db->puskesmas_alamat = $request->puskesmas_alamat;
        $db->save();
        return responseJson('Puskesmas berhasil ditambahkan');
    }

    public function show($id)
    {
        return new PuskesmasResource(Puskesmas::find($id));
    }

    public function update(Request $request, $id)
    {
        $db = Puskesmas::find($id);
        $db->puskesmas_nama = $request->puskesmas_nama;
        $db->puskesmas_no = $request->puskesmas_no;
        $db->kecamatan_id = $request->kecamatan_id;
        $db->puskesmas_alamat = $request->puskesmas_alamat;
        $db->save();
        return responseJson('Puskesmas berhasil diupdate');
    }

    public function destroy($id)
    {
        Puskesmas::find($id)->delete($id);
        return responseJson('Puskesmas berhasil dihapus');
    }
}
