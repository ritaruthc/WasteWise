@extends('layouts.app')

@section('title', 'Buat Pertanyaan')

@section('styles')
<style>
    body {
        background: linear-gradient(135deg, #114B5F, #1A946F, #88D398, #F3E8D2);
        min-height: 100vh;
        margin: 0;
    }
    .isi {
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin: 20px auto;
        max-width: 500px;
    }
    h1 {
        color: #114B5F;
        margin-bottom: 20px;
        text-align: center;
    }
    .form-label {
        font-weight: bold;
        color: #1A946F;
    }
    .form-control {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #88D398;
        border-radius: 5px;
    }
    .btn-primary {
        background-color: green;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .btn-primary:hover {
        background-color: darkgreen;
    }
</style>
@endsection

@section('content')
<div class="isi">
    <h1>Buat Pertanyaan</h1>
    <form action="{{ route('questions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Isi pertanyaan</label>
            <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn-primary">Kirim</button>
    </form>
</div>
@endsection