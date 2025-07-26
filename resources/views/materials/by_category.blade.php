@extends('layouts.app')

@section('title', 'Artikel Kategori: ' . $category->name)

@section('styles')
<style>
    body {
        background: linear-gradient(135deg, #114B5F, #1A946F, #88D398, #F3E8D2);
        min-height: 100vh;
        margin: 0;
    }
    .card {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .breadcrumb {
        background-color: rgba(255,255,255,0.7);
        padding: 10px 15px;
        border-radius: 5px;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('diskusi') }}">Diskusi</a></li>
            <li class="breadcrumb-item"><a href="{{ route('materials.index') }}">Artikel</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
        </ol>
    </nav>
    
    <h1 class="mb-4 text-white">Kategori: {{ $category->name }}</h1>
   
    <div class="row">
        <div class="col-lg-8">
            @forelse($materials as $material)
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title">{{ $material->title }}</h2>
                        <p class="card-text text-muted">
                            <small>Ditulis pada {{ $material->created_at->format('d M Y') }}</small>
                        </p>
                        <p class="card-text">{{ Str::limit($material->description, 150) }}</p>
                        <a href="{{ route('materials.show', $material->slug) }}" class="btn btn-success">Baca Selengkapnya</a>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">Belum ada artikel dalam kategori ini.</div>
            @endforelse
            
            {{ $materials->links() }}
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Tentang Kategori</h3>
                    <p>{{ $category->description }}</p>
                    <a href="{{ route('materials.index') }}" class="btn btn-secondary btn-block">Kembali ke Semua Artikel</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection