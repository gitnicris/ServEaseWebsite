@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">📅 My Bookings</h1>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    @if($bookings->isEmpty())
        <p class="text-gray-500 text-center py-10">No bookings found.</p>
    @else
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-orange-500 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Service</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Status</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $booking->customer->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $booking->service->title ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $booking->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($booking->status === 'pending')
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Pending</span>
                                @elseif($booking->status === 'approved')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Approved</span>
                                @elseif($booking->status === 'rejected')
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">Rejected</span>
                                @elseif($booking->status === 'completed')
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">Completed</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($booking->status === 'pending')
                                    <form action="{{ route('provider.bookings.approve', $booking->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white text-xs px-3 py-1 rounded-full font-semibold">
                                            Approve
                                        </button>
                                    </form>

                                    <form action="{{ route('provider.bookings.reject', $booking->id) }}" method="POST" class="inline-block ml-2">
                                        @csrf
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded-full font-semibold">
                                            Reject
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs">No actions</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
