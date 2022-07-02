<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

   
    public function loads(){
        return $this->belongsTo(Load::class, 'load_id');
    }
}
