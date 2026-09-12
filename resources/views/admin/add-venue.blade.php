@extends('layouts.main')

@section('content')
<div class="admin-add-venue">
    @include('partials.admin-header')

    <!-- Header -->
    <div class="admin-header">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center py-4">
                        <div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-2">
                                    <li class="breadcrumb-item"><a href="/admin/dashboard" class="text-muted">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="/admin/venues" class="text-muted">Venues</a></li>
                                    <li class="breadcrumb-item active text-primary fw-semibold">Add New</li>
                                </ol>
                            </nav>
                            <h1 class="h2 fw-bold text-dark mb-1">Add New Venue</h1>
                            <p class="text-muted mb-0">Create a new venue listing with all necessary details</p>
                        </div>
                        <a href="/admin/venues" class="btn btn-outline-secondary px-4">
                            <i class="fas fa-arrow-left me-2"></i>Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <!-- Form Card -->
                <div class="card border-0 shadow-sm mb-5">
                    <form action="/admin/venues/add" method="POST" enctype="multipart/form-data" id="venueForm">
                        @csrf
                        <div class="card-header bg-white border-0 px-5 pt-5 pb-0">
                            <h3 class="fw-bold text-dark mb-4">
                                <i class="fas fa-building text-primary me-2"></i>Venue Information
                            </h3>
                        </div>

                        <div class="card-body px-5 py-4">
                            <!-- Basic Information -->
                            <div class="form-section mb-5">
                                <div class="section-header mb-4">
                                    <h5 class="fw-bold text-dark d-flex align-items-center">
                                        <span class="section-icon bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3">
                                            <i class="fas fa-info-circle"></i>
                                        </span>
                                        Basic Information
                                    </h5>
                                    <p class="text-muted small mb-0">Essential details about the venue</p>
                                </div>

                                <div class="row">
                                    <div class="col-md-8 mb-4">
                                        <label for="name" class="form-label fw-semibold">
                                            Venue Name <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-building text-muted"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0 ps-0"
                                                   id="name" name="name"
                                                   placeholder="Enter venue name" value="{{ old('name') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label for="location" class="form-label fw-semibold">
                                            Location <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-map-marker-alt text-muted"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0 ps-0"
                                                   id="location" name="location"
                                                   placeholder="City, Country" value="{{ old('location') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label for="description" class="form-label fw-semibold">
                                        Description <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-textarea-wrapper">
                                        <textarea class="form-control" id="description" name="description"
                                                  rows="4" placeholder="Describe the venue features, ambiance, and unique selling points..."
                                                  required>{{ old('description') }}</textarea>
                                        <div class="form-text text-end mt-2">
                                            <span id="charCount">0</span>/500 characters
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Capacity & Pricing -->
                            <div class="form-section mb-5">
                                <div class="section-header mb-4">
                                    <h5 class="fw-bold text-dark d-flex align-items-center">
                                        <span class="section-icon bg-success bg-opacity-10 text-success rounded-circle p-2 me-3">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                        Capacity & Pricing
                                    </h5>
                                    <p class="text-muted small mb-0">Set venue capacity and pricing structure</p>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="capacity" class="form-label fw-semibold">
                                            Capacity <span class="text-danger">*</span>
                                        </label>
                                        <div class="capacity-input">
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-users text-muted"></i>
                                                </span>
                                                <input type="number" class="form-control border-start-0 ps-0"
                                                       id="capacity" name="capacity" min="1"
                                                       placeholder="Maximum attendees" value="{{ old('capacity') }}" required>
                                                <span class="input-group-text bg-light border-start-0">
                                                    people
                                                </span>
                                            </div>
                                            <div class="form-text">Maximum number of people the venue can accommodate</div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label for="pricePerHour" class="form-label fw-semibold">
                                            Price per Hour <span class="text-danger">*</span>
                                        </label>
                                        <div class="price-input">
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-clock text-muted"></i>
                                                </span>
                                                <span class="input-group-text bg-light border-start-0 border-end-0 px-0">
                                                    $
                                                </span>
                                                <input type="number" class="form-control border-start-0 ps-0"
                                                       id="pricePerHour" name="pricePerHour"
                                                       min="0" step="0.01" placeholder="0.00" value="{{ old('pricePerHour') }}" required>
                                                <span class="input-group-text bg-light border-start-0">
                                                    / hour
                                                </span>
                                            </div>
                                            <div class="form-text">Hourly rate for booking this venue</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Operating Hours -->
                            <div class="form-section mb-5">
                                <div class="section-header mb-4">
                                    <h5 class="fw-bold text-dark d-flex align-items-center">
                                        <span class="section-icon bg-warning bg-opacity-10 text-warning rounded-circle p-2 me-3">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                        Operating Hours
                                    </h5>
                                    <p class="text-muted small mb-0">Set daily operating schedule</p>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="openingTime" class="form-label fw-semibold">Opening Time</label>
                                        <div class="time-input">
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-door-open text-muted"></i>
                                                </span>
                                                <input type="time" class="form-control border-start-0 ps-0"
                                                       id="openingTime" name="openingTime" value="{{ old('openingTime', '09:00') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label for="closingTime" class="form-label fw-semibold">Closing Time</label>
                                        <div class="time-input">
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-door-closed text-muted"></i>
                                                </span>
                                                <input type="time" class="form-control border-start-0 ps-0"
                                                       id="closingTime" name="closingTime" value="{{ old('closingTime', '18:00') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Images Upload -->
                            <div class="form-section mb-5">
                                <div class="section-header mb-4">
                                    <h5 class="fw-bold text-dark d-flex align-items-center">
                                        <span class="section-icon bg-info bg-opacity-10 text-info rounded-circle p-2 me-3">
                                            <i class="fas fa-images"></i>
                                        </span>
                                        Media & Images
                                    </h5>
                                    <p class="text-muted small mb-0">Upload venue photos (Maximum 5 images)</p>
                                </div>

                                <div class="image-upload-area mb-4">
                                    <div class="upload-dropzone border-2 border-dashed rounded-3 p-5 text-center"
                                         id="dropzone">
                                        <div class="upload-icon mb-3">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-muted"></i>
                                        </div>
                                        <h5 class="fw-semibold mb-2">Drop images here or click to upload</h5>
                                        <p class="text-muted small mb-4">Supports JPG, PNG, WEBP up to 5MB each</p>
                                        <input class="form-control d-none" type="file" id="images"
                                               name="images[]" multiple accept="image/*">
                                        <button type="button" class="btn btn-outline-primary px-4"
                                                onclick="document.getElementById('images').click()">
                                            <i class="fas fa-folder-open me-2"></i>Browse Files
                                        </button>
                                    </div>
                                    <div id="fileList" class="mt-3"></div>
                                </div>
                            </div>

                            <!-- Amenities -->
                            <div class="form-section mb-2">
                                <div class="section-header mb-4">
                                    <h5 class="fw-bold text-dark d-flex align-items-center">
                                        <span class="section-icon bg-purple bg-opacity-10 text-purple rounded-circle p-2 me-3">
                                            <i class="fas fa-concierge-bell"></i>
                                        </span>
                                        Amenities & Features
                                    </h5>
                                    <p class="text-muted small mb-0">Add available amenities and features</p>
                                </div>

                                <div class="mb-4">
                                    <label for="amenities" class="form-label fw-semibold">Amenities</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-check-circle text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0 ps-0"
                                               id="amenities" name="amenities"
                                               placeholder="WiFi, Projector, Parking, Air Conditioning, Catering, Audio System" value="{{ old('amenities') }}">
                                    </div>
                                    <div class="form-text">Separate amenities with commas</div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-white border-0 px-5 py-4">
                            <div class="d-flex justify-content-end align-items-center">
                                <div class="d-flex gap-3">
                                    <a href="/admin/venues" class="btn btn-outline-secondary px-4">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary px-5">
                                        <i class="fas fa-plus-circle me-2"></i>Create Venue
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.admin-add-venue {
    min-height: 100vh;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    padding-bottom: 3rem;
}

