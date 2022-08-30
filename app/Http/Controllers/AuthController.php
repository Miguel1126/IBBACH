<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login(Request $request){
        $user = User::where("code", "=", $request->code)->first();
        if (isset($user->id)) {
            if(Hash::check($request->password, $user->password)) {
                $token = $user->createToken("auth_token")->plainTextToken;
                return response()->json([
                    "status" => "logged",
                    "role" => $user->role,
                    "token" => $token
                ],200);
            }
            else {
                return response()->json([
                    "status" => "notlogged",
                    "message" => "El usuario o la contraseña son incorrectos"
                ], 200);
            }
        }
        else {
            return response()->json([
                "status" => "notlogged",
                "message" => "El usuario o la contraseña son incorrectos"
            ], 200);
        }
    }

    public function logout(Request $request) {
        try {
            $accessToken = $request->bearerToken();
            $token = PersonalAccessToken::findToken($accessToken);
            $token->delete();
            $success = true;
            $message = "Se cerró la sesión correctamente";
        }
        catch (\Exception $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);
    }
}
