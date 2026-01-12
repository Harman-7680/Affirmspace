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
                                    data-room="{{ $room->jitsi_link }}" data-room-id="{{ $room->id }}">
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
                                data-room="{{ $room->jitsi_link }}" data-room-id="{{ $room->id }}">
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
    {{-- <div id="jitsiModal">
    <div class="bg-white rounded-lg w-[90%] md:w-[80%] lg:w-[70%] h-[80%] relative">
        <button id="closeJitsi">X</button>
        <div id="jitsiContainer"></div>
    </div>
</div> --}}

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
            background: rgba(0, 0, 0, 0.6);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 50;
        }

        #jitsiModal.active {
            display: flex;
        }

        #jitsiContainer {
            width: 100%;
            height: 100%;
        }

        #closeJitsi {
            position: absolute;
            top: 10px;
            right: 10px;
            background: red;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
@endsection

@section('script')
    <!-- Jitsi Script -->
    <script src="https://meet.jit.si/external_api.js"></script>
    <script>
        document.querySelectorAll('.joinRoomBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                const roomLink = this.dataset.room;
                const roomId = this.dataset.roomId;
                const roomName = roomLink.split('/').pop();

                // Show modal
                const modal = document.getElementById('jitsiModal');
                modal.classList.add('active');

                // Initialize Jitsi
                const domain = "meet.jit.si";
                const options = {
                    roomName: roomName,
                    parentNode: document.getElementById('jitsiContainer'),
                    width: '100%',
                    height: '100%',
                    userInfo: {
                        email: "{{ auth()->user()->email }}",
                        displayName: "{{ auth()->user()->name }}"
                    },
                    configOverwrite: {
                        startWithAudioMuted: true,
                        startWithVideoMuted: true
                    },
                    interfaceConfigOverwrite: {
                        TOOLBAR_BUTTONS: ['microphone', 'camera', 'hangup', 'fullscreen']
                    }
                };
                const api = new JitsiMeetExternalAPI(domain, options);

                // AJAX join
                fetch('/jitsi/join/' + roomId, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                }).then(res => res.json()).then(data => {
                    if (data.error) alert(data.error);
                });

                // Close modal
                document.getElementById('closeJitsi').onclick = function() {
                    api.dispose();
                    modal.classList.remove('active');
                }
            });
        });

        // Search filter
        document.getElementById('roomSearch').addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            document.querySelectorAll('#roomsContainer .room-card').forEach(card => {
                const title = card.dataset.title.toLowerCase();
                card.style.display = title.includes(query) ? 'flex' : 'none';
            });
        });
    </script>
@endsection
