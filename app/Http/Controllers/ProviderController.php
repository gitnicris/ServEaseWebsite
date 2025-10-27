<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProviderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:provider']);
    }

    // ✅ Dashboard: Provider info + services list
    public function dashboard()
    {
        $user = Auth::user();
        $services = $user->services()->latest()->get();

        return view('provider.dashboard', compact('user', 'services'));
    }

    // ✅ View profile
    public function profile()
    {
        $user = Auth::user();
        return view('provider.profile', compact('user'));
    }

    // ✅ Update profile
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

        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $path = $request->file('photo')->store('profile_photos', 'public');
            $user->photo = $path;
        }

        $user->update($request->only('name', 'bio', 'phone', 'address'));

        return back()->with('success', 'Profile updated successfully!');
    }

    /* -----------------------------------
       ✅ Service CRUD for Provider Panel
       ----------------------------------- */

    // Create new service ✅
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

        Auth::user()->services()->create($data);

        return redirect()->route('provider.dashboard')->with('success', 'Service created!');
    }

    // Edit Form ✅
    public function edit(Service $service)
    {
        $this->authorizeOwner($service);

        return view('provider.edit-service', compact('service'));
    }

    // Update ✅
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

        return redirect()->route('provider.dashboard')->with('success', 'Service updated!');
    }

    // Delete ✅
    public function destroy(Service $service)
    {
        $this->authorizeOwner($service);

        if ($service->image && Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route('provider.dashboard')->with('success', 'Service deleted.');
    }

    // ✅ Reusable authorization check
    private function authorizeOwner(Service $service)
    {
        if ($service->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
