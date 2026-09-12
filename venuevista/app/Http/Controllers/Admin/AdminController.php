<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // GET /admin/dashboard
    public function dashboard()
    {
        $venueCount = Venue::count();
        $availableVenues = Venue::where('is_available', true)->count();
        $bookingCount = Booking::count();
        $userCount = User::count();
        $adminCount = User::where('role', 'admin')->count();

        $totalRevenue = Booking::where('status', 'confirmed')->sum('total_amount');

        $recentBookings = Booking::with(['user:id,name,email', 'venue:id,name,location'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $cancelledBookings = Booking::where('status', 'cancelled')->count();

        $today = Carbon::today();
        $todayBookingsCount = Booking::whereDate('booking_date', '>=', $today)->count();

        $startOfMonth = Carbon::now()->startOfMonth();
        $monthlyRevenue = Booking::where('status', 'confirmed')
            ->where('created_at', '>=', $startOfMonth)
            ->sum('total_amount');

        return view('admin.dashboard', [
            'title' => 'Admin Dashboard',
            'venueCount' => $venueCount,
            'availableVenues' => $availableVenues,
            'bookingCount' => $bookingCount,
            'userCount' => $userCount,
            'adminCount' => $adminCount,
            'totalRevenue' => $totalRevenue,
            'recentBookings' => $recentBookings,
            'confirmedBookings' => $confirmedBookings,
            'pendingBookings' => $pendingBookings,
            'cancelledBookings' => $cancelledBookings,
            'todayBookingsCount' => $todayBookingsCount,
            'monthlyRevenue' => $monthlyRevenue,
        ]);
    }

    // GET /admin/venues
    public function venues()
    {
        $venues = Venue::orderByDesc('created_at')->get();

        return view('admin.venues', [
            'title' => 'Manage Venues',
            'venues' => $venues,
        ]);
    }

    // GET /admin/venues/add
    public function addVenueForm()
    {
        return view('admin.add-venue', [
            'title' => 'Add Venue',
        ]);
    }

    // POST /admin/venues/add
    public function addVenue(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'capacity' => ['required', 'integer', 'min:1'],
            'location' => ['required', 'string'],
            'pricePerHour' => ['required', 'numeric', 'min:0'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:10240'],
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '-' . random_int(100000000, 999999999) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/venues'), $filename);
                $images[] = '/uploads/venues/' . $filename;
            }
        }

        $amenities = [];
        if ($request->filled('amenities')) {
            $amenities = array_filter(array_map('trim', explode(',', $request->amenities)));
        }

        Venue::create([
            'name' => trim($request->name),
            'description' => trim($request->description),
            'capacity' => (int) $request->capacity,
            'location' => trim($request->location),
            'price_per_hour' => (float) $request->pricePerHour,
            'created_by' => auth()->id(),
            'is_available' => true,
            'opening_time' => $request->openingTime ?? '09:00',
            'closing_time' => $request->closingTime ?? '18:00',
            'amenities' => array_values($amenities),
            'images' => $images,
        ]);

        return redirect('/admin/venues')->with('success', 'Venue added successfully');
    }

    // GET /admin/venues/edit/{id}
    public function editVenueForm($id)
    {
        $venue = Venue::find($id);

        if (! $venue) {
            return redirect('/admin/venues')->with('error', 'Venue not found');
        }

        return view('admin.edit-venue', [
            'title' => 'Edit Venue',
            'venue' => $venue,
        ]);
    }

    // POST /admin/venues/edit/{id}
    public function editVenue(Request $request, $id)
    {
        $venue = Venue::find($id);

        if (! $venue) {
            return redirect('/admin/venues')->with('error', 'Venue not found');
        }

        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'capacity' => ['required', 'integer', 'min:1'],
            'location' => ['required', 'string'],
            'pricePerHour' => ['required', 'numeric', 'min:0'],
            'newImages.*' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:10240'],
        ]);

        // Existing images kept via checkboxes
        $existingImages = $request->input('existingImages', []);
        if (! is_array($existingImages)) {
            $existingImages = [$existingImages];
        }
        $existingImages = array_filter($existingImages, fn ($i) => $i && trim($i) !== '');

        // New uploads
        $newImages = [];
        if ($request->hasFile('newImages')) {
            foreach ($request->file('newImages') as $file) {
                $filename = time() . '-' . random_int(100000000, 999999999) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/venues'), $filename);
                $newImages[] = '/uploads/venues/' . $filename;
            }
        }

        $allImages = array_slice(array_values(array_merge($existingImages, $newImages)), 0, 5);

        $amenitiesArray = [];
        if ($request->filled('amenities')) {
            $amenitiesArray = array_filter(array_map('trim', explode(',', $request->amenities)));
        }

        // Delete removed images from filesystem
        $imagesToKeep = array_flip($allImages);
        foreach ((array) $venue->images as $oldImage) {
            if (! isset($imagesToKeep[$oldImage])) {
                $path = public_path(ltrim($oldImage, '/'));
                if (file_exists($path)) {
                    @unlink($path);
                }
            }
        }

        $venue->update([
            'name' => trim($request->name),
            'description' => trim($request->description),
            'capacity' => (int) $request->capacity,
            'location' => trim($request->location),
            'price_per_hour' => (float) $request->pricePerHour,
            'is_available' => $request->isAvailable === 'true' || $request->isAvailable === '1' || $request->boolean('isAvailable'),
            'images' => array_values($allImages),
            'amenities' => array_values($amenitiesArray),
            'opening_time' => $request->openingTime ?? $venue->opening_time,
            'closing_time' => $request->closingTime ?? $venue->closing_time,
        ]);

        return redirect('/admin/venues')->with('success', 'Venue updated successfully');
    }

    // POST /admin/venues/delete-image/{id}  (AJAX)
    public function deleteImage(Request $request, $id)
    {
        $venue = Venue::find($id);

        if (! $venue) {
            return response()->json(['success' => false, 'message' => 'Venue not found'], 404);
        }

        $images = $venue->images ?? [];
        $imageIndex = $request->input('imageIndex');
        $imageUrl = $request->input('imageUrl');

        $indexToRemove = -1;
        if ($imageIndex !== null && $imageIndex !== '') {
            $indexToRemove = (int) $imageIndex;
        } elseif ($imageUrl) {
            $indexToRemove = array_search($imageUrl, $images, true);
            $indexToRemove = $indexToRemove === false ? -1 : $indexToRemove;
        }

        if ($indexToRemove >= 0 && $indexToRemove < count($images)) {
            $imageToDelete = $images[$indexToRemove];

            $path = public_path(ltrim($imageToDelete, '/'));
            if (file_exists($path)) {
                @unlink($path);
            }

            array_splice($images, $indexToRemove, 1);
            $venue->images = $images;
            $venue->save();

            return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Image not found'], 400);
    }

    // POST /admin/venues/delete/{id}
    public function deleteVenue($id)
    {
        $venue = Venue::find($id);

        if (! $venue) {
            return redirect('/admin/venues')->with('error', 'Venue not found');
        }

        foreach ((array) $venue->images as $imagePath) {
            $full = public_path(ltrim($imagePath, '/'));
            if (file_exists($full)) {
                @unlink($full);
            }
        }

        $venue->delete();

        return redirect('/admin/venues')->with('success', 'Venue deleted successfully');
    }

    // POST /admin/venues/toggle/{id}
    public function toggleAvailability($id)
    {
        $venue = Venue::find($id);

        if (! $venue) {
            return redirect('/admin/venues')->with('error', 'Venue not found');
        }

        $venue->update(['is_available' => ! $venue->is_available]);

        $msg = $venue->is_available ? 'made available' : 'made unavailable';

        return redirect('/admin/venues')->with('success', "Venue {$msg}");
    }

    // GET /admin/bookings
    public function bookings(Request $request)
    {
        $page = (int) $request->query('page', 1);
        $limit = 10;

        $query = Booking::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('venue')) {
            $query->where('venue_id', $request->venue);
        }

        if ($request->filled('dateFrom')) {
            $query->whereDate('booking_date', '>=', $request->dateFrom);
        }

        if ($request->filled('dateTo')) {
            $query->whereDate('booking_date', '<=', $request->dateTo);
        }

        $totalBookings = $query->count();

        $bookings = $query->with(['user:id,name,email', 'venue:id,name,location,price_per_hour,capacity'])
            ->orderByDesc('booking_date')
            ->orderByDesc('created_at')
            ->forPage($page, $limit)
            ->get();

        $venuesList = Venue::select('id', 'name')->get();

        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $cancelledBookings = Booking::where('status', 'cancelled')->count();

        return view('admin.bookings', [
            'title' => 'Manage Bookings',
            'bookings' => $bookings,
            'venuesList' => $venuesList,
            'bookingCount' => $totalBookings,
            'confirmedBookings' => $confirmedBookings,
            'pendingBookings' => $pendingBookings,
            'cancelledBookings' => $cancelledBookings,
            'totalBookings' => $totalBookings,
            'page' => $page,
            'hasNextPage' => $page * $limit < $totalBookings,
            'query' => $request->query(),
        ]);
    }

    // POST /admin/bookings/confirm/{id}
    public function confirmBooking($id)
    {
        $booking = Booking::find($id);

        if (! $booking) {
            return redirect('/admin/bookings')->with('error', 'Booking not found');
        }

        $booking->update(['status' => 'confirmed']);

        return redirect('/admin/bookings')->with('success', "Booking #{$booking->reference} confirmed successfully");
    }

    // POST /admin/bookings/cancel/{id}
    public function cancelBooking($id)
    {
        $booking = Booking::find($id);

        if (! $booking) {
            return redirect('/admin/bookings')->with('error', 'Booking not found');
        }

        $booking->update(['status' => 'cancelled']);

        return redirect('/admin/bookings')->with('success', "Booking #{$booking->reference} cancelled successfully");
    }
}
