@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4">Our Services</h2>
<p class="text-gray-600 mb-6">Browse available services from our trusted providers.</p>

<div class="grid md:grid-cols-3 gap-6">
    {{-- Sample card --}}
    <div class="bg-white p-4 rounded-lg shadow">
        <h3 class="font-semibold text-lg mb-2">Sample Service</h3>
        <p class="text-gray-500 mb-3">Short description of the service.</p>
        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">View Details</button>
    </div>
</div>
@endsection
