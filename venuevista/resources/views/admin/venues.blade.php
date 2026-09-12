@extends('layouts.main')

@section('content')
<div class="admin-venues">
    @include('partials.admin-header')

    <div class="dashboard-header mb-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <div class="mb-3 mb-md-0">
                            <h1 class="h3 fw-bold text-dark mb-2">Venue Management</h1>
                            <p class="text-muted mb-0">Manage all venue listings and settings</p>
                        </div>
                        <div>
                            <a href="/admin/venues/add" class="btn btn-primary px-4 py-2">
                                <i class="fas fa-plus-circle me-2"></i>Add New Venue
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                @if ($venues->isNotEmpty())
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="fw-bold text-dark mb-1">
                                        <i class="fas fa-building text-primary me-2"></i>All Venues
                                    </h5>
                                    <p class="text-muted mb-0 small">Manage your venue listings</p>
                                </div>
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 fw-normal">
                                    {{ $venues->count() }} venues
                                </span>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="py-3 ps-4">Venue Name</th>
                                            <th class="py-3">Price/Hour</th>
                                            <th class="py-3">Capacity</th>
                                            <th class="py-3">Status</th>
                                            <th class="py-3 pe-4 text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($venues as $venue)
                                        <tr class="align-middle">
                                            <td class="py-3 ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="venue-icon bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3">
                                                        <i class="fas fa-building"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 fw-semibold text-dark">{{ $venue->name }}</h6>
                                                        <div class="d-flex align-items-center mt-1">
                                                            <i class="fas fa-clock text-muted me-1 small"></i>
                                                            <small class="text-muted">
                                                                {{ $venue->opening_time ?? '09:00' }} - {{ $venue->closing_time ?? '18:00' }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <span class="fw-bold text-success">${{ $venue->price_per_hour }}</span>
                                                <small class="text-muted d-block">per hour</small>
                                            </td>
                                            <td class="py-3">
                                                <span class="fw-semibold text-dark">{{ $venue->capacity }}</span>
                                                <small class="text-muted d-block">people</small>
                                            </td>
                                            <td class="py-3">
                                                <span class="badge {{ $venue->is_available ? 'bg-success bg-opacity-10 text-success border border-success' : 'bg-danger bg-opacity-10 text-danger border border-danger' }} px-3 py-2">
                                                    <i class="fas fa-circle {{ $venue->is_available ? 'text-success' : 'text-danger' }} me-1 small"></i>
                                                    {{ $venue->is_available ? 'Available' : 'Unavailable' }}
                                                </span>
                                            </td>
                                            <td class="py-3 pe-4">
                                                <div class="d-flex justify-content-end gap-2">
                                                    <a href="/admin/venues/edit/{{ $venue->id }}" class="btn btn-sm btn-outline-primary px-3">
                                                        <i class="fas fa-edit me-1"></i>Edit
                                                    </a>
                                                    <form action="/admin/venues/toggle/{{ $venue->id }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm {{ $venue->is_available ? 'btn-outline-warning' : 'btn-outline-success' }} px-3">
                                                            <i class="fas {{ $venue->is_available ? 'fa-ban' : 'fa-check' }} me-1"></i>
                                                            {{ $venue->is_available ? 'Disable' : 'Enable' }}
                                                        </button>
                                                    </form>
                                                    <button type="button" class="btn btn-sm btn-outline-danger px-3 delete-btn"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#deleteModal"
                                                            data-venue-id="{{ $venue->id }}"
                                                            data-venue-name="{{ $venue->name }}">
                                                        <i class="fas fa-trash me-1"></i>Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 py-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                                <span class="text-muted mb-2 mb-md-0 small">
                                    Total of <span class="fw-semibold">{{ $venues->count() }}</span> venues
                                </span>
                                <div class="d-flex gap-2">
                                    <a href="/admin/dashboard" class="btn btn-outline-secondary px-4">
                                        <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-5">
                            <div class="text-center py-5">
                                <div class="icon-xl bg-light bg-opacity-10 text-muted rounded-circle p-4 mb-4 d-inline-flex">
                                    <i class="fas fa-building fa-3x"></i>
                                </div>
                                <h4 class="fw-bold mb-3">No Venues Yet</h4>
                                <p class="text-muted mb-4">Start by adding your first venue to the system.</p>
                                <a href="/admin/venues/add" class="btn btn-primary px-4 py-2">
                                    <i class="fas fa-plus-circle me-2"></i>Add First Venue
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold text-dark">
                    <i class="fas fa-exclamation-circle text-danger me-2"></i>Delete Venue
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-4">
                <p>Are you sure you want to delete <strong id="venueName"></strong>?</p>
                <p class="text-muted small mb-0">This action cannot be undone.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger px-4">Delete Venue</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteModal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteForm');
        const venueNameSpan = document.getElementById('venueName');
        
        deleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const venueId = button.getAttribute('data-venue-id');
            const venueName = button.getAttribute('data-venue-name');
            
            venueNameSpan.textContent = venueName;
            deleteForm.action = `/admin/venues/delete/${venueId}`;
        });
    });
</script>
@endpush