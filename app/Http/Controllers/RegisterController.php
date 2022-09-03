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
                'role' => 'required',
            ]);

            $user = new User();
            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->code = $this->generateUserCode($request->name, $request->last_name);
            $pass = $this->generatePassword();
            $user->password = Hash::make($pass);
            $user->role = $request->role;
            if ($user->save() >= 1) {
                return response()->json(["user" => $user, "pass" => $pass], 201);
            }             
        }
        catch(\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }

    // Function to generate the user code
    private function generateUserCode($firstName, $lastName) {
        $applicantNameFirstLetter = strtoupper(substr($firstName,0,1));
        $applicantLastNameFirstLetter = strtoupper(substr($lastName,0,1));
        $code = $applicantNameFirstLetter . $applicantLastNameFirstLetter . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);

        do {
            $applicantNameFirstLetter = strtoupper(substr($firstName,0,1));
            $applicantLastNameFirstLetter = strtoupper(substr($lastName,0,1));
            $code = $applicantNameFirstLetter . $applicantLastNameFirstLetter . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
        } while (User::where('code', '=', $code)->exists());

        return $code;
    }

    // Function to generate a random password
    private function generatePassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 6; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }
}
