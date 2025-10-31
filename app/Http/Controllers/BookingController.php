<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // 🧾 Customer books a service
    public function bookService(Request $request, $serviceId)
    {
        $service = Service::findOrFail($serviceId);

        // Prevent providers from booking their own services
        if ($service->user_id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot book your own service.');
        }

        // Check if already booked and pending/active
        $existing = Booking::where('service_id', $service->id)
            ->where('customer_id', Auth::id())
            ->whereIn('status', ['pending', 'accepted'])
            ->first();

        if ($existing) {
            return redirect()->back()->with('info', 'You already have a pending or active booking for this service.');
        }

        Booking::create([
            'service_id' => $service->id,
            'customer_id' => Auth::id(),
            'provider_id' => $service->user_id,
            'price' => $service->price,
            'status' => 'pending',
        ]);

        return redirect()->route('customer.bookings')->with('success', 'Booking request sent to provider!');
    }

    // 📋 Customer View: My Bookings
    public function index()
    {
        $bookings = Booking::where('customer_id', Auth::id())
            ->with(['service', 'provider'])
            ->latest()
            ->get();

        return view('customer.bookings', compact('bookings'));
    }

    
    public function providerBookings()
    {
        $bookings = Booking::where('provider_id', Auth::id())
            ->with(['service', 'customer'])
            ->latest()
            ->get();

        return view('provider.bookings', compact('bookings'));
    }

    
    public function updateStatus(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

    
        if ($booking->provider_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:pending,accepted,rejected,completed,cancelled',
        ]);

        $booking->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Booking status updated successfully!');
    }
}
