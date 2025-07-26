<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'description', 'content', 'image_url', 'category_id'];

    public function category()
    {
        return $this->belongsTo(MaterialCategory::class, 'category_id');
    }
}