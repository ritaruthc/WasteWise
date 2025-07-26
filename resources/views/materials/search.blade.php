@extends('layouts.app')

@section('title', 'Hasil Pencarian: ' . $query)

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
    .highlight {
        background-color: yellow;
        font-weight: bold;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-white">Hasil Pencarian: "{{ $query }}"</h1>
   
    <div class="row">
        <div class="col-lg-8">
            @if($materials->count() > 0)
                <p class="text-white mb-4">Ditemukan {{ $materials->total() }} hasil untuk pencarian Anda.</p>
                @foreach($materials as $material)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h2 class="card-title">{!! preg_replace('/(' . $query . ')/i', '<span class="highlight">$1</span>', $material->title) !!}</h2>
                            <p class="card-text text-muted">
                                <small>Kategori: <a href="{{ route('materials.category', $material->category->slug) }}">{{ $material->category->name }}</a> | 
                                Ditulis pada {{ $material->created_at->format('d M Y') }}</small>
                            </p>
                            <p class="card-text">{!! preg_replace('/(' . $query . ')/i', '<span class="highlight">$1</span>', Str::limit($material->description, 150)) !!}</p>
                            <a href="{{ route('materials.show', $material->slug) }}" class="btn btn-primary btn-success">Baca Selengkapnya</a>
                        </div>
                    </div>
                @endforeach
                {{ $materials->appends(['query' => $query])->links() }}
            @else
                <div class="alert alert-info">
                    Tidak ada hasil yang ditemukan untuk pencarian "{{ $query }}".
                    <br>Coba cari dengan kata kunci lain atau periksa ejaan Anda.
                </div>
            @endif
        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title">Cari Lagi</h3>
                    <form action="{{ route('materials.search') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="query" placeholder="Masukkan kata kunci..." value="{{ $query }}">
                            <button class="btn btn-primary btn-success" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection