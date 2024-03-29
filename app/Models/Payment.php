<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

//use Illuminate\Foundation\Auth\User;

class Payment extends Model
{
    use HasFactory, HasApiTokens;

    public function rate() {
        return $this->belongsTo(Rate::class,'rate_id');
    }
    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }
}
