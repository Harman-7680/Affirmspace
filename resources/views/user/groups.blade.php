@extends('layouts.app1')

@section('content')
    <main class="max-w-4xl mx-auto mt-[--m-top] p-4">

        <div class="page-heading mb-6 text-center sm:text-left">
            <h1 class="page-title text-2xl font-semibold text-gray-800 dark:text-white">Join a Room</h1>
            <p class="text-sm text-gray-500 mt-1">Explore available rooms and join the ones you like.</p>
        </div>

        <div class="mb-6 px-2">
            @if ($rooms && !$rooms->isEmpty())
                <input type="text" placeholder="Search"
                    class="w-full p-3 rounded-full border border-gray-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm"
                    id="roomSearch">
            @endif
        </div>

        <div class="px-2">
            @if ($rooms && !$rooms->isEmpty())
                <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Available Rooms</h2>
            @else
                <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">No Rooms Available</h2>
            @endif

            <div class="space-y-4" id="roomsContainer">
                @foreach ($rooms as $room)
                    <div class="room-card bg-white rounded-lg shadow-sm p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between"
                        data-title="{{ $room->room_name }}">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('images/new_logo.png') }}" alt="{{ $room->room_name }}"
                                class="w-16 h-16 rounded-full object-cover">
                            <div>
                                <a href="javascript:void(0)" class="block text-base font-semibold text-gray-800 joinRoomBtn"
                                    data-room="{{ $room->room_code }}" data-room-id="{{ $room->id }}">
                                    {{ $room->room_name }}
                                </a>
                                <div class="text-sm text-gray-500">
                                    {{ $room->users_count }} / {{ $room->max_users }} Users
                                </div>
                                <div class="text-xs text-gray-500 mt-1">{{ $room->description }}</div>
                            </div>
                        </div>
                        <div class="mt-4 sm:mt-0">
                            <button class="gradient-btn text-white px-6 py-2 rounded-full text-sm joinRoomBtn"
                                data-room="{{ $room->room_code }}" data-room-id="{{ $room->id }}">
                                <span class="inline-block text-base leading-none">+</span>
                                <span>Join</span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>

    <!-- Jitsi Modal -->
    <div id="jitsiModal">

        <div id="jitsiWrapper">

            <button id="closeJitsi">
                ✕
            </button>

            <div id="jitsiContainer"></div>

        </div>

    </div>

    </div>

    {{-- @include('layouts.chatbot') --}}
@endsection

@section('css')
    <style>
        .gradient-btn {
            background: linear-gradient(90deg, #ff512f, #dd2476);
        }

        #jitsiModal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .85);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 999999;
        }

        #jitsiModal.active {
            display: flex;
        }

        #jitsiWrapper {
            width: 95vw;
            height: 94vh;
            background: #000;
            border-radius: 20px;
            overflow: hidden;
            position: relative;
        }

        #jitsiContainer {
            width: 100%;
            height: 100%;
        }

        #closeJitsi {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 999999;
            background: rgba(255, 255, 255, .15);
            backdrop-filter: blur(10px);
            color: #fff;
            border: none;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
@endsection

@section('script')
    <script src='https://8x8.vc/vpaas-magic-cookie-3b7aa2c587234976b65a4c61a71fca76/external_api.js' async></script>

    <script>
        let jitsiApi = null;
        let roomTimer = null;

        document.querySelectorAll('.joinRoomBtn').forEach(btn => {

            btn.addEventListener('click', async function() {

                const roomId = this.dataset.roomId;

                const response = await fetch('/jitsi/join/' + roomId, {

                    method: 'POST',

                    headers: {

                        'X-CSRF-TOKEN': '{{ csrf_token() }}',

                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                const expiresAt = data.expires_at;

                if (data.error) {

                    alert(data.error);

                    return;
                }

                // OPEN MODAL
                document.getElementById('jitsiModal')
                    .classList.add('active');

                // remove old instance
                if (jitsiApi) {

                    jitsiApi.dispose();

                    jitsiApi = null;
                }

                // EXACT SAME AS 1-to-1
                jitsiApi = new JitsiMeetExternalAPI(
                    "8x8.vc", {
                        roomName: data.room_name,

                        parentNode: document.getElementById('jitsiContainer'),

                        jwt: data.jwt,

                        width: "100%",
                        height: "100%",

                        userInfo: {},

                        configOverwrite: {

                            prejoinPageEnabled: false,

                            startWithAudioMuted: false,

                            startWithVideoMuted: false,

                            disableDeepLinking: true
                        }
                    });

                // AUTO END ROOM TIMER
                roomTimer = setInterval(() => {

                    const now = Math.floor(Date.now() / 1000);

                    if (now >= expiresAt) {

                        alert('Room time expired');

                        // close modal
                        document.getElementById('jitsiModal')
                            .classList.remove('active');

                        // destroy meeting
                        if (jitsiApi) {

                            jitsiApi.dispose();

                            jitsiApi = null;
                        }

                        clearInterval(roomTimer);
                    }

                }, 1000);

            });

        });

        // CLOSE
        document.getElementById('closeJitsi').onclick = function() {

            document.getElementById('jitsiModal')
                .classList.remove('active');

            if (jitsiApi) {

                jitsiApi.dispose();

                jitsiApi = null;
            }

            if (roomTimer) {

                clearInterval(roomTimer);

                roomTimer = null;
            }
        };

        // ROOM SEARCH
        const roomSearch = document.getElementById('roomSearch');

        if (roomSearch) {

            roomSearch.addEventListener('keyup', function() {

                const searchValue = this.value.toLowerCase();

                document.querySelectorAll('.room-card').forEach(card => {

                    const roomName = card.dataset.title.toLowerCase();

                    if (roomName.includes(searchValue)) {

                        card.style.display = '';

                    } else {

                        card.style.display = 'none';
                    }
                });
            });
        }
    </script>
@endsection
