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
        $totalMessages = Message::where('sender_id', $user->id)
                                ->orWhere('receiver_id', $user->id)
                                ->count();

        // 💡 Recommended & Recent
        $recommendedServices = Service::inRandomOrder()->take(6)->get();

        // 📅 Recent Bookings
        $recentBookings = Booking::with(['service', 'provider'])
            ->where('customer_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('customer.dashboard', compact(
            'user',
            'totalBookings',
            'totalMessages',
            'recommendedServices',
            'recentBookings'
        ));
    }

    // 👤 Profile Page
    public function profile()
    {
        $user = Auth::user();

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

    // 🔄 Update Profile
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

        if ($request->hasFile('photo')) {
            if ($profile->photo && Storage::disk('public')->exists($profile->photo)) {
                Storage::disk('public')->delete($profile->photo);
            }
            $path = $request->file('photo')->store('customer_photos', 'public');
            $profile->photo = $path;
        }

        $profile->fill($request->only('name', 'bio', 'phone', 'address'))->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    // 🔎 Browse Services
    public function browseServices(Request $request)
    {
        $query = Service::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $services = $query->latest()->paginate(10);

        return view('customer.services', compact('services'));
    }

    public function services()
    {
        // Fetch all available services from providers
        $services = Service::latest()->get();
        return view('customer.services', compact('services'));
    }

    // 💬 Messages Page
    public function messages()
    {
        $user = Auth::user();

        $conversations = Message::where('sender_id', $user->id)
                                ->orWhere('receiver_id', $user->id)
                                ->with('sender', 'receiver')
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
}
