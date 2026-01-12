@extends('layouts.app1')

@section('content')
    {{-- SUCCESS ALERT --}}
    @if (session('success'))
        <div id="flash-success"
            style="
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #dcfce7;
            border: 1px solid #22c55e;
            color: #166534;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            z-index: 9999;
            box-shadow: 0 10px 25px rgba(0,0,0,.15);
            text-align: center;
            min-width: 260px;
        ">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(() => {
                const el = document.getElementById('flash-success');
                if (el) el.style.display = 'none';
            }, 5000);
        </script>
    @endif

    {{-- ERROR ALERT --}}
    @if (session('error'))
        <div id="flash-error"
            style="
            position: fixed;
            top: 70px;
            left: 50%;
            transform: translateX(-50%);
            background: #fee2e2;
            border: 1px solid #ef4444;
            color: #7f1d1d;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            z-index: 9999;
            box-shadow: 0 10px 25px rgba(0,0,0,.15);
            text-align: center;
            min-width: 260px;
        ">
            {{ session('error') }}
        </div>

        <script>
            setTimeout(() => {
                const el = document.getElementById('flash-error');
                if (el) el.style.display = 'none';
            }, 5000);
        </script>
    @endif

    <div class="global-hearts" aria-hidden="true">
        <span class="heart">💖</span>
        <span class="heart">💜</span>
        <span class="heart">💙</span>
        <span class="heart">💗</span>
        <span class="heart">💞</span>
        <span class="heart">💘</span>
        <span class="heart">💖</span>
        <span class="heart">💜</span>
        <span class="heart">💙</span>
    </div>

    <br><br>

    <div class="max-w-3xl mx-auto mt-10">

        {{-- HEADER --}}
        <div class="text-center mb-6">
            <h1
                class="text-4xl font-extrabold bg-gradient-to-r from-pink-500 via-fuchsia-500 to-purple-600
               bg-clip-text text-transparent drop-shadow-[0_0_10px_rgba(255,0,150,0.6)]
               animate-glow">
                💖 AffirmSpace — Love for Everyone
            </h1>

            <p class="text-gray-600 text-sm mt-2 italic tracking-wide">

            </p>
        </div>

        <style>
            @keyframes glowPulse {
                0% {
                    text-shadow: 0 0 10px rgba(255, 0, 0, 0.8);
                }

                25% {
                    text-shadow: 0 0 12px rgba(255, 255, 0, 0.9);
                }

                50% {
                    text-shadow: 0 0 12px rgba(0, 255, 0, 0.9);
                }

                75% {
                    text-shadow: 0 0 12px rgba(0, 128, 255, 0.9);
                }

                100% {
                    text-shadow: 0 0 10px rgba(255, 0, 0, 0.8);
                }
            }

            .animate-glow {
                animation: glowPulse 3s infinite linear;
            }
        </style>

        <div
            class="relative bg-gradient-to-r from-pink-400 via-red-400 to-yellow-400 rounded-2xl h-40 flex items-center justify-between px-6 shadow-lg">

            {{-- Name & Email --}}
            <div class="text-white">
                <h1 class="text-2xl font-bold">{{ $user->first_name }} {{ $user->last_name }}</h1>
                <p class="text-sm" style="color:grey;">{{ $user->email }}</p>
            </div>

            @if (Auth::check() && Auth::id() === $user->id)
                <div class="relative">
                    <button onclick="document.getElementById('editModal').classList.remove('hidden')"
                        class="text-white text-2xl font-bold focus:outline-none" style="color:grey;">⋮</button>
                </div>
            @else
                <div class="mt-3 flex space-x-2" id="actionButtons">

                    {{-- FOLLOW --}}
                    @if (!$friendship)
                        <button id="followBtn" onclick="sendRequest({{ $user->id }})"
                            class="px-4 py-1 text-sm rounded bg-blue-500 text-white hover:bg-blue-600">
                            Follow
                        </button>

                        {{-- BLOCK --}}
                        <button id="blockBtn" onclick="blockUser({{ $user->id }})"
                            class="px-4 py-1 text-sm rounded bg-red-600 text-white hover:bg-red-700">
                            Block
                        </button>
                    @endif

                    {{-- REQUEST SENT BY ME --}}
                    @if ($friendship && $friendship->status === 'pending' && (int) $friendship->sender_id === (int) Auth::id())
                        <button id="requestedBtn" onclick="withdrawRequest({{ $user->id }})"
                            class="px-4 py-1 text-sm rounded bg-teal-500 text-white hover:bg-teal-600 transition">
                            Requested
                        </button>
                    @endif

                    {{-- REQUEST RECEIVED --}}
                    @if ($friendship && $friendship->status === 'pending' && (int) $friendship->sender_id !== (int) Auth::id())
                        <button id="acceptBtn" {{-- onclick="acceptRequest({{ $user->id }})" --}}
                            class="px-4 py-1 text-sm rounded bg-yellow-500 text-white hover:bg-yellow-600">
                            Pending
                        </button>
                    @endif

                    {{-- ACCEPTED --}}
                    @if ($friendship && $friendship->status === 'accepted')
                        <button id="followingBtn" onclick="unfollowUser({{ $user->id }})"
                            class="px-4 py-1 text-sm rounded bg-green-500 text-white hover:bg-green-600">
                            Following
                        </button>

                        {{-- BLOCK --}}
                        <button id="blockBtn" onclick="blockUser({{ $user->id }})"
                            class="px-4 py-1 text-sm rounded bg-red-600 text-white hover:bg-red-700">
                            Block
                        </button>
                    @endif
                </div>
            @endif

            {{-- Profile Picture --}}
            <div class="absolute -bottom-20 left-1/2 transform -translate-x-1/2">
                <img src="{{ $user->details->photo1 ? asset('storage/' . $user->details->photo1) : asset('/images/avatars/avatar-1.jpg') }}"
                    class="w-40 h-40 object-cover rounded-full border-4 border-white shadow-lg">
            </div>
        </div>

        {{-- Profile Card --}}
        <div class="bg-white p-6 mt-6 rounded-2xl shadow-lg space-y-6">

            {{-- Gallery --}}
            <div>
                <h2 class="text-xl font-semibold mb-3 border-b pb-2 text-pink-600">Gallery</h2>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach (['photo1', 'photo2', 'photo3', 'photo4'] as $pic)
                        @if ($user->details->$pic)
                            <img src="{{ asset('storage/' . $user->details->$pic) }}"
                                class="w-full h-28 sm:h-32 object-cover rounded-lg border-2 border-gray-200 hover:scale-105 transform transition">
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Profile Details --}}
            <div>
                <h2 class="text-xl font-semibold mb-3 border-b pb-2 text-pink-600">Profile Details</h2>

                @if (Auth::check() && Auth::id() !== $user->id)
                    <!-- Message Input -->
                    <div class="flex items-center gap-2 mb-4 mt-2">
                        <input type="text" id="datingMessage" placeholder="Say Hi 👋"
                            class="flex-1 p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                        <button onclick="sendDatingMessage()"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                            Send
                        </button>
                    </div>
                @endif
                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <li class="flex justify-between">
                        <span class="font-medium text-gray-700">Gender:</span>
                        <span class="text-gray-600">{{ $user->gender }}</span>
                    </li>

                    <li class="flex justify-between">
                        <span class="font-medium text-gray-700">Looking For:</span>
                        <span class="text-gray-600">{{ $user->details->preference }}</span>
                    </li>

                    <li class="flex justify-between">
                        <span class="font-medium text-gray-700">Relationship Type:</span>
                        <span class="text-gray-600">{{ $user->details->relationship_type }}</span>
                    </li>

                    <li class="flex justify-between">
                        <span class="font-medium text-gray-700">Interest:</span>
                        <span class="text-gray-600">{{ $user->details->interest }}</span>
                    </li>

                    <!-- BIO FULL WIDTH -->
                    <li class="sm:col-span-2 flex flex-col">
                        <span class="font-medium text-gray-700 mb-1">Bio:</span>
                        <span class="text-gray-600">{{ $user->details->bio ?? 'No bio added' }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- UPDATE PREFERENCES MODAL --}}
    @include('components.preference_modal')
