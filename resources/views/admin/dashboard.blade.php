@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('styles')
<style>
    body {
        background: linear-gradient(135deg, #114B5F, #1A946F, #88D398, #F3E8D2);
        min-height: 100vh;
        margin: 0;
    }
    .card {
        transition: transform 0.3s ease-in-out;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .stats-card {
        border-left: 4px solid #007bff;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="text-white mb-4">Admin Dashboard</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card stats-card">
                <div class="card-body">
                    <h5 class="card-title">Total Artikel</h5>
                    <p class="card-text display-4">{{ $totalMaterials }}</p>
                    {{-- <a href="{{ route('admin.materials.index') }}" class="btn btn-primary btn-sm">View All</a> --}}
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card stats-card">
                <div class="card-body">
                    <h5 class="card-title">Total Kategori</h5>
                    <p class="card-text display-4">{{ $totalCategories }}</p>
                    {{-- <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm">Manage Categories</a> --}}
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card stats-card">
                <div class="card-body">
                    <h5 class="card-title">Total User</h5>
                    <p class="card-text display-4">{{ $totalUsers }}</p>
                    {{-- <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm">Manage Users</a> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Artikel Terbaru</h2>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Dibuat pada</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentMaterials as $material)
                                <tr>
                                    <td>{{ $material->title }}</td>
                                    <td><span class="badge bg-info text-dark">{{ $material->category->name }}</span></td>
                                    <td>{{ $material->created_at->format('d M Y, H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.materials.edit', $material) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.materials.destroy', $material) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this material?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada materi terbaru.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('admin.materials.create') }}" class="btn btn-success mt-3">
                        <i class="fas fa-plus"></i> Tambah materi baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection