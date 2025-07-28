@extends('layouts.app')

@section('title', 'Profile')

@section('styles')
    <style>
        body {
            background: linear-gradient(135deg, #114B5F, #1A946F, #88D398, #F3E8D2);
            min-height: 100vh;
            margin: 0;
        }

        .card {
            border-radius: 10px;
        }

        .avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
        }

        .icon {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8" style="padding-top: 20px;">
                <div class="card">
                    <div class="card-body">
                        @if (isset($user))
                            <div class="text-center mb-4">
                                @if (auth()->user()->avatar)
                                    <img src="{{ route('avatar.show', auth()->user()->id) }}" alt="{{ auth()->user()->name }}"
                                        class="rounded-circle me-2" width="150" height="150">
                                @else
                                    <img src="https://raw.githubusercontent.com/ritaruthc/WasteWise/main/public/images/user.png" alt="{{ auth()->user()->name }}"
                                        class="rounded-circle me-2" width="150" height="150">
                                @endif
                                <h2 class="mt-2">{{ $user->name }}</h2>
                                <p>{{ $user->bio ?? 'No bio available' }}</p>
                                <p>Anggota sejak {{ $user->created_at->diffForHumans() }}</p>
                            </div>

                            <div class="row text-center mb-4">
                                <div class="col-md-4">
                                    <i class="fas fa-coins icon"></i>
                                    <h3>{{ $user->points ?? 0 }}</h3>
                                    <p>Poin</p>
                                </div>
                                <div class="col-md-4">
                                    <i class="fas fa-hand-holding-heart icon"></i>
                                    <h3>{{ $user->contributions_count ?? 0 }}</h3>
                                    <p>Kontribusi</p>
                                </div>
                                <div class="col-md-4">
                                    <i class="fas fa-award icon"></i>
                                    <h3>{{ $user->best_answers_count ?? 0 }}</h3>
                                    <p>Jawaban Terbaik</p>
                                </div>
                            </div>

                            {{-- @if (isset($activities) && count($activities) > 0)
                                <h3>Recent Activities</h3>
                                @foreach ($activities as $activity)
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="{{ $activity->user->avatar ? 'data:image/jpeg;base64,' . base64_encode($activity->user->avatar) : 'https://via.placeholder.com/50' }}"
                                            alt="{{ $activity->user->name }}" class="rounded-circle mr-2" width="50"
                                            height="50">
                                        <p class="mb-0">{{ $activity->description }}</p>
                                    </div>
                                @endforeach
                            @else
                                <p>Tidak ada aktivitas terbaru.</p>
                            @endif --}}
                        @else
                            <p>Pengguna tidak ditemukan.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function refreshPage() {
            window.location.reload();
        }
    </script>
@endsection
