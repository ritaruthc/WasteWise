<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Answer;

class AnswerAddedNotification extends Notification
{
    use Queueable;

    protected $answer;

    public function __construct(Answer $answer)
    {
        $this->answer = $answer;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // You can add more channels like 'sms' or 'slack'
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Hello!')
                    ->line('Your question "' . $this->answer->question->title . '" has a new answer.')
                    ->action('View Answer', url('/questions/' . $this->answer->question_id))
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'question_id' => $this->answer->question_id,
            'answer_id' => $this->answer->id,
            'message' => 'Your question "' . $this->answer->question->title . '" has a new answer.'
        ];
    }
}
