<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Applicant extends Model
{
    use HasFactory, HasApiTokens;

    public function personalInformation() {
        return $this->belongsTo(PersonalInformation::class,'personal_information_id');
    }

    public function eclesiasticalInformation() {
        return $this->belongsTo(EcclesiasticalInformation::class,'ecclesiastical_information_id');
    }

    public function ministerialInformation() {
        return $this->belongsTo(MinisterialInformation::class,'ministerial_information_id');
    }
}
