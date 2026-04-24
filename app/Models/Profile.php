<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'village_name',
        'head_of_village_name',
        'head_of_village_msg',
        'head_of_village_img',
        'population',
        'area_size',
        'hamlet_count',
        'vision',
        'mission',
        'history',
        'org_chart_image',
    ];

    protected $casts = [
        'population' => 'integer',
        'hamlet_count' => 'integer',
    ];
}
