@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-green-50 to-white py-20">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl font-extrabold text-green-700 mb-4">
            Welcome to Our Service Platform
        </h1>
        <p class="text-gray-600 text-lg max-w-2xl mx-auto mb-8">
            Discover a variety of professional services designed to make your life easier. 
            Book, manage, and explore all in one place.
        </p>

        <a href="{{ route('services.index') }}" 
           class="inline-block bg-green-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-green-700 transition">
           View Our Services
        </a>
    </div>
</div>

<div class="container mx-auto px-6 py-16">
    <h2 class="text-2xl font-bold text-gray-800 text-center mb-10">Why Choose Us?</h2>

    <div class="grid md:grid-cols-3 gap-8 text-center">
        <div class="bg-white rounded-2xl shadow-md p-6">
            <h3 class="text-green-700 font-semibold text-xl mb-2">Reliable Service</h3>
            <p class="text-gray-600">Our professionals ensure consistent and high-quality service every time.</p>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-6">
            <h3 class="text-green-700 font-semibold text-xl mb-2">Affordable Pricing</h3>
            <p class="text-gray-600">Get the best value with transparent and competitive pricing.</p>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-6">
            <h3 class="text-green-700 font-semibold text-xl mb-2">Trusted Providers</h3>
            <p class="text-gray-600">We connect you only with verified and trustworthy service providers.</p>
        </div>
    </div>
</div>
@endsection
