<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProfileResource;
use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function edit()
    {
        return new ProfileResource(auth()->user());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'password' => 'nullable|confirmed',
            'username' => 'required'
        ]);
        $id = auth()->id();
        $db = User::find($id);
//        $db->user_name = $request->input('name');
        $db->username = $request->input('username');
//        $db->bio = $request->input( 'bio');
//        $db->phone = $request->input('phone');
        if ($request->password != null) {
            $db->password = bcrypt($request->password);
        }
        $r = [
            'message' => 'Profil Berhasil Diupdate',
            'data' => new ProfileResource($db)
        ];
        return $db->save() ? response()->json($r) : '';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function avatar(Request $request)
    {
        $image = $request->image;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = Str::random(60) . '.' . 'png';
        $up = File::put(public_path() . '/assets/img/avatar/' . $imageName, base64_decode($image));
        if ($up) {
            $db = User::find(auth()->user()->user_id);
            $db->user_avatar = $imageName;
            if ($db->save()) {
                $r = [
                    'message' => 'Profil Berhasil Diupdate',
                    'data' => new ProfileResource($db)
                ];
                return response()->json($r);
            }
        }
    }

    /**
     * @return ProfileResource
     */
    public function user()
    {
        return new ProfileResource(User::find(auth()->user()->id));
    }
}
