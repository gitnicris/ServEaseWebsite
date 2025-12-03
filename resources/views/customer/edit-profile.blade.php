@extends('layouts.app')
@section('title', 'Edit Profile | ServEase')

@section('content')

<div class="max-w-3xl mx-auto">

    <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Profile Photo Upload --}}
        <div class="text-center mb-6">
            <div class="relative inline-block">
                <img 
                    id="profilePreview"
                    src="{{ $profile->photo_url }}"
                    class="w-32 h-32 rounded-full border-4 border-white shadow-md object-cover cursor-pointer hover:opacity-80 transition"
                    onclick="document.getElementById('profilePhotoInput').click();"
                >

                <input 
                    type="file"
                    id="profilePhotoInput"
                    name="photo"  {{-- Must match controller --}}
                    accept="image/*"
                    class="hidden"
                    onchange="previewProfile(event)"
                >
            </div>

            <p class="mt-2 text-gray-500 text-sm">Click your photo to change</p>
        </div>

        {{-- Form Card --}}
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">

            <h4 class="text-lg font-semibold mb-4">Edit Your Information</h4>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- Name --}}
                <div class="col-span-2">
                    <label class="text-sm text-gray-600">Full Name</label>
                    <input type="text" name="name" value="{{ $user->name }}"
                        class="form-control mt-1">
                </div>

                {{-- Email --}}
                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}"
                        class="form-control mt-1">
                </div>

                {{-- Phone --}}
                <div>
                    <label class="text-sm text-gray-600">Phone</label>
                    <input type="text" name="phone" value="{{ $profile->phone }}"
                        class="form-control mt-1">
                </div>

                {{-- Address --}}
                <div class="col-span-2">
                    <label class="text-sm text-gray-600">Address</label>
                    <input type="text" name="address" value="{{ $profile->address }}"
                        class="form-control mt-1">
                </div>

            </div>

            <div class="flex justify-between mt-5">
                <a href="{{ route('customer.profile') }}"
                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg shadow">
                    Back to Profile
                </a>

                <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
                    Save Changes
                </button>
            </div>

        </div>

    </form>
</div>

<script>
function previewProfile(event) {
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('profilePreview').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
