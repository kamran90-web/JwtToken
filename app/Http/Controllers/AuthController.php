<?php

namespace App\Http\Controllers;

use JWTAuth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
class AuthController extends Controller
{
    public $loginAfterSinUp = true;

    public function login(Request $request) {
      $credentials = $request->all();
      $token = null;
      $username = User::where('email', $request->email)->pluck('username')->first();
           
        if(!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'status' =>false,
                'message' =>"unauthorized",
            ]);
        }
        return response()->json([
          'username' =>$username,
          'email' =>$request->email,
          'token' =>$token
        ]);
    }

    public function register(UserRequest $request, UserService $service) {
        $request->validated();
        $user = $service->UserService($request);
        $user->save();
        return response()->json([
            'status' => 'User created Successfully',
           'user' =>$user
        ]);
        
    }
    

    public function profile() {
        try {
            $user = User::all();
        }catch(\Tymon\JwtAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
        return $user;
    }
}