/* Header */
.admin-header {
    background: white;
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    margin-bottom: 2rem;
}

/* Breadcrumb */
.breadcrumb {
    --bs-breadcrumb-divider: '›';
    font-size: 0.875rem;
}

.breadcrumb-item a {
    text-decoration: none;
    transition: color 0.2s ease;
}

.breadcrumb-item a:hover {
    color: #3b82f6 !important;
}

/* Card Styling */
.card {
    border: none;
    border-radius: 12px;
    overflow: hidden;
    background: white;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

/* Form Sections */
.form-section {
    padding-bottom: 2rem;
    border-bottom: 1px solid #e5e7eb;
}

.form-section:last-of-type {
    border-bottom: none;
    padding-bottom: 0;
}

.section-header {
    padding-bottom: 1rem;
}

.section-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}

/* Form Controls */
.form-label {
    margin-bottom: 0.5rem;
    color: #374151;
    font-size: 0.95rem;
}

.input-group {
    border-radius: 8px;
    overflow: hidden;
}

.input-group-text {
    background-color: #f9fafb;
    border-color: #d1d5db;
    color: #6b7280;
    font-size: 0.9rem;
}

.form-control {
    border-color: #d1d5db;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    border-radius: 8px;
}

.form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.1);
}

.form-control.border-start-0 {
    border-left: none;
}

