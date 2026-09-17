@extends('layouts.app_admin')

@section('css')
    <style>
        .profile-wrapper {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        .profile-card {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .profile-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .profile-left img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-left h2 {
            font-size: 20px;
            font-weight: 600;
            margin: 0;
        }

        .profile-left p {
            margin: 2px 0;
            color: #666;
            font-size: 14px;
        }

        .followers-btn {
            background: none;
            border: none;
            color: #333;
            font-size: 14px;
            cursor: pointer;
            text-decoration: underline;
        }

        .followers-btn:hover {
            color: #007bff;
        }

        /* Navigation Tabs */
        .profile-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #eaeaea;
            padding-bottom: 10px;
            flex-wrap: wrap;
        }

        .tab-btn {
            background: #f1f3f5;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            color: #495057;
            transition: all 0.2s ease;
        }

        .tab-btn.active {
            background: #007bff;
            color: #fff;
        }

        .tab-btn:hover:not(.active) {
            background: #e2e6ea;
        }

        /* Tab Content Sections */
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .posts-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .posts-header h3 {
            font-size: 18px;
            font-weight: 600;
        }

        .back-btn {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }

        .back-btn:hover {
            text-decoration: underline;
        }

        .posts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 15px;
        }

        .post-card,
        .tweet-card,
        .event-card {
            background: #fff;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .post-card img,
        .event-card img,
        .post-card video {
            width: 100%;
            height: 180px;
            border-radius: 8px;
            object-fit: cover;
            margin-bottom: 8px;
        }

        .post-caption,
        .tweet-content,
        .event-info {
            color: #333;
            font-size: 14px;
        }

        .post-time,
        .tweet-time,
        .event-time {
            color: #999;
            font-size: 12px;
            margin-top: 4px;
        }

        .post-actions {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-top: 10px;
            font-size: 14px;
        }

        .like-btn,
        .comment-btn {
            background: none;
            border: none;
            border-radius: 50%;
            padding: 8px;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .like-btn {
            color: #e63946;
            background: #ffe5e5;
        }

        .comment-btn {
            color: #007bff;
            background: #e6f0ff;
        }

        .like-btn:hover {
            background: #ffd6d6;
        }

        .comment-btn:hover {
            background: #d6e6ff;
        }

        .tagged-badge,
        .event-badge {
            font-size: 11px;
            background: #e9ecef;
            color: #495057;
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 6px;
        }

        .event-badge.paid {
            background: #d4edda;
            color: #155724;
        }

        .event-badge.free {
            background: #cce5ff;
            color: #004085;
        }

        /* Modal Styling */
        .custom-modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 1050;
            background: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }

        .custom-modal.active {
            display: flex;
        }

        .custom-modal-content {
            background: #fff;
            border-radius: 8px;
            width: 100%;
            max-width: 450px;
            padding: 20px;
            position: relative;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .custom-modal-content h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 22px;
            color: #666;
            border: none;
            background: none;
            cursor: pointer;
        }

        .close-btn:hover {
            color: #dc3545;
        }

        .modal-list {
            max-height: 250px;
            overflow-y: auto;
            list-style: none;
            padding: 0;
        }

        .modal-list li {
            border-bottom: 1px solid #ddd;
            padding: 8px 0;
            font-size: 14px;
        }

        .modal-list a {
            color: #007bff;
            text-decoration: none;
        }

        .modal-list a:hover {
            text-decoration: underline;
        }

        .no-posts {
            text-align: center;
            color: #777;
            font-size: 14px;
            margin-top: 15px;
        }
    </style>
@endsection

@section('content')
    <br><br>
    <div class="profile-wrapper">
        <div class="profile-card">
            <div class="profile-left">
                <img src="{{ $userProfile->image && $userProfile->image !== '0' ? asset('storage/' . $userProfile->image) : asset('images/avatars/avatar-1.jpg') }}"
                    alt="User Image">
                <div>
                    <h2>{{ $userProfile->first_name }} {{ $userProfile->last_name }}</h2>
                    <p>{{ $userProfile->email }}</p>
                </div>
            </div>

            <div>
                <button onclick="openFollowersModal()" class="followers-btn">
                    Followers : <strong>{{ $followersCount }}</strong>
                </button>
            </div>
        </div>

        <!-- 4 Buttons / Tabs -->
        <div class="profile-tabs">
            <button class="tab-btn active" onclick="switchTab('posts', event)">Posts</button>
            <button class="tab-btn" onclick="switchTab('tweets', event)">Tweets</button>
            <button class="tab-btn" onclick="switchTab('tags', event)">Tags</button>
            <button class="tab-btn" onclick="switchTab('events', event)">Events</button>
        </div>

        <!-- Back Link Header -->
        <div class="posts-header">
            <h3 id="sectionTitle">Posts</h3>
            <a href="javascript:history.back()" class="back-btn">← Back</a>
        </div>

        <!-- 1. Posts Tab Content (Default Active) -->
        <div id="posts" class="tab-content active">
            <div class="posts-grid">
                @forelse ($posts as $post)
                    <div class="post-card">
                        <div>
                            @php
                                $mediaPath = $post->post_image;
                                $extension = strtolower(pathinfo($mediaPath, PATHINFO_EXTENSION));
                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                                $videoExtensions = ['mp4', 'webm', 'ogg'];
                            @endphp

                            @if (in_array($extension, $imageExtensions))
                                <img src="{{ asset('storage/' . $mediaPath) }}" alt="Post Image">
                            @elseif (in_array($extension, $videoExtensions))
                                <video controls>
                                    <source src="{{ asset('storage/' . $mediaPath) }}" type="video/{{ $extension }}">
                                    Your browser does not support the video tag.
                                </video>
                            @endif

                            @if ($post->caption)
                                <p class="post-caption">Caption: {{ $post->caption }}</p>
                            @endif
                        </div>

                        <div>
                            <p class="post-time">{{ $post->created_at->diffForHumans() }}</p>
                            <div class="post-actions">
                                <div>
                                    <button type="button" class="like-btn" onclick="showLikes({{ $post->id }})">
                                        <ion-icon name="heart"></ion-icon>
                                    </button>
                                    <span onclick="showLikes({{ $post->id }})"
                                        style="cursor:pointer;">{{ $post->likes_count ?? 0 }}</span>
                                </div>
                                <div>
                                    <button type="button" class="comment-btn" onclick="showComments({{ $post->id }})">
                                        <ion-icon name="chatbubble-ellipses"></ion-icon>
                                    </button>
                                    <span onclick="showComments({{ $post->id }})"
                                        style="cursor:pointer;">{{ $post->comments_count ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="no-posts" style="grid-column: 1 / -1;">No posts yet.</p>
                @endforelse
            </div>
        </div>

        <!-- 2. Tweets Tab Content -->
        <div id="tweets" class="tab-content">
            <div class="posts-grid">
                @forelse ($tweets as $tweet)
                    <div class="tweet-card">
                        <div>
                            <p class="tweet-content"><strong>{{ $tweet->title }}</strong></p>
                            <p class="tweet-content" style="margin-top: 5px;">{{ $tweet->paragraph }}</p>
                        </div>
                        <p class="tweet-time">{{ $tweet->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="no-posts" style="grid-column: 1 / -1;">No tweets yet.</p>
                @endforelse
            </div>
        </div>

        <!-- 3. Tags Tab Content -->
        <div id="tags" class="tab-content">
            <div class="posts-grid">
                @forelse ($taggedPosts as $post)
                    <div class="post-card">
                        <div>
                            <span class="tagged-badge">Posted by: {{ $post->user->first_name ?? 'User' }}</span>
                            @php
                                $mediaPath = $post->post_image;
                                $extension = strtolower(pathinfo($mediaPath, PATHINFO_EXTENSION));
                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                                $videoExtensions = ['mp4', 'webm', 'ogg'];
                            @endphp

                            @if (in_array($extension, $imageExtensions))
                                <img src="{{ asset('storage/' . $mediaPath) }}" alt="Post Image">
                            @elseif (in_array($extension, $videoExtensions))
                                <video controls>
                                    <source src="{{ asset('storage/' . $mediaPath) }}" type="video/{{ $extension }}">
                                    Your browser does not support the video tag.
                                </video>
                            @endif

                            @if ($post->caption)
                                <p class="post-caption">Caption: {{ $post->caption }}</p>
                            @endif
                        </div>

                        <div>
                            <p class="post-time">{{ $post->created_at->diffForHumans() }}</p>
                            <div class="post-actions">
                                <div>
                                    <button type="button" class="like-btn" onclick="showLikes({{ $post->id }})">
                                        <ion-icon name="heart"></ion-icon>
                                    </button>
                                    <span onclick="showLikes({{ $post->id }})"
                                        style="cursor:pointer;">{{ $post->likes_count ?? 0 }}</span>
                                </div>
                                <div>
                                    <button type="button" class="comment-btn" onclick="showComments({{ $post->id }})">
                                        <ion-icon name="chatbubble-ellipses"></ion-icon>
                                    </button>
                                    <span onclick="showComments({{ $post->id }})"
                                        style="cursor:pointer;">{{ $post->comments_count ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="no-posts" style="grid-column: 1 / -1;">No tagged posts found.</p>
                @endforelse
            </div>
        </div>

        <!-- 4. Events Tab Content -->
        <div id="events" class="tab-content">
            <div class="posts-grid">
                @forelse ($events as $event)
                    <div class="event-card">
                        <div>
                            @if ($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" alt="Event Image">
                            @endif

                            <div style="display: flex; gap: 5px; margin-bottom: 6px;">
                                <span class="event-badge {{ $event->is_paid ? 'paid' : 'free' }}">
                                    {{ $event->is_paid ? 'Paid ($' . $event->amount . ')' : 'Free' }}
                                </span>
                                <span class="event-badge" style="background: #e2e8f0; color: #334155;">
                                    Status: {{ ucfirst($event->status) }}
                                </span>
                            </div>

                            <p class="event-info"><strong>{{ $event->name }}</strong></p>
                            <p class="event-info" style="margin-top: 4px; color: #555;">
                                📍 Address: {{ json_decode($event->city)->address ?? $event->city }}
                            </p>
                            <p class="event-info" style="margin-top: 2px; color: #555;">⏰ Timing: {{ $event->timing }}</p>
                        </div>
                        <p class="event-time">{{ $event->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="no-posts" style="grid-column: 1 / -1;">No events found.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Followers Modal -->
    <div id="followersModal" class="custom-modal">
        <div class="custom-modal-content">
            <button class="close-btn" onclick="closeFollowersModal()">&times;</button>
            <h3>Followers</h3>
            <ul class="modal-list">
                @forelse ($followers as $friend)
                    <li>
                        <a href="{{ url('/admin/' . $friend->id) }}">{{ $friend->first_name }}
                            {{ $friend->last_name }}</a>
                    </li>
                @empty
                    <li>No followers found.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- Info Modal -->
    <div id="infoModal" class="custom-modal">
        <div class="custom-modal-content">
            <button class="close-btn" onclick="closeModal()">&times;</button>
            <h3 id="modalTitle">Details</h3>
            <ul id="modalContent" class="modal-list"></ul>
        </div>
    </div>
@endsection

@section('script')
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script>
        function switchTab(tabId, event) {
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            document.getElementById(tabId).classList.add('active');
            event.currentTarget.classList.add('active');

            const titles = {
                'posts': 'Posts',
                'tweets': 'Tweets',
                'tags': 'Tagged Posts',
                'events': 'Events'
            };
            document.getElementById('sectionTitle').innerText = titles[tabId] || 'Posts';
        }

        function openFollowersModal() {
            document.getElementById('followersModal').classList.add('active');
        }

        function closeFollowersModal() {
            document.getElementById('followersModal').classList.remove('active');
        }

        function showLikes(postId) {
            fetch(`/post/${postId}/likes`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('modalTitle').innerText = 'Liked by';
                    const modalContent = document.getElementById('modalContent');
                    modalContent.innerHTML = '';
                    if (data.length === 0) {
                        modalContent.innerHTML = '<li>No likes yet.</li>';
                    } else {
                        data.forEach(user => {
                            modalContent.innerHTML +=
                                `<li><a href="/admin/${user.id}">${user.first_name} ${user.last_name}</a></li>`;
                        });
                    }
                    document.getElementById('infoModal').classList.add('active');
                });
        }

        function showComments(postId) {
            fetch(`/post/${postId}/comments`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('modalTitle').innerText = 'Comments';
                    const modalContent = document.getElementById('modalContent');
                    modalContent.innerHTML = '';

                    if (data.length === 0) {
                        modalContent.innerHTML = '<li>No comments yet.</li>';
                        return;
                    }

                    data.forEach(comment => {
                        let html = `
                            <li>
                                <strong>
                                    <a href="/admin/${comment.user.id}">
                                        ${comment.user.first_name} ${comment.user.last_name}
                                    </a>
                                </strong>: ${comment.body}
                        `;

                        if (comment.replies && comment.replies.length > 0) {
                            html += `<ul style="margin-left:20px; margin-top:6px;">`;
                            comment.replies.forEach(reply => {
                                html += `
                                    <li style="border-left:2px solid #ddd; padding-left:10px; margin-top:4px;">
                                        <strong>
                                            <a href="/admin/${reply.user.id}">
                                                ${reply.user.first_name} ${reply.user.last_name}
                                            </a>
                                        </strong>: ${reply.body}
                                    </li>
                                `;
                            });
                            html += `</ul>`;
                        }

                        html += `</li>`;
                        modalContent.innerHTML += html;
                    });

                    document.getElementById('infoModal').classList.add('active');
                });
        }

        function closeModal() {
            document.getElementById('infoModal').classList.remove('active');
        }
    </script>
@endsection
