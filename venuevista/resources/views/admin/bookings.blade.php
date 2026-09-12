@extends('layouts.main')

@section('content')
<div class="admin-bookings">
    @include('partials.admin-header')

    <!-- Page Header -->
    <div class="dashboard-header mb-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <div class="mb-3 mb-md-0">
                            <h1 class="h3 fw-bold text-dark mb-2">Booking Management</h1>
                            <p class="text-muted mb-0">View and manage all venue bookings</p>
                        </div>
                        <div>
                            <a href="/admin/dashboard" class="btn btn-outline-secondary px-4 py-2">
                                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <!-- Bookings Table -->
                @if ($bookings && $bookings->count() > 0)
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="fw-bold text-dark mb-1">
                                        <i class="fas fa-calendar-alt text-primary me-2"></i>All Bookings
                                    </h5>
                                    <p class="text-muted mb-0 small">Manage venue bookings</p>
                                </div>
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 fw-normal">
                                    {{ $bookings->count() }} bookings
                                </span>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="py-3 ps-4">Booking Details</th>
                                            <th class="py-3">Venue</th>
                                            <th class="py-3">Date & Time</th>
                                            <th class="py-3">Amount</th>
                                            <th class="py-3">Status</th>
                                            <th class="py-3 pe-4 text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bookings as $booking)
                                            <tr class="align-middle">
                                                <td class="py-3 ps-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="booking-icon bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0 fw-semibold text-dark">{{ $booking->user->name }}</h6>
                                                            <small class="text-muted">
                                                                {{ $booking->user->email }}
                                                                <span class="mx-1">•</span>
                                                                #{{ $booking->reference }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    <h6 class="mb-0 fw-semibold">{{ $booking->venue->name }}</h6>
                                                    <small class="text-muted d-block">
                                                        <i class="fas fa-map-marker-alt me-1 small"></i>
                                                        {{ $booking->venue->location }}
                                                    </small>
                                                </td>
                                                <td class="py-3">
                                                    <div>
                                                        <span class="d-block fw-semibold">
                                                            {{ $booking->booking_date->format('D, M j') }}
                                                        </span>
                                                        <small class="text-muted">
                                                            {{ $booking->start_time }} - {{ $booking->end_time }}
                                                            <span class="mx-1">•</span>
                                                            {{ $booking->total_hours }} hr{{ $booking->total_hours > 1 ? 's' : '' }}
                                                        </small>
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    <span class="fw-bold text-success">${{ $booking->total_amount }}</span>
                                                    <small class="text-muted d-block">
                                                        @ ${{ number_format($booking->total_amount / $booking->total_hours, 2) }}/hour
                                                    </small>
                                                </td>
                                                <td class="py-3">
                                                    @if ($booking->status === 'confirmed')
                                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2">
                                                            <i class="fas fa-check-circle me-1"></i>Confirmed
                                                        </span>
                                                    @elseif ($booking->status === 'pending')
                                                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-2">
                                                            <i class="fas fa-clock me-1"></i>Pending
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2">
                                                            <i class="fas fa-times-circle me-1"></i>Cancelled
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="py-3 pe-4">
                                                    <div class="d-flex justify-content-end gap-2">
                                                        <button class="btn btn-sm btn-outline-primary px-3"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#viewBookingModal{{ $booking->id }}">
                                                            <i class="fas fa-eye me-1"></i>View
                                                        </button>
                                                        @if ($booking->status === 'pending')
                                                            <form action="/admin/bookings/confirm/{{ $booking->id }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-success px-3">
                                                                    <i class="fas fa-check me-1"></i>Confirm
                                                                </button>
                                                            </form>
                                                        @endif
                                                        @if ($booking->status !== 'cancelled')
                                                            <form action="/admin/bookings/cancel/{{ $booking->id }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-outline-danger px-3"
                                                                        onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                                    <i class="fas fa-times me-1"></i>Cancel
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                                <!-- View Booking Modal -->
                                                <div class="modal fade" id="viewBookingModal{{ $booking->id }}" tabindex="-1">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <!-- Header -->
                                                            <div class="modal-header border-bottom bg-light">
                                                                <div class="d-flex align-items-center w-100">
                                                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                                        <i class="fas fa-calendar-alt text-primary fs-5"></i>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <h5 class="modal-title fw-bold text-dark mb-0">Booking Details</h5>
                                                                        <p class="text-muted small mb-0">ID: #{{ $booking->reference }}</p>
                                                                    </div>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>
                                                            </div>

                                                            <!-- Body -->
                                                            <div class="modal-body p-0">
                                                                <!-- Status Banner -->
                                                                <div class="px-4 pt-4">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div>
                                                                            <span class="fw-semibold">Booking Status:</span>
                                                                            @if ($booking->status === 'confirmed')
                                                                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 ms-2">
                                                                                    <i class="fas fa-check-circle me-1"></i>Confirmed
                                                                                </span>
                                                                            @elseif ($booking->status === 'pending')
                                                                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-2 ms-2">
                                                                                    <i class="fas fa-clock me-1"></i>Pending
                                                                                </span>
                                                                            @else
                                                                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2 ms-2">
                                                                                    <i class="fas fa-times-circle me-1"></i>Cancelled
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                        <div class="text-end">
                                                                            <div class="text-muted small">Created</div>
                                                                            <div class="fw-semibold">{{ $booking->booking_date->format('M j, Y') }}</div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Main Content -->
                                                                <div class="px-4 py-3">
                                                                    <!-- Date & Time Section -->
                                                                    <div class="row mb-4">
                                                                        <div class="col-md-6">
                                                                            <div class="card border-0 shadow-sm h-100">
                                                                                <div class="card-body">
                                                                                    <div class="d-flex align-items-center mb-3">
                                                                                        <div class="bg-primary bg-opacity-10 rounded p-2 me-3">
                                                                                            <i class="fas fa-clock text-primary"></i>
                                                                                        </div>
                                                                                        <h6 class="mb-0 fw-semibold">Date & Time</h6>
                                                                                    </div>
                                                                                    <div class="ps-5">
                                                                                        <div class="mb-2">
                                                                                            <div class="text-muted small">Date</div>
                                                                                            <div class="fw-semibold">{{ $booking->booking_date->format('l, F j, Y') }}</div>
                                                                                        </div>
                                                                                        <div class="mb-2">
                                                                                            <div class="text-muted small">Time Slot</div>
                                                                                            <div class="fw-semibold">{{ $booking->start_time }} - {{ $booking->end_time }}</div>
                                                                                        </div>
                                                                                        <div>
                                                                                            <div class="text-muted small">Duration</div>
                                                                                            <div class="fw-semibold">{{ $booking->total_hours }} hour{{ $booking->total_hours > 1 ? 's' : '' }}</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="card border-0 shadow-sm h-100">
                                                                                <div class="card-body">
                                                                                    <div class="d-flex align-items-center mb-3">
                                                                                        <div class="bg-success bg-opacity-10 rounded p-2 me-3">
                                                                                            <i class="fas fa-dollar-sign text-success"></i>
                                                                                        </div>
                                                                                        <h6 class="mb-0 fw-semibold">Payment Summary</h6>
                                                                                    </div>
                                                                                    <div class="ps-5">
                                                                                        <div class="d-flex justify-content-between mb-1">
                                                                                            <span class="text-muted">Hourly Rate</span>
                                                                                            <span class="fw-semibold">${{ $booking->venue->price_per_hour }}/hr</span>
                                                                                        </div>
                                                                                        <div class="d-flex justify-content-between mb-1">
                                                                                            <span class="text-muted">Hours Booked</span>
                                                                                            <span class="fw-semibold">{{ $booking->total_hours }} hrs</span>
                                                                                        </div>
                                                                                        <hr class="my-2">
                                                                                        <div class="d-flex justify-content-between align-items-center">
                                                                                            <span class="fw-bold">Total Amount</span>
                                                                                            <span class="fs-5 fw-bold text-success">${{ $booking->total_amount }}</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Customer & Venue Section -->
                                                                    <div class="row mb-4">
                                                                        <!-- Customer Card -->
                                                                        <div class="col-md-6 mb-3 mb-md-0">
                                                                            <div class="card border-0 shadow-sm h-100">
                                                                                <div class="card-body">
                                                                                    <div class="d-flex align-items-center mb-3">
                                                                                        <div class="bg-info bg-opacity-10 rounded p-2 me-3">
                                                                                            <i class="fas fa-user text-info"></i>
                                                                                        </div>
                                                                                        <h6 class="mb-0 fw-semibold">Customer Details</h6>
                                                                                    </div>
                                                                                    <div class="ps-5">
                                                                                        <div class="d-flex align-items-start mb-3">
                                                                                            <div class="bg-light rounded-circle p-3 me-3">
                                                                                                <i class="fas fa-user-circle text-muted"></i>
                                                                                            </div>
                                                                                            <div>
                                                                                                <h6 class="fw-semibold mb-1">{{ $booking->user->name }}</h6>
                                                                                                <p class="text-muted small mb-2">
                                                                                                    <i class="fas fa-envelope me-1"></i>{{ $booking->user->email }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Venue Card -->
                                                                        <div class="col-md-6">
                                                                            <div class="card border-0 shadow-sm h-100">
                                                                                <div class="card-body">
                                                                                    <div class="d-flex align-items-center mb-3">
                                                                                        <div class="bg-warning bg-opacity-10 rounded p-2 me-3">
                                                                                            <i class="fas fa-building text-warning"></i>
                                                                                        </div>
                                                                                        <h6 class="mb-0 fw-semibold">Venue Details</h6>
                                                                                    </div>
                                                                                    <div class="ps-5">
                                                                                        <h6 class="fw-semibold mb-1">{{ $booking->venue->name }}</h6>
                                                                                        <p class="text-muted small mb-3">
                                                                                            <i class="fas fa-map-marker-alt me-1"></i>{{ $booking->venue->location }}
                                                                                        </p>
                                                                                        <div class="row">
                                                                                            <div class="col-6">
                                                                                                <div class="text-muted small">Capacity</div>
                                                                                                <div class="fw-semibold"><i class="fas fa-users me-1 text-muted"></i>{{ $booking->venue->capacity }} people</div>
                                                                                            </div>
                                                                                            <div class="col-6">
                                                                                                <div class="text-muted small">Hourly Rate</div>
                                                                                                <div class="fw-semibold"><i class="fas fa-tag me-1 text-muted"></i>${{ $booking->venue->price_per_hour }}/hr</div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Notes Section -->
                                                                    @if ($booking->notes)
                                                                        <div class="card border-0 shadow-sm mb-3">
                                                                            <div class="card-body">
                                                                                <div class="d-flex align-items-center mb-3">
                                                                                    <div class="bg-secondary bg-opacity-10 rounded p-2 me-3">
                                                                                        <i class="fas fa-sticky-note text-secondary"></i>
                                                                                    </div>
                                                                                    <h6 class="mb-0 fw-semibold">Customer Notes</h6>
                                                                                </div>
                                                                                <div class="ps-5">
                                                                                    <div class="bg-light rounded p-3">
                                                                                        <p class="mb-0">{{ $booking->notes }}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <!-- Footer -->
                                                            <div class="modal-footer border-top bg-light">
                                                                <div class="w-100 d-flex justify-content-end align-items-center">
                                                                    <div>
                                                                        <button type="button" class="btn btn-outline-secondary px-4 me-2" data-bs-dismiss="modal">
                                                                            <i class="fas fa-times me-2"></i>Close
                                                                        </button>

                                                                        @if ($booking->status === 'pending')
                                                                            <form action="/admin/bookings/confirm/{{ $booking->id }}" method="POST" class="d-inline">
                                                                                @csrf
                                                                                <button type="submit" class="btn btn-success px-4">
                                                                                    <i class="fas fa-check-circle me-2"></i>Confirm
                                                                                </button>
                                                                            </form>
                                                                        @endif

                                                                        @if ($booking->status !== 'cancelled')
                                                                            <form action="/admin/bookings/cancel/{{ $booking->id }}" method="POST" class="d-inline ms-2">
                                                                                @csrf
                                                                                <button type="submit" class="btn btn-outline-danger px-4"
                                                                                        onclick="return confirm('Are you sure you want to cancel this booking? This action cannot be undone.')">
                                                                                    <i class="fas fa-times-circle me-2"></i>Cancel Booking
                                                                                </button>
                                                                            </form>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if ($bookings->count() > 0)
                            <div class="card-footer bg-white border-0 py-4">
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                                    <span class="text-muted mb-2 mb-md-0 small">
                                        Showing {{ $bookings->count() }} of {{ $totalBookings }} bookings
                                    </span>
                                    <div class="d-flex gap-2">
                                        @if ($page > 1)
                                            <a href="?page={{ $page - 1 }}&status={{ $query['status'] ?? '' }}&venue={{ $query['venue'] ?? '' }}&dateFrom={{ $query['dateFrom'] ?? '' }}&dateTo={{ $query['dateTo'] ?? '' }}"
                                               class="btn btn-outline-secondary px-4">
                                                <i class="fas fa-chevron-left me-1"></i> Previous
                                            </a>
                                        @endif
                                        @if ($hasNextPage)
                                            <a href="?page={{ $page + 1 }}&status={{ $query['status'] ?? '' }}&venue={{ $query['venue'] ?? '' }}&dateFrom={{ $query['dateFrom'] ?? '' }}&dateTo={{ $query['dateTo'] ?? '' }}"
                                               class="btn btn-outline-secondary px-4">
                                                Next <i class="fas fa-chevron-right me-1"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-5">
                            <div class="text-center py-5">
                                <div class="icon-xl bg-light bg-opacity-10 text-muted rounded-circle p-4 mb-4 d-inline-flex">
                                    <i class="fas fa-calendar-times fa-3x"></i>
                                </div>
                                <h4 class="fw-bold mb-3">No Bookings Found</h4>
                                <p class="text-muted mb-4">Try adjusting your filters or check back later.</p>
                                <a href="/admin/bookings" class="btn btn-primary px-4 py-2">
                                    <i class="fas fa-redo me-2"></i>Reset Filters
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.admin-bookings {
    min-height: 100vh;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    padding: 0 0;
}

/* Header Styling */
.dashboard-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    padding: 2rem 0;
    margin-bottom: 2rem;
    background: white;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

/* Container */
.container {
    padding-left: 1.5rem;
    padding-right: 1.5rem;
    max-width: 1200px;
}

/* Stat Cards */
.stat-card {
    border-radius: 8px;
    transition: all 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
}

.stat-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Card Styling */
.card {
    border: none;
    border-radius: 12px;
    overflow: hidden;
    background: white;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

/* Table Styling */
.table {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.table thead th {
    font-weight: 600;
    color: #64748b;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #e2e8f0;
    background-color: #f8fafc;
    padding: 1rem 1.5rem;
    white-space: nowrap;
}

.table tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: all 0.2s ease;
}

.table tbody tr:last-child {
    border-bottom: none;
}

.table tbody tr:hover {
    background-color: #f8fafc;
}

.table td {
    padding: 1.25rem 1.5rem;
    vertical-align: middle;
    border-top: none;
    color: #334155;
}

.booking-icon, .customer-avatar {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.venue-icon-sm {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Badge Styling */
.badge {
    font-weight: 500;
    letter-spacing: 0.3px;
    border-radius: 20px;
    font-size: 0.85rem;
    padding: 0.5rem 1rem;
}

/* Button Styling */
.btn {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
    border-width: 1px;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

/* Form Styling */
.form-select, .form-control {
    border: 1px solid #d1d5db;
    border-radius: 6px;
    padding: 0.5rem 1rem;
}

.form-select:focus, .form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Modal Styling */
.modal-content {
    border: none;
    border-radius: 12px;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.modal-header {
    padding: 1.5rem 1.5rem 0.5rem;
}

.modal-body {
    padding: 0 1.5rem;
}

.modal-footer {
    padding: 1rem 1.5rem 1.5rem;
    border-top: 1px solid #e2e8f0;
}

/* Empty State */
.icon-xl {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Responsive Design */
@media (max-width: 768px) {
    .admin-bookings {
        padding: 1rem 0;
    }

    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .dashboard-header {
        padding: 1.5rem 0;
        margin-bottom: 1.5rem;
    }

    .table-responsive {
        font-size: 0.875rem;
    }

    .table th,
    .table td {
        padding: 1rem;
    }

    .booking-icon, .customer-avatar {
        width: 36px;
        height: 36px;
        padding: 0.5rem !important;
        margin-right: 0.75rem !important;
    }

    .d-flex.justify-content-end.gap-2 {
        flex-direction: column;
        gap: 0.5rem !important;
    }

    .btn-sm {
        width: 100%;
        justify-content: center;
    }

    .card-footer .d-flex {
        flex-direction: column;
        gap: 0.75rem;
    }

    .card-footer .btn {
        width: 100%;
    }
}

@media (max-width: 576px) {
    .table th,
    .table td {
        padding: 0.75rem;
    }

    .btn-sm {
        padding: 0.375rem 0.75rem;
    }

    .card-body.p-5 {
        padding: 2rem !important;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-close alerts after 5 seconds
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});
</script>
@endpush
@endsection