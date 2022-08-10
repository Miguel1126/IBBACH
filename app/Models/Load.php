<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Load extends Model
{
    use HasFactory, HasApiTokens;

    public function users(){
        return $this->hasMany(User::class,'id');
    }

    public function cycles(){
        return $this->belongsTo(Cycle::class, 'cycle_id');
    }

    public function subjects(){
        return $this->hasMany(Subject::class,'id');
    }

    public function schedules(){
        return $this->belongsTo(Schedule::class,'id');
    }
}
