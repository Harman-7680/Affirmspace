@extends('layouts.app1')

@section('content')
    <br><br>
    <div class="max-w-5xl mx-auto px-4 py-6">

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">

            {{-- Group Header --}}
            <div class="flex items-center gap-3 p-4 border-b
                    border-gray-200 dark:border-gray-700">

                <div
                    class="w-12 h-12 rounded-full bg-indigo-100
                        flex items-center justify-center shrink-0 overflow-hidden">

                    @if ($group->image)
                        <img src="{{ asset('storage/' . $group->image) }}" alt="Group image"
                            style="width:48px;height:48px;object-fit:cover;">
                    @else
                        <span class="text-xl font-bold text-indigo-600">
                            {{ strtoupper(substr($group->name, 0, 1)) }}
                        </span>
                    @endif

                </div>

                <div class="min-w-0 flex-1">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                        {{ $group->name }}
                    </h2>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $group->members->count() }}
                        {{ $group->members->count() === 1 ? 'member' : 'members' }}
                    </p>
                </div>

                <a href="{{ route('messages') }}"
                    class="px-3 py-2 text-sm rounded-lg border
                      border-gray-300 dark:border-gray-600
                      text-gray-700 dark:text-gray-200">
                    Back to Chats
                </a>
            </div>

            {{-- Members --}}
            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                <p class="text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                    Group Members
                </p>

                <div class="flex flex-wrap gap-2">
                    @foreach ($group->members as $member)
                        <span
                            class="px-3 py-1 rounded-full text-sm
                                 bg-gray-100 dark:bg-gray-700
                                 text-gray-700 dark:text-gray-200">
                            {{ trim($member->first_name . ' ' . $member->last_name) }}

                            @if ((int) $member->id === (int) $group->created_by)
                                · Admin
                            @endif
                        </span>
                    @endforeach
                </div>
            </div>

            {{-- Messages Area --}}
            <div class="p-4 min-h-[350px] max-h-[60vh] overflow-y-auto" id="groupMessages">

                @if (isset($messages) && $messages->count())
                    @foreach ($messages as $message)
                        <div
                            class="mb-4 flex {{ (int) $message->user_id === (int) auth()->id() ? 'justify-end' : 'justify-start' }}">

                            <div
                                class="max-w-[80%] rounded-xl px-4 py-2
                            {{ (int) $message->user_id === (int) auth()->id()
                                ? 'bg-indigo-600 text-white'
                                : 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' }}">

                                @if ((int) $message->user_id !== (int) auth()->id())
                                    <p class="text-xs font-semibold mb-1">
                                        {{ trim(($message->user->first_name ?? '') . ' ' . ($message->user->last_name ?? '')) }}
                                    </p>
                                @endif

                                @if ($message->message)
                                    <p class="text-sm whitespace-pre-wrap break-words">{{ $message->message }}</p>
                                @endif

                                @if ($message->attachment_path)
                                    <a href="{{ asset('storage/' . $message->attachment_path) }}" target="_blank"
                                        rel="noopener noreferrer" class="block mt-2 underline text-sm">
                                        {{ $message->attachment_name ?? 'View attachment' }}
                                    </a>
                                @endif

                                <p class="text-[11px] mt-1 opacity-70 text-right">
                                    {{ $message->created_at->format('h:i A') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div
                        class="h-full min-h-[300px] flex flex-col items-center
                            justify-center text-center">

                        <div
                            class="w-16 h-16 rounded-full bg-indigo-100
                                flex items-center justify-center mb-4">
                            <span class="text-2xl text-indigo-600">👥</span>
                        </div>

                        <h3 class="font-semibold text-gray-800 dark:text-white">
                            Welcome to {{ $group->name }}
                        </h3>

                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                            Your permanent group chat is ready.
                        </p>
                    </div>
                @endif

            </div>

            {{-- Message Composer --}}
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">

                <form id="groupMessageForm" enctype="multipart/form-data" class="flex items-end gap-2">

                    @csrf

                    <label for="groupAttachment" id="groupAttachmentLabel" title="Attach file" aria-label="Attach file">
                        📎
                    </label>

                    <input type="file" id="groupAttachment" name="attachment" class="hidden">

                    <div class="flex-1 min-w-0">
                        <div id="selectedAttachment" class="hidden text-xs text-gray-500 mb-1 break-all"></div>

                        <textarea id="groupMessageInput" name="message" rows="1" maxlength="10000" placeholder="Type a message..."
                            class="w-full resize-none rounded-lg border
                       border-gray-300 dark:border-gray-600
                       bg-white dark:bg-gray-700
                       text-gray-900 dark:text-white
                       px-4 py-3 outline-none"></textarea>
                    </div>

                    <button type="submit" id="groupSendButton">
                        <span class="send-label">Send</span>
                        <span aria-hidden="true">➤</span>
                    </button>

                </form>

                <p id="groupMessageError" class="hidden text-sm text-red-500 mt-2"></p>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const box = document.getElementById('groupMessages');

            if (box) {
                box.scrollTop = box.scrollHeight;
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const groupId = @json($group->id);
            const currentUserId = @json(auth()->id());

            const fetchUrl = @json(route('friend-chat-groups.messages.fetch', $group->id));
            const sendUrl = @json(route('friend-chat-groups.messages.send', $group->id));

            const messagesBox = document.getElementById('groupMessages');
            const form = document.getElementById('groupMessageForm');
            const input = document.getElementById('groupMessageInput');
            const attachmentInput = document.getElementById('groupAttachment');
            const attachmentLabel = document.getElementById('selectedAttachment');
            const sendButton = document.getElementById('groupSendButton');
            const errorBox = document.getElementById('groupMessageError');

            let lastMessageId = 0;
            let loading = false;

            function escapeHtml(value) {
                return String(value ?? '').replace(/[&<>"']/g, function(char) {
                    return {
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;',
                        '"': '&quot;',
                        "'": '&#039;'
                    } [char];
                });
            }

            function renderMessage(message) {
                const ownMessage =
                    Number(message.user_id) === Number(currentUserId);

                const wrapper = document.createElement('div');

                wrapper.className =
                    'group-message-row ' + (ownMessage ? 'own' : 'other');

                const bubble = document.createElement('div');

                bubble.className =
                    'group-message-bubble ' + (ownMessage ? 'own' : 'other');

                if (!ownMessage) {
                    const name = document.createElement('div');

                    name.className = 'group-message-name';
                    name.textContent = message.user_name || 'User';

                    bubble.appendChild(name);
                }

                // Message text
                if (message.message) {
                    const text = document.createElement('div');

                    text.className = 'group-message-text';
                    text.textContent = message.message;

                    bubble.appendChild(text);
                }

                // Attachment preview
                if (message.attachment_url) {
                    const url = message.attachment_url;
                    const mime = message.attachment_mime || '';
                    const fileName = message.attachment_name || 'Shared file';

                    const attachmentContainer = document.createElement('div');

                    attachmentContainer.style.marginTop = '8px';
                    attachmentContainer.style.maxWidth = '100%';

                    if (mime.startsWith('image/')) {
                        // Image preview
                        const image = document.createElement('img');

                        image.src = url;
                        image.alt = fileName;
                        image.loading = 'lazy';

                        image.style.display = 'block';
                        image.style.maxWidth = '100%';
                        image.style.width = 'auto';
                        image.style.maxHeight = '280px';
                        image.style.objectFit = 'contain';
                        image.style.borderRadius = '10px';
                        image.style.cursor = 'pointer';

                        image.addEventListener('click', function() {
                            window.open(url, '_blank', 'noopener,noreferrer');
                        });

                        attachmentContainer.appendChild(image);

                    } else if (mime.startsWith('video/')) {
                        // Video preview
                        const video = document.createElement('video');

                        video.src = url;
                        video.controls = true;
                        video.preload = 'metadata';
                        video.playsInline = true;

                        video.style.display = 'block';
                        video.style.maxWidth = '100%';
                        video.style.width = '100%';
                        video.style.maxHeight = '280px';
                        video.style.borderRadius = '10px';

                        attachmentContainer.appendChild(video);

                    } else if (mime.startsWith('audio/')) {
                        // Audio player
                        const audio = document.createElement('audio');

                        audio.src = url;
                        audio.controls = true;
                        audio.preload = 'metadata';
                        audio.style.display = 'block';
                        audio.style.maxWidth = '100%';
                        audio.style.marginTop = '5px';

                        attachmentContainer.appendChild(audio);

                    } else {
                        // PDF and other files
                        const fileLink = document.createElement('a');

                        fileLink.href = url;
                        fileLink.target = '_blank';
                        fileLink.rel = 'noopener noreferrer';
                        fileLink.textContent = '📎 ' + fileName;

                        fileLink.style.display = 'block';
                        fileLink.style.padding = '10px';
                        fileLink.style.borderRadius = '8px';
                        fileLink.style.overflowWrap = 'anywhere';
                        fileLink.style.textDecoration = 'underline';

                        attachmentContainer.appendChild(fileLink);
                    }

                    bubble.appendChild(attachmentContainer);
                }

                // Message time
                const time = document.createElement('div');

                time.className = 'group-message-time';
                time.textContent = message.created_at || '';

                bubble.appendChild(time);
                wrapper.appendChild(bubble);

                return wrapper;
            }

            async function fetchMessages() {
                if (loading) return;

                loading = true;

                try {
                    const response = await fetch(fetchUrl, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (!response.ok) {
                        const errorText = await response.text();
                        console.error('Fetch messages error:', response.status, errorText);
                        throw new Error('Could not load group messages. HTTP ' + response.status);
                    }

                    const data = await response.json();

                    if (!data.success) return;

                    const messages = data.messages || [];

                    // Initial load
                    if (lastMessageId === 0) {
                        messagesBox.replaceChildren();

                        if (messages.length === 0) {
                            messagesBox.innerHTML =
                                '<p id="emptyGroupMessages" class="text-center ' +
                                'text-sm text-gray-500 py-12">' +
                                'No messages yet. Say hello to your group!</p>';
                        }

                        messages.forEach(function(message) {
                            messagesBox.appendChild(renderMessage(message));
                            lastMessageId = Math.max(lastMessageId, Number(message.id));
                        });

                        messagesBox.scrollTop = messagesBox.scrollHeight;
                        return;
                    }

                    // Append only newly received messages
                    messages.forEach(function(message) {
                        if (Number(message.id) > lastMessageId) {
                            const emptyMessage = document.getElementById('emptyGroupMessages');

                            if (emptyMessage) emptyMessage.remove();

                            messagesBox.appendChild(renderMessage(message));
                            lastMessageId = Math.max(lastMessageId, Number(message.id));
                            messagesBox.scrollTop = messagesBox.scrollHeight;
                        }
                    });

                } catch (error) {
                    console.error('Group messages error:', error);

                    errorBox.textContent = error.message;
                    errorBox.classList.remove('hidden');
                } finally {
                    loading = false;
                }
            }

            attachmentInput.addEventListener('change', function() {
                const file = this.files[0];

                if (file) {
                    attachmentLabel.textContent = 'Selected: ' + file.name;
                    attachmentLabel.classList.remove('hidden');
                } else {
                    attachmentLabel.textContent = '';
                    attachmentLabel.classList.add('hidden');
                }
            });

            form.addEventListener('submit', async function(event) {
                event.preventDefault();

                errorBox.textContent = '';
                errorBox.classList.add('hidden');

                if (!input.value.trim() && !attachmentInput.files.length) {
                    return;
                }

                const formData = new FormData(form);

                sendButton.disabled = true;
                sendButton.textContent = 'Sending...';

                try {
                    const response = await fetch(sendUrl, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': form.querySelector(
                                'input[name="_token"]'
                            ).value
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (!response.ok || !data.success) {
                        throw new Error(
                            data.message || 'Message could not be sent.'
                        );
                    }

                    input.value = '';
                    attachmentInput.value = '';
                    attachmentLabel.textContent = '';
                    attachmentLabel.classList.add('hidden');

                    await fetchMessages();

                } catch (error) {
                    errorBox.textContent = error.message;
                    errorBox.classList.remove('hidden');
                } finally {
                    sendButton.disabled = false;
                    sendButton.textContent = 'Send';
                    input.focus();
                }
            });

            // Enter sends; Shift+Enter adds a new line
            input.addEventListener('keydown', function(event) {
                if (event.key === 'Enter' && !event.shiftKey) {
                    event.preventDefault();
                    form.requestSubmit();
                }
            });

            fetchMessages();

            // Poll for messages from other group members
            setInterval(fetchMessages, 3000);
        });
    </script>
@endsection

@section('css')
    <style>
        #groupMessages {
            min-height: 350px;
            max-height: 60vh;
            overflow-y: auto;
            padding: 20px;
            background: #f8fafc;
        }

        .group-message-row {
            display: flex;
            width: 100%;
            margin-bottom: 14px;
        }

        .group-message-row.own {
            justify-content: flex-end;
        }

        .group-message-row.other {
            justify-content: flex-start;
        }

        .group-message-bubble {
            display: block;
            width: fit-content;
            max-width: 80%;
            min-width: 65px;
            padding: 10px 14px;
            border-radius: 14px;
            overflow-wrap: anywhere;
            white-space: normal;
            box-sizing: border-box;
            font-size: 14px;
            line-height: 1.5;
        }

        .group-message-bubble.own {
            background: #4f46e5;
            color: #ffffff;
            border-bottom-right-radius: 4px;
        }

        .group-message-bubble.other {
            background: #ffffff;
            color: #1f2937;
            border: 1px solid #e5e7eb;
            border-bottom-left-radius: 4px;
        }

        .group-message-name {
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .group-message-text {
            white-space: pre-wrap;
            overflow-wrap: anywhere;
        }

        .group-message-time {
            font-size: 10px;
            text-align: right;
            margin-top: 5px;
            opacity: 0.75;
        }

        #groupMessageForm {
            display: flex;
            align-items: flex-end;
            gap: 10px;
            width: 100%;
        }

        #groupMessageInput {
            display: block;
            width: 100%;
            min-height: 46px;
            max-height: 120px;
            resize: vertical;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            background: #ffffff;
            color: #111827;
            box-sizing: border-box;
        }

        #groupSendButton {
            display: inline-flex !important;
            visibility: visible !important;
            align-items: center;
            justify-content: center;
            gap: 7px;
            flex-shrink: 0;
            min-width: 100px;
            min-height: 46px;
            padding: 10px 16px;
            border: none;
            border-radius: 10px;
            background: #4f46e5;
            color: #ffffff !important;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        #groupSendButton:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }

        #groupAttachmentLabel {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            border-radius: 10px;
            background: #f3f4f6;
            cursor: pointer;
            font-size: 21px;
        }

        @media (max-width: 480px) {
            .group-message-bubble {
                max-width: 90%;
            }

            #groupSendButton {
                min-width: 48px;
                padding: 10px;
            }

            #groupSendButton .send-label {
                display: none;
            }
        }
    </style>
@endsection
