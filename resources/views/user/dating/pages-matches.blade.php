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

    <div class="max-w-6xl mx-auto mt-6 space-y-6">

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

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- LEFT PROFILE CARD --}}
            <div
                class="md:col-span-1 bg-white rounded-2xl shadow-lg p-6 relative h-[200px] flex flex-col transition hover:shadow-2xl">

                {{-- SETTINGS BUTTON --}}
                <button onclick="document.getElementById('editModal').classList.remove('hidden')"
                    class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor">
                        <circle cx="12" cy="5" r="2" />
                        <circle cx="12" cy="12" r="2" />
                        <circle cx="12" cy="19" r="2" />
                    </svg>
                </button>

                {{-- USER DETAILS --}}
                <div class="flex items-center space-x-3 mb-4">
                    @php
                        $photo1 = $user->details->photo1 ?? null;
                    @endphp
                    <a href="{{ url('/dating/profile/' . $user->id) }}">
                        <img src="{{ $photo1 ? asset('storage/' . $photo1) : asset('/images/avatars/avatar-1.jpg') }}"
                            class="w-14 h-14 rounded-full border object-cover hover:opacity-90 transition">
                    </a>

                    <div>
                        <a href="{{ route('timeline') }}">
                            <h2 class="font-bold text-lg text-gray-900 hover:underline hover:text-blue-600 transition">
                                {{ $user->first_name }} {{ $user->last_name }}
                            </h2>
                        </a>
                        <p class="text-sm text-gray-500">Your Profile</p>
                    </div>
                </div>

                {{-- DETAILS LIST --}}
                <div class="flex-1 overflow-y-auto">
                    <div class="flex flex-col gap-2 text-sm text-gray-700">

                        <span class="inline-block bg-blue-50 text-indigo-700 px-3 py-1 rounded-full font-medium">
                            Identity: {{ $details->identity }}
                        </span>

                        <span class="inline-block bg-pink-50 text-pink-700 px-3 py-1 rounded-full font-medium">
                            Preference: {{ $details->preference }}
                        </span>

                        <span class="inline-block bg-green-50 text-green-700 px-3 py-1 rounded-full font-medium">
                            Interest: {{ $details->interest }}
                        </span>

                        <span class="inline-block bg-yellow-50 text-yellow-700 px-3 py-1 rounded-full font-medium">
                            Relationship: {{ $details->relationship_type }}
                        </span>

                        @if ($details->bio)
                            <p class="pt-2 border-t border-gray-200 mt-2 text-gray-600">
                                <strong>Bio:</strong> {{ $details->bio }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- RIGHT MATCHES LIST + SEARCH --}}
            <div class="md:col-span-2" x-data="{
                showCount: 3,
                search: '',
                allMatches: {{ Js::from(
                    $matches->map(function ($m) use ($user) {
                        // Determine friendship status
                        $friendship = \App\Models\Friendship::where(function ($q) use ($user, $m) {
                            $q->where('sender_id', $user->id)->where('receiver_id', $m->user_id);
                        })->orWhere(function ($q) use ($user, $m) {
                                $q->where('sender_id', $m->user_id)->where('receiver_id', $user->id);
                            })->first();
                
                        return [
                            'id' => $m->user->id,
                            'first_name' => $m->user->first_name,
                            'last_name' => $m->user->last_name,
                            'image' => $m->user->details?->photo1,
                            'identity' => $m->identity,
                            'preference' => $m->preference,
                            'interest' => $m->interest,
                            'relationship_type' => $m->relationship_type,
                            'UserStatus' => $m->user->UserStatus,
                            'friendship_status' => $friendship?->status,
                            'friendship_sender' => $friendship?->sender_id,
                            'friend_count' => \App\Models\Friendship::where(function ($q) use ($m) {
                                $q->where('sender_id', $m->user->id)->orWhere('receiver_id', $m->user->id);
                            })->where('status', 'accepted')->count(),
                        ];
                    }),
                ) }},
            
                get filteredUsers() {
                    const s = this.search.toLowerCase();
                    const list = this.allMatches.filter(u =>
                        (u.first_name + ' ' + u.last_name).toLowerCase().includes(s)
                    );
                    return list.slice(0, this.showCount);
                },
            
                seeMore() {
                    const s = this.search.toLowerCase();
                    const list = this.allMatches.filter(u =>
                        (u.first_name + ' ' + u.last_name).toLowerCase().includes(s)
                    );
                    if (this.showCount < list.length) this.showCount += 3;
                },
            
                async blockUser(id) {
                    try {
                        const res = await fetch('{{ route('block.user') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ blocked_id: id })
                        });
            
                        const data = await res.json();
                        if (data.status === 'success') {
                            this.allMatches = this.allMatches.filter(u => u.id !== id);
                        } else {
                            alert(data.message);
                        }
                    } catch {
                        alert('Server error');
                    }
                }
            }">

                {{-- SEARCH BOX --}}
                <input type="text" x-model="search" placeholder="Search Matched users..."
                    class="w-full mb-4 px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">

                {{-- NO MATCHES --}}
                <div x-show="filteredUsers.length === 0" class="bg-white p-4 rounded-xl shadow text-center text-gray-600">
                    No matched users.
                </div>

                {{-- MATCH LIST --}}
                <template x-for="user in filteredUsers" :key="user.id">
                    <div class="flex items-center justify-between p-4 bg-white rounded-xl shadow mb-3">

                        {{-- USER LEFT --}}
                        <div class="flex items-center space-x-3">
                            <a :href="'/dating/profile/' + user.id" class="relative">
                                <img :src="(!user.image || user.image === '0') ? '/images/avatars/avatar-1.jpg' :
                                '/storage/' + user.image"
                                    class="w-12 h-12 rounded-full object-cover border">

                                <div x-show="user.UserStatus == 1" class="user-status-icon text-blue-600 text-sm">🎀</div>
                            </a>

                            <div>
                                <a :href="'/user/' + user.id" class="font-semibold text-gray-900 hover:underline"
                                    x-text="user.first_name + ' ' + user.last_name"></a>

                                <p class="text-xs text-gray-500" x-text="user.friend_count + ' Followers'"></p>

                                {{-- PREFERENCE DETAILS --}}
                                <div class="flex flex-wrap gap-1 mt-1 text-xs text-gray-600">
                                    <span x-text="'Identity: ' + (user.identity ?? 'N/A')"
                                        class="bg-gray-100 px-2 py-0.5 rounded-full"></span>
                                    <span x-text="'Prefers: ' + (user.preference ?? 'N/A')"
                                        class="bg-gray-100 px-2 py-0.5 rounded-full"></span>
                                    <span x-text="'Interest: ' + (user.interest ?? 'N/A')"
                                        class="bg-gray-100 px-2 py-0.5 rounded-full"></span>
                                    <span x-text="'Relationship: ' + (user.relationship_type ?? 'N/A')"
                                        class="bg-gray-100 px-2 py-0.5 rounded-full"></span>
                                </div>
                            </div>
                        </div>

                        {{-- RIGHT BUTTONS --}}
                        <div class="flex space-x-2">

                            {{-- SEND FRIEND REQUEST --}}
                            <template x-if="user.friendship_status === null">
                                <button
                                    @click.prevent="
                fetch('{{ route('send.friend.request') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ receiver_id: user.id })
                })
                .then(r => r.json())
                .then(d => {
                    if (d.status === 'success') {
                        user.friendship_status = 'pending';
                        user.friendship_sender = {{ auth()->id() }};
                    }
                })
            "
                                    class="px-3 py-1 text-sm rounded bg-blue-500 text-white hover:bg-blue-600 transition">
                                    Follow
                                </button>
                            </template>

                            {{-- REQUEST SENT BY ME --}}
                            <template
                                x-if="user.friendship_status === 'pending' && user.friendship_sender === {{ auth()->id() }}">
                                <button @click="withdrawRequest(user)"
                                    class="px-3 py-1 text-sm rounded bg-teal-500 text-white hover:bg-teal-600 transition">
                                    Requested
                                </button>
                            </template>

                            {{-- REQUEST SENT BY OTHER USER --}}
                            <template
                                x-if="user.friendship_status === 'pending' && user.friendship_sender !== {{ auth()->id() }}">
                                <button @click="acceptRequest(user)"
                                    class="px-3 py-1 text-sm rounded bg-yellow-500 text-white hover:bg-yellow-600 transition">
                                    Pending
                                </button>
                            </template>

                            {{-- FRIENDS / FOLLOWING --}}
                            <template x-if="user.friendship_status === 'accepted'">
                                <button @click="unfriend(user)"
                                    class="px-3 py-1 text-sm rounded bg-green-500 text-white hover:bg-green-600 transition">
                                    Following
                                </button>
                            </template>

                            {{-- BLOCK --}}
                            <button x-show="user.friendship_status !== 'pending'" @click="blockUser(user.id)"
                                class="px-3 py-1 text-sm rounded bg-red-600 text-white hover:bg-red-700 transition">
                                Block
                            </button>
                        </div>
                    </div>
                </template>

                {{-- SEE MORE --}}
                <div class="text-center mt-3"
                    x-show="filteredUsers.length < allMatches.filter(u => 
                        (u.first_name + ' ' + u.last_name).toLowerCase().includes(search.toLowerCase())
                    ).length">
                    <button @click="seeMore" class="text-sm text-blue-500 hover:underline">See more</button>
                </div>
            </div>
        </div>
    </div>

    {{-- UPDATE PREFERENCES MODAL --}}
    @include('components.preference_modal')
@endsection

@section('css')
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
        function withdrawRequest(user) {
            if (user.friendship_sender !== {{ auth()->id() }}) return;
            if (!confirm('Are you sure you want to withdraw your friend request?')) return;
            fetch(`/friends/withdraw/${user.id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        user.friendship_status = null;
                        user.friendship_sender = null;
                    }
                });
        }

        function unfriend(user) {
            if (!confirm('Unfriend this user?')) return;

            fetch(`/unfriend/${user.id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        user.friendship_status = null;
                        user.friendship_sender = null;
                    }
                })
                .catch(() => alert("Network error"));
        }
    </script>
@endsection
