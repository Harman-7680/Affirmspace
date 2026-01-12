@extends('layouts.app1')

@section('content')
    <!-- main contents -->
    <main id="site__main" class="2xl:ml-[--w-side]  xl:ml-[--w-side-sm] p-2.5 h-[calc(100vh-var(--m-top))] mt-[--m-top]">
        <div class="relative overflow-hidden border -m-2.5 dark:border-slate-700">
            <div class="flex bg-white dark:bg-dark2">
                <!-- sidebar -->
                <div class="md:w-[360px] relative border-r dark:border-slate-700">

                    <div id="side-chat"
                        class="top-0 left-0 max-md:fixed max-md:w-5/6 max-md:h-screen bg-white z-50 max-md:shadow max-md:-translate-x-full dark:bg-dark2">

                        <!-- heading title -->
                        <div class="p-4 border-b dark:border-slate-700">

                            <div class="flex mt-2 items-center justify-between">

                                <h2 class="text-2xl font-bold text-black ml-1 dark:text-white"> Chats </h1>
                                    <!-- right action buttons -->
                                    {{-- <div class="flex items-center gap-2.5">
                                        <button class="group">
                                            <ion-icon name="settings-outline"
                                                class="text-2xl flex group-aria-expanded:rotate-180"></ion-icon>
                                        </button>
                                        <div class="md:w-[270px] w-full"
                                            uk-dropdown="pos: bottom-left; offset:10; animation: uk-animation-slide-bottom-small">
                                            <nav>
                                                <a href="#"> <ion-icon class="text-2xl shrink-0 -ml-1"
                                                        name="checkmark-outline"></ion-icon> Mark all as read </a>
                                                <a href="#"> <ion-icon class="text-2xl shrink-0 -ml-1"
                                                        name="notifications-outline"></ion-icon> notifications setting </a>
                                                <a href="#"> <ion-icon class="text-xl shrink-0 -ml-1"
                                                        name="volume-mute-outline"></ion-icon> Mute notifications </a>
                                            </nav>
                                        </div>

                                        <button class="">
                                            <ion-icon name="checkmark-circle-outline" class="text-2xl flex"></ion-icon>
                                        </button>

                                        <!-- mobile toggle menu -->
                                        <button type="button" class="md:hidden"
                                            uk-toggle="target: #side-chat ; cls: max-md:-translate-x-full">
                                            <ion-icon name="chevron-down-outline"></ion-icon>
                                        </button>

                                    </div> --}}
                            </div>

                            <!-- search -->
                            <div x-data="{
                                search: '',
                                appointments: {{ Js::from(
                                    $appointments->map(
                                        fn($u) => [
                                            'id' => $u->id,
                                            'name' => $u->first_name . ' ' . $u->last_name,
                                            'image' => $u->image,
                                        ],
                                    ),
                                ) }},
                                get filtered() {
                                    return this.appointments.filter(a =>
                                        a.name.toLowerCase().includes(this.search.toLowerCase())
                                    );
                                }
                            }"
                                class="space-y-2 p-2 overflow-y-auto md:h-[calc(100vh-204px)] h-[calc(100vh-130px)]">
                                <!-- Search bar -->
                                <div class="relative mt-4">
                                    <div class="absolute left-3 bottom-1/2 translate-y-1/2 flex">
                                        <ion-icon name="search" class="text-xl text-gray-500"></ion-icon>
                                    </div>
                                    <input type="text" x-model="search" placeholder="Search Users"
                                        class="w-full !pl-10 !py-2 !rounded-lg border border-gray-300 focus:outline-none focus:ring focus:border-blue-400">
                                </div>

                                <!-- Filtered friends -->
                                <template x-for="user in filtered" :key="user.id">
                                    <a :href="`/counselor/messages/${user.id}`"
                                        class="flex items-center gap-4 p-2 hover:bg-gray-100 rounded">

                                        <img :src="user.image ?
                                            `{{ asset('storage') }}/${user.image}` :
                                            `{{ asset('images/avatars/avatar-1.jpg') }}`"
                                            class="w-12 h-12 rounded-full object-cover">

                                        <div class="font-semibold text-sm" x-text="user.name"></div>
                                    </a>
                                </template>

                                <div x-show="filtered.length === 0" class="text-gray-500 text-sm mt-2">
                                    No accepted appointments.
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- overly -->
                    <div id="side-chat"
                        class="bg-slate-100/40 backdrop-blur w-full h-full dark:bg-slate-800/40 z-40 fixed inset-0 max-md:-translate-x-full md:hidden"
                        uk-toggle="target: #side-chat ; cls: max-md:-translate-x-full">
                    </div>
                </div>

                <!-- message center -->
                <div class="flex-1">
                    <!-- chat heading -->
                    <div
                        class="flex items-center justify-between gap-2 w- px-6 py-3.5 z-10 border-b dark:border-slate-700 uk-animation-slide-top-medium">

                        @if ($receiver)
                            <div class="flex items-center sm:gap-4 gap-2">
                                <!-- toggle for mobile -->
                                <button type="button" class="md:hidden"
                                    uk-toggle="target: #side-chat ; cls: max-md:-translate-x-full">
                                    <ion-icon name="chevron-back-outline" class="text-2xl -ml-4"></ion-icon>
                                </button>

                                {{-- <div class="relative cursor-pointer max-md:hidden"
                                    uk-toggle="target: .rightt ; cls: hidden"> --}}
                                <div class="relative max-md:hidden">
                                    <img src="{{ $receiver->image ? asset('storage/' . $receiver->image) : asset('images/avatars/avatar-1.jpg') }}"
                                        alt="avatar" class="w-8 h-8 rounded-full shadow">
                                    {{-- <div class="w-2 h-2 bg-teal-500 rounded-full absolute right-0 bottom-0 m-px"></div> --}}
                                </div>

                                {{-- <div class="cursor-pointer" uk-toggle="target: .rightt ; cls: hidden"> --}}
                                <div>
                                    <div class="text-base font-bold">
                                        {{ $receiver->first_name }} {{ $receiver->last_name }}
                                    </div>
                                    <div class="text-xs text-green-500 font-semibold">
                                        {{-- Online --}}
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                {{-- <button type="button" class="button__ico">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-6 h-6">
                                    <path fill-rule="evenodd"
                                        d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button> --}}

                                {{-- <a href="https://9c22e6016bb7946003bc.vercel.app/create" target="_blank">
                                    <button type="button" class="hover:bg-slate-100 p-1.5 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round"
                                                d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z" />
                                        </svg>
                                    </button>
                                </a> --}}

                                @php
                                    $senderId = auth()->id();
                                    $receiverId = $receiver->id;
                                    $roomName =
                                        config('services.jitsi.app_id') .
                                        '/AffirmSpaceCall_' .
                                        min(auth()->id(), $receiver->id) .
                                        '_' .
                                        max(auth()->id(), $receiver->id);
                                    $callId = 'call_' . $senderId . '_' . $receiverId . '_' . time();
                                    $jwt = \App\Services\JitsiService::generateToken($roomName, auth()->user());
                                @endphp

                                @if ($receiver)
                                    @php
                                        $isHidden = $hiddenUsers->contains($receiver->id);
                                    @endphp


                                    @if ($isHidden)
                                        {{-- <div class="p-4 bg-red-100 text-red-800 rounded">
                                        </div> --}}
                                    @else
                                        <button id="startCall" style="padding:10px 20px; font-size:16px;">
                                            Call {{ $receiver->first_name }}
                                        </button>
                                    @endif
                                @endif

                                @include('user.chat.calling')

                            </div>
                        @else
                            <div class="text-sm text-gray-500 px-4">Select a user to start chatting</div>
                        @endif
                    </div>

                    <!-- chats bubble -->
                    {{-- its a chatting feature all js in this div about firebase --}}

                    <div class="w-full p-5 py-10 overflow-y-auto md:h-[calc(100vh-204px)] h-[calc(100vh-195px)]">
                        @if ($receiver)
                            <div class="py-10 text-center text-sm lg:pt-8">
                                <img src="{{ $receiver->image ? asset('storage/' . $receiver->image) : asset('images/avatars/avatar-1.jpg') }}"
                                    class="w-24 h-24 rounded-full mx-auto mb-3" alt="">
                                <div class="mt-8">
                                    <div class="md:text-xl text-base font-medium text-black dark:text-white">
                                        {{ $receiver->first_name }} {{ $receiver->last_name }}
                                    </div>
                                </div>
                                <div class="mt-3.5">
                                    <a href="{{ route('counselor.user.profile', ['id' => $receiver->id]) }}"
                                        class="inline-block rounded-lg px-4 py-1.5 text-sm font-semibold bg-secondery">
                                        View profile
                                    </a>
                                </div>
                            </div>
                            <div id="chat-messages" class="text-sm font-medium space-y-6">
                            </div>

                            <script type="module">
                                import {
                                    initializeApp
                                } from "https://www.gstatic.com/firebasejs/10.3.1/firebase-app.js";
                                import {
                                    getFirestore,
                                    collection,
                                    doc,
                                    addDoc,
                                    orderBy,
                                    query,
                                    onSnapshot,
                                    serverTimestamp
                                } from "https://www.gstatic.com/firebasejs/10.3.1/firebase-firestore.js";

                                const firebaseConfig = {
                                    apiKey: "AIzaSyDMQtL-8YAkyAWqFSxNaiqHphj-08TKs-0",
                                    authDomain: "chat-ca22a.firebaseapp.com",
                                    projectId: "chat-ca22a",
                                    storageBucket: "chat-ca22a.firebasestorage.app",
                                    messagingSenderId: "766199956984",
                                    appId: "1:766199956984:web:7b7fe890cdb6f2a937420d",
                                    measurementId: "G-LBGPM7H9PL"
                                };

                                const app = initializeApp(firebaseConfig);
                                const db = getFirestore(app);

                                const senderId = {{ Auth::id() }};
                                const receiverId = {{ $receiver->id }};
                                const chatRoom = senderId < receiverId ?
                                    `${senderId}_${receiverId}` :
                                    `${receiverId}_${senderId}`;

                                const messagesQuery = query(
                                    collection(db, "chats", chatRoom, "messages"),
                                    orderBy("timestamp")
                                );

                                onSnapshot(messagesQuery, (snapshot) => {
                                    snapshot.docChanges().forEach(change => {
                                        if (change.type === "added") {
                                            const msg = change.doc.data();
                                            const currentUserId = {{ Auth::id() }};
                                            const isSender = msg.sender_id == currentUserId;
                                            const html = isSender ?
                                                `<div class="flex gap-2 flex-row-reverse items-end">
                        <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('images/avatars/avatar-1.jpg') }}"
                            alt="" class="w-5 h-5 rounded-full shadow">
                        <div class="px-4 py-2 rounded-[20px] max-w-sm bg-gradient-to-tr from-sky-500 to-blue-500 text-white shadow">
                            ${msg.message}
                        </div>
                    </div>` :
                                                `<div class="flex gap-3">
                        <img src="{{ $receiver->image ? asset('storage/' . $receiver->image) : asset('images/avatars/avatar-1.jpg') }}"
                            alt="" class="w-9 h-9 rounded-full shadow">
                        <div class="px-4 py-2 rounded-[20px] max-w-sm bg-secondery">
                            ${msg.message}
                        </div>
                    </div>`;
                                            document.getElementById('chat-messages').innerHTML += html;
                                        }
                                    });
                                });

                                document.getElementById('sendButton').addEventListener('click', async () => {
                                    const input = document.getElementById('messageInput');
                                    const text = input.value.trim();
                                    if (text === '') return;

                                    await addDoc(collection(db, "chats", chatRoom, "messages"), {
                                        sender_id: senderId,
                                        receiver_id: receiverId,
                                        message: text,
                                        timestamp: serverTimestamp()
                                    });
                                    input.value = '';
                                });
                            </script>
                        @endif
                    </div>

                    @if ($receiver)
                        @if ($isHidden)
                            <div class="p-4 bg-red-100 text-red-800 rounded" style="text-align: center;">
                                You cannot interact with {{ $receiver->first_name }} {{ $receiver->last_name }}.
                            </div>
                        @else
                            <div class="flex items-center m-4 gap-2">
                                <input type="text" id="messageInput"
                                    class="w-full p-2 border rounded dark:bg-gray-900 dark:border-gray-600"
                                    placeholder="Type a message..." />
                                <button id="sendButton" class="bg-blue-500 text-white px-4 py-2 rounded">Send</button>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
    </main>
    </div>
@endsection

@section('css')
    <style>
        .friend-status-icon {
            position: absolute;
            left: 50%;
            bottom: -10px;
            /* adjust to move up/down */
            transform: translateX(-50%);
            font-size: 16px;
            color: #2563eb;
            /* Tailwind's blue-600 */
        }
    </style>
@endsection
