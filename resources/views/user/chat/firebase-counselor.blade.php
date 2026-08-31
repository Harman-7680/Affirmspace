<div class="py-10 text-center text-sm lg:pt-8">
    <img src="{{ $receiver->image ? asset('storage/' . $receiver->image) : asset('images/avatars/avatar-1.jpg') }}"
        class="w-24 h-24 rounded-full mx-auto mb-3" alt="">
    <div class="mt-8">
        <div class="md:text-xl text-base font-medium text-black dark:text-white">
            {{ $receiver->first_name }} {{ $receiver->last_name }}
        </div>
    </div>
    {{-- <div class="mt-3.5">
                                    <a href="{{ route('user.profile', ['id' => $receiver->id]) }}"
                                        class="inline-block rounded-lg px-4 py-1.5 text-sm font-semibold bg-secondery">
                                        View profile
                                    </a>
                                </div> --}}
    <div class="mt-3.5">
        @if ($receiver->role == 1)
            {{-- Counselor profile --}}
            <a href="{{ url('/counselor/' . $receiver->id) }}"
                class="inline-block rounded-lg px-4 py-1.5 text-sm font-semibold bg-secondery">
                View profile
            </a>
        @elseif ($receiver->chat_type == 'dating')
            {{-- Dating profile --}}
            <a href="{{ url('/dating/profile/' . $receiver->id) }}"
                class="inline-block rounded-lg px-4 py-1.5 text-sm font-semibold bg-secondery">
                View profile
            </a>
        @else
            {{-- Counselee profile --}}
            <a href="{{ route('user.profile', ['id' => $receiver->id]) }}"
                class="inline-block rounded-lg px-4 py-1.5 text-sm font-semibold bg-secondery">
                View profile
            </a>
        @endif
    </div>
</div>

<div id="chat-messages" class="text-sm font-medium space-y-6"></div>

<script>
    window.Chat = {
        senderId: {{ Auth::id() }},
        receiverId: {{ $receiver->id }},
        currentUserImage: "{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('images/avatars/avatar-1.jpg') }}",
        receiverImage: "{{ $receiver->image ? asset('storage/' . $receiver->image) : asset('images/avatars/avatar-1.jpg') }}"
    };
</script>

@vite(['resources/js/app.js', 'resources/js/chat.js'])