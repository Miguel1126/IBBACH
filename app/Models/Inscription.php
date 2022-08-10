<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Inscription extends Model
{
    use HasFactory, HasApiTokens;

    public function loads(){
        return $this->belongsTo(Load::class, 'load_id');
    }

    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
