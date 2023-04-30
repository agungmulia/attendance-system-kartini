<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
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

        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        
        $remember = $loginData['remember'] ?? false;
        unset($loginData['remember']);

        if(!Auth::attempt($loginData,$remember))
            return response(['error' => 'Email atau Password Salah!'],401);

        $user = Auth::user();
        if($user->is_admin == 3){
            return response(['error' => 'Anda bukan seorang guru!'],401);
        }
        $token = $user->createToken('main')->accessToken;
        return response([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function loginSiswa(Request $request){
        $loginData = $request->all();
        $validate = Validator::make($loginData,[
            'email' => 'required|email:rfc,dns',
            'password' => 'required',
            'remember' => 'boolean'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        
        $remember = $loginData['remember'] ?? false;
        unset($loginData['remember']);

        if(!Auth::attempt($loginData,$remember))
            return response(['error' => 'Email atau Password Salah!'],401);

        $user = Auth::user();
        if($user->is_admin != 3){
            return response(['error' => 'Anda bukan seorang siswa!'],401);
        }
        $token = $user->createToken('main')->accessToken;
        return response([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function loginAdmin(Request $request){
        $loginData = $request->all();
        $validate = Validator::make($loginData,[
            'email' => 'required|email:rfc,dns',
            'password' => 'required',
            'remember' => 'boolean'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()],400);
            

        $remember = $loginData['remember'] ?? false;
        unset($loginData['remember']);

        if(!Auth::attempt($loginData,$remember))
            return response(['error' => 'Email atau Password Salah!'],401);

        $user = Auth::user();
        if($user->is_admin != 1){
            return response(['error' => 'Anda bukan seorang admin!'],401);
        }
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

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password_lama' => ['required', 'string'],
            'password_baru' => ['required', 'string', 'min:8', 'confirmed'],
            
        ]);

        if($validator->fails()){
            foreach ($validator->errors()->all() as $message) {
                return response(['error' => $message],400);
            }
        }

        $user = Auth::user();
        if (!Hash::check($request->password_lama, $user->password)) {
           return response(['error' => 'Password Lama Anda Salah!'],400);
        }
        $user_email = Auth::user()->email;
        $Guru = Guru::select('gurus.*')
            ->where('gurus.email_guru',$user_email )
            ->first();

        $user->password = Hash::make($request->password_baru);
        $Guru->password_guru = Hash::make($request->password_baru);
        if($Guru->save() && $user->save()){
            return response([
                'message' => 'Password Berhasil Dirubah!',
            ],200);
        }
    }

    public function changePasswordSiswa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password_lama' => ['required', 'string'],
            'password_baru' => ['required', 'string', 'min:8', 'confirmed'],
            
        ]);

        if($validator->fails()){
            foreach ($validator->errors()->all() as $message) {
                return response(['error' => $message],400);
            }
        }

        $user = Auth::user();
        if (!Hash::check($request->password_lama, $user->password)) {
           return response(['error' => 'Password Lama Anda Salah!'],400);
        }
        $user_email = Auth::user()->email;
        $Siswa = Siswa::select('siswas.*')
            ->where('siswas.email_siswa',$user_email )
            ->first();

        $user->password = Hash::make($request->password_baru);
        $Siswa->password_siswa = Hash::make($request->password_baru);
        if($Siswa->save() && $user->save()){
            return response([
                'message' => 'Password Berhasil Dirubah!',
            ],200);
        }
    }
}