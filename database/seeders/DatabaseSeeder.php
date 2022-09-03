<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\EcclesiasticalInformation;
use App\Models\MinisterialInformation;
use App\Models\PersonalInformation;
use App\Models\User;
use App\Models\Rate;
use Illuminate\Console\Application;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "admin";
        $user->last_name = "admin";
        $user->code = "admin";
        $user->password = Hash::make("admin");
        $user->role = "admin";
        $user->save();

        $user = new User();
        $user->name = "secretaria";
        $user->last_name = "secretaria";
        $user->code = "secretaria";
        $user->password = Hash::make("secretaria");
        $user->role = "secretaria";
        $user->save();

        $user = new User();
        $user->name = "docente";
        $user->last_name = "docente";
        $user->code = "docente";
        $user->password = Hash::make("docente");
        $user->role = "docente";
        $user->save();

        $user = new User();
        $user->name = "alumno";
        $user->last_name = "alumno";
        $user->code = "alumno";
        $user->password = Hash::make("alumno");
        $user->role = "alumno";
        $user->save();

        $rate = new Rate();
        $rate->price = "30.00";
        $rate->tuition = "0";
        $rate->save();

        $rate = new Rate();
        $rate->price = "17.00";
        $rate->tuition = "0";
        $rate->save();

        PersonalInformation::factory(100)->create();
        EcclesiasticalInformation::factory(100)->create();
        MinisterialInformation::factory(100)->create();
        Applicant::factory(100)->create();

    }
}
