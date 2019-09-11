<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index()
    {
        return DataTables::of(User::query())
            ->addColumn('action', function(User $value){
                return view('action.user', compact('value'));
            })
           ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "username" => [
                "required", Rule::unique('_user','username')
            ],
            "role" => "required",
            "password" => "required|confirmed",
        ]);
        $db = User::insert([
            "username" => $request->input("username"),
            "user_level" => $request->input("role"),
            "password" => bcrypt($request->input("password")),
            "api_token" => Str::random(60)
        ]);
        return $db
            ? response()->json([
                "status" => true,
                "text" => "success",
                "message" => "User Berhasil Ditambahkan",
            ])
            : response()->json([
                "status" => false,
                "text" => "error",
                "message" => "User Gagal Ditambahkan",
            ]);
    }


    /**
     * @param $id
     * @return UserResource
     */
    public function edit($id)
    {
        $data = User::find($id);
        return new UserResource($data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            "name" => "required",
            "username" => [
                "required", Rule::unique('_user','username')->ignore($id,'id')
            ],
            "role" => "required",
        ]);
        if ($request->has("password") && $request->password != null) {
            $db = User::where("id", $id)->update([
                "name" => $request->input("name"),
                "username" => $request->input("username"),
                "role" => $request->input("role"),
                "password" => bcrypt($request->input("password")),
            ]);
        } else {
            $db = User::where("id", $id)->update([
                "name" => $request->input("name"),
                "username" => $request->input("username"),
                "role" => $request->input("role"),
            ]);
        }
        return $db
            ? response()->json([
                "status" => true,
                "text" => "success",
                "message" => "User Berhasil Diupdate",
            ])
            : response()->json([
                "status" => false,
                "text" => "error",
                "message" => "User Gagal Diupdate",
            ]);
    }


    public function destroy($id)
    {
        User::destroy($id);
        return response()->json([
            "status" => true,
            "text" => "success",
            "message" => "User berhasil dihapus"
        ]);
    }
}
