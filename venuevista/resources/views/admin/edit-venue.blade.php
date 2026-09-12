@extends('layouts.main')

@section('content')
<div class="admin-edit-venue">
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
                                    <li class="breadcrumb-item active text-primary fw-semibold">Edit Venue</li>
                                </ol>
                            </nav>
                            <h1 class="h2 fw-bold text-dark mb-1">Edit Venue</h1>
                            <p class="text-muted mb-0">Update the venue details and images</p>
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
        @if (session('error'))
        <div class="row justify-content-center mb-4">
            <div class="col-xl-10">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="alert-icon rounded-circle bg-danger bg-opacity-10 p-2 me-3">
                            <i class="fas fa-exclamation-circle text-danger"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-0">{{ session('error') }}</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if (session('success'))
        <div class="row justify-content-center mb-4">
            <div class="col-xl-10">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="alert-icon rounded-circle bg-success bg-opacity-10 p-2 me-3">
                            <i class="fas fa-check-circle text-success"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-0">{{ session('success') }}</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-xl-10">
                <!-- Form Card -->
                <div class="card border-0 shadow-sm mb-5">
                    <form action="/admin/venues/edit/{{ $venue->id }}" method="POST" enctype="multipart/form-data" id="editVenueForm">
                        @csrf
                        <div class="card-header bg-white border-0 px-5 pt-5 pb-0">
                            <h3 class="fw-bold text-dark mb-4">
                                <i class="fas fa-edit text-primary me-2"></i>Edit Venue Information
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
                                                   value="{{ old('name', $venue->name) }}"
                                                   placeholder="Enter venue name" required>
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
                                                   value="{{ old('location', $venue->location) }}"
                                                   placeholder="City, Country" required>
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
                                                  required>{{ old('description', $venue->description) }}</textarea>
                                        <div class="form-text text-end mt-2">
                                            <span id="charCount">{{ strlen($venue->description ?? '') }}</span>/500 characters
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
                                                       value="{{ old('capacity', $venue->capacity) }}"
                                                       placeholder="Maximum attendees" required>
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
                                                       value="{{ old('pricePerHour', $venue->price_per_hour) }}"
                                                       min="0" step="0.01" placeholder="0.00" required>
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
                                                       id="openingTime" name="openingTime"
                                                       value="{{ old('openingTime', $venue->opening_time ?? '09:00') }}">
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
                                                       id="closingTime" name="closingTime"
                                                       value="{{ old('closingTime', $venue->closing_time ?? '18:00') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Current Images -->
                            @if (!empty($venue->images))
                            <div class="form-section mb-5">
                                <div class="section-header mb-4">
                                    <h5 class="fw-bold text-dark d-flex align-items-center">
                                        <span class="section-icon bg-info bg-opacity-10 text-info rounded-circle p-2 me-3">
                                            <i class="fas fa-images"></i>
                                        </span>
                                        Current Images
                                    </h5>
                                    <p class="text-muted small mb-0">Manage existing venue photos</p>
                                </div>

                                <div class="row g-3">
                                    @foreach ($venue->images as $index => $image)
                                    <div class="col-md-4">
                                        <div class="current-image-card">
                                            <div class="image-wrapper position-relative">
                                                <img src="{{ $image }}" class="img-fluid rounded" alt="Venue Image"
                                                     style="height: 180px; width: 100%; object-fit: cover;">
                                                <div class="image-overlay position-absolute top-0 end-0 p-2">
                                                    <div class="form-check form-switch mb-2">
                                                        <input class="form-check-input" type="checkbox"
                                                            role="switch" id="image-{{ $index }}"
                                                            name="existingImages[]"
                                                            value="{{ $image }}"
                                                            checked>
                                                        <label class="form-check-label small text-white" for="image-{{ $index }}">
                                                            Keep
                                                        </label>
                                                    </div>
                                                    <button type="button"
                                                            class="btn btn-sm btn-danger delete-image-btn"
                                                            data-venue-id="{{ $venue->id }}"
                                                            data-image-url="{{ $image }}"
                                                            data-image-index="{{ $index }}">
                                                        <i class="fas fa-trash me-1"></i> Remove
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Add New Images -->
                            <div class="form-section mb-5">
                                <div class="section-header mb-4">
                                    <h5 class="fw-bold text-dark d-flex align-items-center">
                                        <span class="section-icon bg-info bg-opacity-10 text-info rounded-circle p-2 me-3">
                                            <i class="fas fa-plus-circle"></i>
                                        </span>
                                        Add New Images
                                    </h5>
                                    <p class="text-muted small mb-0">Upload additional venue photos (Max 5 total images)</p>
                                </div>

                                <div class="image-upload-area mb-4">
                                    <div class="upload-dropzone border-2 border-dashed rounded-3 p-5 text-center"
                                         id="dropzone">
                                        <div class="upload-icon mb-3">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-muted"></i>
                                        </div>
                                        <h5 class="fw-semibold mb-2">Drop images here or click to upload</h5>
                                        <p class="text-muted small mb-4">Supports JPG, PNG, WEBP up to 5MB each</p>
                                        <div class="mb-3">
                                            @if (!empty($venue->images))
                                            <div class="alert alert-info d-inline-flex align-items-center py-2 px-3">
                                                <i class="fas fa-info-circle me-2"></i>
                                                You can add up to {{ 5 - count($venue->images) }} more images
                                            </div>
                                            @else
                                            <div class="alert alert-info d-inline-flex align-items-center py-2 px-3">
                                                <i class="fas fa-info-circle me-2"></i>
                                                You can upload up to 5 images
                                            </div>
                                            @endif
                                        </div>
                                        <input class="form-control d-none" type="file" id="newImages"
                                               name="newImages[]" multiple accept="image/*">
                                        <button type="button" class="btn btn-outline-primary px-4"
                                                onclick="document.getElementById('newImages').click()">
                                            <i class="fas fa-folder-open me-2"></i>Browse Files
                                        </button>
                                    </div>
                                    <div id="fileList" class="mt-3"></div>
                                </div>
                            </div>

                            <!-- Amenities -->
                            <div class="form-section mb-5">
                                <div class="section-header mb-4">
                                    <h5 class="fw-bold text-dark d-flex align-items-center">
                                        <span class="section-icon bg-purple bg-opacity-10 text-purple rounded-circle p-2 me-3">
                                            <i class="fas fa-concierge-bell"></i>
                                        </span>
                                        Amenities & Features
                                    </h5>
                                    <p class="text-muted small mb-0">Update available amenities and features</p>
                                </div>

                                <div class="mb-4">
                                    <label for="amenities" class="form-label fw-semibold">Amenities</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-check-circle text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0 ps-0"
                                               id="amenities" name="amenities"
                                               value="{{ old('amenities', !empty($venue->amenities) ? implode(', ', $venue->amenities) : '') }}"
                                               placeholder="WiFi, Projector, Parking, Air Conditioning, Catering, Audio System">
                                    </div>
                                    <div class="form-text">Separate amenities with commas</div>

                                </div>
                            </div>

                            <!-- Availability -->
                            <div class="form-section mb-2">
                                <div class="section-header mb-4">
                                    <h5 class="fw-bold text-dark d-flex align-items-center">
                                        <span class="section-icon bg-teal bg-opacity-10 text-teal rounded-circle p-2 me-3">
                                            <i class="fas fa-toggle-on"></i>
                                        </span>
                                        Availability
                                    </h5>
                                    <p class="text-muted small mb-0">Control venue booking availability</p>
                                </div>

                                <div class="mb-4">
                                    <div class="availability-toggle">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="isAvailable" name="isAvailable" value="true"
                                                   {{ $venue->is_available ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="isAvailable">
                                                <span class="d-flex align-items-center">
                                                    <i class="fas fa-calendar-check me-2 text-success"></i>
                                                    Venue is available for bookings
                                                </span>
                                            </label>
                                        </div>
                                        <div class="form-text mt-2">
                                            <i class="fas fa-info-circle text-muted me-1"></i>
                                            Toggle to make venue available or unavailable for new bookings
                                        </div>
                                    </div>
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
                                        <i class="fas fa-save me-2"></i>Update Venue
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
.admin-edit-venue {
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

/* Current Images */
.current-image-card {
    position: relative;
    transition: transform 0.2s ease;
}

.current-image-card:hover {
    transform: translateY(-2px);
}

.current-image-card .image-wrapper {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.image-overlay {
    background: linear-gradient(180deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 100%);
    border-bottom-left-radius: 8px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.current-image-card:hover .image-overlay {
    opacity: 1;
}

/* Form Switch */
.form-check-input {
    width: 2.5em;
    height: 1.4em;
}

.form-check-input:checked {
    background-color: #10b981;
    border-color: #10b981;
}

.form-check-input:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.25);
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

.upload-dropzone.dragover {
    background-color: #eff6ff;
    border-color: #3b82f6;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

.upload-icon {
    color: #94a3b8;
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

.btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    border: none;
}

.btn-danger:hover {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(239, 68, 68, 0.25);
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

/* Responsive Design */
@media (max-width: 768px) {
    .admin-edit-venue {
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

    .current-image-card .image-overlay {
        opacity: 1;
        background: rgba(0,0,0,0.5);
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

    .col-md-4 {
        margin-bottom: 1rem;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character counter for description
    const description = document.getElementById('description');
    const charCount = document.getElementById('charCount');

    if (description && charCount) {
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
    }

    // New images upload preview (same as add page)
    const newImagesInput = document.getElementById('newImages');
    const dropzone = document.getElementById('dropzone');
    const fileList = document.getElementById('fileList');

    if (newImagesInput && dropzone) {
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
            newImagesInput.files = files;
            handleFiles(files);
        }

        newImagesInput.addEventListener('change', function(e) {
            handleFiles(this.files);
            const existingImages = document.querySelectorAll('input[name="existingImages[]"]:checked').length;
            const newImagesCount = this.files ? this.files.length : 0;
            const totalImages = existingImages + newImagesCount;

            if (totalImages > 5) {
                showAlert('error', `Warning: You have selected ${totalImages} images. Maximum allowed is 5.`);
            }
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
    }

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
    const form = document.getElementById('editVenueForm');
    if (form) {
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
            if (capacity && capacity.value < 1) {
                capacity.classList.add('is-invalid');
                isValid = false;
            }

            // Price validation
            const price = document.getElementById('pricePerHour');
            if (price && price.value < 0) {
                price.classList.add('is-invalid');
                isValid = false;
            }

            // Images validation (max 5 total)
            const existingImages = document.querySelectorAll('input[name="existingImages[]"]:checked');
            const newImagesInputEl = document.getElementById('newImages');
            const newImagesCount = newImagesInputEl && newImagesInputEl.files ? newImagesInputEl.files.length : 0;
            const totalImages = existingImages.length + newImagesCount;

            if (totalImages > 5) {
                e.preventDefault();
                showAlert('error', `Total images cannot exceed 5. You selected ${totalImages} images. Please remove ${totalImages - 5} image(s).`);
                isValid = false;
            }

            // Operating hours validation
            const openingTime = document.getElementById('openingTime');
            const closingTime = document.getElementById('closingTime');

            if (openingTime && closingTime && openingTime.value && closingTime.value) {
                if (openingTime.value >= closingTime.value) {
                    e.preventDefault();
                    showAlert('error', 'Opening time must be before closing time');
                    isValid = false;
                }
            }

            if (!isValid) {
                e.preventDefault();
                showAlert('error', 'Please fill in all required fields correctly');
            }
        });
    }

    // Delete image button handler (same as original)
    document.querySelectorAll('.delete-image-btn').forEach(button => {
        button.addEventListener('click', function() {
            const venueId = this.getAttribute('data-venue-id');
            const imageUrl = this.getAttribute('data-image-url');
            const imageIndex = this.getAttribute('data-image-index');

            if (confirm('Are you sure you want to delete this image? This action cannot be undone.')) {
                const data = {
                    imageUrl: imageUrl,
                    imageIndex: imageIndex
                };

                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Deleting...';
                this.disabled = true;

                fetch(`/admin/venues/delete-image/${venueId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const imageCard = this.closest('.col-md-4');
                        if (imageCard) {
                            imageCard.remove();
                        }

                        const checkbox = document.getElementById(`image-${imageIndex}`);
                        if (checkbox) {
                            checkbox.checked = false;
                            checkbox.disabled = true;
                        }

                        const currentImages = document.querySelectorAll('.col-md-4');
                        const infoAlert = document.querySelector('.upload-dropzone .alert-info');
                        if (infoAlert) {
                            infoAlert.innerHTML = `<i class="fas fa-info-circle me-2"></i>You can add up to ${5 - currentImages.length} more images`;
                        }

                        showAlert('success', data.message || 'Image deleted successfully!');
                    } else {
                        throw new Error(data.message || 'Failed to delete image');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('error', error.message || 'Error deleting image. Please try again.');

                    this.innerHTML = originalText;
                    this.disabled = false;
                });
            }
        });
    });
});
</script>
@endpush
@endsection