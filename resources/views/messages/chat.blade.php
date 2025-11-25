@extends('layouts.app')

@section('title', 'Chat')

@section('content')
<div class="flex flex-col md:flex-row gap-4">

    {{-- SIDEBAR CONVERSATION LIST --}}
    <div class="w-full md:w-1/3 bg-gray-50 border border-gray-200 rounded-lg overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 bg-white flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800 mb-0">
                <i class="bi bi-chat-dots me-1 text-primary"></i> Messages
            </h2>
        </div>

        <div class="max-h-[520px] overflow-y-auto">
            @forelse($conversations as $conversation)
                @php
                    $otherUser = auth()->user()->role === 'provider'
                        ? $conversation->customer
                        : $conversation->provider;

                    $active = $conversation->id === $booking->id;
                @endphp

                <a href="{{ route(auth()->user()->role . '.messages.chat', $conversation->id) }}"
                   class="block px-4 py-3 border-b border-gray-100 hover:bg-blue-50 transition {{ $active ? 'bg-blue-50' : 'bg-white' }}">
                    <div class="flex justify-between gap-2">
                        <div class="min-w-0">
                            <p class="font-semibold text-gray-900 mb-0">
                                {{ $otherUser->name ?? 'Unknown User' }}
                            </p>
                            <p class="text-sm text-gray-500 mb-0 truncate">
                                {{ $conversation->service->name ?? 'Service' }}
                            </p>
                        </div>

                        <span class="text-xs text-gray-400 whitespace-nowrap">
                            {{ optional($conversation->messages->last())->created_at?->diffForHumans() ?? '' }}
                        </span>
                    </div>
                </a>
            @empty
                <div class="px-4 py-5 text-center text-gray-500">
                    No conversations yet.
                </div>
            @endforelse
        </div>
    </div>

    {{-- MAIN CHAT FOR THIS BOOKING --}}
    <div class="w-full md:flex-1">
        <div class="flex flex-col h-full bg-white border border-gray-200 rounded-lg">

            {{-- HEADER --}}
            <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between bg-gray-50">
                <div class="min-w-0">
                    <h3 class="text-base md:text-lg font-semibold text-gray-900 mb-0 truncate">
                        {{ auth()->id() === $booking->customer_id ? $booking->provider->name : $booking->customer->name }}
                    </h3>
                    <p class="text-xs md:text-sm text-gray-500 mb-0 truncate">
                        {{ $booking->service->name ?? '' }}
                    </p>
                </div>
                <span class="text-xs text-gray-400 ms-3">
                    Booking #{{ $booking->id }}
                </span>
            </div>

            {{-- MESSAGES --}}
            <div id="chat-box" class="flex-1 overflow-y-auto px-4 py-3 space-y-2 max-h-[420px] bg-white">
                @forelse($messages as $msg)
                    @php
                        $isMe = $msg->sender_id === auth()->id();
                    @endphp

                    <div class="msg-row flex {{ $isMe ? 'justify-end' : 'justify-start' }}" data-msg-id="{{ $msg->id }}">
                        <div class="bubble {{ $isMe ? 'me' : 'them' }}">
                            <div class="whitespace-pre-line text-sm">
                                {{ $msg->message }}
                            </div>
                            <div class="msg-meta">
                                {{ $msg->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center mt-4 mb-0">
                        No messages yet. Say hello 👋
                    </p>
                @endforelse
            </div>

            {{-- INPUT (AJAX + Echo/Pusher) --}}
            <form
                id="message-form"
                action="{{ route(auth()->user()->role . '.messages.send', $booking->id) }}"
                method="POST"
                class="px-3 py-2 border-t border-gray-200 bg-gray-50 flex gap-2 items-center"
            >
                @csrf

                <input
                    id="message-input"
                    name="message"
                    type="text"
                    required
                    placeholder="Type a message..."
                    class="flex-1 form-control text-sm"
                >

                <button
                    id="send-btn"
                    type="submit"
                    class="btn btn-primary btn-sm d-flex align-items-center gap-1"
                >
                    <i class="bi bi-send-fill"></i>
                    <span class="d-none d-md-inline">Send</span>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    /* message bubbles inside page-card (light theme) */
    .bubble {
        max-width: 75%;
        padding: 0.55rem 0.9rem;
        border-radius: 999px;
        display: inline-block;
    }
    .bubble.me {
        background: #2563eb;
        color: #ffffff;
        border-bottom-right-radius: 0.55rem;
    }
    .bubble.them {
        background: #f3f4f6;
        color: #111827;
        border-bottom-left-radius: 0.55rem;
    }
    #chat-box .msg-row {
        margin-bottom: 0.35rem;
        display: flex;
        gap: 0.35rem;
        align-items: flex-end;
    }
    .msg-meta {
        font-size: 0.7rem;
        color: #9ca3af;
        margin-top: 0.2rem;
        text-align: right;
    }
</style>

{{-- Pusher & Echo (CDN) --}}
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.1/dist/echo.iife.js"></script>

<script>
    const bookingId = {{ $booking->id }};
    const userId = {{ auth()->id() }};
    const userName = {!! json_encode(auth()->user()->name) !!};

    // Send message via AJAX (stay in page-card)
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
            }
        } catch(err) {
            console.error(err);
        }
    });

    function appendMessage(data, optimistic = false) {
        const chatBox = document.getElementById('chat-box');
        const isMe = parseInt(data.sender_id) === parseInt(userId);

        const row = document.createElement('div');
        row.className = 'msg-row flex ' + (isMe ? 'justify-end' : 'justify-start');

        const bubble = document.createElement('div');
        bubble.className = 'bubble ' + (isMe ? 'me' : 'them');
        bubble.innerHTML =
            `<div class="whitespace-pre-line text-sm">${escapeHtml(data.message)}</div>
             <div class="msg-meta">${timeAgo(new Date(data.created_at))}</div>`;

        row.appendChild(bubble);
        chatBox.appendChild(row);

        if (!optimistic) {
            scrollToBottom();
        }
    }

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
        if (chatBox) chatBox.scrollTop = chatBox.scrollHeight + 200;
    }

    function timeAgo(date) {
        const now = new Date();
        const diff = Math.floor((now - date) / 1000);
        if (diff < 60) return `${diff}s`;
        if (diff < 3600) return `${Math.floor(diff/60)}m`;
        if (diff < 86400) return `${Math.floor(diff/3600)}h`;
        return date.toLocaleString();
    }

    // Echo / Pusher
    (function initEcho() {
        try {
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
            });

            echo.private('booking.' + bookingId)
                .listen('.MessageSent', (e) => {
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

    let pollingInterval = null;
    let lastFetchedIds = new Set();

    function startPolling() {
        if (pollingInterval) return;
        fetchMessages();
        pollingInterval = setInterval(fetchMessages, 4000);
    }

    async function fetchMessages() {
        try {
            const res = await fetch("{{ route(auth()->user()->role . '.messages.fetch', $booking->id) }}", {
                headers: { 'Accept': 'application/json' }
            });
            if (!res.ok) return;
            const data = await res.json();
            data.forEach(msg => {
                if (!lastFetchedIds.has(msg.id)) {
                    lastFetchedIds.add(msg.id);
                    appendMessage(msg, false);
                }
            });
            scrollToBottom();
        } catch (err) {
            console.error('Polling error', err);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        scrollToBottom();
        document.querySelectorAll('#chat-box .msg-row[data-msg-id]').forEach(el => {
            const id = el.getAttribute('data-msg-id');
            if (id) lastFetchedIds.add(parseInt(id));
        });
    });
</script>
@endsection
