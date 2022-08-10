<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Subject extends Model
{
    use HasFactory, HasApiTokens;

   
    public function inscriptions(){
        return $this->hasMany(Inscription::class, 'id');
    }
}
