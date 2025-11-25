@extends('layouts.app')

@section('title', 'Messages')

@section('content')
<div class="flex h-[calc(100vh-180px)] bg-white text-gray-900 rounded-lg overflow-hidden shadow-lg relative">

    {{-- SIDEBAR --}}
    <div class="hidden md:block w-1/3 bg-gray-50 border-r">
        <div class="p-4 border-b">
            <h2 class="text-xl font-semibold text-blue-600">Messages</h2>
        </div>

        <div class="overflow-y-auto h-[calc(100vh-220px)]">
            @forelse($conversations as $conversation)
                @php
                    $otherUser = auth()->user()->role === 'provider' ? $conversation->customer : $conversation->provider;
                @endphp
                <a href="{{ route(auth()->user()->role . '.messages.chat', $conversation->id) }}" class="block p-4 hover:bg-gray-100 transition {{ $conversation->id === $booking->id ? 'bg-blue-50' : '' }}">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-semibold">{{ $otherUser->name ?? 'Unknown User' }}</p>
                            <p class="text-sm text-gray-500 truncate">{{ $conversation->service->name ?? 'Service' }}</p>
                        </div>
                        <span class="text-xs text-gray-400">
                            {{ optional($conversation->messages->last())->created_at?->diffForHumans() ?? '' }}
                        </span>
                    </div>
                </a>
            @empty
                <div class="p-4 text-gray-500 text-center">No conversations yet.</div>
            @endforelse
        </div>
    </div>

    {{-- CHAT PANEL --}}
    <div class="flex-1 flex flex-col bg-white">
        {{-- Header --}}
        <div class="flex items-center justify-between p-4 border-b">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">
                    {{ auth()->id() === $booking->customer_id ? $booking->provider->name : $booking->customer->name }}
                </h3>
                <p class="text-sm text-gray-500">{{ $booking->service->name ?? '' }}</p>
            </div>
            <div class="text-sm text-gray-400">
                Booking #{{ $booking->id }}
            </div>
        </div>

        {{-- Messages --}}
        <div id="chat-box" class="flex-1 p-4 overflow-y-auto bg-gradient-to-b from-white to-gray-50">
            {{-- Messages will be appended by server-rendered markup for first load --}}
            @forelse($messages as $msg)
                @include('messages._single_message', ['msg' => $msg])
            @empty
                <div class="text-center text-gray-500 mt-8">No messages yet. Say hello 👋</div>
            @endforelse
        </div>

        {{-- Input --}}
        <form id="message-form" action="{{ route(auth()->user()->role . '.messages.send', $booking->id) }}" method="POST" class="p-4 border-t flex gap-2 items-center">
            @csrf
            <input id="message-input" name="message" type="text" required placeholder="Type a message..." class="flex-1 px-4 py-2 rounded-full border focus:outline-none focus:ring-2 focus:ring-blue-200">
            <button id="send-btn" type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full font-semibold">Send</button>
        </form>
    </div>
</div>

{{-- Partial for one message bubble --}}
@push('blade-components')
    {{-- nothing; included below as separate file reference --}}
@endpush