.form-control.border-start-0:focus {
    border-left: none;
    box-shadow: none;
}

/* Image Upload */
.upload-dropzone {
    background-color: #f8fafc;
    border-color: #cbd5e1;
    transition: all 0.3s ease;
    cursor: pointer;
}

.upload-dropzone:hover {
    background-color: #f1f5f9;
    border-color: #3b82f6;
    transform: translateY(-2px);
}
/* Active Link UI */
.header-nav-link.active {
    color: var(--primary) !important;
    font-weight: 700;
    border-bottom: 2px solid var(--primary);
    padding-bottom: 2px;
}
.upload-dropzone.dragover {
    background-color: #eff6ff;
    border-color: #3b82f6;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

.upload-icon {
    color: #94a3b8;
}

/* Amenities Tags */
.amenities-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.tag {
    background: #eff6ff;
    color: #1d4ed8;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.tag-remove {
    cursor: pointer;
    font-size: 0.75rem;
    opacity: 0.7;
}

.tag-remove:hover {
    opacity: 1;
}

/* Buttons */
.btn {
    border-radius: 8px;
    font-weight: 500;
    padding: 0.75rem 1.5rem;
    transition: all 0.2s ease;
    border-width: 1px;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(59, 130, 246, 0.25);
}

.btn-outline-primary {
    border-color: #d1d5db;
    color: #374151;
}

.btn-outline-primary:hover {
    background-color: #eff6ff;
    border-color: #3b82f6;
    color: #1d4ed8;
}

.btn-outline-secondary {
    border-color: #d1d5db;
    color: #6b7280;
}

.btn-outline-secondary:hover {
    background-color: #f9fafb;
    border-color: #9ca3af;
    color: #374151;
}

/* Alert */
.alert {
    border: none;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.alert-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.alert-heading {
    font-size: 0.95rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

/* File Upload Preview */
.file-preview {
    display: flex;
    align-items: center;
    padding: 0.75rem;
    background: #f8fafc;
    border-radius: 8px;
    margin-bottom: 0.5rem;
    border: 1px solid #e5e7eb;
}

.file-preview img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
    margin-right: 1rem;
}

.file-info {
    flex: 1;
}

.file-name {
    font-weight: 500;
    color: #374151;
    font-size: 0.9rem;
}

.file-size {
    color: #6b7280;
    font-size: 0.8rem;
}

.file-remove {
    color: #ef4444;
    cursor: pointer;
    padding: 0.5rem;
}

.file-remove:hover {
    color: #dc2626;
}

/* Checkbox */
.form-check-input {
    width: 1.1em;
    height: 1.1em;
    margin-top: 0.15em;
}

.form-check-input:checked {
    background-color: #3b82f6;
    border-color: #3b82f6;
}

.form-check-label {
    color: #6b7280;
    font-size: 0.9rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .admin-add-venue {
        padding: 1rem 0;
    }

    .admin-header {
        padding: 1rem 0;
    }

    .card-body, .card-footer, .card-header {
        padding-left: 1.5rem !important;
        padding-right: 1.5rem !important;
    }

    .upload-dropzone {
        padding: 2rem 1rem !important;
    }

    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1.5rem;
    }

    .btn {
        width: 100%;
    }
}

@media (max-width: 576px) {
    .row {
        --bs-gutter-x: 1rem;
    }

    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .section-icon {
        margin-bottom: 0.5rem;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character counter for description
    const description = document.getElementById('description');
    const charCount = document.getElementById('charCount');

    charCount.textContent = description.value.length;

    description.addEventListener('input', function() {
        charCount.textContent = this.value.length;
        if (this.value.length > 500) {
            charCount.classList.add('text-danger');
            this.classList.add('is-invalid');
        } else {
            charCount.classList.remove('text-danger');
            this.classList.remove('is-invalid');
        }
    });

    // Image upload preview
    const imageInput = document.getElementById('images');
    const dropzone = document.getElementById('dropzone');
    const fileList = document.getElementById('fileList');

    // Drag and drop functionality
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, unhighlight, false);
    });

    function highlight() {
        dropzone.classList.add('dragover');
    }

    function unhighlight() {
        dropzone.classList.remove('dragover');
    }

    dropzone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        imageInput.files = files;
        handleFiles(files);
    }

    imageInput.addEventListener('change', function(e) {
        handleFiles(this.files);
    });

    function handleFiles(files) {
        fileList.innerHTML = '';
        const maxFiles = 5;
        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        const maxSize = 5 * 1024 * 1024; // 5MB

        Array.from(files).slice(0, maxFiles).forEach(file => {
            if (!allowedTypes.includes(file.type)) {
                showAlert('error', 'Invalid file type. Please upload images only.');
                return;
            }

            if (file.size > maxSize) {
                showAlert('error', 'File size exceeds 5MB limit.');
                return;
            }

            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(e) {
                const preview = document.createElement('div');
                preview.className = 'file-preview';
                preview.innerHTML = `
                    <img src="${e.target.result}" alt="${file.name}">
                    <div class="file-info">
                        <div class="file-name">${file.name}</div>
                        <div class="file-size">${formatFileSize(file.size)}</div>
                    </div>
                    <div class="file-remove" onclick="removeFile(this)">
                        <i class="fas fa-times"></i>
                    </div>
                `;
                fileList.appendChild(preview);
            };
        });
    }

    window.removeFile = function(element) {
        element.parentElement.remove();
    };

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function showAlert(type, message) {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type === 'error' ? 'danger' : 'success'} alert-dismissible fade show`;
        alert.innerHTML = `
            <div class="d-flex align-items-center">
                <div class="alert-icon rounded-circle ${type === 'error' ? 'bg-danger' : 'bg-success'} bg-opacity-10 p-2 me-3">
                    <i class="fas ${type === 'error' ? 'fa-exclamation-circle text-danger' : 'fa-check-circle text-success'}"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="mb-0">${message}</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        document.querySelector('.container .row').insertBefore(alert, document.querySelector('.card'));

        setTimeout(() => {
            alert.remove();
        }, 5000);
    }

    // Form validation
    const form = document.getElementById('venueForm');
    form.addEventListener('submit', function(e) {
        // Basic validation
        const requiredFields = ['name', 'description', 'capacity', 'pricePerHour', 'location'];
        let isValid = true;

        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        // Capacity validation
        const capacity = document.getElementById('capacity');
        if (capacity.value < 1) {
            capacity.classList.add('is-invalid');
            isValid = false;
        }

        // Price validation
        const price = document.getElementById('pricePerHour');
        if (price.value < 0) {
            price.classList.add('is-invalid');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            showAlert('error', 'Please fill in all required fields correctly');
        }
    });
});
</script>
@endpush
@endsection