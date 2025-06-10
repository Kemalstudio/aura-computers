<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreReview extends Model
{
    use HasFactory;

    // Поля, которые можно заполнять массово
    protected $fillable = [
        'name',
        'text',
        'rating',
        'is_approved', // Важно для безопасности, чтобы отзывы не появлялись сразу
    ];
}