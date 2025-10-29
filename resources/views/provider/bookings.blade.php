@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Your Service Bookings</h2>

    @if($bookings->isEmpty())
        <div class="alert alert-info">No bookings yet.</div>
    @else
        <div class="list-group">
            @foreach($bookings as $booking)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h5>{{ $booking->service->title }}</h5>
                        <p>Customer: {{ $booking->customer->name }}</p>
                        <p>Status: <strong>{{ ucfirst($booking->status) }}</strong></p>
                    </div>
                    <a href="{{ route('provider.messages.chat', $booking->id) }}" class="btn btn-primary">
                        💬 Chat with Customer
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
