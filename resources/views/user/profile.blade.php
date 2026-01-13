@extends('layouts.app1')

@section('title')
    User Profile
@endsection

@section('content')
    <br><br><br><br>
    <div class="max-w-3xl mx-auto p-4">
        <div class="bg-white rounded shadow p-4 mb-6 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="relative inline-block">
                    <!-- User Image -->
                    <img src="{{ $userProfile->image && $userProfile->image !== '0' ? asset('storage/' . $userProfile->image) : asset('images/avatars/avatar-1.jpg') }}"
                        class="w-16 h-16 rounded-full object-cover" alt="User Image">

                    <!-- Bow Icon (only if UserStatus == 1) -->
                    @if ($userProfile->UserStatus == 1)
                        <div class="user-status-icon text-blue-600 text-sm">
                            🎀
                        </div>
                    @endif
                </div>

                <div>
                    <h2 class="text-xl font-bold">{{ $userProfile->first_name }} {{ $userProfile->last_name }}</h2>
                    <p class="text-sm text-gray-500">{{ $userProfile->pronouns }}</p>
                    <p class="text-sm text-gray-500">{{ $userProfile->bio }}</p>
                </div>
            </div>

            {{-- Friendship Status --}}
            <div>
                @php
                    $auth = auth()->user();
                    $friendship = \App\Models\Friendship::where(function ($q) use ($auth, $userProfile) {
                        $q->where('sender_id', $auth->id)->where('receiver_id', $userProfile->id);
                    })
                        ->orWhere(function ($q) use ($auth, $userProfile) {
                            $q->where('sender_id', $userProfile->id)->where('receiver_id', $auth->id);
                        })
                        ->first();
                @endphp

                @php
                    $isBlockedByUser = \App\Models\Block::where('user_id', $userProfile->id)
                        ->where('blocked_id', $auth->id)
                        ->exists();

                    $hasBlockedUser = \App\Models\Block::where('user_id', $auth->id)
                        ->where('blocked_id', $userProfile->id)
                        ->exists();
                @endphp

                @if (!$isBlockedByUser && !$hasBlockedUser)
                    {{-- Not friends yet --}}
                    @if (!$friendship)
                        <button class="bg-blue-500 text-white px-4 py-1 rounded text-sm follow-btn"
                            data-id="{{ $userProfile->id }}">
                            Follow
                        </button>

                        <button class="bg-red-600 text-white px-4 py-1 rounded text-sm block-user-btn"
                            data-id="{{ $userProfile->id }}">
                            Block
                        </button>

                        {{-- Pending (sent by auth) --}}
                    @elseif ($friendship->status === 'pending' && (int) $friendship->sender_id === (int) $auth->id)
                        <button
                            class="px-3 py-1 text-sm rounded bg-teal-500 text-white hover:bg-teal-600 transition requested-btn"
                            data-id="{{ $userProfile->id }}">
                            Requested
                        </button>

                        {{-- Pending (received by auth) --}}
                    @elseif ($friendship->status === 'pending' && (int) $friendship->receiver_id === (int) $auth->id)
                        <div class="flex space-x-2">
                            <button class="bg-green-500 text-white px-4 py-1 rounded text-sm friend-accept"
                                data-id="{{ $friendship->id }}">
                                Accept
                            </button>
                            <button class="bg-red-500 text-white px-4 py-1 rounded text-sm friend-reject"
                                style="background:red; color:white; padding:4px 14px;" data-id="{{ $friendship->id }}">
                                Reject
                            </button>
                        </div>

                        {{-- Already friends --}}
                    @elseif ($friendship->status === 'accepted')
                        <button class="bg-green-500 text-white px-4 py-1 rounded text-sm following-btn cursor-pointer"
                            data-id="{{ $userProfile->id }}">
                            Following
                        </button>

                        <button class="bg-red-600 text-white px-4 py-1 rounded text-sm block-user-btn"
                            data-id="{{ $userProfile->id }}">
                            Block
                        </button>
                    @endif
                @else
                    <p class="text-gray-500 text-sm"></p>
                @endif
            </div>
        </div>

        {{-- Posts Section --}}
        <div>
            <h3 class="text-lg font-semibold mb-4">Posts</h3>

            {{-- Privacy check --}}
            @if (!$canViewPosts)
                <p class="text-gray-500 text-center">{{ $message }}</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @forelse ($posts as $post)
                        <div id="post-{{ $post->id }}" class="bg-white rounded shadow p-3 transition-all duration-500">
                            {{-- Post Image --}}
                            @if ($post->post_image)
                                <img src="{{ asset('storage/' . $post->post_image) }}" alt="Post Image"
                                    class="w-full h-40 object-cover rounded mb-2">
                            @endif
                            {{-- Caption --}}
                            @if ($post->caption)
                                <p class="text-gray-800 text-sm">{{ $post->caption }}</p>
                            @endif

                            {{-- Timestamp --}}
                            <p class="text-xs text-gray-400 mt-1">{{ $post->created_at->diffForHumans() }}</p>

                            {{-- Like + Comment Counts --}}
                            <div class="flex items-center justify-start mt-3 space-x-4 text-sm text-gray-600">
                                <!-- ❤️ Like Section -->
                                <div x-data="{ open: false }">
                                    <div class="flex items-center gap-2.5">
                                        <button @click="open = true" type="button"
                                            class="button-icon text-red-500 bg-red-100 dark:bg-slate-700 rounded-full p-2">
                                            <ion-icon class="text-lg" name="heart"></ion-icon>
                                        </button>
                                        <a href="javascript:void(0);" @click="open = true">
                                            {{ $post->likes->count() }}
                                        </a>
                                    </div>

                                    <!-- Likes Modal -->
                                    <div x-show="open" x-transition
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
                                        style="display:none">

                                        <!-- MODAL BOX -->
                                        <div
                                            class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-2xl max-h-[80vh] overflow-hidden">

                                            <!-- HEADER -->
                                            <div
                                                class="flex justify-between items-center px-5 py-4 border-b dark:border-gray-700">
                                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                    Liked by
                                                </h2>
                                                <button @click="open = false"
                                                    class="text-gray-500 hover:text-gray-700 text-2xl leading-none">
                                                    &times;
                                                </button>
                                            </div>

                                            <!-- BODY (SCROLLABLE) -->
                                            <div class="p-5 overflow-y-auto max-h-[65vh] space-y-4">

                                                @forelse($post->likes as $like)
                                                    <div class="flex items-center gap-4">

                                                        <!-- USER IMAGE -->
                                                        <img src="{{ $like->user->image ? asset('storage/' . $like->user->image) : asset('images/avatars/avatar-1.jpg') }}"
                                                            class="w-10 h-10 rounded-full object-cover">

                                                        <!-- USER NAME -->
                                                        <div>
                                                            <p
                                                                class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                                                {{ $like->user->first_name }} {{ $like->user->last_name }}
                                                            </p>
                                                        </div>

                                                    </div>
                                                @empty
                                                    <p class="text-sm text-gray-500 text-center">
                                                        No likes yet
                                                    </p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Comment Section --}}
                                <div x-data="{
                                    openComments: false,
                                    comments: [],
                                    storagePath: '{{ asset('storage') }}',
                                    avatarPath: '{{ asset('images/avatars/avatar-1.jpg') }}'
                                }">

                                    <!-- Comment Button -->
                                    <div class="flex items-center gap-2 cursor-pointer">
                                        <button type="button"
                                            @click="
                openComments = true;
                fetch('/post/{{ $post->id }}/comment')
                    .then(res => res.json())
                    .then(data => comments = data);
            "
                                            class="button-icon bg-blue-100 text-blue-600 hover:bg-blue-200 dark:bg-slate-700 rounded-full p-2">
                                            <ion-icon class="text-lg" name="chatbubble-ellipses"></ion-icon>
                                        </button>

                                        <span>{{ $post->comments_count ?? 0 }}</span>
                                    </div>

                                    <!-- COMMENTS MODAL -->
                                    <div x-show="openComments" x-transition
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
                                        style="display:none">

                                        <!-- MODAL BOX -->
                                        <div
                                            class="bg-white dark:bg-gray-800 rounded-xl shadow-xl 
                   w-full max-w-2xl mx-4 max-h-[85vh] flex flex-col">

                                            <!-- HEADER -->
                                            <div
                                                class="flex justify-between items-center px-5 py-3 border-b dark:border-gray-700">
                                                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                                                    Comments
                                                </h2>
                                                <button @click="openComments = false"
                                                    class="text-2xl text-gray-500 hover:text-gray-700">
                                                    &times;
                                                </button>
                                            </div>

                                            <!-- COMMENTS BODY (SCROLL AREA) -->
                                            <div class="flex-1 overflow-y-auto px-5 py-4 space-y-4">

                                                <!-- NO COMMENTS -->
                                                <template x-if="comments.length === 0">
                                                    <p class="text-sm text-gray-500 text-center">
                                                        No comments yet
                                                    </p>
                                                </template>

                                                <!-- COMMENTS LIST -->
                                                <template x-for="comment in comments" :key="comment.id">
                                                    <div class="space-y-2">

                                                        <!-- MAIN COMMENT -->
                                                        <div class="flex gap-3">
                                                            <img :src="comment.user.image ?
                                                                storagePath + '/' + comment.user.image :
                                                                avatarPath"
                                                                class="w-9 h-9 rounded-full border">

                                                            <div
                                                                class="bg-gray-100 dark:bg-gray-700 rounded-lg px-3 py-2 w-full">
                                                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200"
                                                                    x-text="comment.user.first_name + ' ' + comment.user.last_name">
                                                                </p>
                                                                <p class="text-sm text-gray-700 dark:text-gray-300"
                                                                    x-text="comment.body">
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <!-- REPLIES -->
                                                        <div class="ml-12 pl-4 space-y-2">
                                                            <template x-for="reply in comment.replies"
                                                                :key="reply.id">
                                                                <div class="flex gap-2">
                                                                    <img :src="reply.user.image ?
                                                                        storagePath + '/' + reply.user.image :
                                                                        avatarPath"
                                                                        class="w-7 h-7 rounded-full border">

                                                                    <div
                                                                        class="bg-gray-50 dark:bg-gray-600 rounded-lg px-3 py-2 w-full">
                                                                        <p class="text-xs font-semibold text-gray-800 dark:text-gray-200"
                                                                            x-text="reply.user.first_name + ' ' + reply.user.last_name">
                                                                        </p>
                                                                        <p class="text-xs text-gray-600 dark:text-gray-300"
                                                                            x-text="reply.body">
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </template>
                                                        </div>

                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">No posts yet.</p>
                    @endforelse
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Send friend request
            $(document).on('click', '.follow-btn', function() {
                let receiverId = $(this).data('id');
                let button = $(this);

                // Find block button inside the same user row
                let blockBtn = button.closest('.flex.justify-between').find('.block-user-btn');

                $.ajax({
                    url: "{{ route('send.friend.request') }}",
                    type: "POST",
                    data: {
                        receiver_id: receiverId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status === 'success') {

                            // Change Follow → Requested
                            button.removeClass(
                                    'bg-blue-500 text-white px-4 py-1 rounded text-sm follow-btn'
                                )
                                .addClass(
                                    'px-3 py-1 text-sm rounded bg-teal-500 text-white hover:bg-teal-600 transition requested-btn'
                                )
                                .text('Requested');

                            // Hide block button
                            blockBtn.hide();
                        }
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON?.message || 'Something went wrong.');
                    }
                });
            });

            // Withdraw request
            $(document).on('click', '.requested-btn', function() {
                if (!confirm('Do you want to withdraw your friend request?')) return;

                let receiverId = $(this).data('id');
                let button = $(this);

                let container = $(this).closest('div');

                $.ajax({
                    url: "/friends/withdraw/" + receiverId,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status === 'success') {

                            container.html(`
                    <button class="bg-blue-500 text-white px-4 py-1 rounded text-sm follow-btn"
                        data-id="${receiverId}">
                        Follow
                    </button>

                    <button class="bg-red-600 text-white px-4 py-1 rounded text-sm block-user-btn"
                        onclick="blockUser(${receiverId})">
                        Block
                    </button>
                `);

                        }
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON?.message || 'Error withdrawing request.');
                    }
                });
            });

            // Accept request
            $(document).on('click', '.friend-accept', function(e) {
                e.preventDefault();
                let friendshipId = $(this).data('id');

                $.ajax({
                    url: "{{ route('friends.accept') }}",
                    type: "POST",
                    data: {
                        friendship_id: friendshipId,
                        action: 'accept',
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('body').fadeOut(200, function() {
                            location.reload(); // reload the page smoothly
                        });
                    },
                    error: function() {
                        alert('Error accepting request.');
                    }
                });
            });

            // Reject request
            $(document).on('click', '.friend-reject', function() {
                let friendshipId = $(this).data('id');
                let container = $(this).closest('div');

                $.ajax({
                    url: "{{ route('friends.accept') }}",
                    type: "POST",
                    data: {
                        friendship_id: friendshipId,
                        action: 'reject',
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        container.html(`
                <button class="bg-blue-500 text-white px-4 py-1 rounded text-sm follow-btn"
                    data-id="{{ $userProfile->id }}">
                    Follow
                </button>

                <button class="bg-red-600 text-white px-4 py-1 rounded text-sm block-user-btn"
                    onclick="blockUser({{ $userProfile->id }})">
                    Block
                </button>
            `);
                    },
                    error: function() {
                        alert('Error rejecting request.');
                    }
                });
            });

            $(document).on('click', '.following-btn', function(e) {
                e.preventDefault();
                let userId = $(this).data('id');
                if (!confirm('Do you want to unfollow this user?')) return;

                $.ajax({
                    url: "/unfriend/" + userId,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            // Slight fade and reload page
                            $('body').fadeOut(200, function() {
                                location.reload();
                            });
                        }
                    },
                    error: function() {
                        alert('Error unfollowing user.');
                    }
                });
            });
        });

        // BLOCK USER
        $(document).on('click', '.block-user-btn', function() {
            let userId = $(this).data('id');

            if (!confirm("Do you really want to block this user?")) return;

            $.ajax({
                url: "{{ route('block.user') }}",
                type: "POST",
                data: {
                    blocked_id: userId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status === "success") {

                        // Smooth fade + redirect
                        $('body').fadeOut(200, function() {
                            window.location.href = "/event";
                        });
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    alert(xhr.responseJSON?.message || "Server error while blocking user.");
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const params = new URLSearchParams(window.location.search);
            const postId = params.get('post');

            if (postId) {
                const postEl = document.getElementById('post-' + postId);

                if (postEl) {
                    postEl.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });

                    // Highlight effect
                    postEl.classList.add('ring-4', 'ring-blue-400');

                    setTimeout(() => {
                        postEl.classList.remove('ring-4', 'ring-blue-400');
                    }, 3000);
                }
            }
        });
    </script>
@endsection

@section('css')
    <style>
        .user-status-icon {
            position: absolute;
            left: 50%;
            bottom: -8px;
            /* distance below the image */
            transform: translateX(-50%);
            font-size: 18px;
            color: #2563eb;
            /* Tailwind blue-600 */
        }
    </style>
@endsection
