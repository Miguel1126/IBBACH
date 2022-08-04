<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request) {
        try{
            $request->validate([
                'name' => 'required',
                'last_name' => 'required',
                'code' => 'required|unique:users',
                'password' => 'required|confirmed',
                'role' => 'required',
            ]);

            $user = new User();
            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->code = $request->code;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;
            $user->status = $request->status;
            $user->applicant_id = $request->applicant_id;
            $user->save();
        
            return response()->json([
                "msg" => "Registro de usuario existoso"
            ]);
        
        }catch(\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }
}
