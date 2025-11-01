<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Booking;
use App\Models\Message;
use App\Models\CustomerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:customer']);
    }

    // 🏠 Dashboard
    public function dashboard()
{
    $user = Auth::user();

    // 📊 Dynamic Stats
    $totalBookings = Booking::where('customer_id', $user->id)->count();
    $completedBookings = Booking::where('customer_id', $user->id)
        ->where('status', 'completed')
        ->count();
    $cancelledBookings = Booking::where('customer_id', $user->id)
        ->where('status', 'cancelled')
        ->count();
    $totalMessages = Message::where('sender_id', $user->id)
                            ->orWhere('receiver_id', $user->id)
                            ->count();

    // 💡 Recommended & Recent
    $recommendedServices = Service::where('status', 'approved')
        ->inRandomOrder()
        ->take(6)
        ->get();

    // 📅 Recent Bookings
    $recentBookings = Booking::with(['service', 'provider'])
        ->where('customer_id', $user->id)
        ->latest()
        ->take(5)
        ->get();

    return view('customer.dashboard', compact(
        'user',
        'totalBookings',
        'completedBookings',
        'cancelledBookings',
        'totalMessages',
        'recommendedServices',
        'recentBookings'
    ));
}

    // 👤 Profile Page
    public function profile()
    {
        $user = Auth::user();

        // Create profile if not yet existing
        $profile = CustomerProfile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $user->name,
                'bio' => '',
                'phone' => '',
                'address' => '',
                'photo' => null,
            ]
        );

        return view('customer.profile', compact('user', 'profile'));
    }
    public function editProfile()
{
    $user = Auth::user();
    $profile = CustomerProfile::firstOrCreate(['user_id' => $user->id]);
    return view('customer.edit-profile', compact('user', 'profile'));
}


    // 🧩 Update Customer Profile (Fixed image saving)
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $profile = CustomerProfile::firstOrCreate(['user_id' => $user->id]);

        // 🖼️ Handle profile photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($profile->photo && Storage::disk('public')->exists($profile->photo)) {
                Storage::disk('public')->delete($profile->photo);
            }

            // Save new photo
            $path = $request->file('photo')->store('customer_photos', 'public');
            $profile->photo = $path;
        }

        // ✏️ Update profile info
        $profile->fill($request->only(['bio', 'phone', 'address']));
        $profile->save();

        // ✏️ Update global user name
        $user->name = $request->input('name');
        $user->save();

        // ✅ Redirect back to profile with success message
        return redirect()
            ->route('customer.profile')
            ->with('success', 'Profile updated successfully!');
    }

    // 🔎 Browse Services (with search & category filters)
    public function browseServices(Request $request)
    {
        $query = Service::query()
            ->where('status', 'approved'); // ✅ Only show approved services

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $services = $query->latest()->paginate(10);

        return view('customer.services', compact('services'));
    }

    // 🧾 All Services (simple version)
    public function services()
    {
        // ✅ Only fetch approved services
        $services = Service::where('status', 'approved')
            ->latest()
            ->get();

        return view('customer.services', compact('services'));
    }

    // 💬 Messages Page
    public function messages()
    {
        $user = Auth::user();

        $conversations = Message::where('sender_id', $user->id)
                                ->orWhere('receiver_id', $user->id)
                                ->with(['sender', 'receiver'])
                                ->latest()
                                ->get();

        return view('customer.messages', compact('conversations'));
    }

    // 📅 Bookings Page
    public function bookings()
    {
        $bookings = Booking::with(['service', 'provider'])
            ->where('customer_id', auth()->id())
            ->latest()
            ->get();

        return view('customer.bookings', compact('bookings'));
    }
    public function cancelBooking(Booking $booking)
{
    // 🔒 Security: Ensure only the owner can cancel their booking
    if ($booking->customer_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }

    // 🕒 Allow cancel only if not completed or already cancelled
    if (in_array($booking->status, ['completed', 'cancelled'])) {
        return back()->with('error', 'This booking cannot be cancelled.');
    }

    // ❌ Update status to cancelled
    $booking->update(['status' => 'cancelled']);

    return redirect()
        ->route('customer.bookings')
        ->with('error', 'Booking cancelled successfully.');
}

}
