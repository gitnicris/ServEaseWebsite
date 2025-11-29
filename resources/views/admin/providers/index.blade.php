@extends('layouts.app')

@section('title', 'Providers')

@section('content')
<div class="max-w-6xl mx-auto mt-8 bg-white rounded-3xl shadow-lg p-6 md:p-8 border border-gray-100">

    <h1 class="text-3xl font-bold mb-6">Providers </h1>

    <!-- Table Card -->
    <div class="overflow-x-auto rounded-xl border border-gray-200">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="py-3 px-4 text-left">#</th>
                    <th class="py-3 px-4 text-left">Name</th>
                    <th class="py-3 px-4 text-left">Email</th>
                    <th class="py-3 px-4 text-left">Joined</th>
                    <th class="py-3 px-4 text-left">Services</th>
                    <th class="py-3 px-4 text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($providers as $index => $provider)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-3 px-4">
                            {{ $providers->firstItem() + $index }}
                        </td>

                        <td class="py-3 px-4 font-medium text-gray-800">
                            {{ $provider->name }}
                        </td>

                        <td class="py-3 px-4 text-gray-600">
                            {{ $provider->email }}
                        </td>

                        <td class="py-3 px-4 text-gray-600">
                            {{ $provider->created_at->format('M d, Y') }}
                        </td>

                        <td class="py-3 px-4">
                            <span class="bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $provider->services_count }}
                            </span>
                        </td>

                        <td class="py-3 px-4 text-center">
                            <a href="{{ route('admin.providers.view', $provider->id) }}"
                               class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-1.5 rounded-lg text-xs font-semibold transition">
                                View Profile
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-4 text-center text-gray-500">
                            No providers found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-5">
        {{ $providers->links() }}
    </div>

</div>
@endsection
