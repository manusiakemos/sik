<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryBeritaResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\SelectDataResource;
use App\Model\CategoryBerita;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CategoryBeritaController extends Controller
{

    public function list()
    {
        $data = CategoryBerita::all();
        $res = SelectDataResource::get($data, "cb_id", "cb_name");
        return $res;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index()
    {
        return DataTables::of(CategoryBerita::query())
            ->addColumn('action', function ($value){
                return view('action.category-news', compact('value'));
            })
            ->toJson();
    }


    public function store(Request $request)
    {
        $db = new CategoryBerita;
        $db->cb_name = $request->nama_kategori;
        return $db->save()
            ? response()->json([
                "status" => true,
                "text" => "success",
                "message" => "kategori Berhasil Ditambahkan",
            ])
            : response()->json([
                "status" => false,
                "text" => "error",
                "message" => "kategori Gagal Ditambahkan",
            ]);
    }


    public function show($id)
    {
        return new CategoryBeritaResource(CategoryBerita::find($id));
    }

    public function update(Request $request, $id)
    {
        $db = CategoryBerita::findOrFail($id);
        $db->cb_name = $request->nama_kategori;
        return $db->save()
            ? response()->json([
                "status" => true,
                "text" => "success",
                "message" => "kategori Berhasil Diupdate",
            ])
            : response()->json([
                "status" => false,
                "text" => "error",
                "message" => "kategori Gagal Diupdate",
            ]);
    }

    public function destroy($id)
    {
        $db = CategoryBerita::findOrFail($id);
        $db->delete();
        return $db->save()
            ? response()->json([
                "status" => true,
                "text" => "success",
                "message" => "kategori Berhasil Dihapus",
            ])
            : response()->json([
                "status" => false,
                "text" => "error",
                "message" => "kategori Gagal Dihapus",
            ]);
    }
}
