<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    // 📋 Provider: View their own services (regardless of status)
    public function index()
    {
        $services = Service::where('user_id', Auth::id())->latest()->get();
        return view('provider.services', compact('services'));
    }

    // 🌍 Public / Customer: Only show approved services
    public function browse()
    {
        $services = Service::where('status', 'approved')
            ->latest()
            ->get();

        return view('pages.services', compact('services'));
    }

    // ➕ Provider: Create new service → automatically pending
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:4096',
        ]);

        $data = $request->only(['title', 'description', 'price', 'category']);
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending'; // 🕒 Waiting for admin approval

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($data);

        return redirect()->route('provider.services')
            ->with('success', 'Your service has been submitted for admin approval.');
    }

    // ✏️ Provider: Edit service (requires re-approval)
    public function edit(Service $service)
    {
        if ($service->user_id !== Auth::id()) abort(403);
        return view('provider.edit-service', compact('service'));
    }

    // 💾 Update service and mark as pending again
    public function update(Request $request, Service $service)
    {
        if ($service->user_id !== Auth::id()) abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:4096',
        ]);

        $data = $request->only(['title', 'description', 'price', 'category']);
        $data['status'] = 'pending'; // 🔄 Must be reapproved after editing

        if ($request->hasFile('image')) {
            if ($service->image && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);

        return redirect()->route('provider.services')
            ->with('success', 'Service updated and sent for re-approval.');
    }

    // ❌ Delete service (only owner can)
    public function destroy(Service $service)
    {
        if ($service->user_id !== Auth::id()) abort(403);

        if ($service->image && Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route('provider.services')
            ->with('success', 'Service deleted successfully.');
    }
}
