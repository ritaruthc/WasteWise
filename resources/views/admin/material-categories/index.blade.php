@extends('layouts.app')

@section('title', 'Kategori Artikel')

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
    .btn-success {
        background-color: #1A946F;
        border-color: #1A946F;
    }
    .btn-success:hover {
        background-color: #147a5e;
        border-color: #147a5e;
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
    .img-thumbnail {
        border-radius: 8px;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="mb-0 text-primary">Kategori Artikel</h1>
                <a href="{{ route('admin.material-categories.create') }}" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Tambah Kategori Baru
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Slug</th>
                            <th>Deskripsi</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td><span class="badge bg-secondary">{{ $category->slug }}</span></td>
                                <td>{{ Str::limit($category->description, 50) }}</td>
                                <td>
                                    @if($category->photo)
                                        <img src="{{ asset('storage/' . $category->photo) }}" alt="{{ $category->name }}" width="50" class="img-thumbnail">
                                    @else
                                        <span class="text-muted"><i class="fas fa-image me-1"></i>No image</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.material-categories.edit', $category->id) }}" class="btn btn-warning btn-sm me-2">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                    <form action="{{ route('admin.material-categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?')">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-folder-open me-2"></i>No categories found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Add any additional JavaScript if needed
    $(document).ready(function() {
        // Example: Add a fade effect to alerts
        $('.alert').fadeIn('slow');
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    });
</script>
@endsection