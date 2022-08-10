<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Assistance extends Model
{
    use HasFactory, HasApiTokens;

    public function notes(){
        return $this->belongsTo(Note::class, 'note_id');
    }
}
