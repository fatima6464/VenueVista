@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* VenueVista Collection Design System */
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700&family=Inter:wght@300;400;500;600;700&display=swap');

    body {
        background-color: #f7f6f2;
        font-family: 'Inter', sans-serif;
        color: #334155;
    }

    .browse-container {
        padding-top: 100px;
        padding-bottom: 80px;
    }

    .page-title {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 2.5rem;
        color: #1e293b;
    }

    /* Professional Filter Bar */
    .filter-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        margin-bottom: 40px;
    }

    .filter-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 8px;
        display: block;
    }

    .form-control-vv {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 10px 15px;
        font-size: 0.9rem;
        transition: 0.3s;
    }

    .form-control-vv:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(31, 77, 58, 0.1);
        outline: none;
    }

    /* Elegant Venue Cards */
    .venue-card-vv {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .venue-card-vv:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        border-color: var(--primary);
    }

    .image-wrapper {
        height: 220px;
        position: relative;
        overflow: hidden;
    }

    .availability-tag {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 10;
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .tag-available { background: #dcfce7; color: #166534; }
    .tag-booked { background: #fee2e2; color: #991b1b; }

    .card-content {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .card-venue-name {
        font-family: 'Playfair Display', serif;
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 5px;
        text-decoration: none;
    }

    .card-location {
        font-size: 0.85rem;
        color: #64748b;
        margin-bottom: 15px;
    }

    .card-specs {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-top: 1px solid #f1f5f9;
        margin-top: auto;
    }

    .spec-box {
        text-align: center;
        flex: 1;
    }

    .spec-box:first-child { border-right: 1px solid #f1f5f9; }

    .spec-val {
        display: block;
        font-weight: 700;
        color: #1e293b;
        font-size: 0.95rem;
    }

    .spec-lbl {
        display: block;
        font-size: 0.7rem;
        color: #94a3b8;
        text-transform: uppercase;
    }

    .btn-view-vv {
        background: var(--primary);
        color: #fff !important;
        border-radius: 50px;
        padding: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
        margin-top: 15px;
        transition: 0.3s;
    }

    .btn-view-vv:hover {
        background: #153528;
    }
</style>

<div class="container browse-container">
    <header class="row mb-5">
        <div class="col-md-8">
            <h1 class="page-title">Explore Venues</h1>
            <p class="text-muted lead">Discover hand-picked spaces for your next signature event.</p>
        </div>
        <div class="col-md-4 text-md-end d-flex align-items-center justify-content-md-end">
            <span class="badge bg-white border text-dark p-2 px-3 rounded-pill shadow-sm">
                <i class="fas fa-gem text-primary me-2"></i>{{ $venues->count() }} Collections Available
            </span>
        </div>
    </header>

    <div class="filter-panel">
        <form id="filterForm" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label for="search" class="filter-label">Search Keywords</label>
                <input type="text" class="form-control-vv w-100" id="search" placeholder="Enter name, location or amenity...">
            </div>
            <div class="col-md-3">
                <label for="minCapacity" class="filter-label">Minimum Guests</label>
                <input type="number" class="form-control-vv w-100" id="minCapacity" min="1" placeholder="Any">
            </div>
            <div class="col-md-2">
                <label for="maxPrice" class="filter-label">Max Budget/Hr</label>
                <input type="number" class="form-control-vv w-100" id="maxPrice" min="0" placeholder="Any">
            </div>
            <div class="col-md-2">
                <button type="button" id="resetFilters" class="btn btn-outline-secondary rounded-pill w-100 py-2">
                    <i class="fas fa-undo-alt me-2"></i> Reset
                </button>
            </div>
        </form>
    </div>

    <div class="row" id="venuesContainer">
        @if ($venues->isEmpty())
            <div class="col-12 text-center py-5">
                <i class="fas fa-search fa-3x text-muted opacity-25 mb-4"></i>
                <h3 class="fw-bold">No Collections Found</h3>
                <p class="text-muted">Check back later or adjust your search filters.</p>
                <a href="/user/dashboard" class="btn-view-vv px-4 d-inline-block">Return to Dashboard</a>
            </div>
        @else
            @foreach ($venues as $venue)
                <div class="col-lg-4 col-md-6 mb-4 venue-card"
                     data-name="{{ strtolower($venue->name) }}"
                     data-location="{{ strtolower($venue->location) }}"
                     data-amenities="{{ strtolower(implode(',', $venue->amenities ?? [])) }}"
                     data-capacity="{{ $venue->capacity }}"
                     data-price="{{ $venue->price_per_hour }}">

                    <div class="venue-card-vv shadow-sm">
                        <div class="image-wrapper">
                            <span class="availability-tag {{ $venue->is_available ? 'tag-available' : 'tag-booked' }}">
                                {{ $venue->is_available ? 'Available' : 'Booked' }}
                            </span>

                            @if ($venue->images && count($venue->images) > 0)
                                <div id="carousel-{{ $venue->id }}" class="carousel slide h-100" data-bs-ride="carousel">
                                    <div class="carousel-inner h-100">
                                        @foreach ($venue->images as $index => $image)
                                            <div class="carousel-item h-100 {{ $index === 0 ? 'active' : '' }}">
                                                <img src="{{ $image }}" class="d-block w-100 h-100" style="object-fit: cover;">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="h-100 bg-light d-flex align-items-center justify-content-center">
                                    <i class="fas fa-camera fa-3x text-muted opacity-20"></i>
                                </div>
                            @endif
                        </div>

                        <div class="card-content">
                            <a href="/user/venues/{{ $venue->id }}" class="card-venue-name">{{ $venue->name }}</a>
                            <div class="card-location">
                                <i class="fas fa-map-marker-alt text-primary me-1"></i> {{ $venue->location }}
                            </div>

                            <div class="card-specs">
                                <div class="spec-box">
                                    <span class="spec-val">{{ $venue->capacity }}</span>
                                    <span class="spec-lbl">Guests</span>
                                </div>
                                <div class="spec-box">
                                    <span class="spec-val text-success">₹{{ $venue->price_per_hour }}</span>
                                    <span class="spec-lbl">Per Hour</span>
                                </div>
                            </div>

                            <a href="/user/venues/{{ $venue->id }}" class="btn-view-vv">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <div id="noResults" class="text-center py-5" style="display: none;">
        <i class="fas fa-search-minus fa-3x text-muted mb-4"></i>
        <h3 class="fw-bold">Refine Your Search</h3>
        <p class="text-muted">We couldn't find any venues matching those specific criteria.</p>
        <button id="resetFiltersBtn" class="btn btn-outline-primary rounded-pill px-4 mt-3">Clear All Filters</button>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const minCapacityInput = document.getElementById('minCapacity');
    const maxPriceInput = document.getElementById('maxPrice');
    const resetBtns = [document.getElementById('resetFilters'), document.getElementById('resetFiltersBtn')];
    const venueCards = document.querySelectorAll('.venue-card');
    const noResults = document.getElementById('noResults');
    const container = document.getElementById('venuesContainer');

    function filterVenues() {
        const term = searchInput.value.toLowerCase();
        const minCap = parseInt(minCapacityInput.value) || 0;
        const maxPr = parseFloat(maxPriceInput.value) || Infinity;
        let visibleCount = 0;

        venueCards.forEach(card => {
            const name = card.dataset.name;
            const loc = card.dataset.location;
            const am = card.dataset.amenities;
            const cap = parseInt(card.dataset.capacity);
            const pr = parseFloat(card.dataset.price);

            const matches = (!term || name.includes(term) || loc.includes(term) || am.includes(term)) &&
                            (cap >= minCap) && (pr <= maxPr);

            card.style.display = matches ? 'block' : 'none';
            if (matches) visibleCount++;
        });

        container.style.display = visibleCount === 0 ? 'none' : 'flex';
        noResults.style.display = visibleCount === 0 ? 'block' : 'none';
    }

    searchInput.addEventListener('input', filterVenues);
    minCapacityInput.addEventListener('input', filterVenues);
    maxPriceInput.addEventListener('input', filterVenues);

    resetBtns.forEach(btn => btn.addEventListener('click', () => {
        searchInput.value = '';
        minCapacityInput.value = '';
        maxPriceInput.value = '';
        filterVenues();
    }));
});
</script>
@endpush
@endsection