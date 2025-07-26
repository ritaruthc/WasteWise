@extends('layouts.app')

@section('title', $material->title)

@section('styles')
<style>
    body {
        background: linear-gradient(135deg, #114B5F, #1A946F, #88D398, #F3E8D2);
        min-height: 100vh;
        margin: 0;
    }
    .breadcrumb {
        background-color: rgba(255,255,255,0.7);
        padding: 10px 15px;
        border-radius: 5px;
    }
    .card {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .article-content {
        font-size: 1.1em;
        line-height: 1.6;
    }
    .article-image {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('diskusi') }}">Diskusi</a></li>
            <li class="breadcrumb-item"><a href="{{ route('materials.index') }}">Artikel</a></li>
            <li class="breadcrumb-item"><a href="{{ route('materials.category', $material->category->slug) }}">{{ $material->category->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $material->title }}</li>
        </ol>
    </nav>
    
    <h1 class="mb-4 text-white">{{ $material->title }}</h1>
   
    <div class="row">
        <div class="col-lg-8">
            @if($material->image_url)
                <img src="{{ $material->image_url }}" alt="{{ $material->title }}" class="img-fluid mb-4 article-image">
            @endif
           
            <div class="card mb-4">
                <div class="card-body article-content">
                    {!! $material->content !!}
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title">Tentang Artikel Ini</h3>
                    <p><strong>Kategori:</strong> <a href="{{ route('materials.category', $material->category->slug) }}">{{ $material->category->name }}</a></p>
                    <p><strong>Penulis:</strong> {{ $material->author->name ?? 'Admin' }}</p>
                    <p><strong>Dipublikasikan:</strong> {{ $material->created_at->format('d F Y') }}</p>
                    <p><strong>Terakhir Diperbarui:</strong> {{ $material->updated_at->format('d F Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection