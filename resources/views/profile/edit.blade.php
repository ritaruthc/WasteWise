@extends('layouts.app')

@section('title', 'Edit Profil')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<style>
    body {
        background: linear-gradient(135deg, #114B5F, #1A946F, #88D398, #F3E8D2);
        min-height: 100vh;
        margin: 0;
    }

    .card {
        border-radius: 10px;
    }
    .card-header {
        background-color: #1A946F;
        font-weight: bold;
        text-align: center;text-align: center;
    }

    .avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
    }

    .icon {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .password-requirements {
        position: static;
        width: 100%;
        padding: 0.5rem;
        background-color: #f8d7da;
        border-radius: 0.25rem;
        display: none;
        margin-top: 0.5rem;
    }

    .password-requirements ul {
        margin: 0;
        padding: 0;
    }

    .password-requirements li {
        font-size: 0.8rem;
    }

    .password-requirements li i {
        margin-right: 0.5rem;
    }

    .password-requirements li.text-success {
        color: #155724;
        background-color: #d4edda;
    }

    .password-requirements li.text-danger {
        color: #721c24;
        background-color: #f8d7da;
    }
</style>


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8" style="padding-top: 20px;">
            <div class="card">
                <div class="card-header">{{ __('Edit Profil') }}</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                    
                        {{-- Form Edit Nama --}}
                        <div class="form-group">
                            <label for="name">{{ __('Nama') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    
                        {{-- Form Edit Email --}}
                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Form Edit Avatar --}}
                        <div class="form-group">
                            <label for="avatar">{{ __('Avatar') }}</label>
                            <input type="file" class="form-control-file @error('avatar') is-invalid @enderror" id="avatar" name="avatar" accept="image/*">
                            @error('avatar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group" id="avatar-preview-container" style="display: none;">
                            <img id="avatar-preview" src="#" alt="Avatar preview" style="max-width: 300px; max-height: 300px;">
                            <button type="button" id="edit-avatar-button" class="btn btn-secondary mt-2">{{ __('Edit Avatar') }}</button>
                        </div>
                    
                        <div class="form-group" id="avatar-crop-container" style="display: none;">
                            <img id="avatar-image" src="#" alt="Avatar to crop" style="max-width: 100%;">
                            <button type="button" id="crop-button" class="btn btn-primary mt-2">{{ __('Crop') }}</button>
                        </div>
                    
                        <input type="hidden" id="cropped-avatar" name="cropped_avatar">

                        {{-- Form Edit Bio --}}
                        <div class="form-group">
                            <label for="bio">{{ __('Bio') }}</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    
                        {{-- Form Edit Points (optional, hidden if not for admin) --}}
                        @if(auth()->user()->is_admin)
                        <div class="form-group">
                            <label for="points">{{ __('Points') }}</label>
                            <input type="number" class="form-control @error('points') is-invalid @enderror" id="points" name="points" value="{{ old('points', $user->points) }}">
                            @error('points')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        @endif

                        {{-- Form Edit Password --}}
                        <div class="form-group">
                            <label for="current_password">{{ __('Password Saat Ini') }}</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password">
                            @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    
                        <div class="form-group">
                            <label for="password">{{ __('Password Baru') }}</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="password-requirements mt-2" style="display: none;">
                                <ul class="list-unstyled">
                                    <li id="length" class="text-danger">
                                        <i class="fas fa-times"></i> Minimal 8 karakter
                                    </li>
                                    <li id="uppercase" class="text-danger">
                                        <i class="fas fa-times"></i> Ada huruf kapital
                                    </li>
                                    <li id="lowercase" class="text-danger">
                                        <i class="fas fa-times"></i> Ada huruf kecil
                                    </li>
                                    <li id="number" class="text-danger">
                                        <i class="fas fa-times"></i> Ada angka
                                    </li>
                                    <li id="special" class="text-danger">
                                        <i class="fas fa-times"></i> Ada karakter spesial
                                    </li>
                                </ul>
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <label for="password_confirmation">{{ __('Konfirmasi Password') }}</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                    
                        <button type="submit" class="btn btn-success">{{ __('Simpan Perubahan') }}</button>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <img id="sample_image" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="crop" class="btn btn-primary">Crop</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
                if (croppedAvatarInput.value) {
                    // Jika ada gambar yang di-crop, tidak perlu melakukan apa-apa lagi
                    return;
                }
                if (cropper) {
                    e.preventDefault();
                    cropper.getCroppedCanvas({
                        width: 300,
                        height: 300
                    }).toBlob(function(blob) {
                        const fileReader = new FileReader();
                        fileReader.onload = function(e) {
                            croppedAvatarInput.value = e.target.result;
                            form.submit();
                        };
                        fileReader.readAsDataURL(blob);
                    }, 'image/jpeg', 0.8);
                }
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.getElementById('password');
        const requirementsDiv = document.querySelector('.password-requirements');
        const requirements = {
            length: document.getElementById('length'),
            uppercase: document.getElementById('uppercase'),
            lowercase: document.getElementById('lowercase'),
            number: document.getElementById('number'),
            special: document.getElementById('special')
        };

        const checkPassword = () => {
            const password = passwordInput.value;
            const criteria = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /\d/.test(password),
                special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
            };

            if (password.length > 0) {
                requirementsDiv.style.display = 'block';
            } else {
                requirementsDiv.style.display = 'none';
            }

            for (const key in criteria) {
                if (criteria[key]) {
                    requirements[key].classList.remove('text-danger');
                    requirements[key].classList.add('text-success');
                    requirements[key].innerHTML = `<i class="fas fa-check"></i> ${requirements[key].textContent.trim()}`;
                } else {
                    requirements[key].classList.remove('text-success');
                    requirements[key].classList.add('text-danger');
                    requirements[key].innerHTML = `<i class="fas fa-times"></i> ${requirements[key].textContent.trim()}`;
                }
            }
        };

        passwordInput.addEventListener('input', checkPassword);
        passwordInput.addEventListener('focus', checkPassword);
        passwordInput.addEventListener('blur', () => {
            if (passwordInput.value.length === 0) {
                requirementsDiv.style.display = 'none';
            }
        });
    });
</script>
@endsection