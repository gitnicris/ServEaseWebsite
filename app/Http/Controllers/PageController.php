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

    public function services()
    {
        $services = Service::with('provider')
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
