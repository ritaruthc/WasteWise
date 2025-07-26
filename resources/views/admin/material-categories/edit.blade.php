@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
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
    .photo-container {
        max-width: 100%;
        margin-bottom: 20px;
    }
    #photo-image, #photo-preview {
        max-width: 100%;
        height: auto;
    }
    .cropper-container {
        margin-bottom: 20px;
    }
    .btn-primary {
        background-color: #1A946F;
        border-color: #1A946F;
    }
    .btn-primary:hover {
        background-color: #147a5e;
        border-color: #147a5e;
    }
    .form-control:focus {
        border-color: #1A946F;
        box-shadow: 0 0 0 0.2rem rgba(26, 148, 111, 0.25);
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">{{ __('Edit Kategori') }}</h4>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.material-categories.update', $materialCategory->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                    
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Nama') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $materialCategory->name) }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">{{ __('Slug') }}</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $materialCategory->slug) }}" required>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Deskripsi') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{ old('description', $materialCategory->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="avatar" class="form-label">{{ __('Gambar') }}</label>
                            <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar" accept="image/*">
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3" id="avatar-preview-container" style="display: none;">
                            <img id="avatar-preview" src="#" alt="Avatar preview" class="img-thumbnail" style="max-width: 300px; max-height: 300px;">
                            <button type="button" id="edit-avatar-button" class="btn btn-secondary mt-2">
                                <i class="fas fa-edit me-2"></i>{{ __('Edit Gambar') }}
                            </button>
                        </div>
                    
                        <div class="mb-3" id="avatar-crop-container" style="display: none;">
                            <img id="avatar-image" src="#" alt="Avatar to crop" style="max-width: 100%;">
                            <button type="button" id="crop-button" class="btn btn-primary mt-2">
                                <i class="fas fa-crop me-2"></i>{{ __('Crop') }}
                            </button>
                        </div>
                    
                        <input type="hidden" id="cropped-avatar" name="cropped_avatar">

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>{{ __('Simpan Perubahan') }}
                            </button>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Crop Image Modal -->
<div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="cropImagePopLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cropImagePopLabel">Crop Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <img id="sample_image" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="crop" class="btn btn-primary">Crop</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const avatarInput = document.getElementById('avatar');
    const avatarImage = document.getElementById('avatar-image');
    const avatarPreview = document.getElementById('avatar-preview');
    const avatarCropContainer = document.getElementById('avatar-crop-container');
    const avatarPreviewContainer = document.getElementById('avatar-preview-container');
    const croppedAvatarInput = document.getElementById('cropped-avatar');
    const cropButton = document.getElementById('crop-button');
    const editAvatarButton = document.getElementById('edit-avatar-button');
    const categoryNameInput = document.getElementById('category-name');
    let cropper;

    function initCropper(imageUrl) {
        avatarImage.src = imageUrl;
        avatarCropContainer.style.display = 'block';
        avatarPreviewContainer.style.display = 'none';

        if (cropper) {
            cropper.destroy();
        }

        cropper = new Cropper(avatarImage, {
            aspectRatio: 1,
            viewMode: 1,
            minCropBoxWidth: 200,
            minCropBoxHeight: 200,
            ready: function() {
                this.cropper.crop();
            }
        });
    }

    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
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
                    width: 300,
                    height: 300
                });
                
                croppedCanvas.toBlob(function(blob) {
                    const fileReader = new FileReader();
                    fileReader.onload = function(e) {
                        croppedAvatarInput.value = e.target.result;
                        avatarPreview.src = e.target.result;
                        avatarCropContainer.style.display = 'none';
                        avatarPreviewContainer.style.display = 'block';
                    };
                    fileReader.readAsDataURL(blob);
                }, 'image/jpeg', 0.8);
            }
        });
    }

    if (editAvatarButton) {
        editAvatarButton.addEventListener('click', function() {
            initCropper(avatarPreview.src);
        });
    }

    // Tambahkan event listener untuk form submission
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (cropper) {
                cropper.getCroppedCanvas({
                    width: 300,
                    height: 300
                }).toBlob(function(blob) {
                    const formData = new FormData(form);
                    formData.delete('avatar'); // Remove the original file input
                    formData.append('avatar', blob, 'category-image.png');
                    
                    fetch('/save-category-image', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Category image saved successfully!');
                            // Optionally redirect or update UI
                        } else {
                            alert('Error saving category image: ' + data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while saving the image.');
                    });
                }, 'image/png', 1);
            }
        });
    }
    const express = require('express');
    const multer = require('multer');
    const path = require('path');
    const fs = require('fs');

    const app = express();

    // Konfigurasi penyimpanan multer
    const storage = multer.diskStorage({
    destination: function (req, file, cb) {
        const dir = path.join(__dirname, 'public', 'images', 'kategori');
        if (!fs.existsSync(dir)) {
        fs.mkdirSync(dir, { recursive: true });
        }
        cb(null, dir);
    },
    filename: function (req, file, cb) {
        const categoryName = req.body.categoryName || 'default';
        cb(null, `${categoryName}.png`);
    }
    });

    const upload = multer({ storage: storage });

    app.post('/save-category-image', upload.single('avatar'), (req, res) => {
    if (req.file) {
        res.json({ success: true, filename: req.file.filename });
    } else {
        res.status(400).json({ success: false, error: 'No file uploaded' });
    }
    });
    // ... kode server lainnya

    app.listen(3000, () => {
    console.log('Server running on port 3000');
    });

});
</script>
@endsection