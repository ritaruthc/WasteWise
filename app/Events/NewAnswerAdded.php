<?php

namespace App\Events;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class NewAnswerAdded
{
    use Dispatchable, SerializesModels;

    public $answer;
    public $questionOwner;

    public function __construct(Answer $answer, User $questionOwner)
    {
        $this->answer = $answer;
        $this->questionOwner = $questionOwner;
    }
}
