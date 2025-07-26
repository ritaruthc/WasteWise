<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id', 
        'title', 
        'message', 
        'is_read', 
        'related_question_id',
        'created_at', 
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function relatedQuestion()
    {
        return $this->belongsTo(Question::class, 'related_question_id');
    }
}
