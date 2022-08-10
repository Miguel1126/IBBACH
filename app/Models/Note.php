<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Note extends Model
{
    use HasFactory, HasApiTokens;

    public function loads(){
        return $this->hasMany(Load::class,'id');
    }

    public function inscriptions(){
        return $this->hasMany(Inscription::class,'id');
    }
}
