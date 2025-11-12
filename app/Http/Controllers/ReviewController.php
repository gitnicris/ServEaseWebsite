<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'provider_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Ensure only customers can leave reviews
        if (Auth::user()->role !== 'customer') {
            abort(403, 'Only customers can leave reviews.');
        }

        // Prevent duplicate reviews for the same service by the same customer
        $existingReview = Review::where('service_id', $request->service_id)
            ->where('customer_id', Auth::id())
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this service.');
        }

        // Create the review
        Review::create([
            'service_id' => $request->service_id,
            'provider_id' => $request->provider_id,
            'customer_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Your review has been posted!');
    }
}
