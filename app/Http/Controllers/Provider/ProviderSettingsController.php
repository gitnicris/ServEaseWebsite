<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProviderSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:provider']);
    }

    // ⚙️ Settings Page
    public function index()
    {
        $user = Auth::user();
        return view('provider.settings.index', compact('user'));
    }

    // ✅ Update Account (Name + Email)
    public function updateAccount(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        Auth::user()->update($request->only('name', 'email'));

        return back()->with('success', 'Account updated successfully!');
    }

    // 🔐 Update Password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|confirmed|min:8',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        Auth::user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password updated successfully!');
    }

    // ❌ Delete Account
    public function destroyAccount(Request $request)
    {
        $request->validate(['password' => 'required']);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Incorrect password.');
        }

        $user->delete();
        Auth::logout();

        return redirect('/')->with('success', 'Account deleted successfully.');
    }
}
