<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ProviderProfile;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProviderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:provider']);
    }

    // 📊 Dashboard
    public function dashboard()
    {
        $user = Auth::user();

        $services = Service::where('user_id', $user->id)->get();
        $bookings = Booking::whereHas('service', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        return view('provider.dashboard', [
            'user' => $user,
            'totalServices' => $services->count(),
            'totalBookings' => $bookings->count(),
            'totalEarnings' => $bookings->where('status', 'completed')->sum('price'),
            'recentServices' => $services->take(5)
        ]);
    }

    // 🛠️ My Services
    public function services()
    {
        $services = Service::where('user_id', Auth::id())->latest()->get();
        return view('provider.services', compact('services'));
    }

    // 👤 Profile
public function profile()
{
    $user = Auth::user();

    // Create profile if it doesn't exist
    $profile = ProviderProfile::firstOrCreate(
        ['user_id' => $user->id],
        [
            'name'    => $user->name,
            'bio'     => '',
            'address' => '',
            'gmail'   => $user->email ?? '',
            'phone'   => '',
            'photo'   => null,
            'about'   => '',
        ]
    );

    // ✅ Load reviews via the relation on ProviderProfile
    // Make sure ProviderProfile has: public function reviews() { ... }
    $profile->load(['reviews.customer']);

    // Use the loaded relation for average rating
    $averageRating = round($profile->reviews->avg('rating') ?? 0, 1);

    return view('provider.profile', [
        'user'          => $user,
        'profile'       => $profile,
        'averageRating' => $averageRating,
    ]);
}



    // ✏️ Edit Provider Profile
    public function editProfile()
    {
        $user = Auth::user();
        $profile = ProviderProfile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $user->name,
                'bio' => '',
                'address' => '',
                'gmail' => $user->email ?? '',
                'phone' => '',
                'photo' => null,
                'about' => '',
            ]
        );

        return view('provider.edit-profile', compact('user', 'profile'));
    }

    // 💾 Update Provider Profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'address' => 'nullable|string|max:255',
            'gmail' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'about' => 'nullable|string|max:2000',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $profile = ProviderProfile::firstOrCreate(['user_id' => $user->id]);

        // Handle profile photo upload
        if ($request->hasFile('photo')) {
            if ($profile->photo && Storage::disk('public')->exists($profile->photo)) {
                Storage::disk('public')->delete($profile->photo);
            }

            $path = $request->file('photo')->store('provider_photos', 'public');
            $profile->photo = $path;
        }

        $profile->fill($request->only('bio', 'address', 'gmail', 'phone', 'about'));
        $profile->name = $request->name; // Update name in profile as well
        $profile->save();

        $user->update(['name' => $request->name]);

        return redirect()->route('provider.profile')->with('success', 'Profile updated successfully!');
    }

    // 🟢 Store New Service
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:4096',
        ]);

        $data = $request->only('title', 'description', 'price', 'category');
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($data);

        return redirect()
            ->route('provider.services')
            ->with('success', 'Service submitted successfully! Awaiting admin approval.');
    }

    // ✏️ Edit Service
    public function edit(Service $service)
    {
        $this->authorizeOwner($service);
        return view('provider.edit-service', compact('service'));
    }

    // 🔄 Update Service
    public function update(Request $request, Service $service)
    {
        $this->authorizeOwner($service);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:4096',
        ]);

        $data = $request->only('title', 'description', 'price', 'category');

        if ($request->hasFile('image')) {
            if ($service->image && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);

        return redirect()->route('provider.services')->with('success', 'Service updated successfully!');
    }

    // ❌ Delete Service
    public function destroy(Service $service)
    {
        $this->authorizeOwner($service);

        if ($service->image && Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();
        return redirect()->route('provider.services')->with('success', 'Service deleted successfully.');
    }

    // 🔐 Ownership Check
    private function authorizeOwner(Service $service)
    {
        abort_if($service->user_id !== Auth::id(), 403, 'Unauthorized action.');
    }

    // 🕓 Pending Bookings
    public function pendingBookings()
    {
        $bookings = Booking::where('status', 'pending')
            ->whereHas('service', fn($q) => $q->where('user_id', Auth::id()))
            ->with(['service', 'customer'])
            ->latest()
            ->get();

        $approvedCount = Booking::where('status', 'accepted')
            ->whereHas('service', fn($q) => $q->where('user_id', Auth::id()))
            ->count();

        $cancelledCount = Booking::where('status', 'cancelled')
            ->whereHas('service', fn($q) => $q->where('user_id', Auth::id()))
            ->count();

        return view('provider.pending', compact('bookings', 'approvedCount', 'cancelledCount'));
    }

    // ✅ All Bookings
    public function bookings()
    {
        $bookings = Booking::whereHas('service', fn($q) => $q->where('user_id', Auth::id()))
            ->with(['service', 'customer'])
            ->latest()
            ->get();

        return view('provider.bookings', compact('bookings'));
    }

    // ✅ Approve Booking
    public function approveBooking(Booking $booking)
    {
        try {
            $booking->update(['status' => 'accepted']);
            return redirect()->route('provider.pending')->with('success', '✅ Booking approved successfully!');
        } catch (\Exception $e) {
            return redirect()->route('provider.pending')->with('error', 'Failed to approve booking.');
        }
    }

    // ❌ Reject Booking
    public function rejectBooking(Booking $booking)
    {
        try {
            $booking->update(['status' => 'cancelled']);
            return redirect()->route('provider.pending')->with('error', '❌ Booking rejected.');
        } catch (\Exception $e) {
            return redirect()->route('provider.pending')->with('error', 'Failed to reject booking.');
        }
    }
}
