@extends('layouts.app')

@section('content')
<div class="text-center">
    <h1 class="text-4xl font-bold text-blue-600 mb-4">Welcome to ServEase</h1>
    <p class="text-gray-600 text-lg mb-6">Connecting Customers with Trusted Service Providers.</p>
    <a href="{{ route('services') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
        Explore Services
    </a>
</div>
@endsection
