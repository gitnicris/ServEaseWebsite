@extends('layouts.app')
@section('title', 'My Profile | ServEase')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- Profile Header --}}
    <div class="text-center mb-6">
        <div class="relative inline-block">
            <img 
                id="profilePhoto"
                src="{{ $profile->photo_url }}" 
                class="w-32 h-32 rounded-full border-4 border-white shadow-md object-cover cursor-pointer hover:opacity-80 transition"
                onclick="openModal()"
                title="Click to view"
            >
        </div>

        <h2 class="text-2xl font-semibold mt-3">{{ $user->name }}</h2>
        <p class="text-gray-500">{{ $user->email }}</p>

        <button onclick="window.location='{{ route('customer.profile.edit') }}'"
                class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
            Edit Profile
        </button>
    </div>

    {{-- Info Card --}}
    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <h4 class="text-lg font-semibold mb-4">Account Information</h4>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="text-sm text-gray-500">Full Name</label>
                <p class="font-medium">{{ $user->name }}</p>
            </div>

            <div>
                <label class="text-sm text-gray-500">Email</label>
                <p class="font-medium">{{ $user->email }}</p>
            </div>

            <div>
                <label class="text-sm text-gray-500">Phone</label>
                <p class="font-medium">{{ $profile->phone ?? 'Not set' }}</p>
            </div>

            <div>
                <label class="text-sm text-gray-500">Address</label>
                <p class="font-medium">{{ $profile->address ?? 'Not set' }}</p>
            </div>

        </div>
    </div>

</div>

{{-- Modal --}}
<div id="photoModal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center hidden z-50">
    <span class="absolute top-4 right-6 text-white text-3xl cursor-pointer" onclick="closeModal()">&times;</span>
    <img id="modalImage" src="" class="max-h-[80%] max-w-[80%] rounded-lg shadow-lg">
</div>

<script>
function openModal() {
    const modal = document.getElementById('photoModal');
    const modalImg = document.getElementById('modalImage');
    const photo = document.getElementById('profilePhoto');

    modalImg.src = photo.src;
    modal.classList.remove('hidden');
}
function closeModal() {
    document.getElementById('photoModal').classList.add('hidden');
}
</script>

@endsection
