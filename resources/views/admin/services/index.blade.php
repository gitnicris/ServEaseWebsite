@extends('layouts.app')

@section('title', 'All Services')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Services Overview</h1>
</div>

<div class="bg-white rounded-xl shadow p-6">
    <div class="border-b mb-6 flex gap-6 text-gray-600 text-sm font-medium">
        <button id="tabApproved" class="tab active text-orange-600 border-b-2 border-orange-600 pb-2">
            Approved Services
        </button>

        <button id="tabRejected" class="tab pb-2">
            Rejected Services
        </button>
    </div>

    {{-- Approved Services --}}
    <div id="approvedList">
        @if ($approvedServices->isEmpty())
            <p class="text-gray-500 italic text-center">No approved services.</p>
        @else
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b text-gray-500 uppercase text-xs tracking-wider">
                        <th class="py-3 px-2">#</th>
                        <th class="py-3 px-2">Title</th>
                        <th class="py-3 px-2">Provider</th>
                        <th class="py-3 px-2">Price</th>
                        <th class="py-3 px-2">Category</th>
                        <th class="py-3 px-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($approvedServices as $service)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-2">{{ $service->id }}</td>
                            <td class="py-3 px-2 font-semibold">{{ $service->title }}</td>
                            <td class="py-3 px-2">{{ $service->user->name }}</td>
                            <td class="py-3 px-2">₱{{ number_format($service->price, 2) }}</td>
                            <td class="py-3 px-2">{{ $service->category }}</td>
                            <td class="py-3 px-2">
                                <span class="bg-green-500 text-white text-xs px-2 py-1 rounded">
                                    Approved
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $approvedServices->links() }}
            </div>
        @endif
    </div>

    {{-- Rejected Services --}}
    <div id="rejectedList" class="hidden">
        @if ($rejectedServices->isEmpty())
            <p class="text-gray-500 italic text-center">No rejected services.</p>
        @else
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b text-gray-500 uppercase text-xs tracking-wider">
                        <th class="py-3 px-2">#</th>
                        <th class="py-3 px-2">Title</th>
                        <th class="py-3 px-2">Provider</th>
                        <th class="py-3 px-2">Price</th>
                        <th class="py-3 px-2">Category</th>
                        <th class="py-3 px-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rejectedServices as $service)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-2">{{ $service->id }}</td>
                            <td class="py-3 px-2 font-semibold">{{ $service->title }}</td>
                            <td class="py-3 px-2">{{ $service->user->name }}</td>
                            <td class="py-3 px-2">₱{{ number_format($service->price, 2) }}</td>
                            <td class="py-3 px-2">{{ $service->category }}</td>
                            <td class="py-3 px-2">
                                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded">
                                    Rejected
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $rejectedServices->links() }}
            </div>
        @endif
    </div>
</div>

{{-- SIMPLE TAB SWITCH SCRIPT --}}
<script>
document.getElementById('tabApproved').onclick = function () {
    document.getElementById('approvedList').classList.remove('hidden');
    document.getElementById('rejectedList').classList.add('hidden');

    this.classList.add('text-orange-600', 'border-orange-600', 'border-b-2');
    document.getElementById('tabRejected').classList.remove('text-orange-600', 'border-orange-600', 'border-b-2');
};

document.getElementById('tabRejected').onclick = function () {
    document.getElementById('rejectedList').classList.remove('hidden');
    document.getElementById('approvedList').classList.add('hidden');

    this.classList.add('text-orange-600', 'border-orange-600', 'border-b-2');
    document.getElementById('tabApproved').classList.remove('text-orange-600', 'border-orange-600', 'border-b-2');
};
</script>
@endsection
