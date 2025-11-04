@extends('layouts.app')

@section('title', 'Messages')

@section('content')
<div x-data="{ showSidebar: window.innerWidth >= 768 }" 
     @resize.window="showSidebar = window.innerWidth >= 768" 
     class="flex h-[calc(100vh-180px)] bg-gray-900 text-white rounded-lg overflow-hidden shadow-lg relative">

    {{-- MOBILE TOGGLE BUTTON --}}
    <button @click="showSidebar = !showSidebar"
            class="absolute top-3 left-3 z-20 md:hidden bg-gray-800 p-2 rounded-lg shadow-md hover:bg-gray-700 transition">
        <svg xmlns="http://www.w3.org/2000/svg" 
             fill="none" viewBox="0 0 24 24" stroke-width="2" 
             stroke="currentColor" class="w-6 h-6 text-orange-400">
            <path stroke-linecap="round" stroke-linejoin="round" 
                  d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    {{-- SIDEBAR: Conversations --}}
    <div x-show="showSidebar" 
         x-transition 
         class="w-full md:w-1/3 bg-gray-800 border-r border-gray-700 flex flex-col absolute md:relative inset-0 md:inset-auto z-10">
        <h2 class="text-xl font-semibold text-orange-400 p-4 border-b border-gray-700 flex justify-between items-center">
            Messages
            <button @click="showSidebar = false" class="md:hidden text-gray-400 hover:text-white">
                ✕
            </button>
        </h2>

        <div class="flex-1 overflow-y-auto custom-scrollbar">
            @forelse($conversations as $conversation)
                @php
                    $otherUser = auth()->user()->role === 'provider'
                        ? $conversation->customer
                        : $conversation->provider;
                @endphp
                <a href="{{ route(auth()->user()->role . '.messages.chat', $conversation->id) }}" 
                   class="block p-4 hover:bg-gray-700 transition 
                          {{ $conversation->id === $booking->id ? 'bg-gray-700' : '' }}"
                   @click="if(window.innerWidth < 768) showSidebar = false">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-semibold text-white">
                                {{ $otherUser->name ?? 'Unknown User' }}
                            </p>
                            <p class="text-sm text-gray-400 truncate">
                                {{ $conversation->service->name ?? 'Service' }}
                            </p>
                        </div>
                        <span class="text-xs text-gray-500">
                            {{ optional($conversation->messages->last())->created_at?->diffForHumans() ?? '' }}
                        </span>
                    </div>
                </a>
            @empty
                <div class="p-4 text-gray-400 text-center">
                    No conversations yet.
                </div>
            @endforelse
        </div>
    </div>

    {{-- CHAT AREA --}}
    <div class="flex-1 flex flex-col bg-gray-900">
        {{-- Chat Header --}}
        <div class="flex items-center justify-between p-4 bg-gray-800 border-b border-gray-700 flex-shrink-0">
            <h2 class="text-lg font-semibold text-orange-400 truncate">
                {{ auth()->id() === $booking->customer_id ? $booking->provider->name : $booking->customer->name }}
            </h2>
            <span class="text-gray-400 text-sm truncate">
                {{ $booking->service->name ?? '' }}
            </span>
        </div>

        {{-- Messages --}}
        <div id="chat-box" class="flex-1 overflow-y-auto p-4 custom-scrollbar bg-gray-900">
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
                <p class="text-gray-400 text-center mt-10">No messages yet.</p>
            @endforelse
        </div>

        {{-- Input Box --}}
        <form action="{{ route(auth()->user()->role . '.messages.send', $booking->id) }}" 
              method="POST" 
              class="p-4 bg-gray-800 border-t border-gray-700 flex gap-2 flex-shrink-0">
            @csrf
            <input type="text" 
                   name="message" 
                   required 
                   placeholder="Type a message..."
                   class="flex-1 px-4 py-2 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
            <button type="submit" 
                    class="bg-orange-500 hover:bg-orange-600 px-5 py-2 rounded-lg font-semibold">
                Send
            </button>
        </form>
    </div>
</div>

{{-- Custom Styles --}}
<style>
main {
    padding: 0 !important;
}
.custom-scrollbar::-webkit-scrollbar { width: 8px; }
.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: #444; border-radius: 4px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background-color: #666;
}
</style>

{{-- Auto-scroll and Alpine.js (for mobile sidebar) --}}
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const chatBox = document.getElementById('chat-box');
    if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
});
</script>
@endsection
