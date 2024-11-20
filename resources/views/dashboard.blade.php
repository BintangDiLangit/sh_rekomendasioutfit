@extends('admin.layouts.master')

@section('title', 'Dashboard')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Dashboard</h1>

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-check-circle mr-1"></i></strong>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Error Message -->
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-exclamation-circle mr-1"></i></strong>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-exclamation-triangle mr-1"></i> Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <form action="{{ route('admin.seo.update') }}" method="POST" enctype="multipart/form-data" id="seoForm">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">SEO</h6>
                    </div>
                    <div class="card-body">
                        <!-- Banner Image -->
                        <div class="mb-4">
                            <label for="banner_image" class="form-label">Banner Image</label>
                            <div class="custom-file-container">
                                <div class="preview-container mb-2" id="banner_preview_container">
                                    <div class="preview-placeholder" id="banner_placeholder"
                                        style="{{ isset($seo->banner_image) ? 'display: none;' : '' }}">
                                        <i class="fas fa-image fa-3x text-gray-300"></i>
                                        <p class="mt-2">No image selected</p>
                                    </div>
                                    <img id="banner_preview"
                                        src="{{ isset($seo->banner_image) ? asset($seo->banner_image) : '#' }}"
                                        alt="Banner Preview"
                                        style="{{ isset($seo->banner_image) ? '' : 'display: none;' }} max-width: 100%;">
                                    <button type="button" class="btn btn-sm btn-danger remove-image"
                                        data-target="banner_image"
                                        style="{{ isset($seo->banner_image) ? '' : 'display: none;' }}">
                                        <i class="fas fa-times"></i> Remove
                                    </button>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="banner_image" name="banner_image"
                                        accept="image/*">
                                    <label class="custom-file-label" for="banner_image">
                                        {{ isset($seo->banner_image) ? basename($seo->banner_image) : 'Choose banner image' }}
                                    </label>
                                </div>
                                @if (isset($seo->banner_image))
                                    <input type="hidden" name="old_banner_image" value="{{ $seo->banner_image }}">
                                @endif
                            </div>
                        </div>

                        <!-- Profile Image -->
                        <div class="mb-4">
                            <label for="profile_image" class="form-label">Profile Image</label>
                            <div class="custom-file-container">
                                <div class="preview-container mb-2" id="profile_preview_container">
                                    <div class="preview-placeholder" id="profile_placeholder"
                                        style="{{ isset($seo->profile_image) ? 'display: none;' : '' }}">
                                        <i class="fas fa-user fa-3x text-gray-300"></i>
                                        <p class="mt-2">No image selected</p>
                                    </div>
                                    <img id="profile_preview"
                                        src="{{ isset($seo->profile_image) ? asset($seo->profile_image) : '#' }}"
                                        alt="Profile Preview"
                                        style="{{ isset($seo->profile_image) ? '' : 'display: none;' }} max-width: 100%;">
                                    <button type="button" class="btn btn-sm btn-danger remove-image"
                                        data-target="profile_image"
                                        style="{{ isset($seo->profile_image) ? '' : 'display: none;' }}">
                                        <i class="fas fa-times"></i> Remove
                                    </button>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="profile_image" name="profile_image"
                                        accept="image/*">
                                    <label class="custom-file-label" for="profile_image">
                                        {{ isset($seo->profile_image) ? basename($seo->profile_image) : 'Choose profile image' }}
                                    </label>
                                </div>
                                @if (isset($seo->profile_image))
                                    <input type="hidden" name="old_profile_image" value="{{ $seo->profile_image }}">
                                @endif
                            </div>
                        </div>

                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="{{ isset($seo) ? $seo->title : old('title') }}" placeholder="Enter title">
                            <small class="text-muted">Character count: <span id="titleCount">0</span>/100</small>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" cols="30" rows="10" class="form-control"
                                placeholder="Enter description">{{ isset($seo) ? $seo->description : old('description') }}</textarea>
                            <small class="text-muted">Character count: <span id="descCount">0</span>/500</small>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Social Media URLs</h6>
                    </div>
                    <div class="card-body">
                        <!-- Social Media Inputs -->
                        <div class="mb-3">
                            <label for="instagram_url" class="form-label">
                                <i class="fab fa-instagram"></i> Instagram
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">URL</span>
                                </div>
                                <input type="text" class="form-control" id="instagram_url" name="instagram_url"
                                    value="{{ isset($seo) ? $seo->instagram_url : old('instagram_url') }}"
                                    placeholder="username">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="x_url" class="form-label">
                                <i class="fab fa-twitter"></i> X (Twitter)
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">URL</span>
                                </div>
                                <input type="text" class="form-control" id="x_url" name="x_url"
                                    value="{{ isset($seo) ? $seo->x_url : old('x_url') }}" placeholder="username">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="telegram_url" class="form-label">
                                <i class="fab fa-telegram"></i> Telegram
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">URL</span>
                                </div>
                                <input type="text" class="form-control" id="telegram_url" name="telegram_url"
                                    value="{{ isset($seo) ? $seo->telegram_url : old('telegram_url') }}"
                                    placeholder="username">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="tiktok_url" class="form-label">
                                <i class="fab fa-tiktok"></i> TikTok
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">URL</span>
                                </div>
                                <input type="text" class="form-control" id="tiktok_url" name="tiktok_url"
                                    value="{{ isset($seo) ? $seo->tiktok_url : old('tiktok_url') }}"
                                    placeholder="username">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="reset" class="btn btn-secondary">Reset</button>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    {{ isset($seo) ? 'Update' : 'Save' }} Changes
                </button>
            </div>
        </form>
    </div>

    <style>
        .custom-file-container {
            position: relative;
        }

        .preview-container {
            border: 2px dashed #ddd;
            border-radius: 4px;
            padding: 20px;
            text-align: center;
            position: relative;
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .preview-placeholder {
            color: #6c757d;
        }

        .remove-image {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .custom-file-label::after {
            content: "Browse";
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image preview functionality
            function handleImageInput(inputId, previewId, placeholderId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);
                const placeholder = document.getElementById(placeholderId);
                const removeBtn = preview.parentElement.querySelector('.remove-image');
                const oldImageInput = document.querySelector(`input[name="old_${inputId}"]`);

                input.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                            placeholder.style.display = 'none';
                            removeBtn.style.display = 'block';
                            input.parentElement.querySelector('.custom-file-label').textContent = file
                                .name;
                        };
                        reader.readAsDataURL(file);
                    }
                });

                // Remove image functionality
                removeBtn.addEventListener('click', function() {
                    input.value = '';
                    preview.src = '#';
                    preview.style.display = 'none';
                    placeholder.style.display = 'block';
                    removeBtn.style.display = 'none';
                    input.parentElement.querySelector('.custom-file-label').textContent = 'Choose file';

                    // If there's an old image, mark it for deletion
                    if (oldImageInput) {
                        oldImageInput.value = '';
                    }
                });

            }

            // Initialize image inputs
            handleImageInput('banner_image', 'banner_preview', 'banner_placeholder');
            handleImageInput('profile_image',
                'profile_preview', 'profile_placeholder');

            // Character counter for title and description
            function updateCharCount(inputId, counterId, maxLength) {
                const input = document.getElementById(inputId);
                const counter = document.getElementById(counterId);

                input.addEventListener('input', function() {
                    const count = this.value.length;
                    counter.textContent = count;

                    if (count > maxLength) {
                        counter.classList.add('text-danger');
                    } else {
                        counter.classList.remove('text-danger');
                    }
                });

                // Initial count
                counter.textContent = input.value.length;
            }

            updateCharCount('title', 'titleCount', 100);
            updateCharCount('description', 'descCount', 500);

            // Form submission handling
            const form = document.getElementById('seoForm');
            const submitBtn = document.getElementById('submitBtn');
            const spinner = submitBtn.querySelector('.spinner-border');

            form.addEventListener('submit', function(e) {
                submitBtn.disabled = true;
                spinner.classList.remove('d-none');
                submitBtn.classList.add('loading');
            });

            // Reset form handling
            form.addEventListener('reset', function(e) {
                const previews = document.querySelectorAll('img[id$="_preview"]');
                const placeholders = document.querySelectorAll('div[id$="_placeholder"]');
                const removeButtons = document.querySelectorAll('.remove-image');
                const fileLabels = document.querySelectorAll('.custom-file-label');

                previews.forEach(preview => preview.style.display = 'none');
                placeholders.forEach(placeholder => placeholder.style.display = 'block');
                removeButtons.forEach(button => button.style.display = 'none');
                fileLabels.forEach(label => label.textContent = 'Choose file');

                document.getElementById('titleCount').textContent = '0';
                document.getElementById('descCount').textContent = '0';
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    if (alert) {
                        const closeButton = alert.querySelector('button.close');
                        if (closeButton) {
                            closeButton.click();
                        }
                    }
                }, 5000);
            });
        });
    </script>
@endsection
