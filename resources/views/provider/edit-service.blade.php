@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4 mx-auto" style="max-width: 700px;">
        <div class="card-header bg-success text-white text-center py-3 rounded-top-4">
            <h3 class="mb-0">Edit Service</h3>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('provider.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-bold">Service Title</label>
                    <input type="text" name="title" class="form-control form-control-lg" value="{{ old('title', $service->title) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="description" class="form-control" rows="4" required>{{ old('description', $service->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Price (₱)</label>
                    <input type="number" name="price" class="form-control form-control-lg" step="0.01" value="{{ old('price', $service->price) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Category</label>
                    <input type="text" name="category" class="form-control form-control-lg" value="{{ old('category', $service->category) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Image</label>
                    <input type="file" name="image" class="form-control">
                    @if ($service->image)
                        <div class="mt-3 text-center">
                            <img src="{{ asset('storage/' . $service->image) }}" alt="Current Image" class="rounded" style="max-height: 150px;">
                        </div>
                    @endif
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('provider.services') }}" class="btn btn-secondary px-4">Cancel</a>
                    <button type="submit" class="btn btn-success px-4">Update Service</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f8f9fa;
    }
    @media (max-width: 768px) {
        .card {
            margin: 0 10px;
        }
    }
</style>
@endsection
