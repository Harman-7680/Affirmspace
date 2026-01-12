@extends('layouts.app1')

@section('content')
    <div class="max-w-4xl mx-auto mt-6 space-y-6">
        <br>
        {{-- Header --}}
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Explore Friends</h1>
            <p class="text-gray-500 text-sm">Find and follow friends easily</p>
        </div>

        {{-- People Search Component --}}
        <div class="box p-3 px-4 mt-6 max-w-3xl mx-auto" x-data="{
            showCount: 2,
            search: '',
            allUsers: {{ Js::from($all_users->where('role', 0)->values()) }},
        
            get filteredUsers() {
                const searchTerm = this.search.toLowerCase();
                const matched = this.allUsers.filter(user => {
                    return (user.first_name + ' ' + user.last_name).toLowerCase().includes(searchTerm);
                });
                return matched.slice(0, this.showCount);
            },
        
            seeMore() {
                const searchTerm = this.search.toLowerCase();
                const matched = this.allUsers.filter(user => {
                    return (user.first_name + ' ' + user.last_name).toLowerCase().includes(searchTerm);
                });
                if (this.showCount < matched.length) {
                    this.showCount += 3;
                }
            },
        
            async blockUser(userId) {
                try {
                    const res = await fetch('{{ route('block.user') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ blocked_id: userId })
                    });
        
                    const data = await res.json();
                    if (data.status === 'success') {
                        // Remove blocked user from list
                        this.allUsers = this.allUsers.filter(u => u.id !== userId);
                    } else {
                        alert(data.message || 'Failed to block user');
                    }
                } catch (err) {
                    console.error(err);
                    alert('Something went wrong.');
                }
            }
        }">

            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-lg text-black dark:text-white">Find Friends</h3>
            </div>

            <div class="mb-4">
                <input type="text" x-model="search" placeholder="Search users..."
                    class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <template x-for="user in filteredUsers" :key="user.id">
                <div
                    class="flex items-center justify-between mb-4 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">

                    <!-- User Info -->
                    <div class="flex items-center space-x-3">
                        <a :href="'/user/' + user.id" class="relative inline-block">
                            <!-- User Image -->
                            <img :src="(!user.image || user.image === '0') ? '/images/avatars/avatar-1.jpg' : '/storage/' +
                            user.image"
                                class="w-12 h-12 rounded-full object-cover border">

                            <!-- Bow Icon (only visible if UserStatus == 1) -->
                            <div x-show="user.UserStatus == 1" class="user-status-icon text-blue-600 text-sm">
                                🎀
                            </div>
                        </a>
                        <div>
                            <a :href="'/user/' + user.id" class="font-semibold text-gray-800 dark:text-white"
                                x-text="user.first_name + ' ' + user.last_name"></a>
                            <p class="text-xs text-gray-500" x-text="user.friend_count + ' Followers'"></p>
                        </div>
                    </div>

                    <!-- Action Buttons (Follow / Requested / Following / Block) -->
                    <div class="flex space-x-2">

                        <!-- Follow Button (AJAX) -->
                        <template x-if="user.friendship_status === null">
                            <button
                                @click.prevent="
                        fetch('{{ route('send.friend.request') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({ receiver_id: user.id })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if(data.status === 'success') {
                                user.friendship_status = 'pending';
                                user.friendship_sender = {{ auth()->id() }};
                            } else {
                                alert(data.message || 'Request already sent');
                            }
                        })
                        .catch(() => alert('Server error'));
                    "
                                class="px-3 py-1 text-sm rounded bg-blue-500 text-white hover:bg-blue-600">
                                Follow
                            </button>
                        </template>

                        <!-- Requested / Pending -->
                        <template x-if="user.friendship_status === 'pending'">
                            <button @click="withdrawRequest(user)"
                                :class="user.friendship_sender === {{ auth()->id() }} ?
                                    'px-3 py-1 text-sm rounded bg-teal-500 text-white hover:bg-teal-600 transition' :
                                    'px-3 py-1 text-sm rounded bg-yellow-500 text-white hover:bg-yellow-600 transition'"
                                x-text="user.friendship_sender === {{ auth()->id() }} ? 'Requested' : 'Pending'">
                            </button>
                        </template>

                        <!-- Following -->
                        <template x-if="user.friendship_status === 'accepted'">
                            <button @click="unfriend(user)" class="px-3 py-1 text-sm rounded bg-green-500 text-white">
                                Following
                            </button>
                        </template>

                        <!-- Block Button -->
                        <button x-show="user.friendship_status !== 'pending'" @click="blockUser(user.id)"
                            class="px-3 py-1 text-sm rounded bg-red-500 text-white hover:bg-red-600"
                            style="background:red; color:white; padding:4px 16px;">
                            Block
                        </button>
                    </div>
                </div>
            </template>

            <div class="text-center mt-3"
                x-show="filteredUsers.length < allUsers.filter(user => 
            (user.first_name + ' ' + user.last_name).toLowerCase().includes(search.toLowerCase())
            ).length">
                <button @click="seeMore" class="text-sm text-blue-500 hover:underline">See more</button>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function withdrawRequest(user) {
            if (user.friendship_sender !== {{ auth()->id() }}) return; // Only sender can withdraw

            if (!confirm('Are you sure you want to withdraw your friend request?')) return;

            fetch(`/friends/withdraw/${user.id}`, { // Backend route to withdraw request
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        receiver_id: user.id
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Update button to Follow
                        user.friendship_status = null;
                        user.friendship_sender = null;

                        // Optionally remove notification if exists
                        const notif = document.getElementById('notification-' + user.id);
                        if (notif) {
                            notif.style.transition = 'opacity 0.3s';
                            notif.style.opacity = 0;
                            setTimeout(() => notif.remove(), 300);
                        }
                    } else {
                        alert(data.message || 'Something went wrong');
                    }
                })
                .catch(() => alert('Server error'));
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

@section('css')
    <style>
        .user-status-icon {
            position: absolute;
            left: 50%;
            bottom: -10px;
            /* move up/down as needed */
            transform: translateX(-50%);
            font-size: 16px;
            color: #2563eb;
            /* Tailwind blue-600 */
        }
    </style>
@endsection
