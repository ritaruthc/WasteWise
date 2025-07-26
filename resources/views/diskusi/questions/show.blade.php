@extends('layouts.app')

@section('title', 'Diskusi: ' . $question->title)

@section('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    body {
        background: linear-gradient(135deg, #114B5F, #1A946F, #88D398, #F3E8D2);
        min-height: 100vh;
        margin: 0;
    }
    .card {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
    }
    .accepted-answer {
        border-left: 4px solid #28a745;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="card mb-4">
        <div class="card-body">
            <h1 id="question-title" class="card-title">{{ $question->title }}</h1>
            <p id="question-content" class="card-text">{{ $question->content }}</p>
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Ditanyakan oleh <a href="{{ route('profile.show', $question->user->id) }}">{{ $question->user->name }}</a> 
                    {{ $question->created_at->diffForHumans() }}
                </small>
                @if (auth()->id() === $question->user_id)
                    <button id="edit-question-btn" class="btn btn-success btn-sm">Edit Pertanyaan</button>
                @endif
            </div>
        </div>
    </div>

    @if (auth()->id() === $question->user_id)
        <div id="edit-question-form" class="card mb-4 d-none">
            <div class="card-body">
                <form id="edit-question-form">
                    @csrf
                    <div class="mb-3">
                        <label for="edit-title" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="edit-title" name="title" value="{{ $question->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-content" class="form-label">Konten</label>
                        <textarea class="form-control" id="edit-content" name="content" rows="10" required>{{ $question->content }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    <button type="button" id="cancel-edit-btn" class="btn btn-secondary">Batal</button>
                </form>
            </div>
        </div>
    @endif

    @forelse ($question->answers as $answer)
        <div class="card mb-3 {{ $answer->is_accepted ? 'accepted-answer' : '' }}">
            <div class="card-body">
                <div class="card-text">{!! $answer->content !!}</div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted">
                        Dijawab oleh {{ $answer->user->name }} {{ $answer->created_at->diffForHumans() }}
                    </small>
                    @if ($question->status != 'selesai' && auth()->id() === $question->user_id && !$answer->is_accepted)
                        <form action="{{ route('answers.accept', $answer) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Terima Jawaban Ini</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">Belum ada jawaban untuk pertanyaan ini.</div>
    @endforelse

    @auth
        @if (auth()->id() !== $question->user_id)
            <div class="card mt-4">
                <div class="card-body">
                    <h3 class="card-title">Jawaban Anda</h3>
                    <form id="answer-form" action="{{ route('answers.store', $question) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <div id="editor-container" style="height: 200px;"></div>
                            <input type="hidden" name="content" id="content">
                        </div>
                        <button type="submit" class="btn btn-success">Kirim Jawaban</button>
                    </form>
                </div>
            </div>
        @endif
    @else
        <div class="alert alert-warning mt-4">
            Anda harus <a href="{{ route('login') }}">login</a> atau <a href="{{ route('register') }}">daftar</a> terlebih dahulu untuk memberikan jawaban.
        </div>
    @endauth
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editBtn = document.getElementById('edit-question-btn');
        const editForm = document.getElementById('edit-question-form');
        const questionTitle = document.getElementById('question-title');
        const questionContent = document.getElementById('question-content');

        editBtn?.addEventListener('click', function() {
            // Tampilkan form edit
            editForm.classList.remove('d-none');
            
            // Sembunyikan konten pertanyaan
            questionTitle.classList.add('d-none');
            questionContent.classList.add('d-none');
            
            // Isi form dengan data pertanyaan saat ini
            document.getElementById('edit-title').value = questionTitle.innerText;
            document.getElementById('edit-content').value = questionContent.innerText;
            
            // Sembunyikan tombol edit
            editBtn.classList.add('d-none');
        });

        // Tambahkan event listener untuk tombol batal
        const cancelEditBtn = document.getElementById('cancel-edit-btn');
        cancelEditBtn?.addEventListener('click', function() {
            // Sembunyikan form edit
            editForm.classList.add('d-none');
            
            // Tampilkan kembali konten pertanyaan
            questionTitle.classList.remove('d-none');
            questionContent.classList.remove('d-none');
            
            // Tampilkan kembali tombol edit
            editBtn.classList.remove('d-none');
        });
    });
    var quill = new Quill('#editor-container', {
        theme: 'snow'
    });

    var form = document.getElementById('answer-form');
    form.onsubmit = function() {
        var content = document.querySelector('input[name=content]');
        content.value = quill.root.innerHTML;

        if (quill.getText().trim().length === 0) {
            alert('Jawaban tidak boleh kosong');
            return false;
        }
        return true;
    };

    document.getElementById('edit-question-btn')?.addEventListener('click', function() {
        document.getElementById('edit-question-form').classList.remove('d-none');
    });

    document.getElementById('cancel-edit-btn')?.addEventListener('click', function() {
        document.getElementById('edit-question-form').classList.add('d-none');
    });

    document.getElementById('edit-question-form')?.addEventListener('submit', function(e) {
        e.preventDefault();

        var title = document.getElementById('edit-title').value;
        var content = document.getElementById('edit-content').value;

        fetch('{{ route('questions.update', $question) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-HTTP-Method-Override': 'PUT'
            },
            body: JSON.stringify({
                title: title,
                content: content
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const questionTitle = document.getElementById('question-title');
                const questionContent = document.getElementById('question-content');
                const editForm = document.getElementById('edit-question-form');
                const editBtn = document.getElementById('edit-question-btn');

                questionTitle.innerText = data.question.title;
                questionContent.innerText = data.question.content;
                
                // Sembunyikan form edit
                editForm.classList.add('d-none');
                
                // Tampilkan kembali konten pertanyaan
                questionTitle.classList.remove('d-none');
                questionContent.classList.remove('d-none');
                
                // Tampilkan kembali tombol edit
                editBtn.classList.remove('d-none');

                alert(data.message);
            } else {
                alert('Gagal mengupdate pertanyaan: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        });
    });
</script>
@endsection