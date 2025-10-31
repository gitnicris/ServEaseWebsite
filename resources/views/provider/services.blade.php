@extends('layouts.app')

@section('title', 'My Services')

@section('content')
<div class="container mx-auto px-6 py-10">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-100 dark:text-gray-900">My Services</h1>
        <button id="addServiceBtn" 
                class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition">
            + Add New Service
        </button>
    </div>

    {{-- Services Grid --}}
    <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6">
        @forelse ($services as $service)
            <div class="bg-gray-800 dark:bg-white rounded-2xl shadow-lg overflow-hidden transform hover:scale-105 transition">
                @if ($service->image)
                    <img src="{{ asset('storage/' . $service->image) }}" 
                         alt="{{ $service->title }}" 
                         class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-700 flex items-center justify-center text-gray-400">
                        No Image
                    </div>
                @endif

                <div class="p-4 text-white dark:text-gray-900">
                    <h3 class="text-lg font-semibold">{{ $service->title }}</h3>
                    <p class="text-gray-400 dark:text-gray-600 text-sm mt-1 line-clamp-2">
                        {{ $service->description }}
                    </p>
                    <p class="mt-3 font-bold text-orange-400">₱{{ number_format($service->price, 2) }}</p>

                    {{-- 🟡 Status Badge --}}
                    <div class="mt-3">
                        @if ($service->status === 'pending')
                            <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded">Pending Approval</span>
                        @elseif ($service->status === 'approved')
                            <span class="bg-green-500 text-white text-xs px-2 py-1 rounded">Approved</span>
                        @elseif ($service->status === 'rejected')
                            <span class="bg-red-500 text-white text-xs px-2 py-1 rounded">Rejected</span>
                        @endif
                    </div>

                    <div class="flex justify-end space-x-2 mt-4">
                        <a href="{{ route('provider.services.edit', $service->id) }}" 
                           class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-sm">
                            Edit
                        </a>
                        <form action="{{ route('provider.services.destroy', $service->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this service?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-400 dark:text-gray-600 text-center col-span-3">
                You haven't added any services yet.
            </p>
        @endforelse
    </div>
</div>

{{-- Add Service Modal --}}
<div id="addServiceModal" class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50">
    <div class="bg-gray-900 dark:bg-white rounded-2xl p-6 w-full max-w-lg relative shadow-xl">
        <button id="closeModal" 
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-200 dark:hover:text-gray-800 text-xl font-bold">&times;</button>

        <h2 class="text-xl font-semibold mb-4 text-white dark:text-gray-900">Add New Service</h2>

        <form action="{{ route('provider.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm text-gray-300 dark:text-gray-700 mb-1">Service Title</label>
                <input type="text" name="title" required 
                       class="w-full p-2 rounded-lg bg-gray-800 dark:bg-gray-100 text-white dark:text-gray-900 border border-gray-600 dark:border-gray-300">
            </div>

            <div>
                <label class="block text-sm text-gray-300 dark:text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3" required
                          class="w-full p-2 rounded-lg bg-gray-800 dark:bg-gray-100 text-white dark:text-gray-900 border border-gray-600 dark:border-gray-300"></textarea>
            </div>

            <div>
                <label class="block text-sm text-gray-300 dark:text-gray-700 mb-1">Price (₱)</label>
                <input type="number" name="price" step="0.01" required
                       class="w-full p-2 rounded-lg bg-gray-800 dark:bg-gray-100 text-white dark:text-gray-900 border border-gray-600 dark:border-gray-300">
            </div>

            <div>
                <label class="block text-sm text-gray-300 dark:text-gray-700 mb-1">Upload Image</label>
                <input type="file" name="image" accept="image/*"
                       class="w-full p-2 rounded-lg bg-gray-800 dark:bg-gray-100 text-white dark:text-gray-900 border border-gray-600 dark:border-gray-300">
            </div>

            <div class="flex justify-end space-x-2 pt-2">
                <button type="button" id="cancelBtn" 
                        class="bg-gray-500 hover:bg-gray-600 text-white dark:text-gray-900 px-4 py-2 rounded-lg">
                    Cancel
                </button>
                <button type="submit" 
                        class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg">
                    Save Service
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Script --}}
<script>
    document.getElementById('addServiceBtn').addEventListener('click', () => {
        document.getElementById('addServiceModal').classList.remove('hidden');
    });
    document.getElementById('closeModal').addEventListener('click', () => {
        document.getElementById('addServiceModal').classList.add('hidden');
    });
    document.getElementById('cancelBtn').addEventListener('click', () => {
        document.getElementById('addServiceModal').classList.add('hidden');
    });
</script>
@endsection
