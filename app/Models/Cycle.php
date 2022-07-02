<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
    use HasFactory;

    public function groups(){
        return $this->hasMany(Group::class,'id');
    }
    
    public function loads(){
        return $this->hasMany(Load::class,'load_id');
    }
}
