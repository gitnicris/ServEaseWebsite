@extends('layouts.app')

@section('title', $provider->name . ' | Provider Profile')

@section('content')
<div class="max-w-6xl mx-auto mt-8">

    <!-- Page Title -->
    <h1 class="text-3xl font-bold mb-6">Provider Profile</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Profile Card -->
        <div class="bg-white rounded-3xl shadow-lg p-6 border border-gray-100">
            <div class="text-center">
                <div class="w-24 h-24 mx-auto rounded-full bg-orange-500 text-white flex items-center justify-center text-3xl font-bold">
                    {{ strtoupper(substr($provider->name, 0, 1)) }}
                </div>

                <h2 class="mt-4 text-2xl font-semibold text-gray-800">
                    {{ $provider->name }}
                </h2>

                <p class="text-gray-500">{{ $provider->email }}</p>

                <p class="text-sm text-gray-400 mt-2">
                    Joined {{ $provider->created_at->format('M d, Y') }}
                </p>
            </div>
        </div>

        <!-- Services -->
        <div class="col-span-2 bg-white rounded-3xl shadow-lg p-6 border border-gray-100">

            <h2 class="text-xl font-semibold text-gray-700 mb-4">
                Service Listings
            </h2>

            @forelse($services as $service)
                <div class="py-4 border-b last:border-0 border-gray-200">
                    <div class="flex justify-between items-start">

                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">
                                {{ $service->title }}
                            </h3>

                            <p class="text-gray-500 text-sm">
                                {{ $service->description }}
                            </p>
                        </div>

                        <!-- Status Badge -->
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            @if($service->status === 'approved') bg-green-100 text-green-700
                            @elseif($service->status === 'pending') bg-yellow-100 text-yellow-700
                            @else bg-red-100 text-red-700
                            @endif">
                            {{ ucfirst($service->status) }}
                        </span>

                    </div>
                </div>
            @empty
                <p class="text-gray-500">This provider has no services yet.</p>
            @endforelse

        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-8">
        <a href="{{ route('admin.providers') }}"
            class="inline-block bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-xl shadow-md transition">
            ← Back to Providers
        </a>
    </div>

</div>
@endsection
