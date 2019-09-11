<?php

namespace App\Http\Controllers;

use App\Http\Resources\BeritaResource;
use App\Http\Resources\SelectDataResource;
use App\Model\Berita;
use App\Model\CategoryBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class BeritaController extends Controller
{
    public function list()
    {
        $data = CategoryBerita::all();
        $res = new SelectDataResource($data, "cb_id", "cb_name");
        return $res->get();
    }

    public function index()
    {
        try {
            return DataTables::of(Berita::with('category')->with('user'))
                ->addColumn('action', function ($value) {
                    return view('action.berita', compact('value'));
                })
                ->editColumn('berita_aktif', function ($value) {
                    return boolean_text($value['berita_aktif']);
                })
                ->toJson();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function store(Request $request)
    {
        ini_set('post_max_size', '20M');
        ini_set('upload_max_filesize', '16M');
        ini_set('memory_limit', '-1');
        $this->validate($request,[
           'link' => Rule::unique('berita', 'berita_url')
        ]);
        $berita = new Berita;
        $berita->berita_judul = $request->judul;
        $berita->user_id = $request->user()->id;
        $berita->berita_aktif = true;
        $berita->berita_hit = 0;
        $berita->cb_id = $request->kategori;
        $berita->berita_url = $request->link;
        $berita->berita_isi = $request->isi_berita;
        if($request->has("file")){
            $file = $request->file('file');
            $filename = Str::random() .".". $file->getClientOriginalExtension();
            $move = $file->move("assets/img/news", $filename);
            if($move){
                $berita->berita_gambar = $filename;
            }
        }
        return $berita->save() ?
            response()->json([
                "status" => true,
                "text" => "success",
                "message" => "Berita Berhasil Ditambahkan",
            ])
            : response()->json([
                "status" => false,
                "text" => "error",
                "message" => "Berita Gagal Ditambahkan",
            ]);
    }

    public function show($id)
    {
        $berita = Berita::with('user')->with('category')->first();
        return new BeritaResource($berita);
    }

    public function update(Request $request, $id)
    {
        ini_set('post_max_size', '20M');
        ini_set('upload_max_filesize', '16M');
        ini_set('memory_limit', '-1');
        $berita = Berita::find($id);
        $berita->berita_judul = $request->judul;
        $berita->cb_id = $request->kategori;
        $berita->berita_url = $request->link;
        $berita->berita_isi = $request->isi_berita;
        if($request->has("file") && $request->file('file')){
            $file = $request->file('file');
            $filename = Str::random() .".". $file->getClientOriginalExtension();
            $move = $file->move("assets/img/news", $filename);
            if($move){
                File::delete(public_path("assets/img/news/{$berita->berita_gambar}"));
                $berita->berita_gambar = $filename;
            }
        }
        return $berita->save() ?
            response()->json([
            "status" => true,
            "text" => "success",
            "message" => "Berita Berhasil Diupdate",
        ])
            : response()->json([
                "status" => false,
                "text" => "error",
                "message" => "Berita Gagal Diupdate",
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Berita $berita
     * @return \Illuminate\Http\Response
     */
    public function destroy(Berita $berita)
    {
        //
    }
}
