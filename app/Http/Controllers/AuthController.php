<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt',['except'=>['login']]);
    }

    public function login(){
        $credentials = request(['email','password']);
        if(!$token = Auth::attempt($credentials)){
            return response()->json(['error'=>'Unauthorized'],401);
        }

        return $this->responseWithToken($token);
    }

    public function logout(){
        auth()->logout();
        return response()->json(['message'=>'Logout Successful']);
    }

    public function refresh(){
        return $this->responseWithToken(auth()->refresh());
    }
    public function me(){
        return response()->json(auth()->user());
    }
    public function payload(){
        return response()->json(auth()->payload(),200);
    }

    private function responseWithToken($token){
        return response()->json([
            'access_token'=>$token,
            'token_type'=> 'bearer',
            'expires_in'=>auth()->factory()->getTTL()*60,
        ]);
    }
}
