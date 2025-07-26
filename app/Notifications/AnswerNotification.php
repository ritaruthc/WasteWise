<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Answer;

class AnswerNotification extends Notification
{
    use Queueable;

    protected $answer;

    public function __construct(Answer $answer)
    {
        $this->answer = $answer;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'answer_id' => $this->answer->id,
            'question_id' => $this->answer->question_id,
            'message' => 'Jawaban baru telah ditambahkan ke pertanyaan Anda.',
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'answer_id' => $this->answer->id,
            'question_id' => $this->answer->question_id,
        ];
    }
}
