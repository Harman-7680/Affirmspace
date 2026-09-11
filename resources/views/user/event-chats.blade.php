@extends('layouts.app1')

@section('content')

    <br><br>

    <div class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 lg:ml-[240px] lg:w-[calc(100%-280px)]">

        {{-- Page Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Event Messages</h1>
            <p class="text-gray-500 text-sm">Manage and respond to messages related to your events</p>
        </div>

        <div class="w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">

            {{-- FIXED EXTRA LARGE HEIGHT CONTAINER --}}
            <div class="grid grid-cols-1 md:grid-cols-3 h-[880px] w-full">

                {{-- ========================================================= --}}
                {{-- LEFT SIDE : EVENT CONVERSATIONS --}}
                {{-- ========================================================= --}}

                <div
                    class="w-full min-w-0 border-b md:border-b-0 md:border-r border-gray-100 flex flex-col bg-gray-50/50 h-full overflow-hidden">

                    {{-- SECTION 1 : MY EVENTS (Independent Scroller) --}}
                    <div class="flex-1 flex flex-col min-h-0 border-b border-gray-200">
                        <div class="px-5 py-3 bg-gray-100 flex-shrink-0 border-b border-gray-200">
                            <h3 class="text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Messages on My Events
                            </h3>
                            <p class="text-[11px] text-gray-400 mt-0.5">
                                People who contacted you on your events
                            </p>
                        </div>

                        <div class="overflow-y-auto flex-1 divide-y divide-gray-100">
                            @forelse($myEventConversations as $conversation)
                                <a href="{{ route('events.chats', [
                                    'event_id' => $conversation['event_id'],
                                    'user_id' => $conversation['other_user_id'],
                                ]) }}"
                                    class="block w-full p-4 hover:bg-white transition-all duration-200
            {{ $selectedEvent &&
            $selectedEvent->id == $conversation['event_id'] &&
            $selectedUser &&
            $selectedUser->id == $conversation['other_user_id']
                ? 'bg-white shadow-sm border-l-4 border-[#dd2476] !pl-[15px]'
                : '' }}">

                                    <div class="flex items-center gap-3.5 min-w-0">
                                        <div class="w-12 h-12 flex-shrink-0 relative">
                                            @if ($conversation['event_image'])
                                                <img src="{{ asset('storage/' . $conversation['event_image']) }}"
                                                    class="w-12 h-12 rounded-xl object-cover shadow-sm" alt="">
                                            @else
                                                <img src="{{ asset('images/default-event.jpg') }}"
                                                    class="w-12 h-12 rounded-xl object-cover shadow-sm" alt="">
                                            @endif
                                        </div>

                                        <div class="min-w-0 flex-1">
                                            <div class="font-semibold text-sm text-gray-800 truncate">
                                                {{ $conversation['event_name'] }}
                                            </div>

                                            @php
                                                $otherUser = \App\Models\User::find($conversation['other_user_id']);
                                            @endphp

                                            <div class="text-xs font-medium text-indigo-600 mt-0.5 truncate">
                                                {{ $otherUser->first_name ?? '' }}
                                                {{ $otherUser->last_name ?? '' }}
                                            </div>

                                            <div class="text-xs text-gray-400 truncate mt-1">
                                                {{ $conversation['last_message'] }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="p-6 text-center text-gray-400 text-sm">
                                    No messages on your events.
                                </div>
                            @endforelse
                        </div>
                    </div>


                    {{-- SECTION 2 : EVENTS I MESSED (Independent Scroller) --}}
                    <div class="flex-1 flex flex-col min-h-0">
                        <div class="px-5 py-3 bg-gray-100 flex-shrink-0 border-b border-gray-200">
                            <h3 class="text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Events I Messaged
                            </h3>
                            <p class="text-[11px] text-gray-400 mt-0.5">
                                Events where you contacted the owner
                            </p>
                        </div>

                        <div class="overflow-y-auto flex-1 divide-y divide-gray-100">
                            @forelse($otherEventConversations as $conversation)
                                <a href="{{ route('events.chats', [
                                    'event_id' => $conversation['event_id'],
                                    'user_id' => $conversation['other_user_id'],
                                ]) }}"
                                    class="block w-full p-4 hover:bg-white transition-all duration-200
            {{ $selectedEvent &&
            $selectedEvent->id == $conversation['event_id'] &&
            $selectedUser &&
            $selectedUser->id == $conversation['other_user_id']
                ? 'bg-white shadow-sm border-l-4 border-[#dd2476] !pl-[15px]'
                : '' }}">

                                    <div class="flex items-center gap-3.5 min-w-0">
                                        <div class="w-12 h-12 flex-shrink-0 relative">
                                            @if ($conversation['event_image'])
                                                <img src="{{ asset('storage/' . $conversation['event_image']) }}"
                                                    class="w-12 h-12 rounded-xl object-cover shadow-sm" alt="">
                                            @else
                                                <img src="{{ asset('images/default-event.jpg') }}"
                                                    class="w-12 h-12 rounded-xl object-cover shadow-sm" alt="">
                                            @endif
                                        </div>

                                        <div class="min-w-0 flex-1">
                                            <div class="font-semibold text-sm text-gray-800 truncate">
                                                {{ $conversation['event_name'] }}
                                            </div>

                                            @php
                                                $otherUser = \App\Models\User::find($conversation['other_user_id']);
                                            @endphp

                                            <div class="text-xs font-medium text-indigo-600 mt-0.5 truncate">
                                                {{ $otherUser->first_name ?? '' }}
                                                {{ $otherUser->last_name ?? '' }}
                                            </div>

                                            <div class="text-xs text-gray-400 truncate mt-1">
                                                {{ $conversation['last_message'] }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="p-6 text-center text-gray-400 text-sm">
                                    You haven't messaged any other events yet.
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>


                {{-- ========================================================= --}}
                {{-- RIGHT SIDE : CHAT --}}
                {{-- ========================================================= --}}

                <div class="w-full min-w-0 md:col-span-2 flex flex-col bg-white h-full overflow-hidden">

                    @if ($selectedEvent && $selectedUser)
                        {{-- Chat Header --}}
                        <div
                            class="p-4 border-b border-gray-100 flex items-center gap-3.5 min-w-0 bg-white shadow-xs flex-shrink-0">
                            <div class="w-12 h-12 flex-shrink-0">
                                @if ($selectedEvent->image)
                                    <img src="{{ asset('storage/' . $selectedEvent->image) }}"
                                        class="w-12 h-12 rounded-xl object-cover shadow-sm" alt="">
                                @else
                                    <img src="{{ asset('images/default-event.jpg') }}"
                                        class="w-12 h-12 rounded-xl object-cover shadow-sm" alt="">
                                @endif
                            </div>

                            <div class="min-w-0">
                                <h3 class="font-bold text-gray-800 truncate text-base">
                                    {{ $selectedEvent->name }}
                                </h3>
                                <p class="text-xs font-medium text-indigo-600 truncate">
                                    Chat with {{ $selectedUser->first_name }} {{ $selectedUser->last_name }}
                                </p>
                            </div>
                        </div>


                        {{-- Messages (Scrollable with independent scroller) --}}
                        <div id="event-chat-messages"
                            class="flex-1 min-w-0 p-5 space-y-4 overflow-y-auto overflow-x-hidden bg-gray-50/30">

                            @forelse($selectedMessages as $message)
                                @if ($message->sender_id == $user->id)
                                    {{-- My Message --}}
                                    <div class="flex justify-end min-w-0">
                                        <div class="max-w-[75%] min-w-0">
                                            <div
                                                class="chat_send_bubble text-white px-4 py-2.5 rounded-2xl rounded-br-sm break-words shadow-sm text-sm">
                                                {{ $message->message }}
                                            </div>
                                            <div class="text-[10px] text-gray-400 text-right mt-1">
                                                {{ $message->created_at->format('d M Y, h:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    {{-- Other User Message --}}
                                    <div class="flex justify-start min-w-0">
                                        <div class="max-w-[75%] min-w-0">
                                            <div
                                                class="bg-white border border-gray-100 text-gray-800 px-4 py-2.5 rounded-2xl rounded-bl-sm break-words shadow-sm text-sm">
                                                {{ $message->message }}
                                            </div>
                                            <div class="text-[10px] text-gray-400 mt-1">
                                                {{ $message->created_at->format('d M Y, h:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            @empty
                                <div class="text-center text-gray-400 text-sm py-16">
                                    No messages yet. Start the conversation!
                                </div>
                            @endforelse

                        </div>


                        {{-- Send Message Form --}}
                        <div class="w-full border-t border-gray-100 p-4 bg-white flex-shrink-0">
                            <form action="{{ route('events.chats.send') }}" method="POST"
                                class="flex gap-3 w-full items-center">
                                @csrf

                                <input type="hidden" name="event_id" value="{{ $selectedEvent->id }}">
                                <input type="hidden" name="user_id" value="{{ $selectedUser->id }}">

                                <input type="text" name="message" required maxlength="5000"
                                    placeholder="Type a message..."
                                    class="flex-1 min-w-0 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#dd2476]/50 focus:border-[#dd2476] text-sm">

                                <button type="submit"
                                    class="create_room_button flex-shrink-0 px-6 py-3 rounded-xl text-sm font-semibold transition cursor-pointer">
                                    Send
                                </button>
                            </form>
                        </div>
                    @else
                        {{-- No Chat Selected State --}}
                        <div class="flex-1 flex items-center justify-center p-6 bg-gray-50/20 h-full">
                            <div class="text-center text-gray-400">
                                <div
                                    class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400">
                                    💬
                                </div>
                                <h3 class="text-base font-semibold text-gray-700">
                                    Select an event conversation
                                </h3>
                                <p class="text-xs text-gray-400 mt-1">
                                    Choose a conversation from the left sidebar to view messages.
                                </p>
                            </div>
                        </div>
                    @endif

                </div>

            </div>

        </div>

    </div>

@endsection

@section('css')
    <style>
        .create_room_button {
            background: linear-gradient(90deg, #ff512f, #dd2476) !important;
            border-radius: 12px !important;
            color: white !important;
            font-weight: 600;
            letter-spacing: .5px;
            box-shadow: 0 4px 10px rgba(221, 36, 118, 0.25);
            transition: 0.3s ease;
            border: none;
        }

        .create_room_button:hover {
            opacity: .9;
            transform: translateY(-1px);
        }

        .chat_send_bubble {
            background: linear-gradient(90deg, #ff512f, #dd2476) !important;
        }
    </style>
@endsection
