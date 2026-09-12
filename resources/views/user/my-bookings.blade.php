@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    /* VenueVista Premium Design System */
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700&family=Inter:wght@300;400;500;600;700&display=swap');

    :root {
        --bg-dashboard: #f3f5f4;
        --primary: #1f4d3a;
    }

    body {
        background-color: var(--bg-dashboard);
        font-family: 'Inter', sans-serif;
        color: #334155;
        margin: 0;
        padding-top: 50px;
    }

    /* Navbar Consistency Logic */
    .vv-navbar-fixed {
        background: transparent !important;
        backdrop-filter: none !important;
        border-bottom: none !important;
        transition: all 0.3s ease;
    }

    .vv-navbar-fixed.scrolled {
        background: rgba(255, 255, 255, 0.98) !important;
        backdrop-filter: blur(10px) !important;
        border-bottom: 1px solid #e2e8f0 !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .page-header {
        padding: 30px 0 30px;
    }

    /* Breadcrumb Link */
    .back-link {
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        color: var(--text-muted);
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 15px;
        transition: 0.2s;
    }

    .back-link:hover {
        color: var(--primary);
        transform: translateX(-3px);
    }

    .page-header h1 {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 2.2rem;
        color: #1e293b;
        margin: 0;
    }

    /* Main Table Panel */
    .booking-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .panel-top {
        padding: 25px 30px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .panel-top h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0;
    }

    /* Action Buttons */
    .btn-action {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: 0.2s;
        border: 1px solid #e2e8f0;
        background: white;
        color: #64748b;
        text-decoration: none;
    }

    .btn-action:hover {
        background: #f8fafc;
        color: var(--primary);
        border-color: var(--primary);
    }

    .btn-delete:hover {
        background: #fef2f2;
        color: #dc2626;
        border-color: #fecaca;
    }

    /* Table Formatting */
    .table-vv th {
        background: #fafafa;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        padding: 16px 30px;
        border: none;
    }

    .table-vv td {
        padding: 20px 30px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.9rem;
    }

    /* Original Backend Image Thumbnail */
    .venue-img-circle {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.08);
    }

    /* Status Pills */
    .status-badge {
        font-size: 0.7rem;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 50px;
        text-transform: uppercase;
    }

    .status-confirmed { background: #dcfce7; color: #166534; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }
    .status-pending { background: #fef3c7; color: #92400e; }

    .btn-vv-primary {
        background: var(--primary, #1f4d3a);
        color: #ffffff !important;
        padding: 10px 24px;
        border-radius: 4px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
    }
</style>

<div class="container">
    <div class="page-header">
        <a href="/user/dashboard" class="back-link">
            <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
        </a>

        <div class="row align-items-center">
            <div class="col-md-7">
                <h1>My Bookings</h1>
                <p class="text-muted">Review your history and upcoming plans.</p>
            </div>
            <div class="col-md-5 text-md-end">
                <a href="/user/venues" class="btn-vv-primary">
                    <i class="fas fa-plus me-2"></i> Book New Venue
                </a>
            </div>
        </div>
    </div>

    <div class="booking-panel">
        <div class="panel-top">
            <h2>Reservations Archive</h2>
        </div>

        @if ($bookings && $bookings->count() > 0)
            <div class="table-responsive">
                <table class="table table-vv mb-0">
                    <thead>
                        <tr>
                            <th>Venue Details</th>
                            <th>Date</th>
                            <th>Timing</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        @if ($booking->venue && !empty($booking->venue->images))
                                            <img src="{{ $booking->venue->images[0] }}" class="venue-img-circle" alt="{{ $booking->venue->name }}">
                                        @else
                                            <div class="venue-img-circle bg-light d-flex align-items-center justify-content-center">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold text-dark">{{ $booking->venue ? $booking->venue->name : 'Unknown Venue' }}</div>
                                            <div class="small text-muted"><i class="fas fa-map-marker-alt me-1"></i>{{ $booking->venue ? $booking->venue->location : 'Generic Location' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-600 text-dark">
                                        {{ $booking->booking_date ? $booking->booking_date->format('M j, Y') : 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="small fw-500 text-dark">{{ $booking->start_time }} - {{ $booking->end_time }}</div>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">₹{{ $booking->total_amount }}</span>
                                </td>
                                <td>
                                    @if ($booking->status === 'confirmed')
                                        <span class="status-badge status-confirmed">Confirmed</span>
                                    @elseif ($booking->status === 'cancelled')
                                        <span class="status-badge status-cancelled">Cancelled</span>
                                    @else
                                        <span class="status-badge status-pending">{{ $booking->status }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="/user/venues/{{ $booking->venue ? $booking->venue->id : '' }}"
                                           class="btn-action" title="View Venue">
                                            <i class="fas fa-eye small"></i>
                                        </a>

                                        @if ($booking->status !== 'cancelled')
                                            <form action="/user/bookings/cancel/{{ $booking->id }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn-action btn-delete"
                                                        onclick="return confirm('Do you want to cancel this booking?')"
                                                        title="Cancel">
                                                    <i class="fas fa-trash-alt small"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-5 text-center">
                <i class="fas fa-inbox fa-3x text-muted opacity-25 mb-3"></i>
                <p class="text-muted">You don't have any bookings yet.</p>
                <a href="/user/venues" class="btn-vv-primary mt-2">Explore Venues</a>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.querySelector('.vv-navbar-fixed');
        if(navbar) {
            window.addEventListener('scroll', function() {
                if (window.scrollY > 20) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
        }
    });
</script>
@endpush
@endsection