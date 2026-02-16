<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    use HasFactory;

    // Tambahkan baris ini
    protected $fillable = [
        'user_id',
        'color',
        'musician',
        'outfit',
        'snack',
        'place'
    ];
    
}