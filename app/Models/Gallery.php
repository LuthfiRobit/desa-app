<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'image_path',
        'date_taken',
    ];

    protected $casts = [
        'date_taken' => 'date',
    ];
}
