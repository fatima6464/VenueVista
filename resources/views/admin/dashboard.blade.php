@extends('layouts.main')

@section('content')
<div class="admin-wrapper">
    @include('partials.admin-header')

    <main class="admin-content container">

        <div class="mb-5">
            <h1 class="h3 fw-bold text-dark">Admin Dashboard</h1>
            <p class="text-muted">Real-time overview of your venue management system.</p>
        </div>

        <div class="row mb-5">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card bg-white border-start border-primary border-4 rounded-end shadow-sm p-4 h-100">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3">
                            <i class="fas fa-building"></i>
                        </div>
                        <div>
                            <h6 class="text-uppercase text-muted small fw-semibold mb-1">Venues</h6>
                            <h2 class="fw-bold mb-0 text-primary">{{ $venueCount }}</h2>
                        </div>
                    </div>
                    <div class="text-muted small">{{ $availableVenues }} currently listed</div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card bg-white border-start border-success border-4 rounded-end shadow-sm p-4 h-100">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-success bg-opacity-10 text-success rounded-circle p-3 me-3">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div>
                            <h6 class="text-uppercase text-muted small fw-semibold mb-1">Bookings</h6>
                            <h2 class="fw-bold mb-0 text-success">{{ $bookingCount }}</h2>
                        </div>
                    </div>
                    <div class="text-muted small">{{ $todayBookingsCount }} new today</div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card bg-white border-start border-warning border-4 rounded-end shadow-sm p-4 h-100">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning rounded-circle p-3 me-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h6 class="text-uppercase text-muted small fw-semibold mb-1">Users</h6>
                            <h2 class="fw-bold mb-0 text-warning">{{ $userCount }}</h2>
                        </div>
                    </div>
                    <div class="text-muted small">Active platform members</div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card bg-white border-start border-info border-4 rounded-end shadow-sm p-4 h-100">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-info bg-opacity-10 text-info rounded-circle p-3 me-3">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div>
                            <h6 class="text-uppercase text-muted small fw-semibold mb-1">Revenue</h6>
                            <h2 class="fw-bold mb-0 text-info">${{ number_format($totalRevenue) }}</h2>
                        </div>
                    </div>
                    <div class="text-muted small">Total confirmed revenue</div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-5">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Recent Bookings</h5>
                <a href="/admin/bookings" class="btn btn-sm btn-link text-decoration-none">Manage All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">User</th>
                                <th>Venue</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($recentBookings && $recentBookings->count() > 0)
                                @foreach ($recentBookings as $booking)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold">{{ $booking->user->name }}</div>
                                            <small class="text-muted">{{ $booking->user->email }}</small>
                                        </td>
                                        <td>{{ $booking->venue->name }}</td>
                                        <td>{{ $booking->booking_date->format('n/j/Y') }}</td>
                                        <td>
                                            <span class="badge rounded-pill {{ $booking->status === 'confirmed' ? 'bg-success' : 'bg-warning text-dark' }} px-3 py-1">
                                                {{ $booking->status }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-4 fw-bold">${{ $booking->total_amount }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="5" class="text-center py-4">No recent activity.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection