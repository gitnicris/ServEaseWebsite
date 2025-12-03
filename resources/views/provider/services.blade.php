@extends('layouts.app')

@section('title', 'My Services')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-10 px-6 md:px-10">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-4 sm:mb-0">
                My Services
            </h1>
            <button id="addServiceBtn"
                class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-5 rounded-lg shadow">
                + Add New Service
            </button>
        </div>

        {{-- Services Grid --}}
        <div class="grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-5">

            @forelse ($services as $service)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">

                    {{-- IMAGE --}}
                    @if ($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}"
                            class="w-full h-32 object-cover" alt="">
                    @else
                        <div class="w-full h-32 bg-gray-100 dark:bg-gray-700 flex justify-center items-center text-gray-400">
                            No Image
                        </div>
                    @endif

                    {{-- BODY --}}
                    <div class="p-4">

                        {{-- Title + Category --}}
                        <div class="flex justify-between items-start mb-1">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 leading-tight max-w-[70%]">
                                {{ Str::limit($service->title, 30) }}
                            </h3>

                            @if ($service->category)
                                <span class="bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-300
                                            text-[10px] px-2 py-0.5 rounded-full">
                                    {{ $service->category }}
                                </span>
                            @endif
                        </div>

                        {{-- Description --}}
                        <p class="text-gray-600 dark:text-gray-400 text-xs mb-2 line-clamp-2">
                            {{ $service->description }}
                        </p>

                        {{-- Price --}}
                        <p class="font-bold text-orange-500 text-sm mb-2">
                            ₱{{ number_format($service->price, 2) }}
                        </p>

                        {{-- Status --}}
                        <div class="mb-3">
                            @if ($service->status === 'pending')
                                <span class="text-[10px] px-2 py-0.5 rounded-full bg-yellow-500/20 text-yellow-600 dark:text-yellow-400">
                                    Pending Approval
                                </span>
                            @elseif ($service->status === 'approved')
                                <span class="text-[10px] px-2 py-0.5 rounded-full bg-green-500/20 text-green-600 dark:text-green-400">
                                    Approved
                                </span>
                            @elseif ($service->status === 'rejected')
                                <span class="text-[10px] px-2 py-0.5 rounded-full bg-red-500/20 text-red-600 dark:text-red-400">
                                    Rejected
                                </span>
                            @endif
                        </div>

                        {{-- Buttons --}}
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('provider.services.edit', $service->id) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1.5 rounded">
                                Edit
                            </a>

                            <form action="{{ route('provider.services.destroy', $service->id) }}" method="POST"
                                  onsubmit="return confirm('Delete this service?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1.5 rounded">
                                    Delete
                                </button>
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

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $services->links() }}
        </div>
    </div>
</div>

{{-- ADD SERVICE MODAL --}}
<div id="addServiceModal"
    class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 p-4">

    <div class="bg-white dark:bg-gray-900 rounded-xl p-6 w-full max-w-md shadow-xl relative animate-[fadeIn_.2s_ease-out]">

        {{-- Close Button --}}
        <button id="closeModal"
            class="absolute top-3 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-2xl">
            &times;
        </button>

        {{-- Title --}}
        <h2 class="text-xl font-bold mb-5 text-gray-800 dark:text-black-100 text-center">
            Add New Service
        </h2>

        <form action="{{ route('provider.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            {{-- Input Fields --}}
            <div>
                <label class="text-sm text-gray-700 dark:text-black-300 font-medium">Service Title</label>
                <input type="text" name="title" required
                    class="w-full mt-1 p-2.5 rounded-lg bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700
                           text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring focus:ring-orange-300 focus:border-orange-500 outline-none">
            </div>

            <div>
                <label class="text-sm text-gray-700 dark:text-black-300 font-medium">Category</label>
                <input type="text" name="category" placeholder="e.g. Cleaning"
                    class="w-full mt-1 p-2.5 rounded-lg bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700
                           text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring focus:ring-orange-300 focus:border-orange-500 outline-none">
            </div>

            <div>
                <label class="text-sm text-gray-700 dark:text-black-300 font-medium">Description</label>
                <textarea name="description" rows="3" required
                    class="w-full mt-1 p-2.5 rounded-lg bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700
                           text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring focus:ring-orange-300 focus:border-orange-500 outline-none"></textarea>
            </div>

            <div>
                <label class="text-sm text-gray-700 dark:text-black-300 font-medium">Price (₱)</label>
                <input type="number" name="price" step="0.01" required
                    class="w-full mt-1 p-2.5 rounded-lg bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700
                           text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring focus:ring-orange-300 focus:border-orange-500 outline-none">
            </div>

            <div>
                <label class="text-sm text-gray-700 dark:text-black-300 font-medium">Image</label>
                <input type="file" name="image" accept="image/*"
                    class="w-full mt-1 p-2.5 rounded-lg bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700
                           text-gray-900 dark:text-gray-100 placeholder-gray-400">
            </div>

            {{-- Buttons --}}
            <div class="flex justify-end gap-2 pt-3">
                <button type="button" id="cancelBtn"
                    class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 text-gray-800">
                    Cancel
                </button>

                <button type="submit"
                    class="px-4 py-2 rounded-lg bg-orange-500 hover:bg-orange-600 text-white shadow">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>


{{-- JS Modal --}}
<script>
    const modal = document.getElementById('addServiceModal');
    document.getElementById('addServiceBtn').onclick = () => modal.classList.remove('hidden');
    document.getElementById('closeModal').onclick = () => modal.classList.add('hidden');
    document.getElementById('cancelBtn').onclick = () => modal.classList.add('hidden');
</script>

@endsection
