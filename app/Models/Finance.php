<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $fillable = [
        'year',
        'type',
        'title',
        'budget_amount',
        'realized_amount',
    ];

    protected $casts = [
        'year' => 'integer',
        'budget_amount' => 'integer',
        'realized_amount' => 'integer',
    ];
}
