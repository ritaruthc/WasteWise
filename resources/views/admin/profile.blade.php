@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Profil Admin</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ $admin->avatar ? asset('storage/'.$admin->avatar) : asset('images/default-avatar.png') }}" 
                         alt="{{ $admin->name }}" class="img-fluid rounded-circle mb-3">
                </div>
                <div class="col-md-8">
                    <h3>{{ $admin->name }}</h3>
                    <p><strong>Email:</strong> {{ $admin->email }}</p>
                    <p><strong>Bergabung sejak:</strong> {{ $admin->created_at->format('d F Y') }}</p>
                    <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary">Edit Profil</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection