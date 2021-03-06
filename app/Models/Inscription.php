<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    public function inscriptions(){
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
