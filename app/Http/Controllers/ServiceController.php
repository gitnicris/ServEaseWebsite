<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    // Show Provider Services (CRUD page)
    public function index()
    {
        $services = Service::where('user_id', Auth::id())->get();
        return view('provider.services', compact('services'));
    }

    // Store newly created service
    public function store(Request $request)
    {
        // Validate
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // Image Upload
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/services'), $imageName);
        }

        // Save to DB
        Service::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'image' => $imageName,
        ]);

        return back()->with('success', 'Service Posted Successfully!');
    }
}