<style>
    /* Bubble styling for Option A */
    .bubble { max-width: 72%; padding: 0.75rem 1rem; border-radius: 18px; display: inline-block; }
    .bubble.me { background: #2563eb; color: white; border-bottom-right-radius: 6px; }
    .bubble.them { background: #f3f4f6; color: #111827; border-bottom-left-radius: 6px; }
    #chat-box .msg-row { margin-bottom: 0.8rem; display: flex; gap: 0.5rem; align-items: flex-end; }
    #chat-box .msg-row.justify-end { justify-content: flex-end; }
    .msg-meta { font-size: 0.75rem; color: #9ca3af; margin-top: 0.25rem; text-align: right; }
</style>

{{-- Load Pusher & Echo (CDN) --}}
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.1/dist/echo.iife.js"></script>

<script>
    const bookingId = {{ $booking->id }};
    const userId = {{ auth()->id() }};
    const userName = {!! json_encode(auth()->user()->name) !!};

    // Send message via AJAX (prevents full page reload)
    document.getElementById('message-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const input = document.getElementById('message-input');
        const text = input.value.trim();
        if (!text) return;

        // optimistic append
        appendMessage({
            id: 'temp-' + Date.now(),
            sender_id: userId,
            sender_name: userName,
            message: text,
            created_at: new Date().toISOString()
        }, true);

        input.value = '';
        scrollToBottom();

        // send via fetch
        try {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
            const res = await fetch("{{ route(auth()->user()->role . '.messages.send', $booking->id) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: text })
            });

            if (!res.ok) {
                console.error('Send failed', res.statusText);
                // optionally show error to user
            } else {
                // server will broadcast; we don't need to do anything here
            }
        } catch(err) {
            console.error(err);
        }
    });

    // append message into DOM; isMe boolean determines bubble
    function appendMessage(data, optimistic = false) {
        const chatBox = document.getElementById('chat-box');
        const isMe = parseInt(data.sender_id) === parseInt(userId);

        const row = document.createElement('div');
        row.className = 'msg-row ' + (isMe ? 'justify-end' : 'justify-start');

        const bubble = document.createElement('div');
        bubble.className = 'bubble ' + (isMe ? 'me' : 'them');
        bubble.innerHTML = `<div>${escapeHtml(data.message)}</div>
                            <div class="msg-meta">${timeAgo(new Date(data.created_at))}</div>`;

        row.appendChild(bubble);
        chatBox.appendChild(row);

        // remove optimistic mark? (not implemented: you'd replace temp ID)
        if (!optimistic) {
            scrollToBottom();
        }
    }

    // Escape helper
    function escapeHtml(unsafe) {
        return unsafe
           .replace(/&/g, "&amp;")
           .replace(/</g, "&lt;")
           .replace(/>/g, "&gt;")
           .replace(/"/g, "&quot;")
           .replace(/'/g, "&#039;");
    }

    function scrollToBottom() {
        const chatBox = document.getElementById('chat-box');
        chatBox.scrollTop = chatBox.scrollHeight + 200;
    }

    function timeAgo(date) {
        const now = new Date();
        const diff = Math.floor((now - date) / 1000);
        if (diff < 60) return `${diff}s`;
        if (diff < 3600) return `${Math.floor(diff/60)}m`;
        if (diff < 86400) return `${Math.floor(diff/3600)}h`;
        return date.toLocaleString();
    }

    // ---- Real-time via Echo/Pusher ----
    (function initEcho() {
        try {
            // Replace these with your keys if not using environment injection
            const PUSHER_KEY = "{{ env('MIX_PUSHER_APP_KEY', env('PUSHER_APP_KEY')) }}";
            const PUSHER_CLUSTER = "{{ env('MIX_PUSHER_APP_CLUSTER', env('PUSHER_APP_CLUSTER', 'mt1')) }}";

            if (!PUSHER_KEY) {
                console.warn('Pusher key not found; falling back to polling.');
                startPolling();
                return;
            }

            window.Pusher.logToConsole = false;

            const echo = new window.Echo({
                broadcaster: 'pusher',
                client: window.Pusher,
                key: PUSHER_KEY,
                cluster: PUSHER_CLUSTER,
                forceTLS: true,
                encrypted: true,
                // authEndpoint (if your broadcast route needs it), Laravel handles /broadcasting/auth with the cookie
            });

            // Subscribe to private channel
            echo.private('booking.' + bookingId)
                .listen('.MessageSent', (e) => {
                    // append only if incoming message from other user or not duplicate
                    if (parseInt(e.message.sender_id) !== parseInt(userId)) {
                        appendMessage({
                            id: e.message.id,
                            sender_id: e.message.sender_id,
                            sender_name: e.message.sender_name,
                            message: e.message.message,
                            created_at: e.message.created_at
                        }, false);
                    }
                })
                .error((err) => {
                    console.error('Echo error', err);
                    startPolling();
                });

        } catch (err) {
            console.warn('Echo initialization failed, fallback to polling', err);
            startPolling();
        }
    })();

    // ---- Polling fallback ----
    let pollingInterval = null;
    function startPolling() {
        if (pollingInterval) return;
        // initial fetch of messages then set interval
        fetchMessages();
        pollingInterval = setInterval(fetchMessages, 4000); // every 4s
    }

    let lastFetchedIds = new Set();
    async function fetchMessages() {
        try {
            const res = await fetch("{{ route(auth()->user()->role . '.messages.fetch', $booking->id) }}", {
                headers: { 'Accept': 'application/json' }
            });
            if (!res.ok) return;
            const data = await res.json();
            // append new messages only
            data.forEach(msg => {
                if (!lastFetchedIds.has(msg.id)) {
                    lastFetchedIds.add(msg.id);
                    // skip messages already in DOM if optimistic used (we used temp IDs so no conflict)
                    appendMessage(msg, false);
                }
            });
            scrollToBottom();
        } catch (err) {
            console.error('Polling error', err);
        }
    }

    // On load, scroll to bottom
    document.addEventListener('DOMContentLoaded', () => {
        scrollToBottom();

        // Fill lastFetchedIds with existing IDs to prevent duplicates when polling
        document.querySelectorAll('#chat-box .msg-row[data-msg-id]').forEach(el => {
            const id = el.getAttribute('data-msg-id');
            if (id) lastFetchedIds.add(parseInt(id));
        });
    });
</script>
@endsection
