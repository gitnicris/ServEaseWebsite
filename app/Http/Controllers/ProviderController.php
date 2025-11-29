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

    // 📊 Dashboard
    public function dashboard()
    {
        $user = Auth::user();

        // Use counts instead of loading full collections
        $totalServices = Service::where('user_id', $user->id)->count();
        $totalBookings = Booking::whereHas('service', fn($q) => $q->where('user_id', $user->id))->count();
        $totalEarnings = Booking::whereHas('service', fn($q) => $q->where('user_id', $user->id))
                                ->where('status', 'completed')
                                ->sum('price');

        // Get only 5 recent services
        $recentServices = Service::where('user_id', $user->id)->latest()->take(5)->get();

        return view('provider.dashboard', compact(
            'user', 'totalServices', 'totalBookings', 'totalEarnings', 'recentServices'
        ));
    }

    // 🛠️ My Services
    public function services()
    {
        $services = Service::where('user_id', Auth::id())->latest()->paginate(10); // paginate to save memory
        return view('provider.services', compact('services'));
    }

    // 👤 Profile
    public function profile()
    {
        $user = Auth::user();

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

        // Paginate reviews to reduce memory usage
        $reviews = $profile->reviews()->with('customer:id,name')->latest()->paginate(10);

        $averageRating = round($profile->reviews()->avg('rating') ?? 0, 1);

        return view('provider.profile', [
            'user'          => $user,
            'profile'       => $profile,
            'reviews'       => $reviews,
            'averageRating' => $averageRating,
        ]);
    }
    

    // ✏️ Edit Profile
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

    // 💾 Update Profile
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

        if ($request->hasFile('photo')) {
            if ($profile->photo && Storage::disk('public')->exists($profile->photo)) {
                Storage::disk('public')->delete($profile->photo);
            }
            $profile->photo = $request->file('photo')->store('provider_photos', 'public');
        }

        $profile->fill($request->only('bio', 'address', 'gmail', 'phone', 'about'));
        $profile->name = $request->name;
        $profile->save();

        $user->update(['name' => $request->name]);

        return redirect()->route('provider.profile')->with('success', 'Profile updated successfully!');
    }

    // 🟢 Store Service
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

        return redirect()->route('provider.services')->with('success', 'Service submitted successfully! Awaiting admin approval.');
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
            ->paginate(10); // paginate to reduce memory

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
            ->paginate(10); // paginate here as well

        return view('provider.bookings', compact('bookings'));
    }

    // ✅ Approve Booking
    public function approveBooking(Booking $booking)
    {
        $booking->update(['status' => 'accepted']);
        return redirect()->route('provider.pending')->with('success', '✅ Booking approved successfully!');
    }

    // ❌ Reject Booking
    public function rejectBooking(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);
        return redirect()->route('provider.pending')->with('error', '❌ Booking rejected.');
    }
}
