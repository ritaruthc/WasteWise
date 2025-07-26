<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class QuestionController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Question::with(['user', 'answers']);

        // Filtering
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'trending':
                    $query->where('trending', true);
                    break;
                case 'popular':
                    $query->orderBy('popularity', 'desc');
                    break;
            }
        }

        // Status filtering
        if ($request->has('status')) {
            $status = $request->status;
            switch ($status) {
                case 'selesai':
                    $query->where('status', 'selesai');
                    break;
                case 'belum_selesai':
                    $query->where('status', 'belum_selesai');
                    break;
                case 'belum_terjawab':
                    $query->where('status', 'belum_terjawab');
                    break;
            }
        }
        
        // Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'view_count':
                    $query->orderBy('view_count', 'desc');
                    break;
                case 'latest':
                    $query->latest();
                    break;
            }
        } else {
            $query->latest(); // Default sorting
        }

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('content', 'like', "%{$searchTerm}%");
            });
        }

        $questions = $query->paginate(10);
        $topUsers = User::orderBy('points', 'desc')->take(5)->get();

        return view('diskusi.diskusi', compact('questions', 'topUsers'));
    }

    public function create()
    {
        return view('diskusi.questions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $validated['user_id'] = Auth::id();
        $question = Question::create($validated);

        return redirect()->route('diskusi.questions.show', $question)->with('success', 'Pertanyaan berhasil dibuat.');
    }

    public function show(Question $question)
    {
        $question->increment('view_count');
        return view('diskusi.questions.show', compact('question'));
    }

    public function updateStatus(Question $question, $status)
    {
        $validStatuses = ['selesai', 'belum_selesai', 'belum_terjawab'];
        if (in_array($status, $validStatuses)) {
            $question->status = $status;
            $question->save();
        }

        return redirect()->route('diskusi.questions.show', $question)
                        ->with('status', 'Status updated successfully');
    }


    public function edit(Question $question)
    {
        Gate::authorize('update', $question);
        return view('questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        // Validasi input
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        // Periksa apakah pengguna yang login adalah pemilik pertanyaan
        if (auth()->id() !== $question->user_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Update pertanyaan
        $question->update($validatedData);

        return response()->json([
            'success' => true,
            'question' => $question,
            'message' => 'Pertanyaan berhasil diperbarui'
        ]);
    }

    public function destroy(Question $question)
    {
        $this->authorize('delete', $question);

        $question->delete();

        return redirect()->route('diskusi')->with('success', 'Pertanyaan berhasil dihapus.');
    }
}
