<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessage;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required|min:5',
        ]);

        // Send mail
        Mail::to('servease.system@gmail.com')->send(new ContactMessage($request));

        return back()->with('success', 'Your message has been sent successfully!');
    }
}
