<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Group extends Model
{
    use HasFactory, HasApiTokens;

    /* public function groups() {
        return $this->hasMany(Cycle::class,'id');
    } */
}
