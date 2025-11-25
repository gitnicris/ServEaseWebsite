@extends('layouts.app')

@section('title', 'Messages')

@section('content')
<div 
    x-data="{ showSidebar: true }"
    @resize.window="showSidebar = window.innerWidth >= 768"
    class="flex gap-6"
>
    {{-- LEFT: CONVERSATION LIST CARD --}}
    <div 
        x-show="showSidebar"
        x-transition
        class="w-full md:w-1/3 bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden relative"
    >
        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200">
            <div class="flex items-center gap-2">
                <span class="inline-flex h-8 w-8 rounded-full bg-blue-100 text-blue-600 items-center justify-center">
                    <i class="bi bi-chat-dots"></i>
                </span>
                <h2 class="text-base font-semibold text-gray-800">Messages</h2>
            </div>

            {{-- Close on mobile --}}
            <button 
                @click="showSidebar = false"
                class="md:hidden text-gray-400 hover:text-gray-700 text-lg"
            >
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        {{-- List --}}
        <div class="max-h-[440px] overflow-y-auto">
            @forelse($conversations as $conversation)
                @php
                    $otherUser = auth()->user()->role === 'provider'
                        ? $conversation->customer
                        : $conversation->provider;

                    // If your controller sends an $activeConversation, we can highlight it
                    $active = isset($activeConversation) && $activeConversation->id === $conversation->id;
                @endphp

                <a href="{{ route(auth()->user()->role . '.messages.chat', $conversation->id) }}"
                   class="block px-5 py-4 text-sm hover:bg-blue-50 transition {{ $active ? 'bg-blue-50' : 'bg-white' }}"
                   @click="if(window.innerWidth < 768) showSidebar = false"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-semibold text-gray-800">
                                {{ $otherUser->name ?? 'Unknown User' }}
                            </p>
                            <p class="text-xs text-gray-500 mt-0.5">
                                {{ $conversation->service->name ?? 'Service' }}
                            </p>
                        </div>
                        <span class="text-[11px] text-gray-400 whitespace-nowrap">
                            {{ optional($conversation->messages->last())->created_at?->diffForHumans() ?? '' }}
                        </span>
                    </div>
                </a>
            @empty
                <div class="px-5 py-6 text-center text-sm text-gray-500">
                    No conversations yet.
                </div>
            @endforelse
        </div>
    </div>

    {{-- RIGHT: EMPTY STATE / HINT --}}
    <div class="hidden md:flex flex-1 items-center justify-center text-gray-400 text-sm">
        Select a conversation to start chatting.
    </div>

    {{-- Mobile toggle button (only visible when sidebar hidden) --}}
    <button 
        @click="showSidebar = true"
        class="fixed bottom-6 right-6 md:hidden inline-flex items-center gap-2 px-4 py-2 rounded-full shadow-md bg-blue-600 text-white text-sm"
        x-show="!showSidebar"
    >
        <i class="bi bi-chat-dots"></i>
        <span>Chats</span>
    </button>
</div>

{{-- Alpine --}}
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
