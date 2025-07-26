<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Question extends Model
{
    const STATUS_SELESAI = 'selesai';
    const STATUS_BELUM_SELESAI = 'belum_selesai';
    const STATUS_BELUM_TERJAWAB = 'belum_terjawab';

    protected $fillable = ['user_id', 'title', 'content', 'status', 'trending', 'popularity', 'view_count'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}


