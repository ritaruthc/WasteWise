<!-- resources/views/diskusi.blade.php -->
@extends('layouts.app')

@section('title', 'PISAH - Forum Diskusi')

@section('styles')
<style>
    body {
        background: linear-gradient(135deg, #114B5F, #1A946F, #88D398, #F3E8D2);
        min-height: 100vh;
        margin: 0;
    }
    .welcome-box {
        background-color: #e0f7fa;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .welcome-box a {
        color: #007bff;
        text-decoration: underline;
    }

    .sidebar {
        margin-top: 20px;
    }

    .sidebar .nav-link {
        padding: 10px 15px;
        color: #333;
        display: flex;
        align-items: center;
    }

    .sidebar .nav-link:hover {
        background-color: #f0f0f0;
        color: #007bff;
    }

    .sidebar .nav-icon {
        margin-right: 10px;
    }

    .sidebar .create-question-btn {
        background-color: #28a745;
        color: #fff;
        border-radius: 5px;
        margin-bottom: 10px;
        transition: background-color 0.3s ease;
    }

    .sidebar .create-question-btn:hover {
        background-color: #218838;
        color: #fff;
    }

    .sidebar .login-prompt {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 10px;
        text-align: center;
    }

    .sidebar .login-prompt a {
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
    }

    .sidebar .login-prompt a:hover {
        text-decoration: underline;
    }

    .top-coder {
        margin-top: 20px;
        padding-left: 20px; 
        padding-bottom: 20px;
    }

    .top-coder h4 {
        margin-bottom: 10px;
    }

    .top-coder .coder {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .top-coder .coder img {
        border-radius: 50%;
        margin-right: 10px;
    }

    .discussion-list {
        margin-top: 20px;
    }

    .discussion-item {
        padding: 15px;
        border-bottom: 1px solid #e0e0e0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .discussion-item .details {
        display: flex;
        flex-direction: column;
    }

    .discussion-item .meta {
        display: flex;
        align-items: center;
        color: #777;
    }

    .discussion-item .meta .views,
    .discussion-item .meta .comments {
        margin-right: 15px;
        display: flex;
        align-items: center;
    }

    .discussion-item .meta .views::before {
        content: '👁️';
        margin-right: 5px;
    }

    .discussion-item .meta .comments::before {
        content: '💬';
        margin-right: 5px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8" style="margin-top: 20px;">
            <div class="welcome-box">
                <h2>Selamat datang di Forum Diskusi!</h2>
                <p>Ayo Bantu selesaikan kendala untuk mendapatkan point dan peringkat di forum :)</p>
                <a href="{{ route('diskusi.panduan') }}">Baca Panduan Diskusi</a>
            </div>
            <div class="discussion-list">
                @foreach($questions as $question)
                    <div class="discussion-item" style="background-color: white">
                        <div class="details">
                            <h5>
                                <span class="badge bg-success text-white">
                                    <a href="{{ route('diskusi.questions.show', $question) }}" style="color: white">{{ $question->title }}</a>
                                </span>
                            </h5>
                            <p>{{ optional($question->user)->name ?? 'Anonymous' }} • {{ $question->created_at->diffForHumans() }}</p>
                            {{-- <p>{{ $question->user->name }} • {{ $question->created_at->diffForHumans() }}</p> --}}
                        </div>
                        <div class="meta">
                            <div class="views">{{ $question->view_count ?? 0 }}</div>
                            <div class="comments">{{ $question->answers->count() }}</div>
                            <span class="badge 
                                {{ $question->status === 'selesai' ? 'bg-success' : ($question->status === 'belum_selesai' ? 'bg-warning' : 'bg-secondary') }}">
                                {{ $question->status === 'selesai' ? 'Selesai' : ($question->status === 'belum_selesai' ? 'Belum Selesai' : 'Belum Terjawab') }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $questions->links() }}
        </div>
        <div class="col-md-4">
            <div class="sidebar">
                <div class="nav flex-column" style="background: white; border-radius: 5px;">
                    @auth
                        <a href="{{ route('questions.create') }}" class="nav-link create-question-btn">
                            <span class="nav-icon">✏️</span> Buat Pertanyaan
                        </a>
                    @else
                        <div class="login-prompt">
                            <p>Untuk membuat pertanyaan, silakan <a href="{{ route('login') }}">masuk</a> atau <a href="{{ route('register') }}">daftar</a> terlebih dahulu.</p>
                        </div>
                    @endauth
                    <a href="{{ route('diskusi') }}" class="nav-link"><span class="nav-icon">📂</span> Semua Diskusi</a>
                    <a href="{{ route('diskusi', ['filter' => 'trending']) }}" class="nav-link"><span class="nav-icon">🔥</span> Trending</a>
                    <a href="{{ route('diskusi', ['filter' => 'popular']) }}" class="nav-link"><span class="nav-icon">🌟</span> Popular</a>
                    <a href="{{ route('diskusi', ['status' => 'selesai']) }}" class="nav-link"><span class="nav-icon">✅</span> Selesai</a>
                    <a href="{{ route('diskusi', ['status' => 'belum_selesai']) }}" class="nav-link"><span class="nav-icon">🕒</span> Belum Selesai</a>
                    <a href="{{ route('diskusi', ['status' => 'belum_terjawab']) }}" class="nav-link"><span class="nav-icon">❓</span> Belum Terjawab</a>
                    <a href="{{ route('diskusi', ['sort' => 'view_count']) }}" class="nav-link"><span class="nav-icon">👁️</span> Paling Banyak Dilihat</a>
                </div>
                <div class="top-coder" style="background-color: white">
                    <h4>Top User</h4>
                    @if(isset($topUsers) && count($topUsers) > 0)
                        @foreach($topUsers as $user)
                            <div class="coder">
                                @if($user->avatar)
                                    <img src="{{ route('avatar.show', $user->id) }}" alt="{{ $user->name }}" class="rounded-circle me-2" width="40" height="40">
                                @else
                                    <img src="https://raw.githubusercontent.com/ritaruthc/WasteWise/main/public/images/user.png" alt="{{ $user->name }}" class="rounded-circle me-2" width="40" height="40">
                                @endif
                                <span>{{ $user->name }} - {{ $user->points }} Point</span>
                            </div>
                        @endforeach
                    @else
                        <p>Belum ada user terbaik</p>
                    @endif
                </div>                
            </div>
        </div>
    </div>
</div>
@endsection
{{-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Send AJAX request to increment view count
        var questionId = "{{ $question->id }}";
        var url = "{{ route('questions.incrementView', $question) }}";

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            // Update the view count on the page
            document.getElementById('view-count').textContent = data.view_count;
        })
        .catch(error => console.error('Error:', error));
    });
</script> --}}