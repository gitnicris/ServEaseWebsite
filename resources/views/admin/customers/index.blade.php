@extends('layouts.app')

@section('title', 'Customers | ServEase Admin')

@section('content')
<h1 class="text-3xl font-bold mb-8">Customers </h1>

<div class="card bg-white/10 backdrop-blur-lg p-6 rounded-xl shadow-lg">
    <table class="w-full text-left text-sm">
        <thead>
            <tr class="border-b border-white/20">
                <th class="py-2">#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Joined</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $index => $customer)
                <tr class="border-b border-white/10">
                    <td class="py-2">{{ $customers->firstItem() + $index }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('admin.customers.view', $customer->id) }}"
                           class="bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded text-xs font-semibold inline-block">
                            View Profile
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-4 text-center text-gray-300">No customers found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $customers->links() }}
    </div>
</div>
@endsection
