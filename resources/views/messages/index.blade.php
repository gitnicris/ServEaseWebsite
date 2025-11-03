@extends('layouts.app')

@section('title', 'Messages')

@section('content')
<div id="messages-layout"
     class="absolute inset-x-0 bottom-0 bg-gray-900 text-white overflow-hidden flex flex-col md:flex-row z-0"
     style="top: var(--navbar-height, 4rem);">

    {{-- 📱 Toggle Sidebar (Mobile) --}}
    <button id="toggleSidebar"
        class="md:hidden absolute top-4 left-4 z-50 bg-orange-500 hover:bg-orange-600 px-3 py-2 rounded-lg shadow-md">
        ☰
    </button>

    {{-- LEFT SIDEBAR --}}
    <div id="sidebar"
         class="w-72 md:w-1/3 bg-gray-800 border-r border-gray-700 flex flex-col transform md:translate-x-0 -translate-x-full transition-transform duration-300 fixed md:static top-[var(--navbar-height,4rem)] md:top-0 left-0 bottom-0 z-40 md:z-0">
        <h2 class="text-xl font-semibold text-orange-400 p-4 border-b border-gray-700">
            Messages
        </h2>

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
                                <p class="font-semibold">{{ $otherUser->name ?? 'Unknown' }}</p>
                                <p class="text-sm text-gray-400 truncate">
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

    {{-- RIGHT CHAT PANEL --}}
    <div class="flex-1 flex flex-col bg-gray-900 md:ml-0 md:static relative">
        @isset($activeConversation)
            {{-- Header --}}
            <div class="flex items-center justify-between p-4 bg-gray-800 border-b border-gray-700 flex-shrink-0">
                <div class="flex items-center gap-2">
                    <button id="backToSidebar" class="md:hidden text-orange-400 hover:text-orange-300">←</button>
                    <h2 class="text-lg font-semibold text-orange-400 truncate">
                        {{ auth()->id() === $activeConversation->customer_id 
                            ? $activeConversation->provider->name 
                            : $activeConversation->customer->name }}
                    </h2>
                </div>
                <span class="text-gray-400 text-sm truncate">
                    {{ $activeConversation->service->name ?? '' }}
                </span>
            </div>

            {{-- Messages --}}
            <div id="chat-box" class="flex-1 overflow-y-auto p-4 custom-scrollbar">
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

            {{-- Input --}}
            <form action="{{ route(auth()->user()->role . '.messages.send', $activeConversation->id) }}" 
                  method="POST" 
                  class="p-4 bg-gray-800 border-t border-gray-700 flex gap-2 flex-shrink-0">
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
            <div class="flex items-center justify-center flex-1 text-gray-500 text-center p-10">
                Select a conversation to start chatting.
            </div>
        @endisset
    </div>
</div>

{{-- Custom Scrollbar + Layout Fixes --}}
<style>
html, body {
    height: 100%;
    margin: 0;
    overflow: hidden;
    background-color: #111827;
}

/* Prevent white gaps caused by main/container */
main, .container, #app {
    padding: 0 !important;
    margin: 0 !important;
    background: transparent !important;
    height: 100% !important;
}

/* Scrollbars */
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

<script>
// ✅ Detect navbar height dynamically
window.addEventListener('load', () => {
    const navbar = document.querySelector('nav, header, .navbar');
    if (navbar) {
        const height = navbar.offsetHeight + 'px';
        document.documentElement.style.setProperty('--navbar-height', height);
    }
});

document.getElementById('toggleSidebar')?.addEventListener('click', () => {
    document.getElementById('sidebar').classList.toggle('-translate-x-full');
});
document.getElementById('backToSidebar')?.addEventListener('click', () => {
    document.getElementById('sidebar').classList.remove('-translate-x-full');
});

const chatBox = document.getElementById('chat-box');
if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
</script>
@endsection
