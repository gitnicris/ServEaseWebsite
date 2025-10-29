@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Chat with {{ $user->name }}</h2>

    <div class="h-96 overflow-y-auto border p-3 bg-gray-50 rounded-lg mb-4">
        @foreach($messages as $message)
            <div class="mb-2 {{ $message->sender_id === Auth::id() ? 'text-right' : 'text-left' }}">
                <div class="{{ $message->sender_id === Auth::id() ? 'bg-blue-500 text-white inline-block rounded-xl px-3 py-1' : 'bg-gray-200 inline-block rounded-xl px-3 py-1' }}">
                    {{ $message->message }}
                </div>
            </div>
        @endforeach
    </div>

    <form method="POST" action="{{ route('chat.store', $user->id) }}" class="flex">
        @csrf
        <input type="text" name="message" placeholder="Type your message..." class="w-full border rounded-l-lg p-2">
        <button type="submit" class="bg-blue-500 text-white px-4 rounded-r-lg">Send</button>
    </form>
</div>
@endsection
