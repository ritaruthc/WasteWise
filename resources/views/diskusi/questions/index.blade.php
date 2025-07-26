@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Discussion Forum</h1>
    <a href="{{ route('questions.create') }}" class="btn btn-primary mb-3">Ask a Question</a>

    @foreach ($questions as $question)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">
                    <a href="{{ route('questions.show', $question) }}">{{ $question->title }}</a>
                </h5>
                <p class="card-text">{{ Str::limit($question->content, 100) }}</p>
                <div class="d-flex justify-content-between">
                    <small>Asked by {{ $question->user->name }} {{ $question->created_at->diffForHumans() }}</small>
                    <span class="badge {{ $question->is_solved ? 'bg-success' : 'bg-secondary' }}">
                        {{ $question->is_solved ? 'Solved' : 'Unsolved' }}
                    </span>
                </div>
            </div>
        </div>
    @endforeach

    {{ $questions->links() }}
</div>
@endsection