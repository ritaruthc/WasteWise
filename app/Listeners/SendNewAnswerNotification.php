<?php

namespace App\Listeners;

use App\Events\AnswerCreated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SendAnswerNotification
{
    public function handle(AnswerCreated $event)
    {
        $answer = $event->answer;
        $question = $answer->question;
        $answerer = $answer->user; // Assuming the answer has a relation with the user

        // Notification data
        $notificationData = [
            'user_id' => $question->user_id,
            'title' => "Seseorang telah menjawab pertanyaan kamu",
            'message' => $this->generateDetailedMessage($question, $answerer),
            'related_question_id' => $question->id, // Add the related question ID here
            'is_read' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Log notification data
        Log::info('Notification Data:', $notificationData);

        // Create the notification
        DB::table('notifications')->insert($notificationData);
    }

    private function generateDetailedMessage($question, $answerer)
    {
        $truncatedQuestionTitle = Str::limit($question->title, 50, '...');
        
        return "Pertanyaan \"{$truncatedQuestionTitle}\" telah dijawab oleh {$answerer->name}.";
    }
}
