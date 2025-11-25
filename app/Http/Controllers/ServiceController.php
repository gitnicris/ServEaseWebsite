<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    // 📋 Provider: View their own services
    public function index()
    {
        $services = Service::where('user_id', Auth::id())->latest()->get();
        return view('provider.services', compact('services'));
    }

    // 🌍 PUBLIC: Browse with filters
    public function browse(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        $query = Service::with('provider')->where('status', 'approved');

        // 🔍 SEARCH filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // 🏷 CATEGORY filter
        if ($category) {
            $query->where('category', $category);
        }

        $services = $query->latest()->get();

        // 📌 Load all category names for dropdown
        $categories = Service::distinct()->pluck('category');

        return view('pages.services', compact('services', 'categories', 'search', 'category'));
    }

    // ➕ Provider: Create new service
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
        $data['status'] = 'pending';

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($data);

        return redirect()->route('provider.services')
            ->with('success', 'Your service has been submitted for admin approval.');
    }

    // ✏ Provider: Edit service
    public function edit(Service $service)
    {
        if ($service->user_id !== Auth::id()) abort(403);
        return view('provider.edit-service', compact('service'));
    }

    // 💾 Update service
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
        $data['status'] = 'pending';

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

    // ❌ Delete service
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

    // 👀 PUBLIC: Show single service
    public function show(Service $service)
    {
        if ($service->status !== 'approved') {
            abort(404);
        }

        $service->load([
            'provider.providerProfile',
            'reviews.customer',
        ]);

        return view('pages.service-show', compact('service'));
    }
}
