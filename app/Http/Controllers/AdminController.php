<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\User;
use App\Models\CustomerProfile;
use App\Models\ProviderProfile;
use App\Models\Booking;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    // 🏠 Dashboard Overview
    public function dashboard()
    {
        // Count by service status
        $pendingCount  = Service::where('status', 'pending')->count();
        $approvedCount = Service::where('status', 'approved')->count();
        $rejectedCount = Service::where('status', 'rejected')->count();

        // Count users by role
        $providersCount = User::where('role', 'provider')->count();
        $customersCount = User::where('role', 'customer')->count();

        // Get recent services for table display
        $recentServices = Service::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'providersCount',
            'customersCount',
            'recentServices'
        ));
    }

    // 🕒 View Pending Services
    public function pendingServices()
    {
        $pendingServices = Service::where('status', 'pending')
            ->with('user')
            ->latest()
            ->get();

        $approvedCount = Service::where('status', 'approved')->count();
        $rejectedCount = Service::where('status', 'rejected')->count();

        return view('admin.services.pending', compact(
            'pendingServices',
            'approvedCount',
            'rejectedCount'
        ));
    }

    // ✅ Approve Service
    public function approveService(Service $service)
    {
        try {
            $service->update(['status' => 'approved']);
            return back()->with('success', '✅ Service approved successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to approve service.');
        }
    }

    // ❌ Reject Service
    public function rejectService(Service $service)
    {
        try {
            $service->update(['status' => 'rejected']);
            return back()->with('error', '❌ Service rejected.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to reject service.');
        }
    }

    // 🧑‍🔧 View All Providers
    public function providers()
    {
        $providers = User::where('role', 'provider')
            ->withCount('services') // Count how many services each provider posted
            ->latest()
            ->paginate(10);

        return view('admin.providers.index', compact('providers'));
    }

    // 👁 View Single Provider Profile
    public function viewProvider(User $provider)
    {
        if ($provider->role !== 'provider') {
            abort(404);
        }

        $services = Service::where('user_id', $provider->id)
            ->latest()
            ->get();

        $bookings = Booking::with(['customer', 'service'])
            ->whereHas('service', function ($query) use ($provider) {
                $query->where('user_id', $provider->id);
            })
            ->latest()
            ->get();

        return view('admin.providers.view', compact('provider', 'services', 'bookings'));
    }

    // 👥 View All Customers
    public function customers()
    {
        $customers = User::where('role', 'customer')
            ->latest()
            ->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }

    // 👁 View Single Customer Profile
    public function viewCustomer(User $customer)
    {
        if ($customer->role !== 'customer') {
            abort(404);
        }

        // Get all bookings made by this customer
        $bookings = Booking::with(['service', 'provider'])
            ->where('customer_id', $customer->id)
            ->latest()
            ->get();

        return view('admin.customers.view', compact('customer', 'bookings'));
    }
}
