<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    // GET /
    public function index()
    {
        // Same static venues as the original Node.js home route
        $staticVenues = [
            (object) ['_id' => '1', 'name' => 'The Glass Pavilion', 'location' => 'London, UK', 'pricePerHour' => 450, 'capacity' => 200, 'images' => ['https://images.unsplash.com/photo-1519167758481-83f550bb49b3?auto=format&fit=crop&w=800']],
            (object) ['_id' => '2', 'name' => 'Azure Sky Deck', 'location' => 'Dubai, UAE', 'pricePerHour' => 800, 'capacity' => 150, 'images' => ['https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?auto=format&fit=crop&w=800']],
            (object) ['_id' => '3', 'name' => 'Nordic Stone Hall', 'location' => 'Oslo, Norway', 'pricePerHour' => 300, 'capacity' => 500, 'images' => ['https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=800&q=80']],
        ];

        return view('home', [
            'title' => 'VenueVista | Premium Spaces',
            'venues' => collect($staticVenues), // <--- CHANGE THIS: Wrap in collect()
            'totalRevenue' => '1.2M',
            'venueCount' => '850+',
            'totalBookings' => '12,000+',
        ]);
    }
}