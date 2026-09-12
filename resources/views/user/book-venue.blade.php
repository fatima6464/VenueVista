@extends('layouts.main')

@section('content')
<style>
    /* VenueVista Booking System Styles preserved exactly */
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700&family=Inter:wght@300;400;500;600;700&display=swap');

    body { background-color: #f7f6f2; font-family: 'Inter', sans-serif; }
    .booking-container { padding-top: 110px; padding-bottom: 80px; }
    .venue-summary-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 20px; overflow: hidden; margin-bottom: 30px; }
    .summary-img { width: 100%; height: 100%; object-fit: cover; min-height: 150px; }
    .form-glass-panel { background: #fff; border: 1px solid #e2e8f0; border-radius: 24px; padding: 40px; box-shadow: 0 10px 25px rgba(0,0,0,0.03); }
    .form-title { font-family: 'Playfair Display', serif; font-weight: 700; font-size: 2rem; color: #1e293b; margin-bottom: 8px; }
    .form-label { font-weight: 600; font-size: 0.85rem; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-control, .form-select { border-radius: 12px; padding: 12px 16px; border: 1px solid #e2e8f0; transition: 0.3s; }
    .form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(31, 77, 58, 0.1); }
    .price-calc-box { background: #f8fafc; border-radius: 16px; padding: 24px; border: 1px dashed #cbd5e1; }
    .calc-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.95rem; }
    .total-row { margin-top: 15px; padding-top: 15px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
    .final-price { font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 700; color: var(--primary); }
    .btn-confirm { background: var(--primary); color: #fff !important; border-radius: 50px; padding: 16px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; border: none; transition: 0.3s; }
    .btn-confirm:hover { background: #153528; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(31, 77, 58, 0.2); }
</style>

<div class="container booking-container">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <a href="/user/venues/{{ $venue->id }}" class="text-muted text-decoration-none small fw-bold mb-4 d-inline-block">
                <i class="fas fa-arrow-left me-2"></i> RETURN TO DETAILS
            </a>

            <div class="form-glass-panel">
                <div class="mb-5">
                    <h1 class="form-title">Secure Your Reservation</h1>
                    <p class="text-muted">Review venue details and select your desired timeframe.</p>
                </div>

                <div class="venue-summary-card">
                    <div class="row g-0">
                        <div class="col-md-4">
                            @if (!empty($venue->images))
                                <img src="{{ $venue->images[0] }}" class="summary-img">
                            @else
                                <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8 p-4">
                            <h5 class="fw-bold mb-1">{{ $venue->name }}</h5>
                            <p class="small text-muted mb-3"><i class="fas fa-map-marker-alt me-2"></i>{{ $venue->location }}</p>
                            <div class="row small g-0">
                                <div class="col-6">
                                    <span class="text-muted d-block">Capacity</span>
                                    <span class="fw-bold">{{ $venue->capacity }} Guests</span>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted d-block">Hours</span>
                                    <span class="fw-bold">{{ $openingTime }} - {{ $closingTime }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="/user/venues/book/{{ $venue->id }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label">Pick Your Date</label>
                            <input type="date" class="form-control" id="bookingDate" name="bookingDate" 
                                   value="{{ $defaultDate }}" min="{{ $defaultDate }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Arrival Time</label>
                            <select class="form-select" id="startTime" name="startTime" required>
                                @for ($hour = (int)explode(':', $openingTime)[0]; $hour < (int)explode(':', $closingTime)[0]; $hour++)
                                    @for ($minute = 0; $minute < 60; $minute += 30)
                                        @php $time = sprintf('%02d:%02d', $hour, $minute); @endphp
                                        <option value="{{ $time }}">{{ $time }}</option>
                                    @endfor
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Departure Time</label>
                            <select class="form-select" id="endTime" name="endTime" required>
                                @for ($hour = (int)explode(':', $openingTime)[0] + 1; $hour <= (int)explode(':', $closingTime)[0]; $hour++)
                                    @for ($minute = 0; $minute < 60; $minute += 30)
                                        @php $time = sprintf('%02d:%02d', $hour, $minute); @endphp
                                        <option value="{{ $time }}">{{ $time }}</option>
                                    @endfor
                                @endfor
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Notes for the Host (Optional)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Tell us about your event requirements..."></textarea>
                        </div>

                        <div class="col-12 mt-5">
                            <div class="price-calc-box">
                                <div class="calc-row">
                                    <span class="text-muted">Base Rate</span>
                                    <span class="fw-bold">₹<span id="pricePerHour">{{ number_format($venue->price_per_hour, 2) }}</span>/hr</span>
                                </div>
                                <div class="calc-row">
                                    <span class="text-muted">Total Duration</span>
                                    <span class="fw-bold"><span id="duration">1</span> Hour(s)</span>
                                </div>
                                <div class="total-row">
                                    <span class="fw-bold text-dark">Total Estimated Investment</span>
                                    <span class="final-price">₹<span id="totalAmount">{{ number_format($venue->price_per_hour, 2) }}</span></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-confirm w-100 shadow-sm">
                                <i class="fas fa-check-circle me-2"></i> Confirm My Reservation
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript remains the same, it works as is
    document.addEventListener('DOMContentLoaded', function() {
        const startTimeSelect = document.getElementById('startTime');
        const endTimeSelect = document.getElementById('endTime');
        const durationSpan = document.getElementById('duration');
        const totalAmountSpan = document.getElementById('totalAmount');
        const pricePerHour = parseFloat(document.getElementById('pricePerHour').textContent.replace(',', ''));
        
        function calculateDuration() {
            const startTime = startTimeSelect.value;
            const endTime = endTimeSelect.value;
            
            if (!startTime || !endTime) return;
            
            const start = new Date(`2000-01-01T${startTime}`);
            const end = new Date(`2000-01-01T${endTime}`);
            
            const duration = (end - start) / (1000 * 60 * 60);
            
            if (duration > 0) {
                durationSpan.textContent = duration.toFixed(1);
                totalAmountSpan.textContent = (duration * pricePerHour).toLocaleString('en-IN', {minimumFractionDigits: 2});
            } else {
                durationSpan.textContent = '0';
                totalAmountSpan.textContent = '0.00';
            }
        }
        
        startTimeSelect.addEventListener('change', calculateDuration);
        endTimeSelect.addEventListener('change', calculateDuration);
        calculateDuration();
    });
</script>
@endsection