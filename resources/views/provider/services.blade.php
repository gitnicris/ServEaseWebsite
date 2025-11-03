@extends('layouts.app')

@section('title', 'My Services')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-10 px-6 md:px-10">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 mb-4 sm:mb-0">
                My Services
            </h1>
            <button id="addServiceBtn"
                class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold py-2 px-5 rounded-lg shadow-md transition-all duration-200">
                + Add New Service
            </button>
        </div>

        {{-- Services Grid --}}
        <div class="grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-8">
            @forelse ($services as $service)
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1">
                    @if ($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}"
                            class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400">
                            No Image
                        </div>
                    @endif

                    <div class="p-5">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                            {{ $service->title }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-3 line-clamp-2">
                            {{ $service->description }}
                        </p>
                        <p class="font-bold text-orange-500 text-lg mb-3">
                            ₱{{ number_format($service->price, 2) }}
                        </p>

                        {{-- Status Badge --}}
                        <div class="mb-4">
                            @if ($service->status === 'pending')
                                <span
                                    class="bg-yellow-500/20 text-yellow-600 dark:text-yellow-400 text-xs px-3 py-1 rounded-full font-semibold">Pending
                                    Approval</span>
                            @elseif ($service->status === 'approved')
                                <span
                                    class="bg-green-500/20 text-green-600 dark:text-green-400 text-xs px-3 py-1 rounded-full font-semibold">Approved</span>
                            @elseif ($service->status === 'rejected')
                                <span
                                    class="bg-red-500/20 text-red-600 dark:text-red-400 text-xs px-3 py-1 rounded-full font-semibold">Rejected</span>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('provider.services.edit', $service->id) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded-lg transition">Edit</a>
                            <form action="{{ route('provider.services.destroy', $service->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this service?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white text-sm px-4 py-2 rounded-lg transition">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-10">
                    <p class="text-gray-500 dark:text-gray-400 text-lg">You haven’t added any services yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Add Service Modal --}}
<div id="addServiceModal"
    class="hidden fixed inset-0 bg-black bg-opacity-70 backdrop-blur-sm flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-900 rounded-2xl p-8 w-full max-w-lg relative shadow-2xl">
        <button id="closeModal"
            class="absolute top-4 right-5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-2xl font-bold">
            &times;
        </button>

        <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100 text-center">Add New Service</h2>

        <form action="{{ route('provider.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Service Title</label>
                <input type="text" name="title" required
                    class="w-full p-3 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-orange-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                <textarea name="description" rows="3" required
                    class="w-full p-3 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-orange-500 focus:outline-none"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Price (₱)</label>
                <input type="number" name="price" step="0.01" required
                    class="w-full p-3 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-orange-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload Image</label>
                <input type="file" name="image" accept="image/*"
                    class="w-full p-3 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-orange-500 focus:outline-none">
            </div>

            <div class="flex justify-end space-x-3 pt-4">
                <button type="button" id="cancelBtn"
                    class="bg-gray-500 hover:bg-gray-600 text-white dark:text-gray-900 px-4 py-2 rounded-lg transition">Cancel</button>
                <button type="submit"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg shadow-md transition">Save
                    Service</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Script --}}
<script>
    const modal = document.getElementById('addServiceModal');
    document.getElementById('addServiceBtn').onclick = () => modal.classList.remove('hidden');
    document.getElementById('closeModal').onclick = () => modal.classList.add('hidden');
    document.getElementById('cancelBtn').onclick = () => modal.classList.add('hidden');
</script>
@endsection
