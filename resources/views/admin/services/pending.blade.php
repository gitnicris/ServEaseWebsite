@extends('layouts.app')

@section('title', 'Pending Services')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Pending Services</h1>

    <div class="text-sm text-gray-600 mt-3 sm:mt-0">
        Approved: <span class="text-green-600 font-semibold">{{ $approvedCount }}</span> | 
        Rejected: <span class="text-red-600 font-semibold">{{ $rejectedCount }}</span>
    </div>
</div>

{{-- Alerts --}}
@if (session('success'))
    <div class="bg-green-500 text-white px-4 py-2 rounded mb-4 shadow">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="bg-red-500 text-white px-4 py-2 rounded mb-4 shadow">
        {{ session('error') }}
    </div>
@endif

{{-- Pending List --}}
@if ($pendingServices->isEmpty())
    <p class="text-center text-gray-600 mt-10 italic">
        🎉 No pending services at the moment!
    </p>
@else
<div class="bg-white rounded-xl shadow p-6 overflow-x-auto">
    <table class="w-full text-left text-sm">
        <thead>
            <tr class="border-b text-gray-500 uppercase text-xs tracking-wider">
                <th class="py-3 px-2">#</th>
                <th class="py-3 px-2">Preview</th>
                <th class="py-3 px-2">Service Title</th>
                <th class="py-3 px-2">Provider</th>
                <th class="py-3 px-2">Price</th>
                <th class="py-3 px-2">Category</th>
                <th class="py-3 px-2">Description</th>
                <th class="py-3 px-2 text-center">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($pendingServices as $index => $service)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="py-3 px-2">{{ $index + 1 }}</td>

                    <td class="py-3 px-2">
                        @if ($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}"
                                 class="w-14 h-14 object-cover rounded-md border">
                        @else
                            <span class="text-gray-400 italic">No Image</span>
                        @endif
                    </td>

                    <td class="py-3 px-2 font-semibold text-gray-800">{{ $service->title }}</td>
                    <td class="py-3 px-2">{{ $service->user->name ?? 'N/A' }}</td>
                    <td class="py-3 px-2">₱{{ number_format($service->price, 2) }}</td>
                    <td class="py-3 px-2">{{ $service->category ?? '—' }}</td>

                    <td class="py-3 px-2 text-gray-600 w-64">
                        {{ Str::limit($service->description, 60) }}
                    </td>

                    <td class="py-3 px-2 text-center">
                        <div class="flex items-center justify-center gap-2">
                            
                            {{-- Approve --}}
                            <form method="POST" action="{{ route('admin.services.approve', $service->id) }}">
                                @csrf
                                <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs">
                                    Approve
                                </button>
                            </form>

                            {{-- Reject --}}
                            <form method="POST" action="{{ route('admin.services.reject', $service->id) }}">
                                @csrf
                                <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">
                                    Reject
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection
