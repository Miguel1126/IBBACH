<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Foundation\Auth\User;

class Payment extends Model
{
    use HasFactory;

    public function rate() {
        return $this->belongsTo(Rate::class,'rate_id');
    }
    // Cuando esté lista la tabla de users le quitan el comentario al código de abajo
    /* public function user() {
        return $this->belongsTo(User::class,'user_id');
    } */
}
