<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $user = User::where("code", "=", $request->code)->first();
            if (!isset($user->status)) {
                return response()->json([
                    "status" => "notlogged",
                    "message" => "El usuario o la contraseña son incorrectos"
                ], 200);
            }
            if ($user->status === "inactivo") {
                return response()->json([
                    "status" => "notlogged",
                    "message" => "Este usuario ya no está disponible"
                ], 200);
            }
            if (isset($user->id)) {
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken("auth_token")->plainTextToken;
                    return response()->json([
                        "status" => "logged",
                        "role" => $user->role,
                        "token" => $token
                    ], 200);
                } else {
                    return response()->json([
                        "status" => "notlogged",
                        "message" => "El usuario o la contraseña son incorrectos"
                    ], 200);
                }
            } else {
                return response()->json([
                    "status" => "notlogged",
                    "message" => "El usuario o la contraseña son incorrectos"
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function getLoggedUser(Request $request)
    {
        try {
            if (auth()->user()->status !== 'activo') {
                $accessToken = $request->bearerToken();
                $token = PersonalAccessToken::findToken($accessToken);
                $token->delete();
                return response()->json(['message' => 'No tienes autorización para ejecutar esta acción, inicia sesión en una cuenta válida'], 401);
            }
            
            if (auth()->user()->role === 'alumno') {
                $user = User::join('applicants', 'users.applicant_id', '=', 'applicants.id')
                ->join('groups', 'users.group_id', '=', 'groups.id')
                ->select('applicants.img', 'groups.group')
                ->where('users.id','=',auth()->user()->id)
                ->get();
                
                auth()->user()->img = count($user) ? $user[0]->img : null;
                auth()->user()->group = count($user) ? $user[0]->group : null;
            }

            return response()->json([
                'id' => auth()->user()->id,
                'img' => auth()->user()->img,
                'name' => auth()->user()->name,
                'last_name' => auth()->user()->last_name,
                'code' => auth()->user()->code,
                'role' => auth()->user()->role,
                'group' => auth()->user()->group,
                'status' => auth()->user()->status,
                'applicant_id' => auth()->user()->applicant_id,
            ], 200);
        } catch (\Exception $ex) {
            return response()->json(["message" => $ex->getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $accessToken = $request->bearerToken();
            $token = PersonalAccessToken::findToken($accessToken);
            $token->delete();
            $success = true;
            $message = "Se cerró la sesión correctamente";
        } catch (\Exception $ex) {
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
