<?php

namespace App\Http\Controllers;

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
                    "status" => 1,
                    "msg" => "Usuario logeado",
                    "access_token" => $token
                ]);
            }
            else {
                return response()->json([
                    "status" => 0,
                    "msg" => "La password es incorrecta"
                ], 404);
            }
        }
        else {
            return response()->json([
                "status" => 0,
                "msg" => "Usuario no registrado"
            ], 404);
        }
    }
}
