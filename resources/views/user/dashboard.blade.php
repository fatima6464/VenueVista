@extends('layouts.main')

@section('content')
<style>
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
        padding-top: 70px;
        padding-bottom: 80px;
    }

    /* Transparent to Solid Navbar Logic */
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

    /* Original Horizontal Stat Cards */
    .stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.08);
    }

    .stat-icon-circle {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .icon-total { background: #f1f5f9; color: #475569; }
    .icon-confirmed { background: #ecfdf5; color: #059669; }
    .icon-pending { background: #fffbeb; color: #d97706; }
    .icon-spent { background: #f0f9ff; color: #0284c7; }

    .stat-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 2px;
    }

    .stat-value {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        color: #1e293b;
        font-weight: 700;
        margin: 0;
    }

    /* Main Activity Table */
    .dashboard-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        overflow: hidden;
    }

    .panel-header {
        padding: 25px 30px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .panel-header h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0;
    }

    /* Venue Image Thumbnail */
    .venue-img-sm {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    /* Action Buttons */
    .btn-action {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
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

    .btn-vv-primary {
        background: var(--primary, #1f4d3a);
        color: #ffffff !important;
        padding: 10px 24px;
        border-radius: 4px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
    }

    .table-vv th {
        background: #fafafa;
        font-size: 0.7rem;
        text-transform: uppercase;
        color: #64748b;
        padding: 15px 30px;
        border: none;
    }

    .table-vv td {
        padding: 18px 30px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }

    .status-badge {
        font-size: 0.7rem;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 50px;
        text-transform: uppercase;
    }

    .status-confirmed { background: #dcfce7; color: #166534; }
    .status-pending { background: #fef3c7; color: #92400e; }

    .main-head { padding: 40px 0 30px; }
    .main-head h1 {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 2.2rem;
    }
</style>

<div class="container">
    <header class="main-head">
        <div class="row align-items-center">
            <div class="col-md-7">
                <h1>Welcome back, {{ $user->name }}</h1>
                <p class="text-muted">Manage your curated venue experiences.</p>
            </div>
            <div class="col-md-5 text-md-end">
                <a href="/user/venues" class="btn-vv-primary">
                    <i class="fas fa-plus me-2"></i>Browse Venues
                </a>
            </div>
        </div>
    </header>

    <div class="row g-3 mb-5">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon-circle icon-total"><i class="fas fa-list-ul"></i></div>
                <div class="stat-info">
                    <span class="stat-label">Bookings</span>
                    <h3 class="stat-value">{{ $bookingStats['total'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon-circle icon-confirmed"><i class="fas fa-check"></i></div>
                <div class="stat-info">
                    <span class="stat-label">Confirmed</span>
                    <h3 class="stat-value">{{ $bookingStats['confirmed'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon-circle icon-pending"><i class="fas fa-clock"></i></div>
                <div class="stat-info">
                    <span class="stat-label">Pending</span>
                    <h3 class="stat-value">{{ $bookingStats['pending'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon-circle icon-spent"><i class="fas fa-wallet"></i></div>
                <div class="stat-info">
                    <span class="stat-label">Spent</span>
                    <h3 class="stat-value">₹{{ number_format($bookingStats['totalSpent'] ?? 0) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-panel">
        <div class="panel-header">
            <h2>Recent Activity</h2>
            <a href="/user/my-bookings" class="small fw-bold text-primary text-decoration-none">VIEW ALL</a>
        </div>
        <div class="table-responsive">
            <table class="table table-vv mb-0">
                <thead>
                    <tr>
                        <th>Venue Details</th>
                        <th>Date & Time</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!$recentBookings || $recentBookings->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No reservations found.</td>
                        </tr>
                    @else
                        @foreach ($recentBookings as $booking)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        @if ($booking->venue && !empty($booking->venue->images))
                                            <img src="{{ $booking->venue->images[0] }}" class="venue-img-sm" alt="venue">
                                        @else
                                            <div class="venue-img-sm bg-light d-flex align-items-center justify-content-center">
                                                <i class="fas fa-building text-muted" style="font-size: 0.8rem;"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold text-dark">{{ $booking->venue ? $booking->venue->name : 'Untitled' }}</div>
                                            <div class="small text-muted">{{ $booking->venue ? $booking->venue->location : '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-600">{{ $booking->booking_date->format('M j') }}</div>
                                    <div class="small text-muted">{{ $booking->start_time }}</div>
                                </td>
                                <td><span class="fw-700">₹{{ $booking->total_amount }}</span></td>
                                <td>
                                    <span class="status-badge status-{{ $booking->status }}">
                                        {{ $booking->status }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="/user/venues/{{ $booking->venue ? $booking->venue->id : '' }}" class="btn-action" title="View Venue">
                                            <i class="fas fa-eye small"></i>
                                        </a>
                                        <form action="/user/bookings/cancel/{{ $booking->id }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn-action btn-delete" onclick="return confirm('Cancel this booking?')" title="Delete">
                                                <i class="fas fa-trash-alt small"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.querySelector('.vv-navbar-fixed');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 20) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    });
</script>
@endpush
@endsection