<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ProviderProfile;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProviderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:provider']);
    }

    // 📊 Dashboard - Overview + Services
    public function dashboard()
    {
        $user = Auth::user();

        // Provider's services
        $services = Service::where('user_id', $user->id)->get();

        // Provider's bookings
        $bookings = Booking::whereHas('service', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        // Stats
        $totalServices = $services->count();
        $totalBookings = $bookings->count();
        $totalEarnings = $bookings->where('status', 'completed')->sum('price');

        // Show 5 most recent services
        $recentServices = $services->take(5);

        return view('provider.dashboard', compact(
            'user',
            'totalServices',
            'totalBookings',
            'totalEarnings',
            'recentServices'
        ));
    }

    // 🛠️ My Services Page
    public function services()
    {
        $providerId = Auth::id();
        $services = Service::where('user_id', $providerId)->latest()->get();

        return view('provider.services', compact('services'));
    }

    // 👤 Profile Page
    public function profile()
    {
        $user = Auth::user();

        // Create profile if not yet existing
        $profile = ProviderProfile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $user->name,
                'bio' => '',
                'phone' => '',
                'address' => '',
                'photo' => null,
            ]
        );

        return view('provider.profile', compact('user', 'profile'));
    }

    // 🧩 Update Profile
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

        $profile = ProviderProfile::firstOrCreate(['user_id' => $user->id]);

        if ($request->hasFile('photo')) {
            if ($profile->photo && Storage::disk('public')->exists($profile->photo)) {
                Storage::disk('public')->delete($profile->photo);
            }

            $path = $request->file('photo')->store('provider_photos', 'public');
            $profile->photo = $path;
        }

        $profile->fill($request->only('bio', 'phone', 'address'));
        $profile->save();

        $user->name = $request->input('name');
        $user->save();

        return redirect()
            ->route('provider.profile')
            ->with('success', 'Profile updated successfully!');
    }

    // 🟢 Create New Service (auto set status = pending)
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

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $data['user_id'] = Auth::id();
        $data['status'] = 'pending'; // Awaiting admin approval

        Service::create($data);

        return redirect()
            ->route('provider.services')
            ->with('success', 'Service submitted successfully! Waiting for admin approval.');
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
        if ($service->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }

    // 📅 Provider Bookings Page
    public function bookings()
    {
        $providerId = Auth::id();

        $bookings = Booking::with(['customer', 'service'])
            ->whereHas('service', function ($query) use ($providerId) {
                $query->where('user_id', $providerId);
            })
            ->latest()
            ->get();

        return view('provider.bookings', compact('bookings'));
    }

    // ✅ Approve Booking
    public function approveBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'approved';
        $booking->save();

        return redirect()->back()->with('success', 'Booking approved successfully.');
    }

    // ❌ Reject Booking
    public function rejectBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'rejected';
        $booking->save();

        return redirect()->back()->with('error', 'Booking rejected.');
    }
}
