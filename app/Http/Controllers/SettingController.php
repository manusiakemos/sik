<?php

namespace App\Http\Controllers;

use App\Http\Resources\SettingResource;
use App\Model\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return SettingResource::collection(Setting::whereIn('setting_id', [6])->get());
    }

    public function show($id)
    {
        return new SettingResource(Setting::find($id));
    }

    public function store(Request $request)
    {
        $db =  new Setting;
        $db->name = $request->name;
        $db->value = $request->value;
        return $db->save()
            ? response()->json([
                "status" => true,
                "text" => "success",
                "message" => "Setting Berhasil Ditambahkan",
            ])
            : response()->json([
                "status" => false,
                "text" => "error",
                "message" => "Setting Gagal Ditambahkan",
            ]);
    }

    public function update(Request $request, $id)
    {
        $db = Setting::find($id);
//        $db->name = $request->name;
        $db->setting_value = $request->setting_value;
        return $db->save()
            ? response()->json([
                "status" => true,
                "text" => "success",
                "message" => "Setting Berhasil Diupdate",
            ])
            : response()->json([
                "status" => false,
                "text" => "error",
                "message" => "Setting Gagal Diupdate",
            ]);
    }

    public function destroy($id)
    {
        $db = Setting::find($id)->delete();

        return $db
            ? response()->json([
                "status" => true,
                "text" => "success",
                "message" => "Setting Berhasil Dihapus",
            ])
            : response()->json([
                "status" => false,
                "text" => "error",
                "message" => "Setting Gagal Dihapus",
            ]);
    }
}
