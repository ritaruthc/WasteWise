<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_name',
        'category',
        'info',
        'handling_info',
        'environmental_impact',
        'recycling_potential',
        'decomposition_time',
        'reduction_tips',
        'other_examples',
        'regulations'
    ];
}
