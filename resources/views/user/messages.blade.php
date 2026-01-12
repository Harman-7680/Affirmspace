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

                                <h2 class="text-2xl font-bold text-black ml-1 dark:text-white"> Friend Chats </h1>
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

                            <div x-data="{
                                search: '',
                                filterType: 'all',
                            
                                myFriendsList: {{ Js::from(
                                    $friends->map(function ($friend) {
                                        return [
                                            'id' => $friend->id,
                                            'name' => $friend->name,
                                            'image' => $friend->image,
                                            'UserStatus' => $friend->UserStatus,
                                            'chat_type' => $friend->chat_type,
                                        ];
                                    }),
                                ) }},
                            
                                // filtered list (used for display)
                                get filteredFriends() {
                                    return this.myFriendsList.filter(friend => {
                                        const matchesSearch = friend.name.toLowerCase().includes(this.search.toLowerCase());
                                        const matchesFilter = this.filterType === 'all' || friend.chat_type === this.filterType;
                                        return matchesSearch && matchesFilter;
                                    });
                                },
                            
                                //  COUNTS (respect search)
                                get allCount() {
                                    return this.myFriendsList.filter(f =>
                                        f.name.toLowerCase().includes(this.search.toLowerCase())
                                    ).length;
                                },
                            
                                get friendCount() {
                                    return this.myFriendsList.filter(f =>
                                        f.chat_type === 'friend' &&
                                        f.name.toLowerCase().includes(this.search.toLowerCase())
                                    ).length;
                                },
                            
                                get counselorCount() {
                                    return this.myFriendsList.filter(f =>
                                        f.chat_type === 'counselor' &&
                                        f.name.toLowerCase().includes(this.search.toLowerCase())
                                    ).length;
                                },
                            
                                get datingCount() {
                                    return this.myFriendsList.filter(f =>
                                        f.chat_type === 'dating' &&
                                        f.name.toLowerCase().includes(this.search.toLowerCase())
                                    ).length;
                                }
                            }"
                                class="space-y-2 p-2 overflow-y-auto md:h-[calc(100vh-204px)] h-[calc(100vh-130px)]">


                                <div class="flex gap-2 mb-4 flex-wrap">

                                    <!-- ALL -->
                                    <button @click="filterType='all'"
                                        :class="filterType === 'all' ? 'bg-blue-500 text-white' :
                                            'bg-gray-200 text-gray-700'"
                                        class="px-2 py-0.5 text-xs rounded-md flex items-center gap-1">
                                        All
                                        <span class="text-[10px] bg-white/80 text-black px-1.5 rounded-full leading-none"
                                            x-text="allCount"></span>
                                    </button>

                                    <!-- FRIEND -->
                                    <button @click="filterType='friend'"
                                        :class="filterType === 'friend' ? 'bg-green-500 text-white' :
                                            'bg-gray-200 text-gray-700'"
                                        class="px-2 py-0.5 text-xs rounded-md flex items-center gap-1">
                                        Friends
                                        <span class="text-[10px] bg-white/80 text-black px-1.5 rounded-full leading-none"
                                            x-text="friendCount"></span>
                                    </button>

                                    <!-- COUNSELOR -->
                                    <button @click="filterType='counselor'"
                                        :class="filterType === 'counselor' ? 'bg-blue-500 text-white' :
                                            'bg-gray-200 text-gray-700'"
                                        class="px-2 py-0.5 text-xs rounded-md flex items-center gap-1">
                                        Doctors
                                        <span class="text-[10px] bg-white/80 text-black px-1.5 rounded-full leading-none"
                                            x-text="counselorCount"></span>
                                    </button>

                                    <!-- DATING -->
                                    <button @click="filterType='dating'"
                                        :class="filterType === 'dating' ? 'bg-yellow-500 text-white' :
                                            'bg-gray-200 text-gray-700'"
                                        class="px-2 py-0.5 text-xs rounded-md flex items-center gap-1">
                                        Date
                                        <span class="text-[10px] bg-white/80 text-black px-1.5 rounded-full leading-none"
                                            x-text="datingCount"></span>
                                    </button>
                                </div>

                                <!-- Search bar -->
                                <div class="relative mb-4">
                                    <div class="absolute left-3 bottom-1/2 translate-y-1/2 flex">
                                        <ion-icon name="search" class="text-xl text-gray-500"></ion-icon>
                                    </div>
                                    <input type="text" x-model="search" placeholder="Search users..."
                                        class="w-full !pl-10 !py-2 !rounded-lg border border-gray-300 focus:outline-none focus:ring focus:border-blue-400">
                                </div>

                                <!-- Filtered users -->
                                <template x-for="friend in filteredFriends" :key="friend.id + '-' + friend.chat_type">
                                    <a :href="`/messages/${friend.id}?type=${friend.chat_type}`"
                                        class="flex items-center gap-4 p-2 hover:bg-gray-100 rounded">

                                        <div class="w-14 h-14 relative">
                                            <img :src="(!friend.image || friend.image === '0') ?
                                            `{{ asset('images/avatars/avatar-1.jpg') }}` :
                                            `{{ asset('storage') }}/${friend.image}`"
                                                alt="" class="rounded-full w-full h-full object-cover">

                                            <div x-show="friend.UserStatus == 1"
                                                class="friend-status-icon text-blue-600 text-sm">
                                                🎀
                                            </div>
                                        </div>

                                        <div>
                                            <div class="font-semibold text-sm" x-text="friend.name"></div>

                                            <span x-show="friend.chat_type === 'friend'" class="text-xs text-green-600">
                                                👥 Friend
                                            </span>

                                            <span x-show="friend.chat_type === 'counselor'" class="text-xs text-blue-600">
                                                🎓 Counselor
                                            </span>

                                            <span x-show="friend.chat_type === 'dating'" class="text-xs text-pink-600">
                                                💖 Dating
                                            </span>
                                        </div>
                                    </a>
                                </template>

                                <div x-show="filteredFriends.length === 0" class="text-gray-500 text-sm mt-2">
                                    No matching users.
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
                                    <img src="{{ $receiver->chat_image ? asset('storage/' . $receiver->chat_image) : asset('images/avatars/avatar-1.jpg') }}"
                                        class="w-8 h-8 rounded-full shadow" alt="avatar">
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
                                        $isHidden = in_array($receiver->id, $hiddenUsers ?? []);
                                    @endphp

                                    @if ($isHidden)
                                        {{-- <div class="p-4 bg-red-100 text-red-800 rounded">
                                        </div> --}}
                                    @else
                                        @if ($receiver && $receiverChatType !== 'dating')
                                            <button id="startCall" style="padding:10px 20px; font-size:16px;">
                                                Call {{ $receiver->first_name }}
                                            </button>
                                        @endif
                                    @endif
                                @endif

                                @include('user.chat.calling')

                                {{-- <button
                                    onclick="navigator.mediaDevices.getUserMedia({ audio:true, video:true }).then(s => { console.log('Stream:', s); alert('Mic & Camera working'); })">Test
                                </button>

                                <button id="startCall" class="call">Call {{ $receiver->first_name }}</button>

                                <audio id="remoteAudio" autoplay></audio>

                                <!-- Incoming call popup -->
                                <div id="incomingCallPopup"
                                    style="position:fixed; top:200px; right:20px; width:280px; background:#fff; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.3); padding:15px; display:none; z-index:1000;">
                                    <p id="incomingText"></p>
                                    <button id="acceptCall" class="accept"
                                        style="background:#4CAF50;color:white;margin-right:5px;">Accept</button>
                                    <button id="rejectCall" class="reject"
                                        style="background:#f44336;color:white;">Reject</button>
                                </div>

                                <!-- Fullscreen video call -->
                                <div id="activeCallPopup"
                                    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:#000; z-index:1000; flex-direction:column; align-items:center; justify-content:center; text-align:center;">
                                    <div id="videoContainer" style="display:flex; width:80%; justify-content:space-around;">
                                        <video id="localVideo" autoplay muted playsinline
                                            style="width:45%; background:#333;"></video>
                                        <video id="remoteVideo" autoplay playsinline
                                            style="width:45%; background:#333;"></video>
                                    </div>
                                    <div id="callControls" style="margin-top:20px;">
                                        <button id="muteBtn">🎤</button>
                                        <button id="cameraBtn">📷</button>
                                        <button id="endCallBtn">⛔</button>
                                    </div>
                                </div>

                                <!-- Ringtone audio -->
                                <audio id="ringtone" loop>
                                    <source src="https://actions.google.com/sounds/v1/alarms/phone_alerts_and_rings.ogg"
                                        type="audio/ogg">
                                </audio>

                                <script type="module">
                                    import {
                                        initializeApp
                                    } from "https://www.gstatic.com/firebasejs/10.13.0/firebase-app.js";
                                    import {
                                        getDatabase,
                                        ref,
                                        set,
                                        onValue,
                                        push,
                                        remove
                                    } from "https://www.gstatic.com/firebasejs/10.13.0/firebase-database.js";

                                    // Firebase config
                                    const firebaseConfig = {
                                        apiKey: "AIzaSyA1ViQLOdWW9q7lEP45HuUdEnchTvY79m4",
                                        authDomain: "videocall-87dab.firebaseapp.com",
                                        databaseURL: "https://videocall-87dab-default-rtdb.firebaseio.com",
                                        projectId: "videocall-87dab",
                                        storageBucket: "videocall-87dab.firebasestorage.app",
                                        messagingSenderId: "733035921265",
                                        appId: "1:733035921265:web:0f2a5bd302701601b780d0",
                                        measurementId: "G-K9CSQY900B"
                                    };
                                    const app = initializeApp(firebaseConfig);
                                    const db = getDatabase(app);

                                    const auth = {
                                        uid: "{{ auth()->id() }}"
                                    };
                                    const receiverId = "{{ $receiver->id }}";

                                    let pc, localStream, currentCallId = null,
                                        audioEnabled = true,
                                        videoEnabled = true;

                                    // DOM elements
                                    const incomingPopup = document.getElementById('incomingCallPopup');
                                    const incomingText = document.getElementById('incomingText');
                                    const activePopup = document.getElementById('activeCallPopup');
                                    const localVideo = document.getElementById('localVideo');
                                    const remoteVideo = document.getElementById('remoteVideo');
                                    const ringtone = document.getElementById('ringtone');

                                    // --- Helpers ---
                                    function showIncoming(from) {
                                        incomingText.innerText = "Incoming call from User " + from;
                                        incomingPopup.style.display = 'block';
                                        ringtone.play();
                                    }

                                    function hideIncoming() {
                                        incomingPopup.style.display = 'none';
                                        ringtone.pause();
                                        ringtone.currentTime = 0;
                                    }

                                    function showActive() {
                                        activePopup.style.display = 'flex';
                                    }

                                    function hideActive() {
                                        activePopup.style.display = 'none';
                                    }

                                    // --- PeerConnection ---
                                    function createPeerConnection() {
                                        pc = new RTCPeerConnection({
                                            iceServers: [{
                                                urls: "stun:stun.l.google.com:19302"
                                            }]
                                        });
                                        if (localStream) localStream.getTracks().forEach(track => pc.addTrack(track, localStream));
                                        pc.ontrack = e => {
                                            remoteVideo.srcObject = e.streams[0]; // For video
                                            const remoteAudio = document.getElementById('remoteAudio');
                                            if (remoteAudio.srcObject !== e.streams[0]) {
                                                remoteAudio.srcObject = e.streams[0];
                                                remoteAudio.play().catch(err => {
                                                    console.log("Autoplay blocked, click to unmute", err);
                                                });
                                            }
                                        };
                                        pc.onicecandidate = e => {
                                            if (e.candidate && currentCallId) push(ref(db, `calls/${currentCallId}/candidates`), e.candidate
                                                .toJSON());
                                        };
                                        return pc;
                                    }

                                    // --- Start Call ---
                                    async function startCall(target) {
                                        try {
                                            localStream = await navigator.mediaDevices.getUserMedia({
                                                audio: true,
                                                video: true
                                            });
                                            localVideo.srcObject = localStream;
                                        } catch (e) {
                                            localStream = await navigator.mediaDevices.getUserMedia({
                                                audio: true
                                            });
                                            localVideo.srcObject = null;
                                        }

                                        pc = createPeerConnection();
                                        showActive();

                                        currentCallId = push(ref(db, 'calls')).key;
                                        const callRef = ref(db, 'calls/' + currentCallId);
                                        await set(callRef, {
                                            from: auth.uid,
                                            to: target,
                                            status: 'calling'
                                        });

                                        // Listen for acceptance
                                        onValue(ref(db, `calls/${currentCallId}/status`), async snap => {
                                            if (snap.val() === 'accepted') {
                                                const offer = await pc.createOffer();
                                                await pc.setLocalDescription(offer);
                                                await set(ref(db, `calls/${currentCallId}/offer`), offer.toJSON());
                                            }
                                            if (snap.val() === 'ended') {
                                                endCallUI();
                                            }
                                        });

                                        onValue(ref(db, `calls/${currentCallId}/answer`), s => {
                                            if (s.val()) pc.setRemoteDescription(s.val());
                                        });
                                        onValue(ref(db, `calls/${currentCallId}/candidates`), s => {
                                            if (s.val()) Object.values(s.val()).forEach(c => pc.addIceCandidate(c));
                                        });
                                    }

                                    // --- Listen Incoming Calls ---
                                    function listenIncomingCall() {
                                        const callsRef = ref(db, 'calls');
                                        onValue(callsRef, snap => {
                                            const calls = snap.val();
                                            if (!calls) return;
                                            Object.entries(calls).forEach(([id, call]) => {
                                                if (call.to === auth.uid && call.status === 'calling' && currentCallId === null) {
                                                    currentCallId = id;
                                                    showIncoming(call.from);

                                                    document.getElementById('acceptCall').onclick = async () => {
                                                        hideIncoming();
                                                        try {
                                                            localStream = await navigator.mediaDevices.getUserMedia({
                                                                audio: true,
                                                                video: true
                                                            });
                                                            localVideo.srcObject = localStream;
                                                        } catch (e) {
                                                            localStream = await navigator.mediaDevices.getUserMedia({
                                                                audio: true
                                                            });
                                                            localVideo.srcObject = null;
                                                        }
                                                        pc = createPeerConnection();
                                                        await set(ref(db, `calls/${id}/status`), 'accepted');

                                                        onValue(ref(db, `calls/${id}/offer`), async s => {
                                                            if (s.val()) {
                                                                await pc.setRemoteDescription(s.val());
                                                                const answer = await pc.createAnswer();
                                                                await pc.setLocalDescription(answer);
                                                                await set(ref(db, `calls/${id}/answer`), answer
                                                                    .toJSON());
                                                            }
                                                        });

                                                        onValue(ref(db, `calls/${id}/candidates`), s => {
                                                            if (s.val()) Object.values(s.val()).forEach(c => pc
                                                                .addIceCandidate(c));
                                                        });
                                                        showActive();
                                                    };

                                                    document.getElementById('rejectCall').onclick = () => {
                                                        hideIncoming();
                                                        remove(ref(db, `calls/${id}`));
                                                        currentCallId = null;
                                                    };
                                                }

                                                // End call by other user
                                                if (call && call.status === 'ended' && currentCallId === id) {
                                                    endCallUI();
                                                }
                                            });
                                        });
                                    }

                                    // --- End Call ---
                                    function endCallUI() {
                                        if (localStream) localStream.getTracks().forEach(t => t.stop());
                                        if (pc) pc.close();
                                        hideActive();
                                        hideIncoming();
                                        currentCallId = null;
                                    }

                                    document.getElementById('endCallBtn').onclick = async () => {
                                        if (currentCallId) await set(ref(db, `calls/${currentCallId}/status`), 'ended');
                                        endCallUI();
                                    };

                                    // Mute mic toggle
                                    document.getElementById('muteBtn').onclick = () => {
                                        if (localStream) {
                                            localStream.getAudioTracks().forEach(t => t.enabled = !t.enabled);
                                            audioEnabled = !audioEnabled;
                                            document.getElementById('muteBtn').textContent = audioEnabled ? "🎤" : "🔇";
                                        }
                                    };

                                    // Camera toggle
                                    document.getElementById('cameraBtn').onclick = () => {
                                        if (localStream) {
                                            localStream.getVideoTracks().forEach(t => t.enabled = !t.enabled);
                                            videoEnabled = !videoEnabled;
                                            document.getElementById('cameraBtn').textContent = videoEnabled ? "📷" : "❌";
                                            localVideo.style.display = videoEnabled ? "block" : "none";
                                        }
                                    };

                                    // Start Call button
                                    document.getElementById('startCall').onclick = async () => {
                                        await startCall(receiverId);
                                    };

                                    // Init
                                    listenIncomingCall();
                                </script> --}}

                                </body>

                                {{-- <style>
                                    video {
                                        width: 45%;
                                        border: 1px solid #ccc;
                                        margin: 5px;
                                    }
                                </style>

                                <video id="localVideo" autoplay muted></video>
                                <video id="remoteVideo" autoplay></video>
                                <br>
                                <button id="startCall">Start Call</button>

                                <script src="https://js.pusher.com/8.2/pusher.min.js"></script>
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.16.1/echo.iife.js"></script>

                                <script>
                                    (async function() {
                                        const userId = {{ auth()->id() }};
                                        const otherUserId = {{ $receiver->id }};
                                        let pc = null;
                                        let localStream = null;
                                        let initialized = false;

                                        // ----------------- Pusher + Echo Setup -----------------
                                        Pusher.logToConsole = true;

                                        window.Echo = new Echo({
                                            broadcaster: 'pusher',
                                            key: '{{ env('PUSHER_APP_KEY') }}',
                                            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                                            forceTLS: true
                                        });

                                        // ----------------- Listen for incoming signals -----------------
                                        Echo.channel(`video-call.${userId}`)
                                            .listen('VideoCallEvent', async (e) => {
                                                const data = e.data;

                                                if (!initialized) await initPeerConnection();

                                                switch (data.type) {
                                                    case 'offer':
                                                        await pc.setRemoteDescription(new RTCSessionDescription(data.sdp));
                                                        const answer = await pc.createAnswer();
                                                        await pc.setLocalDescription(answer);
                                                        sendSignal({
                                                            type: 'answer',
                                                            sdp: answer
                                                        });
                                                        break;
                                                    case 'answer':
                                                        await pc.setRemoteDescription(new RTCSessionDescription(data.sdp));
                                                        break;
                                                    case 'ice-candidate':
                                                        try {
                                                            await pc.addIceCandidate(new RTCIceCandidate(data.candidate));
                                                        } catch (err) {
                                                            console.error('ICE candidate error:', err);
                                                        }
                                                        break;
                                                }
                                            });

                                        // ----------------- Start Call Button -----------------
                                        document.getElementById('startCall').onclick = async () => {
                                            if (!initialized) await initPeerConnection();
                                            const offer = await pc.createOffer();
                                            await pc.setLocalDescription(offer);
                                            sendSignal({
                                                type: 'offer',
                                                sdp: offer
                                            });
                                        };

                                        // ----------------- Initialize Peer Connection -----------------
                                        async function initPeerConnection() {
                                            try {
                                                localStream = await navigator.mediaDevices.getUserMedia({
                                                    video: true,
                                                    audio: true
                                                });
                                                document.getElementById('localVideo').srcObject = localStream;

                                                pc = new RTCPeerConnection();

                                                // Add local tracks
                                                localStream.getTracks().forEach(track => pc.addTrack(track, localStream));

                                                // Handle remote tracks
                                                pc.ontrack = (event) => {
                                                    document.getElementById('remoteVideo').srcObject = event.streams[0];
                                                };

                                                // Handle ICE candidates
                                                pc.onicecandidate = (event) => {
                                                    if (event.candidate) sendSignal({
                                                        type: 'ice-candidate',
                                                        candidate: event.candidate
                                                    });
                                                };

                                                initialized = true;
                                            } catch (err) {
                                                console.error('Error accessing camera/mic:', err);
                                                alert('Cannot access camera/microphone. Please allow permissions.');
                                            }
                                        }

                                        // ----------------- Send Signal to Backend -----------------
                                        function sendSignal(data) {
                                            fetch('/video-call/signal', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                                },
                                                body: JSON.stringify({
                                                    data,
                                                    receiver_id: otherUserId
                                                })
                                            });
                                        }
                                    })();
                                </script> --}}

                                {{-- <button type="button" class="hover:bg-slate-100 p-1.5 rounded-full"
                                uk-toggle="target: .rightt ; cls: hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                            </button> --}}
                            </div>
                        @else
                            <div class="text-sm text-gray-500 px-4">Select a user to start chatting</div>
                        @endif
                    </div>

                    <!-- chats bubble -->
                    {{-- its a chatting feature all js in this div about firebase --}}

                    <div class="w-full p-5 py-10 overflow-y-auto md:h-[calc(100vh-204px)] h-[calc(100vh-195px)]">
                        @if ($receiver)
                            {{-- FRIEND CHAT (Firebase) --}}
                            @if ($receiverChatType === 'friend')
                                @include('user.chat.firebase-friend')
                            @endif

                            {{-- COUNSELOR CHAT (Firebase + Call) --}}
                            @if ($receiverChatType === 'counselor')
                                @include('user.chat.firebase-counselor')
                            @endif

                            {{-- DATING CHAT (DATABASE ONLY) --}}
                            @if ($receiverChatType === 'dating')
                                @include('user.chat.dating-db')
                            @endif
                        @endif
                    </div>

                    @if ($receiver)
                        @if ($isHidden)
                            <div class="p-4 bg-red-100 text-red-800 rounded" style="text-align: center;">
                                You cannot interact with {{ $receiver->first_name }} {{ $receiver->last_name }}.
                            </div>
                        @else
                            @if ($receiver && $receiverChatType !== 'dating')
                                <div class="flex items-center m-4 gap-2">
                                    <input type="text" id="messageInput"
                                        class="w-full p-2 border rounded dark:bg-gray-900 dark:border-gray-600"
                                        placeholder="Type a message..." />
                                    <button id="sendButton" class="bg-blue-500 text-white px-4 py-2 rounded">Send</button>
                                </div>
                            @endif

                            @if ($receiver && $receiverChatType === 'dating')
                                <div class="flex items-center m-4 gap-2">
                                    <input type="text" id="datingMessage" id="messageInput"
                                        class="w-full p-2 border rounded dark:bg-gray-900 dark:border-gray-600"
                                        placeholder="Type a message..." />
                                    <button onclick="sendDatingMessage()" id="sendButton"
                                        class="bg-blue-500 text-white px-4 py-2 rounded">Send</button>
                                </div>
                            @endif
                        @endif
                    @endif

                    <!-- sending message area -->
                    {{-- <div class="flex items-center md:gap-4 gap-2 md:p-3 p-2 overflow-hidden">

                        <div id="message__wrap" class="flex items-center gap-2 h-full dark:text-white -mt-1.5">

                            <button type="button" class="shrink-0">
                                <ion-icon class="text-3xl flex" name="add-circle-outline"></ion-icon>
                            </button>
                            <div class="dropbar pt-36 h-60 bg-gradient-to-t via-white from-white via-30% from-30% dark:from-slate-900 dark:via-900"
                                uk-drop="stretch: x; target: #message__wrap ;animation:  slide-bottom ;animate-out: true; pos: top-left; offset:10 ; mode: click ; duration: 200">

                                <div class="sm:w-full p-3 flex justify-center gap-5"
                                    uk-scrollspy="target: > button; cls: uk-animation-slide-bottom-small; delay: 100;repeat:true">

                                    <button type="button"
                                        class="bg-sky-50 text-sky-600 border border-sky-100 shadow-sm p-2.5 rounded-full shrink-0 duration-100 hover:scale-[1.15] dark:bg-dark3 dark:border-0">
                                        <ion-icon class="text-3xl flex" name="image"></ion-icon>
                                    </button>
                                    <button type="button"
                                        class="bg-green-50 text-green-600 border border-green-100 shadow-sm p-2.5 rounded-full shrink-0 duration-100 hover:scale-[1.15] dark:bg-dark3 dark:border-0">
                                        <ion-icon class="text-3xl flex" name="images"></ion-icon>
                                    </button>
                                    <button type="button"
                                        class="bg-pink-50 text-pink-600 border border-pink-100 shadow-sm p-2.5 rounded-full shrink-0 duration-100 hover:scale-[1.15] dark:bg-dark3 dark:border-0">
                                        <ion-icon class="text-3xl flex" name="document-text"></ion-icon>
                                    </button>
                                    <button type="button"
                                        class="bg-orange-50 text-orange-600 border border-orange-100 shadow-sm p-2.5 rounded-full shrink-0 duration-100 hover:scale-[1.15] dark:bg-dark3 dark:border-0">
                                        <ion-icon class="text-3xl flex" name="gift"></ion-icon>
                                    </button>
                                </div>
                            </div>

                            <button type="button" class="shrink-0">
                                <ion-icon class="text-3xl flex" name="happy-outline"></ion-icon>
                            </button>
                            <div class="dropbar p-2"
                                uk-drop="stretch: x; target: #message__wrap ;animation: uk-animation-scale-up uk-transform-origin-bottom-left ;animate-out: true; pos: top-left ; offset:2; mode: click ; duration: 200 ">
                                <div
                                    class="sm:w-60 bg-white shadow-lg border rounded-xl  pr-0 dark:border-slate-700 dark:bg-dark3">

                                    <h4 class="text-sm font-semibold p-3 pb-0">Send Imogi</h4>

                                    <div class="grid grid-cols-5 overflow-y-auto max-h-44 p-3 text-center text-xl">

                                        <div
                                            class="hover:bg-secondery p-1.5 rounded-md hover:scale-125 cursor-pointer duration-200">
                                            😊 </div>
                                        <div
                                            class="hover:bg-secondery p-1.5 rounded-md hover:scale-125 cursor-pointer duration-200">
                                            🤩 </div>
                                        <div
                                            class="hover:bg-secondery p-1.5 rounded-md hover:scale-125 cursor-pointer duration-200">
                                            😎</div>
                                        <div
                                            class="hover:bg-secondery p-1.5 rounded-md hover:scale-125 cursor-pointer duration-200">
                                            🥳 </div>
                                        <div
                                            class="hover:bg-secondery p-1.5 rounded-md hover:scale-125 cursor-pointer duration-200">
                                            😂 </div>
                                        <div
                                            class="hover:bg-secondery p-1.5 rounded-md hover:scale-125 cursor-pointer duration-200">
                                            🥰 </div>
                                        <div
                                            class="hover:bg-secondery p-1.5 rounded-md hover:scale-125 cursor-pointer duration-200">
                                            😡 </div>
                                        <div
                                            class="hover:bg-secondery p-1.5 rounded-md hover:scale-125 cursor-pointer duration-200">
                                            😊 </div>
                                        <div
                                            class="hover:bg-secondery p-1.5 rounded-md hover:scale-125 cursor-pointer duration-200">
                                            🤩 </div>
                                        <div
                                            class="hover:bg-secondery p-1.5 rounded-md hover:scale-125 cursor-pointer duration-200">
                                            😎</div>
                                        <div
                                            class="hover:bg-secondery p-1.5 rounded-md hover:scale-125 cursor-pointer duration-200">
                                            🥳 </div>
                                        <div
                                            class="hover:bg-secondery p-1.5 rounded-md hover:scale-125 cursor-pointer duration-200">
                                            😂 </div>
                                        <div
                                            class="hover:bg-secondery p-1.5 rounded-md hover:scale-125 cursor-pointer duration-200">
                                            🥰 </div>
                                        <div
                                            class="hover:bg-secondery p-1.5 rounded-md hover:scale-125 cursor-pointer duration-200">
                                            😡 </div>
                                        <div
                                            class="hover:bg-secondery p-1.5 rounded-md hover:scale-125 cursor-pointer duration-200">
                                            🤔 </div>
                                        <div
                                            class="hover:bg-secondery p-1.5 rounded-md hover:scale-125 cursor-pointer duration-200">
                                            😊 </div>
                                        <div
                                            class="hover:bg-secondery p-1.5 rounded-md hover:scale-125 cursor-pointer duration-200">
                                            🤩 </div>
                                        <div
                                            class="hover:bg-secondery p-1.5 rounded-md hover:scale-125 cursor-pointer duration-200">
                                            😎</div>
                                        <div
                                            class="hover:bg-secondery p-1.5 rounded-md hover:scale-125 cursor-pointer duration-200">
                                            🥳 </div>
                                        <div
                                            class="hover:bg-secondery p-1.5 rounded-md hover:scale-125 cursor-pointer duration-200">
                                            😂 </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="relative flex-1">
                            <textarea placeholder="Write your message" rows="1"
                                class="w-full resize-none bg-secondery rounded-full px-4 p-2"></textarea>

                            <button type="button" class="text-white shrink-0 p-2 absolute right-0.5 top-0">
                                <ion-icon class="text-xl flex" name="send-outline"></ion-icon>
                            </button>

                        </div>

                        <button type="button" class="flex h-full dark:text-white">
                            <ion-icon class="text-3xl flex -mt-3" name="heart-outline"></ion-icon>
                        </button>
                    </div> --}}
                </div>

                <!-- user profile right info -->
                {{-- <div class="rightt w-full h-full absolute top-0 right-0 z-10 hidden transition-transform">
                    <div
                        class="w-[360px] border-l shadow-lg h-screen bg-white absolute right-0 top-0 uk-animation-slide-right-medium delay-200 z-50 dark:bg-dark2 dark:border-slate-700">

                        <div class="w-full h-1.5 bg-gradient-to-r to-purple-500 via-red-500 from-pink-500 -mt-px"></div>

                        <div class="py-10 text-center text-sm pt-20">
                            <img src="assets/images/avatars/avatar-3.jpg" class="w-24 h-24 rounded-full mx-auto mb-3"
                                alt="">
                            <div class="mt-8">
                                <div class="md:text-xl text-base font-medium text-black dark:text-white"> Monroe Parker
                                </div>
                                <div class="text-gray-500 text-sm mt-1 dark:text-white/80">@Monroepark</div>
                            </div>
                            <div class="mt-5">
                                <a href="timeline.html"
                                    class="inline-block rounded-full px-4 py-1.5 text-sm font-semibold bg-secondery">View
                                    profile</a>
                            </div>
                        </div>

                        <hr class="opacity-80 dark:border-slate-700">

                        <ul class="text-base font-medium p-3">
                            <li>
                                <div class="flex items-center gap-5 rounded-md p-3 w-full hover:bg-secondery">
                                    <ion-icon name="notifications-off-outline" class="text-2xl"></ion-icon> Mute
                                    Notification
                                    <label class="switch cursor-pointer ml-auto"> <input type="checkbox" checked><span
                                            class="switch-button !relative"></span></label>
                                </div>
                            </li>
                            <li> <button type="button"
                                    class="flex items-center gap-5 rounded-md p-3 w-full hover:bg-secondery"> <ion-icon
                                        name="flag-outline" class="text-2xl"></ion-icon> Report </button></li>
                            <li> <button type="button"
                                    class="flex items-center gap-5 rounded-md p-3 w-full hover:bg-secondery"> <ion-icon
                                        name="settings-outline" class="text-2xl"></ion-icon> Ignore messages </button>
                            </li>
                            <li> <button type="button"
                                    class="flex items-center gap-5 rounded-md p-3 w-full hover:bg-secondery"> <ion-icon
                                        name="stop-circle-outline" class="text-2xl"></ion-icon> Block </button> </li>
                            <li> <button type="button"
                                    class="flex items-center gap-5 rounded-md p-3 w-full hover:bg-red-50 text-red-500">
                                    <ion-icon name="trash-outline" class="text-2xl"></ion-icon> Delete Chat </button>
                            </li>
                        </ul>

                        <!-- close button -->
                        <button type="button" class="absolute top-0 right-0 m-4 p-2 bg-secondery rounded-full"
                            uk-toggle="target: .rightt ; cls: hidden">
                            <ion-icon name="close" class="text-2xl flex"></ion-icon>
                        </button>
                    </div>
                    <!-- overly -->
                    <div class="bg-slate-100/40 backdrop-blur absolute w-full h-full dark:bg-slate-800/40"
                        uk-toggle="target: .rightt ; cls: hidden"></div>
                </div> --}}
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