@endsection

@section('css')
    <style>
        /* Smooth hover effect for gallery images */
        .gallery-img:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease-in-out;
        }
    </style>

    <style>
        .user-status-icon {
            position: absolute;
            left: 50%;
            bottom: -10px;
            transform: translateX(-50%);
            font-size: 16px;
        }

        /* ===== HEARTS FULL SCREEN BACKGROUND ===== */
        .global-hearts {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100vh;
            overflow: hidden;
            z-index: -1;
            pointer-events: none;
        }

        .global-hearts .heart {
            position: absolute;
            bottom: -60px;
            font-size: 40px;
            /* Increased heart size */
            opacity: 0.9;
            animation: floatUp 7s linear infinite;
        }

        /* Random positions & different speeds */
        .global-hearts .heart:nth-child(1) {
            left: 5%;
            animation-duration: 7s;
        }

        .global-hearts .heart:nth-child(2) {
            left: 18%;
            animation-duration: 8.5s;
            font-size: 45px;
            /* ↑ bigger */
        }

        .global-hearts .heart:nth-child(3) {
            left: 32%;
            animation-duration: 6.2s;
        }

        .global-hearts .heart:nth-child(4) {
            left: 48%;
            animation-duration: 7.8s;
        }

        .global-hearts .heart:nth-child(5) {
            left: 63%;
            animation-duration: 9s;
            font-size: 48px;
            /* ↑ bigger */
        }

        .global-hearts .heart:nth-child(6) {
            left: 77%;
            animation-duration: 6.4s;
        }

        .global-hearts .heart:nth-child(7) {
            left: 88%;
            animation-duration: 8s;
        }

        .global-hearts .heart:nth-child(8) {
            left: 25%;
            animation-duration: 7.3s;
            font-size: 44px;
            /* ↑ bigger */
        }

        .global-hearts .heart:nth-child(9) {
            left: 55%;
            animation-duration: 9.2s;
            font-size: 46px;
            /* ↑ bigger */
        }

        /* Floating animation */
        @keyframes floatUp {
            0% {
                transform: translateY(0) rotate(0deg) scale(1);
                opacity: 1;
            }

            50% {
                opacity: .9;
            }

            100% {
                transform: translateY(-120vh) rotate(10deg) scale(1.8);
                opacity: 0;
            }
        }
    </style>
