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
        $user->name = "Secretaria";
        $user->last_name = "...";
        $user->code = "secre000";
        $user->password = Hash::make("0007");
        $user->role = "secretaria";
        $user->save();

        $rate = new Rate();
        $rate->price = "30.00";
        $rate->tuition = "0";
        $rate->save();

        $rate = new Rate();
        $rate->price = "17.00";
        $rate->tuition = "0";
        $rate->save();

        PersonalInformation::factory(20)->create();
        EcclesiasticalInformation::factory(20)->create();
        MinisterialInformation::factory(20)->create();
        Applicant::factory(20)->create();

    }
}
