<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Rate extends Model
{
    use HasFactory, HasApiTokens;

    public function payments() {
        return $this->hasMany(Payment::class,'id');
    }
}
