<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    // 🛍 Show only approved services publicly
    public function services()
    {
        $services = Service::with('provider')
                        ->where('status', 'approved') // ✅ only approved
                        ->latest()
                        ->get();

        return view('pages.services', compact('services'));
    }

    public function messages()
    {
        return view('pages.messages');
    }

    public function about()
    {
        return view('pages.about');
    }
}
