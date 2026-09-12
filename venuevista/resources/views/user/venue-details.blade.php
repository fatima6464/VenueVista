@extends('layouts.main')

@section('content')
<style>
    /* VenueVista Premium Design System */
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@300;400;500;600;700&display=swap');

    body { background-color: #f7f6f2; font-family: 'Inter', sans-serif; color: #1e293b; }
    .venue-container { padding-top: 100px; padding-bottom: 60px; }

    /* Top Hero Header Section */
    .venue-hero-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; gap: 40px; }
    .header-text-side { flex: 1; }
    .venue-name-serif { font-family: 'Playfair Display', serif; font-size: 3.5rem; font-weight: 700; line-height: 1.1; margin-bottom: 15px; color: #0f172a; }
    .location-badge { display: inline-flex; align-items: center; background: #fff; padding: 8px 16px; border-radius: 50px; border: 1px solid #e2e8f0; font-size: 0.9rem; color: #64748b; }

    /* Single Featured Image Frame */
    .featured-image-frame { width: 450px; height: 300px; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.08); background: #fff; padding: 10px; }
    .featured-image-frame img { width: 100%; height: 100%; object-fit: cover; border-radius: 16px; }

    /* Main Content Layout */
    .venue-main-layout { display: grid; grid-template-columns: 1fr 380px; gap: 60px; }
    .section-title { font-family: 'Inter', sans-serif; font-size: 1.25rem; font-weight: 700; margin-bottom: 16px; color: #0f172a; }
    .description-content { color: #475569; line-height: 1.8; font-size: 1.05rem; }
    .divider { height: 1px; background: #e2e8f0; margin: 40px 0; }

    /* Amenities Grid */
    .amenity-list { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .amenity-tag { display: flex; align-items: center; gap: 10px; font-size: 0.95rem; }
    .amenity-tag i { color: var(--primary); }

    /* Professional Sidebar */
    .booking-sidebar-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 20px; padding: 30px; position: sticky; top: 100px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04); }
    .price-display { margin-bottom: 24px; }
    .price-now { font-size: 2.2rem; font-weight: 700; font-family: 'Playfair Display', serif; }
    .spec-line { display: flex; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; }
    .btn-reserve-now { background: var(--primary); color: white !important; width: 100%; border-radius: 50px; padding: 16px; font-weight: 700; border: none; transition: 0.3s; margin-top: 25px; text-transform: uppercase; letter-spacing: 1px; }
    .btn-reserve-now:hover { background: #153528; transform: translateY(-2px); }

    @media (max-width: 992px) {
        .venue-hero-header { flex-direction: column; align-items: flex-start; }
        .featured-image-frame { width: 100%; height: 350px; }
        .venue-main-layout { grid-template-columns: 1fr; }
    }
</style>

<div class="container venue-container">
    <a href="/user/venues" class="text-muted text-decoration-none small fw-bold mb-4 d-inline-block">
        <i class="fas fa-arrow-left me-2"></i> BACK TO VENUES
    </a>

    <section class="venue-hero-header">
        <div class="header-text-side">
            <h1 class="venue-name-serif">{{ $venue->name }}</h1>
            <div class="location-badge">
                <i class="fas fa-map-marker-alt me-2 text-primary"></i> 
                {{ $venue->location }}
            </div>
        </div>

        <div class="featured-image-frame">
            @if (!empty($venue->images))
                <img src="{{ $venue->images[0] }}" alt="{{ $venue->name }}">
            @else
                <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                    <i class="fas fa-image fa-3x text-muted opacity-25"></i>
                </div>
            @endif
        </div>
    </section>

    <div class="venue-main-layout">
        <main>
            <section>
                <h2 class="section-title">Description</h2>
                <div class="description-content">
                    {{ $venue->description }}
                </div>
            </section>

            <div class="divider"></div>

            <section>
                <h2 class="section-title">Amenities & Offerings</h2>
                <div class="amenity-list">
                    @if (!empty($venue->amenities))
                        @foreach ($venue->amenities as $item)
                            <div class="amenity-tag">
                                <i class="fas fa-check-circle"></i> {{ $item }}
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted small">Standard amenities included.</p>
                    @endif
                </div>
            </section>
        </main>

        <aside>
            <div class="booking-sidebar-card">
                <div class="price-display">
                    <span class="price-now">₹{{ number_format($venue->price_per_hour, 2) }}</span>
                    <span class="text-muted small"> / hour</span>
                </div>

                <div class="spec-line">
                    <span class="text-muted">Booking Status</span>
                    <span class="fw-bold {{ $venue->is_available ? 'text-success' : 'text-danger' }}">
                        {{ $venue->is_available ? 'Available' : 'Unavailable' }}
                    </span>
                </div>
                
                <div class="spec-line">
                    <span class="text-muted">Guest Capacity</span>
                    <span class="fw-bold">{{ $venue->capacity }} People</span>
                </div>

                <div class="spec-line">
                    <span class="text-muted">Working Hours</span>
                    <span class="fw-bold">
                        {{ $venue->opening_time ?? '09:00' }} - 
                        {{ $venue->closing_time ?? '21:00' }}
                    </span>
                </div>

                @if ($venue->is_available)
                    <a href="/user/venues/book/{{ $venue->id }}" class="btn btn-reserve-now">
                        Reserve Now
                    </a>
                @else
                    <button class="btn btn-secondary w-100 rounded-pill py-3 mt-4" disabled>
                        Not Available
                    </button>
                @endif

                <div class="text-center mt-3">
                    <small class="text-muted"><i class="fas fa-lock me-1"></i> Secure booking through VenueVista</small>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection