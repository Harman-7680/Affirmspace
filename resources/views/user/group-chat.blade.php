@extends('layouts.app1')

@section('content')
    <br><br><br>
    <div class="group-chat-page max-w-5xl mx-auto px-4 pt-2 w-full">

        {{-- Room Header --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 mb-3 flex items-center justify-between gap-3 shrink-0">

            <div class="min-w-0">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white break-words">
                    {{ $room->room_name }}
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $room->users()->count() }} / {{ $room->max_users }} members
                </p>
            </div>

            <a href="{{ route('groups') }}"
                class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600
                  text-gray-800 dark:text-white px-4 py-2 rounded-lg text-sm
                  font-medium whitespace-nowrap shrink-0">
                Leave Chat
            </a>

        </div>


        {{-- Chat Card --}}
        <div class="group-chat-card bg-white dark:bg-gray-800 rounded-xl shadow">

            {{-- Messages: only this section scrolls --}}
            <div id="groupMessages" class="p-4 space-y-4">

                <p id="loadingMessages" class="text-sm text-gray-500 dark:text-gray-400 text-center">
                    Loading messages...
                </p>

            </div>


            {{-- Selected Attachment Preview --}}
            <div id="attachmentPreview"
                class="hidden px-4 py-2 border-t border-gray-200 dark:border-gray-700
                    text-sm text-gray-600 dark:text-gray-300">
            </div>


            {{-- Fixed Bottom Message Form --}}
            <form id="groupChatForm"
                class="border-t border-gray-200 dark:border-gray-700 p-4
                     bg-white dark:bg-gray-800"
                enctype="multipart/form-data">

                @csrf

                {{-- Attachment Input --}}
                <input type="file" id="groupAttachment" name="attachment"
                    accept="image/*,video/*,.pdf,.doc,.docx,.xls,.xlsx,.txt,.mp3,.wav" class="hidden">


                {{-- Attachment Button --}}
                <button type="button" id="attachmentButton" title="Attach a file" aria-label="Attach a file"
                    class="px-3 py-2.5 rounded-lg border border-gray-300
                       dark:border-gray-600 text-gray-700 dark:text-white
                       hover:bg-gray-100 dark:hover:bg-gray-700">

                    📎

                </button>


                {{-- Message Input --}}
                <input type="text" id="groupMessageInput" name="message" maxlength="5000" autocomplete="off"
                    placeholder="Type your message..."
                    class="rounded-lg border border-gray-300 dark:border-gray-600
                       bg-white dark:bg-gray-900 text-gray-900 dark:text-white
                       px-4 py-3 focus:outline-none focus:ring-2
                       focus:ring-blue-500">


                {{-- Send Button --}}
                <button type="submit" id="groupSendButton"
                    class="p-3 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition disabled:opacity-50"
                    aria-label="Send message" title="Send message">
                    <i class="fas fa-paper-plane text-xl"></i>
                </button>
            </form>

        </div>

    </div>
@endsection


@section('script')
    @vite(['resources/js/app.js', 'resources/js/group-chat.js'])

    {{-- Group Chat Configuration --}}
    <script>
        window.GroupChat = {
            roomId: @json($room->id),

            userId: @json(auth()->id()),

            userName: @json(trim(auth()->user()->first_name . ' ' . auth()->user()->last_name)),

            userImage: @json(auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('images/avatars/avatar-1.jpg')),

            fetchUrl: @json(route('group-chat.fetch', $room->id)),

            sendUrl: @json(route('group-chat.send', $room->id)),

            csrfToken: @json(csrf_token())
        };
    </script>
@endsection

@section('css')
    <style>
        /* Prevent the page itself from scrolling on the group chat page */
        html,
        body {
            overflow: hidden;
        }

        /* Main chat layout */
        .group-chat-page {
            height: calc(100dvh - 70px);
            min-height: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-sizing: border-box;
        }

        /* Chat card must shrink to available height */
        .group-chat-card {
            flex: 1 1 0%;
            min-height: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Only this area scrolls */
        #groupMessages {
            flex: 1 1 0%;
            min-height: 0;
            height: 0;
            overflow-x: hidden;
            overflow-y: auto;
            overscroll-behavior-y: contain;
            scrollbar-width: thin;
            -webkit-overflow-scrolling: touch;
        }

        /* Attachment preview stays above the input */
        #attachmentPreview {
            flex-shrink: 0;
            overflow-wrap: anywhere;
        }

        /* Input and send button stay at the bottom */
        #groupChatForm {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        #groupMessageInput {
            flex: 1 1 0%;
            min-width: 0;
        }

        #groupSendButton,
        #attachmentButton {
            flex-shrink: 0;
        }

        @media (max-width: 640px) {
            .group-chat-page {
                height: calc(100dvh - 65px);
            }

            #groupChatForm {
                gap: 8px;
                padding: 10px;
            }

            #groupMessages {
                padding: 12px;
            }
        }
    </style>
@endsection
