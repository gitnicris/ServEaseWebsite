@extends('layouts.app')

@section('content')
<div class="flex h-[calc(100vh-70px)] bg-[#0f172a] text-gray-200">
    <!-- Left panel (conversation list) -->
    <div class="w-1/3 border-r border-gray-700 p-4 overflow-y-auto">
        <h2 class="text-lg font-semibold text-orange-400 mb-4">Messages</h2>
        @foreach($conversations as $conversation)
            <a href="{{ route('messages.chat', $conversation->id) }}"
               class="block p-3 mb-2 rounded-lg hover:bg-gray-800 transition">
                <div class="font-semibold">{{ $conversation->otherUser->name }}</div>
                <div class="text-sm text-gray-400">{{ $conversation->service->name ?? 'Service' }}</div>
            </a>
        @endforeach
    </div>

    <!-- Right panel (chat window) -->
    <div class="flex-1 flex flex-col bg-[#0f172a]">
        @if(isset($messages))
            <div class="flex-1 overflow-y-auto p-4 space-y-3">
                @foreach($messages as $msg)
                    <div class="flex {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-xs px-4 py-2 rounded-2xl {{ $msg->sender_id === auth()->id() ? 'bg-orange-500 text-white' : 'bg-gray-800 text-gray-100' }}">
                            {{ $msg->message }}
                        </div>
                    </div>
                @endforeach
            </div>

            <form method="POST" action="{{ route('messages.send', $booking->id) }}" class="p-4 border-t border-gray-700 bg-[#1e293b]">
                @csrf
                <div class="flex gap-2">
                    <input type="text" name="message" placeholder="Type your message..."
                           class="flex-1 rounded-lg bg-gray-800 border border-gray-700 text-gray-200 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    <button type="submit" class="px-5 py-2 bg-orange-500 rounded-lg font-semibold hover:bg-orange-600 transition">
                        Send
                    </button>
                </div>
            </form>
        @else
            <div class="flex-1 flex items-center justify-center text-gray-500">
                Select a conversation to start chatting.
            </div>
        @endif
    </div>
</div>
@endsection
