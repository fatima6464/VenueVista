<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // GET /user/venues
    public function venues()
    {
        $venues = Venue::where('is_available', true)
            ->orderByDesc('created_at')
            ->get();

        return view('user.venues', [
            'title' => 'Browse Venues',
            'venues' => $venues,
        ]);
    }

    // GET /user/venues/{id}
    public function venueDetails($id)
    {
        $venue = Venue::find($id);

        if (! $venue) {
            return redirect('/user/venues')->with('error', 'Venue not found');
        }

        $similarVenues = Venue::where('id', '!=', $venue->id)
            ->where('is_available', true)
            ->where(function ($q) use ($venue) {
                $q->where('location', $venue->location)
                    ->orWhereBetween('price_per_hour', [$venue->price_per_hour * 0.7, $venue->price_per_hour * 1.3])
                    ->orWhereBetween('capacity', [$venue->capacity * 0.7, $venue->capacity * 1.3]);
            })
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        return view('user.venue-details', [
            'title' => $venue->name,
            'venue' => $venue,
            'similarVenues' => $similarVenues,
        ]);
    }

    // GET /user/venues/book/{id}
    public function bookVenuePage($id)
    {
        $venue = Venue::find($id);

        if (! $venue) {
            return redirect('/user/venues')->with('error', 'Venue not found');
        }

        $defaultDate = Carbon::tomorrow()->format('Y-m-d');

        return view('user.book-venue', [
            'title' => "Book {$venue->name}",
            'venue' => $venue,
            'defaultDate' => $defaultDate,
            'openingTime' => $venue->opening_time ?? '09:00',
            'closingTime' => $venue->closing_time ?? '18:00',
        ]);
    }

    // POST /user/venues/book/{id}
    public function bookVenue(Request $request, $id)
    {
        $request->validate([
            'bookingDate' => ['required', 'date'],
            'startTime' => ['required'],
            'endTime' => ['required'],
            'notes' => ['nullable', 'string'],
        ]);

        $venue = Venue::find($id);

        if (! $venue) {
            return redirect('/user/venues')->with('error', 'Venue not found');
        }

        if (! $venue->is_available) {
            return redirect("/user/venues/{$id}")->with('error', 'Venue is not available for booking');
        }

        $startHour = (int) explode(':', $request->startTime)[0];
        $endHour = (int) explode(':', $request->endTime)[0];
        $totalHours = $endHour - $startHour;

        if ($totalHours <= 0) {
            return redirect("/user/venues/book/{$id}")->with('error', 'End time must be after start time');
        }

        $totalAmount = $totalHours * $venue->price_per_hour;

        $existingBooking = Booking::where('venue_id', $id)
            ->where('booking_date', $request->bookingDate)
            ->where('start_time', $request->startTime)
            ->whereIn('status', ['pending', 'confirmed'])
            ->first();

        if ($existingBooking) {
            return redirect("/user/venues/book/{$id}")->with('error', 'Venue already booked for this time slot');
        }

        Booking::create([
            'user_id' => auth()->id(),
            'venue_id' => $id,
            'booking_date' => $request->bookingDate,
            'start_time' => $request->startTime,
            'end_time' => $request->endTime,
            'total_hours' => $totalHours,
            'total_amount' => $totalAmount,
            'notes' => $request->notes ?? '',
            'status' => 'pending',
        ]);

        return redirect('/user/my-bookings')->with('success', 'Venue booked successfully! Your booking is pending confirmation.');
    }

    // GET /user/my-bookings
    public function myBookings()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with('venue:id,name,location')
            ->orderByDesc('booking_date')
            ->get();

        return view('user.my-bookings', [
            'title' => 'My Bookings',
            'bookings' => $bookings,
        ]);
    }

    // POST /user/bookings/cancel/{id}
    public function cancelBooking($id)
    {
        $updated = Booking::where('id', $id)
            ->where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'confirmed'])
            ->update(['status' => 'cancelled']);

        if (! $updated) {
            return redirect('/user/my-bookings')->with('error', 'Booking not found or cannot be cancelled');
        }

        return redirect('/user/my-bookings')->with('success', 'Booking cancelled successfully');
    }

    // GET /user/dashboard
    public function dashboard()
    {
        $userId = auth()->id();
        $user = auth()->user();

        $userBookings = Booking::where('user_id', $userId)
            ->with('venue:id,name,location,images,price_per_hour')
            ->orderByDesc('booking_date')
            ->get();

        $bookingStats = [
            'total' => $userBookings->count(),
            'confirmed' => $userBookings->where('status', 'confirmed')->count(),
            'pending' => $userBookings->where('status', 'pending')->count(),
            'cancelled' => $userBookings->where('status', 'cancelled')->count(),
            'totalSpent' => number_format(
                $userBookings->where('status', 'confirmed')->sum('total_amount'),
                2
            ),
        ];

        $recentBookings = $userBookings->take(5);

        $today = Carbon::today();
        $upcomingBookings = $userBookings
            ->filter(fn ($b) => $b->status === 'confirmed' && $b->booking_date->gte($today))
            ->take(2);

        $recentVenueIds = $userBookings->pluck('venue_id')->unique()->values();
        $recentVenues = $recentVenueIds->isNotEmpty()
            ? Venue::whereIn('id', $recentVenueIds)->limit(3)->get()
            : collect();

        return view('user.dashboard', [
            'title' => 'User Dashboard',
            'recentBookings' => $recentBookings,
            'upcomingBookings' => $upcomingBookings,
            'recentVenues' => $recentVenues,
            'bookingStats' => $bookingStats,
            'memberSince' => $user->created_at,
        ]);
    }
}
