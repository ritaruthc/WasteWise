@extends('layouts.app')

@section('title', 'Notifikasi')

@section('styles')
<style>
    body {
        background: linear-gradient(135deg, #114B5F, #1A946F, #88D398, #F3E8D2);
        min-height: 100vh;
        margin: 0;
    }
    .notification-item {
        transition: all 0.3s ease;
    }
    .notification-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .unread {
        border-left: 4px solid #007bff;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-white">Notifikasi</h1>
    
    @if($notifications->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-bell-slash mr-2"></i> Tidak ada notifikasi saat ini.
        </div>
    @else
        <div class="card">
            <ul class="list-group list-group-flush">
                @foreach($notifications as $notification)
                    <li class="list-group-item notification-item {{ $notification->is_read ? '' : 'unread' }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">
                                    <a href="{{ route('diskusi.questions.show', $notification->related_question_id) }}" class="text-dark">
                                        {{ $notification->title }}
                                    </a>
                                </h5>
                                <p class="mb-1">{{ $notification->message }}</p>
                                <small class="text-muted">
                                    <i class="far fa-clock mr-1"></i>
                                    {{ $notification->created_at instanceof \Carbon\Carbon 
                                        ? $notification->created_at->diffForHumans() 
                                        : $notification->created_at }}
                                </small>
                            </div>
                            <div class="btn-group">
                                @if(!$notification->is_read)
                                    <form method="POST" action="{{ route('notifications.markAsRead', ['notification' => $notification->id]) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Tandai telah dibaca">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('notifications.destroy', ['notification' => $notification->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection