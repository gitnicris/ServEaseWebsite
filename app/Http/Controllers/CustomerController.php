<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:customer']);
    }

    public function dashboard()
    {
        $user = Auth::user();
        return view('customer.dashboard', compact('user'));
    }
}
