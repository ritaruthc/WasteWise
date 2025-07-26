@extends('layouts.app')

@section('title', 'Material Categories - WasteWise')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Material Categories</h1>
    <a href="{{ route('admin.material-categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add New Category
    </a>
</div>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td class="d-flex">
                        <a href="{{ route('admin.material-categories.edit', $category->id) }}" class="btn btn-warning btn-sm me-2">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <form action="{{ route('admin.material-categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No categories found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
    // Any custom JavaScript or jQuery for the page can go here
</script>
@endsection