@endsection

@section('script')
    <script>
        function sendRequest(id) {
            fetch('{{ route('send.friend.request') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        receiver_id: id
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        document.getElementById('actionButtons').innerHTML = `
                    <button onclick="withdrawRequest(${id})"
                        class="px-4 py-1 text-sm rounded bg-teal-500 text-white hover:bg-teal-600 transition">
                        Requested
                    </button>
                `;
                    }
                });
        }

        // WITHDRAW → back to follow + block
        function withdrawRequest(id) {
            if (!confirm('Are you sure you want to withdraw your friend request?')) return;
            fetch('/friends/withdraw/' + id, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        document.getElementById('actionButtons').innerHTML = `
                    <button onclick="sendRequest(${id})"
                        class="px-4 py-1 text-sm rounded bg-blue-500 text-white hover:bg-blue-600">
                        Follow
                    </button>

                    <button onclick="blockUser(${id})"
                        class="px-4 py-1 text-sm rounded bg-red-600 text-white hover:bg-red-700">
                        Block
                    </button>
                `;
                    }
                });
        }

        // // ACCEPT → show Following
        // function acceptRequest(id) {
        //     fetch('/friends/accept/' + id, {
        //             method: 'POST',
        //             headers: {
        //                 'Content-Type': 'application/json',
        //                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
        //             }
        //         })
        //         .then(res => res.json())
        //         .then(data => {
        //             if (data.status === "success") {
        //                 document.getElementById('actionButtons').innerHTML = `
    //             <button class="px-4 py-1 text-sm rounded bg-green-600 text-white">
    //                 Following
    //             </button>
    //         `;
        //             }
        //         });
        // }

        function blockUser(id) {
            if (!confirm("Do you really want to block this user?")) return;

            fetch('{{ route('block.user') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        blocked_id: id
                    })
                })
                .then(r => r.json())
                .then(d => {
                    if (d.status === "success") {
                        window.location.href = "/pages";
                    } else {
                        alert(d.message);
                    }
                });
        }

        function unfollowUser(id) {
            if (!confirm("Do you want to unfollow this user?")) return;

            fetch('{{ route('unfriend', '') }}/' + id, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => {
                    return res.json();
                })
                .then(data => {
                    if (data.status === "success") {

                        $('body').fadeOut(200, function() {
                            location.reload(); // reload the page smoothly
                        });

                    } else {
                        alert(data.message);
                    }
                })
                .catch(err => {
                    console.log("JSON Error:", err);
                    alert("Server did not return JSON.");
                });
        }
    </script>

    <script>
        function sendDatingMessage() {
            const messageInput = document.getElementById('datingMessage').value;

            if (!messageInput.trim()) {
                alert("Please enter a message!");
                return;
            }

            fetch("{{ route('dating.message.send') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        receiver_id: {{ $user->id }},
                        message: messageInput
                    })
                })
                .then(async response => {
                    const text = await response.text();

                    try {
                        const data = JSON.parse(text);

                        if (data.success) {
                            alert(data.message);
                            document.getElementById('datingMessage').value = '';
                        } else {
                            alert(data.message || "Something went wrong!");
                        }
                    } catch (e) {
                        // Non-JSON response
                        console.error("Server returned non-JSON:", text);
                        alert("Unexpected server response. Check console for details.");
                    }
                })
                .catch(error => {
                    console.error("Fetch error:", error);
                    alert("Failed to send message. Please try again.");
                });
        }
    </script>
@endsection
