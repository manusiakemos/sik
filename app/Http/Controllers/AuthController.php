<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProfileResource;
use App\User;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    /**
     * username
     *
     * @return string
     */
    public function username()
    {
        return "username";
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $this->sendLockoutResponse($request);
        }
        if ($this->attemptLogin($request)) {
            $user = auth()->user();
            if ($user) {
                return responseJson("login sukses", new ProfileResource($user));
            }
        } else {
            $this->incrementLoginAttempts($request);
            return $this->sendFailedLoginResponse($request);
        }
    }


    /**
     * attemptLogin
     *
     * @param  mixed $request
     *
     * @return bool
     */
    public function attemptLogin($request)
    {
        return Auth::attempt(
            [
                $this->username() => $request->input($this->username()),
                "password" => $request->password,
//                "role" => ["kominfo", "capil"],
//                "deleted_at" => null
            ]
        );
    }

    /**
     * check
     *
     * @return Response
     */
    public function check()
    {
        $id = auth()->id();
        $user = User::joinData()->where("user_id", $id)->first();
        if ($user) {
            return response($user);
        }
        return response(["message" => "Unauthenticated"]);
    }

    /**
     * SocialSignup
     *
     * @param  mixed $provider
     *
     * @return response json
     */
    /*    public function SocialSignup($provider)
        {
            // Socialite will pick response data automatic
            $user = Socialite::driver($provider)->stateless()->user();
            if ($user) {
                return $this->SignUpOrLogin($user);
            }else{
                return response()->json(["message" => "Autentikasi gagal"]);
            }
        }

        public function SignUpOrLogin($user)
        {
            $check = User::where("email", $user->email)->first();
            if ($check) {
                $db = User::find($check->id);

            } else {
                $db = new User;
            }
            $db->api_token = $user->token;
            $db->name = $user->name;
            $db->role = "user";
            $db->email = $user->email;
            $db->username = Str::random();
            $db->password = bcrypt(Str::random());
            $db->avatar = $user->avatar;
            $db->avatar_original = $user->avatar_original;
            $db->save();
            return response()->json($db);

        }*/
}
