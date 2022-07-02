<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;

    public function personalInformation() {
        return $this->belongsTo(PersonalInformation::class,'personal_information_id');
    }

    public function eclesiasticalInformation() {
        return $this->belongsTo(EclesiasticalInformation::class,'eclesiastical_information_id');
    }

    public function ministerialInformation() {
        return $this->belongsTo(MinisterialInformation::class,'ministerial_information_id');
    }
}
