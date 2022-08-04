<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\ArrayKey;

class AuthController extends Controller
{
    public function login(Request $request){
        $user = User::where("code", "=", $request->code)->first();
        if (isset($user->id)) {
            if(Hash::check($request->password, $user->password)) {
                $token = $user->createToken("auth_token")->plainTextToken;
                return response()->json([
                    "role" => $user->role,
                    "access_token" => $token
                ],200);
            }
            else {
                return response()->json([
                    "message" => "El usuario o la contraseña son incorrectos"
                ], 404);
            }
        }
        else {
            return response()->json([
                "message" => "El usuario o la contraseña son incorrectos"
            ], 404);
        }
    }
}
