@extends('layouts.app')

@section('title', 'Kelola Artikel')

@section('styles')
<style>
    body {
        background: linear-gradient(135deg, #114B5F, #1A946F, #88D398, #F3E8D2);
        min-height: 100vh;
        margin: 0;
    }
    .card {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        border: none;
        border-radius: 12px;
    }
    .table-responsive {
        background-color: white;
        border-radius: 8px;
    }
    .btn-primary {
        background-color: #1A946F;
        border-color: #1A946F;
    }
    .btn-primary:hover {
        background-color: #147a5e;
        border-color: #147a5e;
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="mb-0 text-primary">Kelola Artikel</h1>
                <a href="{{ route('admin.materials.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Artikel Baru
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($materials as $material)
                        <tr>
                            <td>{{ $material->id }}</td>
                            <td>{{ $material->title }}</td>
                            <td><span class="badge bg-secondary">{{ $material->category->name }}</span></td>
                            <td>
                                <a href="{{ route('admin.materials.edit', $material) }}" class="btn btn-warning btn-sm me-2">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                                <form action="{{ route('admin.materials.destroy', $material) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus materi ini?')">
                                        <i class="fas fa-trash me-1"></i>Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $materials->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Add any additional JavaScript if needed
</script>
@endsection