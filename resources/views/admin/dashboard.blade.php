@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="page-card mb-4">
    <h1 class="text-2xl font-bold mb-4 flex items-center gap-2">
        📊 Dashboard Overview
    </h1>

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        {{-- Providers --}}
        <div class="p-5 rounded-xl border border-gray-200 bg-white shadow-sm hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="text-4xl">🧑‍🔧</div>
                <div>
                    <h2 class="text-sm font-semibold text-gray-600">Total Providers</h2>
                    <p class="text-3xl font-bold text-gray-900">{{ $providersCount ?? 0 }}</p>
                </div>
            </div>
        </div>

        {{-- Customers --}}
        <div class="p-5 rounded-xl border border-gray-200 bg-white shadow-sm hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="text-4xl">👥</div>
                <div>
                    <h2 class="text-sm font-semibold text-gray-600">Total Customers</h2>
                    <p class="text-3xl font-bold text-gray-900">{{ $customersCount ?? 0 }}</p>
                </div>
            </div>
        </div>

        {{-- Pending Services --}}
        <div class="p-5 rounded-xl border border-gray-200 bg-white shadow-sm hover:shadow-md transition flex flex-col justify-between">
            <div class="flex items-center gap-4">
                <div class="text-4xl">🧾</div>
                <div>
                    <h2 class="text-sm font-semibold text-gray-600">Pending Services</h2>
                    <p class="text-3xl font-bold text-gray-900">{{ $pendingCount ?? 0 }}</p>
                </div>
            </div>

            <a href="{{ route('admin.services.pending') }}"
               class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg text-center transition">
                Review Pending →
            </a>
        </div>

    </div>
</div>

{{-- Recent Services Table --}}
<div class="page-card mt-8">
    <h2 class="text-xl font-semibold mb-4 flex items-center gap-2 text-gray-800">
        🕒 Recent Service Posts
    </h2>

    <div class="overflow-x-auto">
        <table class="table-auto w-full text-sm border-collapse">
            <thead class="bg-gray-100">
                <tr class="text-gray-600">
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Title</th>
                    <th class="px-4 py-3 text-left">Provider</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Date</th>
                </tr>
            </thead>

            <tbody>
                @forelse($recentServices ?? [] as $index => $service)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 font-medium">{{ $service->title }}</td>
                        <td class="px-4 py-3">{{ $service->user->name ?? 'N/A' }}</td>

                        <td class="px-4 py-3">
                            @if($service->status === 'approved')
                                <span class="text-xs px-2 py-1 rounded bg-green-100 text-green-700">Approved</span>
                            @elseif($service->status === 'pending')
                                <span class="text-xs px-2 py-1 rounded bg-yellow-100 text-yellow-700">Pending</span>
                            @else
                                <span class="text-xs px-2 py-1 rounded bg-red-100 text-red-700">Rejected</span>
                            @endif
                        </td>

                        <td class="px-4 py-3">{{ $service->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">No recent service posts</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

