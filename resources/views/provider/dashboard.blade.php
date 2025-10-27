@extends('layouts.app')

@section('title', 'Provider Dashboard')

@section('content')
<div class="max-w-6xl mx-auto p-6">

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-600 text-white rounded">{{ session('success') }}</div>
    @endif

    {{-- Create service form --}}
    <div class="card p-6 rounded-2xl mb-8">
        <h3 class="text-xl font-semibold mb-4">Create a New Service</h3>

        <form action="{{ route('provider.services.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Title</label>
                <input name="title" value="{{ old('title') }}" class="w-full p-3 rounded text-black" />
                @error('title') <p class="text-red-400 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Description</label>
                <textarea name="description" rows="4" class="w-full p-3 rounded text-black">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-400 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Price</label>
                    <input name="price" value="{{ old('price', '0.00') }}" class="w-full p-3 rounded text-black" />
                    @error('price') <p class="text-red-400 text-sm">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Category</label>
                    <input name="category" value="{{ old('category') }}" class="w-full p-3 rounded text-black" />
                    @error('category') <p class="text-red-400 text-sm">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Image (optional)</label>
                <input type="file" name="image" class="text-sm" />
                @error('image') <p class="text-red-400 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <button class="btn bg-orange-500 px-4 py-2 rounded text-white">Create Service</button>
            </div>
        </form>
    </div>

    {{-- Provider's services list --}}
    <h3 class="text-2xl font-semibold mb-4">My Services</h3>

    @if($services->isEmpty())
        <p class="text-gray-200 mb-6">You haven't created any services yet.</p>
    @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $service)
                <div class="card rounded-lg overflow-hidden">
                    @if($service->image)
                        <img src="{{ asset('storage/'.$service->image) }}" class="w-full h-40 object-cover" alt="{{ $service->title }}">
                    @else
                        <div class="w-full h-40 flex items-center justify-center bg-white/10 text-gray-300">No image</div>
                    @endif

                    <div class="p-4">
                        <h4 class="text-lg font-semibold text-orange-400">{{ $service->title }}</h4>
                        <p class="text-sm text-gray-200 mt-2">{{ Str::limit($service->description, 120) }}</p>
                        <p class="text-white mt-2 font-bold">₱{{ number_format($service->price, 2) }}</p>
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('provider.services.edit', $service->id) }}" class="btn bg-blue-500 px-3 py-1 rounded text-white">Edit</a>

                            <form action="{{ route('provider.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Delete this service?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn bg-red-500 px-3 py-1 rounded text-white">Delete</button>
                            </form>

                            <a href="{{ route('services') }}" class="ml-auto text-sm text-gray-300 hover:underline">View public page</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
