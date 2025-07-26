<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;


class TestController extends Controller
{
    public function showAcceptTest()
    {
        return view('test-accept');
    }

    public function accept(Answer $answer)
    {
        // Check if the authenticated user is the owner of the question
        if (Auth::id() !== $answer->question->user_id) {
            return redirect()->back()->with('error', 'Anda tidak berwenang untuk menerima jawaban ini.');
        }
        

        // Update the answer
        $answer->is_accepted = true;
        $answer->save();

        // Update the question status
        $question = $answer->question;

        $question->status = Question::STATUS_SELESAI;
        $question->save();

        // Award points for accepted answer
        $answerUser = User::find($answer->user_id);
        $answerUser->points += 15;
        $answerUser->save();

        // Buat notifikasi
        Notification::create([
            'user_id' => $answer->user_id,
            'title' => 'Jawaban Anda Diterima',
            'message' => 'Jawaban Anda untuk pertanyaan "'.$answer->question->title.'" telah diterima sebagai solusi.',
            'related_question_id' => $answer->question_id, 
        ]);

        return back()->with('status', 'Function accept() berhasil dijalankan!');
    }
}
