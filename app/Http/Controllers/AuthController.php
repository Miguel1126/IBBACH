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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    //sobreescribiendo el metodo redirectPath para redireccionar dependiendo el type de user
    public function redirectPath()
    {
        if (Auth::user()->role=='admin') {
            //retornamos la vista del admin
            return view('../views/admin/base/Admin.vue');
        }
        return '/';
    }

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
