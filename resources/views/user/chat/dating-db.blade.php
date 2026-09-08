<div class="py-10 text-center text-sm lg:pt-8">
    <img src="{{ $receiver->chat_image ? asset('storage/' . $receiver->chat_image) : asset('images/avatars/avatar-1.jpg') }}"
        class="w-24 h-24 rounded-full mx-auto mb-3" alt="">

    <div class="mt-8">
        <a href="{{ url('/user/' . $receiver->id) }}" class="md:text-xl text-base font-medium text-black dark:text-white">
            {{ $receiver->first_name }} {{ $receiver->last_name }}
        </a>
    </div>

    @if (!$receiver->has_details && !$receiver->sender_has_details)
        <div class="mt-3.5">
            <p class="text-gray-500 text-sm">
                Your dating account deleted
            </p>
        </div>
    @elseif (!$receiver->has_details)
        <div class="mt-3.5">
            <p class="text-gray-500 text-sm">
                Dating account deleted
            </p>
        </div>
    @elseif (!$receiver->sender_has_details)
        <div class="mt-3.5">
            <p class="text-gray-500 text-sm">
                Your dating account deleted
            </p>
        </div>
    @else
        <div class="mt-3.5">

            <a href="{{ url('/dating/profile/' . $receiver->id) }}"
                class="inline-block rounded-lg px-4 py-1.5 text-sm font-semibold bg-secondery">
                View profile
            </a>

            <p
                class="text-gray-700 text-sm leading-relaxed px-3 py-2 rounded-lg bg-gradient-to-r from-pink-50 to-blue-50">
                Connect as friends to enable real-time messaging.
            </p>

        </div>
    @endif
</div>

<div id="dating-messages" class="space-y-4"></div>

{{-- <div class="flex items-center m-4 gap-2">
    <input id="datingMessage" id="messageInput" class="w-full p-2 border rounded dark:bg-gray-900 dark:border-gray-600"
        placeholder="">
    <button onclick="sendDatingMessage()" id="sendButton" class="bg-blue-500 text-white px-4 py-2 rounded">
        Send
    </button>
</div> --}}

<script>
    const datingChatAllowed =
        {{ $receiver->has_details && $receiver->sender_has_details ? 'true' : 'false' }};

    async function sendDatingMessage() {

        // Dating account deleted on either side
        if (!datingChatAllowed) {
            return;
        }

        const input = document.getElementById('datingMessage');

        if (!input) return;

        const msg = input.value.trim();

        if (!msg) return;

        const res = await fetch("{{ route('dating.message.send') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                receiver_id: {{ $receiver->id }},
                message: msg
            })
        });

        if (!res.ok) {
            return;
        }

        input.value = '';

        loadDatingChat();
    }


    // Enter key
    document.getElementById('datingMessage')?.addEventListener('keydown', function(e) {

        if (e.key === 'Enter') {

            // Account deleted on either side
            if (!datingChatAllowed) {
                e.preventDefault();
                return;
            }

            e.preventDefault();

            sendDatingMessage();
        }

    });


    async function loadDatingChat() {

        const res = await fetch("{{ route('dating.chat', $receiver->id) }}");

        const data = await res.json();

        const box = document.getElementById('dating-messages');

        box.innerHTML = '';

        data.forEach(m => {

            box.innerHTML += `
                <div class="${m.sender_id == {{ auth()->id() }} ? 'text-right' : 'text-left'}">
                    <span class="inline-block bg-gray-200 px-3 py-2 rounded">
                        ${m.message}
                    </span>
                </div>
            `;

        });
    }

    loadDatingChat();
</script>
