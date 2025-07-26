@extends('layouts.app')

@section('title', 'Tambah Artikel Baru')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
<style>
    body {
        background: linear-gradient(135deg, #114B5F, #1A946F, #88D398, #F3E8D2);
        min-height: 100vh;
        margin: 0;
    }
    .form-wrapper {
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
        margin: 20px auto;
        max-width: 800px;
    }
    h1 {
        color: #114B5F;
        font-weight: 600;
        margin-bottom: 30px;
        text-align: center;
    }
    .form-label {
        font-weight: 500;
        color: #1A946F;
    }
    .form-control, .form-select {
        border: 1px solid #88D398;
        border-radius: 8px;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #1A946F;
        box-shadow: 0 0 0 0.2rem rgba(26, 148, 111, 0.25);
    }
    .btn-success {
        background-color: #1A946F;
        border: none;
        padding: 10px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-success:hover {
        background-color: #114B5F;
    }
    .photo-container {
        background-color: #F3E8D2;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    #photo-image, #photo-preview {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }
    .cropper-container {
        margin-bottom: 20px;
    }
    .btn-secondary {
        background-color: #88D398;
        border: none;
        color: #114B5F;
        font-weight: 500;
    }
    .btn-secondary:hover {
        background-color: #1A946F;
        color: white;
    }
</style>
@endsection

@section('content')
<div class="form-wrapper">
    <h1>Tambah Artikel Baru</h1>

    <form action="{{ route('admin.materials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" required value="{{ old('title') }}">
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Konten</label>
            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10" required>{{ old('content') }}</textarea>
            @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                <option selected disabled>Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Gambar</label>
            <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
            <small class="form-text text-muted">Ukuran maksimum: 2MB. Format yang diizinkan: JPG, JPEG, PNG.</small>
            @error('photo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 photo-container" id="photo-crop-container" style="display: none;">
            <div class="cropper-container">
                <img id="photo-image" src="#" alt="Photo to crop">
            </div>
            <button type="button" id="crop-button" class="btn btn-primary mt-2">{{ __('Crop') }}</button>
        </div>

        <div class="mb-3 photo-container" id="photo-preview-container" style="display: none;">
            <img id="photo-preview" src="#" alt="Photo preview">
            <button type="button" id="edit-photo-button" class="btn btn-secondary mt-2">{{ __('Edit Photo') }}</button>
        </div>

        <input type="hidden" id="cropped-photo" name="cropped_photo">

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<script>
    CKEDITOR.replace('content');

    document.addEventListener('DOMContentLoaded', function () {
        const photoInput = document.getElementById('photo');
        const photoImage = document.getElementById('photo-image');
        const photoPreview = document.getElementById('photo-preview');
        const photoCropContainer = document.getElementById('photo-crop-container');
        const photoPreviewContainer = document.getElementById('photo-preview-container');
        const croppedPhotoInput = document.getElementById('cropped-photo');
        const cropButton = document.getElementById('crop-button');
        const editPhotoButton = document.getElementById('edit-photo-button');
        let cropper;

        function initCropper(imageUrl) {
            photoImage.src = imageUrl;
            photoCropContainer.style.display = 'block';
            photoPreviewContainer.style.display = 'none';

            if (cropper) {
                cropper.destroy();
            }

            cropper = new Cropper(photoImage, {
                aspectRatio: 16 / 9,
                viewMode: 1,
                minCropBoxWidth: 200,
                minCropBoxHeight: 200,
                ready: function() {
                    this.cropper.crop();
                }
            });
        }

        if (photoInput) {
            photoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        initCropper(event.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        if (cropButton) {
            cropButton.addEventListener('click', function() {
                if (cropper) {
                    const croppedCanvas = cropper.getCroppedCanvas({
                        width: 800,
                        height: 450
                    });
                    
                    croppedCanvas.toBlob(function(blob) {
                        const fileReader = new FileReader();
                        fileReader.onload = function(e) {
                            croppedPhotoInput.value = e.target.result;
                            photoPreview.src = e.target.result;
                            photoCropContainer.style.display = 'none';
                            photoPreviewContainer.style.display = 'block';
                        };
                        fileReader.readAsDataURL(blob);
                    }, 'image/jpeg', 0.8);
                }
            });
        }

        if (editPhotoButton) {
            editPhotoButton.addEventListener('click', function() {
                initCropper(photoPreview.src);
            });
        }

        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (croppedPhotoInput.value) {
                    return;
                }
                if (cropper) {
                    e.preventDefault();
                    cropper.getCroppedCanvas({
                        width: 800,
                        height: 450
                    }).toBlob(function(blob) {
                        const fileReader = new FileReader();
                        fileReader.onload = function(e) {
                            croppedPhotoInput.value = e.target.result;
                            form.submit();
                        };
                        fileReader.readAsDataURL(blob);
                    }, 'image/jpeg', 0.8);
                }
            });
        }
    });
</script>
@endsection