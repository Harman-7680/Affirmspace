@extends('layouts.app1')

@section('title')
    User Profile
@endsection

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

    <br><br><br>

    <div style="max-width:800px; margin:auto; padding:15px;">
        <!-- Profile Header -->
        <div
            style="background:white; padding:15px; border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.1); margin-bottom:20px;">

            <div style="display:flex; justify-content:space-between; align-items:center;">

                <!-- User Info -->
                <div style="display:flex; align-items:center; gap:15px;">

                    <img src="{{ $userProfile->image && $userProfile->image !== '0'
                        ? asset('storage/' . $userProfile->image)
                        : asset('images/avatars/avatar-1.jpg') }}"
                        style="width:70px; height:70px; border-radius:50%; object-fit:cover;">

                    <div>
                        <h2 style="font-size:20px; font-weight:bold;">
                            {{ $userProfile->first_name }} {{ $userProfile->last_name }}
                        </h2>
                    </div>
                </div>

                <!-- Followers Count -->
                <div>
                    Followers:
                    <strong>{{ $followersCount }}</strong>
                </div>
            </div>
        </div>

        <!-- Posts Section -->
        <div>
            @if ($isPrivate)
                <p style="text-align:center; color:#777; font-size:16px; margin-top:40px;">
                    This account is private. You cannot view their posts.
                </p>
            @else
                <div style="
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    ">
                    @forelse ($posts as $post)
                        <div
                            style="background:white; padding:12px; border-radius:6px; box-shadow:0 1px 5px rgba(0,0,0,0.08);">

                            <!-- Media -->
                            @php
                                $mediaPath = $post->post_image;
                                $ext = strtolower(pathinfo($mediaPath, PATHINFO_EXTENSION));
                                $imgExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                                $vidExt = ['mp4', 'webm', 'ogg'];
                            @endphp

                            @if (in_array($ext, $imgExt))
                                <img src="{{ asset('storage/' . $mediaPath) }}"
                                    style="width:100%; height:180px; object-fit:cover; border-radius:5px; margin-bottom:8px;">
                            @elseif(in_array($ext, $vidExt))
                                <video controls
                                    style="width:100%; height:180px; object-fit:cover; border-radius:5px; margin-bottom:8px;">
                                    <source src="{{ asset('storage/' . $mediaPath) }}">
                                </video>
                            @endif

                            <!-- Caption -->
                            @if ($post->caption)
                                <p>{{ $post->caption }}</p>
                            @endif

                            <!-- Timestamp -->
                            <p style="color:#777; font-size:13px; margin-top:4px;">
                                {{ $post->created_at->diffForHumans() }}
                            </p>

                            <div class="flex items-center justify-start mt-3 space-x-4 text-sm text-gray-600">

                                <!-- Likes -->
                                <div class="flex items-center gap-2.5">
                                    <button type="button" {{-- onclick="showLikes({{ $post->id }})" --}}
                                        class="button-icon bg-red-100 text-red-500 hover:bg-red-200 transition rounded-full p-2">
                                        <ion-icon class="text-lg" name="heart"></ion-icon>
                                    </button>
                                    <span class="text-gray-700 hover:underline cursor-pointer"
                                        onclick="showLikes({{ $post->id }})">
                                        {{ $post->likes_count }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-2 cursor-pointer">
                                    <button type="button" {{-- onclick="showComments({{ $post->id }})" --}}
                                        class="button-icon bg-blue-100 text-blue-600 hover:bg-blue-200 transition rounded-full p-2">
                                        <ion-icon class="text-lg" name="chatbubble-ellipses"></ion-icon>
                                    </button>
                                    <span>{{ $post->comments_count }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p style="text-align:center; color:#777;">No posts yet.</p>
                    @endforelse
                </div>
            @endif
        </div>
    </div>

    <!-- Modal -->
    <div id="infoModal"
        style="position:fixed; inset:0; background:rgba(0,0,0,0.5);
            display:none; justify-content:center; align-items:center; z-index:999;">

        <div style="background:white; padding:20px; width:350px; border-radius:6px; position:relative;">
            <span onclick="closeModal()" style="position:absolute; right:10px; top:5px; cursor:pointer; font-size:20px;">
                &times;
            </span>

            <h3 id="modalTitle" style="margin-bottom:10px;">Details</h3>
            <ul id="modalContent" style="list-style:none; padding-left:10px;"></ul>
        </div>
    </div>
@endsection

@section('script')
    <!-- Ionicons for icons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script>
        function showLikes(id) {
            fetch(`/post/${id}/likes`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById("modalTitle").innerText = "Liked By";
                    let box = document.getElementById("modalContent");
                    box.innerHTML = "";

                    if (data.length === 0) {
                        box.innerHTML = "<li>No likes yet</li>";
                    } else {
                        data.forEach(u => {
                            box.innerHTML += "<li>" + u.first_name + " " + u.last_name + "</li>";
                        });
                    }
                    openModal();
                });
        }

        function showComments(id) {
            fetch(`/post/${id}/comments`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById("modalTitle").innerText = "Comments";
                    let box = document.getElementById("modalContent");
                    box.innerHTML = "";

                    if (data.length === 0) {
                        box.innerHTML = "<li>No comments yet</li>";
                    } else {
                        data.forEach(c => {
                            let replyHtml = "";
                            if (c.replies) {
                                c.replies.forEach(r => {
                                    replyHtml +=
                                        "<div style='margin-left:10px; font-size:12px; color:#555;'>" +
                                        "<strong>" + r.user.first_name + "</strong>: " + r.body +
                                        "</div>";
                                });
                            }
                            box.innerHTML += "<li><strong>" + c.user.first_name +
                                "</strong>: " + c.body + replyHtml + "</li>";
                        });
                    }
                    openModal();
                });
        }

        function openModal() {
            document.getElementById("infoModal").style.display = "flex";
        }

        function closeModal() {
            document.getElementById("infoModal").style.display = "none";
        }
    </script>
@endsection
