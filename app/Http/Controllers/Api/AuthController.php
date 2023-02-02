<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        $registrationData = $request->all();
        $validate = Validator::make($registrationData,[
            'name' => 'required|max:60',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        $registrationData['password'] = bcrypt($request->password);
        $user = User::create($registrationData);
        return response([
            'message' => 'Register Success',
            'user' => $user,
        ],200);
    }


    public function login(Request $request){
        $loginData = $request->all();
        $validate = Validator::make($loginData,[
            'email' => 'required|email:rfc,dns',
            'password' => 'required',
            'remember' => 'boolean'
        ]);

        if($validate->fails()){
            foreach ($validate->errors()->all() as $message) {
                return response(['error' => $message],400);
            }
        }
            

        $remember = $loginData['remember'] ?? false;
        unset($loginData['remember']);

        if(!Auth::attempt($loginData,$remember))
            return response(['error' => 'Email atau Password Salah!'],401);

        $user = Auth::user();
        $token = $user->createToken('main')->accessToken;
        return response([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout()
    {
        $user = Auth::user();
        $user->token()->delete();
        // Revoke the token that was used to authenticate the current request...
        return response([
            'success' => true
        ]);
    }
}