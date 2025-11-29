@extends('layouts.app')

@section('content')
<div class="fixed inset-0 flex items-center justify-center bg-black/40 backdrop-blur-sm z-50 px-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl border border-gray-200 p-8 text-center">

        <h2 class="text-2xl font-semibold text-gray-900 mb-6">Choose Your Role</h2>
        <p class="text-sm text-gray-500 mb-6">Please select your role to continue.</p>

        <form action="{{ route('choose.role.save') }}" method="POST" class="space-y-4">
            @csrf
            <button type="submit" name="role" value="customer"
                class="w-full py-2.5 rounded-lg bg-green-600 text-white text-sm font-medium hover:bg-green-700 transition">
                I am a Customer
            </button>

            <button type="submit" name="role" value="provider"
                class="w-full py-2.5 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition">
                I am a Provider
            </button>
        </form>

    </div>
</div>
@endsection
