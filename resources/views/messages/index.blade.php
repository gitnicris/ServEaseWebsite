@extends('layouts.app')

@section('content')
<div class="h-screen bg-gray-900 text-white flex overflow-hidden">

    {{-- LEFT SIDEBAR: Conversation List --}}
    <div class="w-1/3 bg-gray-800 border-r border-gray-700 flex flex-col">
        <h2 class="text-xl font-semibold text-orange-400 p-4 border-b border-gray-700">Messages</h2>

        <div class="flex-1 overflow-y-auto custom-scrollbar">
            @if($conversations->isEmpty())
                <div class="p-4 text-gray-400 text-center">No conversations yet.</div>
            @else
                @foreach($conversations as $conversation)
                    @php
                        $otherUser = auth()->user()->role === 'provider' 
                            ? $conversation->customer 
                            : $conversation->provider;
                        $active = isset($activeConversation) && $activeConversation->id === $conversation->id;
                    @endphp
                    <a href="{{ route(auth()->user()->role . '.messages.chat', $conversation->id) }}" 
                       class="block p-4 hover:bg-gray-700 transition {{ $active ? 'bg-gray-700' : '' }}">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-semibold text-white">
                                    {{ $otherUser->name ?? 'Unknown User' }}
                                </p>
                                <p class="text-sm text-gray-400">
                                    {{ $conversation->service->name ?? 'Service' }}
                                </p>
                            </div>
                            <span class="text-xs text-gray-500">
                                {{ optional($conversation->messages->last())->created_at?->diffForHumans() ?? '' }}
                            </span>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
    </div>

    {{-- RIGHT PANEL: Chat Area --}}
    <div class="flex-1 flex flex-col bg-gray-900 h-full">
        @isset($activeConversation)
            {{-- Header --}}
            <div class="flex items-center justify-between p-4 bg-gray-800 border-b border-gray-700">
                <h2 class="text-lg font-semibold text-orange-400 truncate">
                    {{ auth()->id() === $activeConversation->customer_id 
                        ? $activeConversation->provider->name 
                        : $activeConversation->customer->name }}
                </h2>
                <span class="text-gray-400 text-sm truncate">
                    {{ $activeConversation->service->name ?? '' }}
                </span>
            </div>

            {{-- Chat messages --}}
            <div id="chat-box" class="flex-1 overflow-y-auto p-4 bg-gray-900 custom-scrollbar">
                @forelse($messages as $msg)
                    <div class="mb-3 flex {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[70%] px-4 py-2 rounded-2xl 
                            {{ $msg->sender_id === auth()->id() 
                                ? 'bg-orange-500 text-white' 
                                : 'bg-gray-700 text-gray-100' }}">
                            <p class="whitespace-pre-line">{{ $msg->message }}</p>
                            <small class="block text-xs text-gray-300 mt-1 text-right">
                                {{ $msg->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-400 text-center mt-10">No messages yet. Start chatting below!</p>
                @endforelse
            </div>

            {{-- Send message form --}}
            <form action="{{ route(auth()->user()->role . '.messages.send', $activeConversation->id) }}" 
                  method="POST" 
                  class="p-4 bg-gray-800 border-t border-gray-700 flex gap-2">
                @csrf
                <input type="text" name="message" required 
                    class="flex-1 px-4 py-2 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-orange-500"
                    placeholder="Type a message...">
                <button type="submit" 
                    class="bg-orange-500 hover:bg-orange-600 px-5 py-2 rounded-lg font-semibold">
                    Send
                </button>
            </form>
        @else
            <div class="flex items-center justify-center flex-1 text-gray-500">
                Select a conversation to start chatting.
            </div>
        @endisset
    </div>
</div>

{{-- Optional custom scrollbar styling --}}
<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 8px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: #444;
    border-radius: 4px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background-color: #666;
}
</style>
@endsection
