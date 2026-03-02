@extends('layouts.app1')

@section('content')
    <br><br><br><br>

    <div class="md:max-w-[580px] mx-auto flex-1 space-y-6">

        <div class="bg-white rounded-xl shadow-sm text-sm font-medium post-item" data-post-id="{{ $post->id }}"
            data-user-id="{{ $post->user->id }}">

            <!-- HEADER -->
            <div class="flex gap-3 sm:p-4 p-2.5 text-sm font-medium">
                <img src="{{ $post->user->image ? asset('storage/' . $post->user->image) : asset('images/avatars/avatar-1.jpg') }}"
                    class="w-10 h-10 rounded-full object-cover">

                <div class="flex-1">
                    <h4 class="text-black">
                        {{ $post->user->first_name }} {{ $post->user->last_name }}
                    </h4>
                    <div class="text-xs text-gray-500">
                        {{ $post->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>

            <!-- CAPTION -->
            @if ($post->content)
                <div class="px-4 pb-2 text-sm">
                    {{ $post->content }}
                </div>
            @endif

            <!-- IMAGE -->
            @if ($post->post_image)
                <div class="relative w-full sm:px-4 media-preview" data-src="{{ asset('storage/' . $post->post_image) }}"
                    data-type="image">
                    <img src="{{ asset('storage/' . $post->post_image) }}" class="w-full rounded-lg object-cover">
                </div>
            @endif

            <!-- LIKE + COMMENT ICONS -->
            <div class="sm:p-4 p-2.5 flex items-center gap-4 text-xs font-semibold">

                <!-- LIKE -->
                <div class="like-section" data-post-id="{{ $post->id }}">
                    @php
                        $isLiked = $post->likes->contains('user_id', auth()->id());
                    @endphp

                    <button class="like-button text-red-500 text-xl">
                        <i class="fa{{ $isLiked ? 's' : 'r' }} fa-heart"></i>
                    </button>

                    <span class="like-count ml-2">
                        {{ $post->likes->count() }}
                    </span>
                </div>

                <!-- COMMENT COUNT -->
                <div class="flex items-center gap-2">
                    <ion-icon class="text-lg" name="chatbubble-ellipses"></ion-icon>
                    <span id="commentCount_{{ $post->id }}">
                        {{ $post->total_comments }}
                    </span>
                </div>
            </div>

            <!-- COMMENTS LIST -->
            <div id="commentList_{{ $post->id }}" data-post-id="{{ $post->id }}"
                class="sm:p-4 p-2.5 border-t space-y-3">

                @foreach ($post->comments->where('parent_id', null) as $comment)
                    <div class="flex flex-col gap-2 comment-item" id="comment_{{ $comment->id }}">

                        <div class="flex items-start gap-3">

                            <img src="{{ $comment->user->image ? asset('storage/' . $comment->user->image) : asset('images/avatars/avatar-1.jpg') }}"
                                class="w-6 h-6 rounded-full">

                            <div class="flex-1">
                                <b>{{ $comment->user->first_name }} {{ $comment->user->last_name }}</b>
                                <p>{{ $comment->body }}</p>

                                <!-- REPLY BUTTON -->
                                <button type="button" class="text-sm text-blue-500 reply-btn"
                                    data-id="{{ $comment->id }}">
                                    Reply ?
                                </button>

                                <!-- REPLY FORM -->
                                <form class="reply-form hidden mt-2" data-comment-id="{{ $comment->id }}">
                                    @csrf
                                    <div class="flex items-center gap-2">
                                        <textarea name="comment" placeholder="Write a reply..." rows="1" class="w-full border rounded px-3 py-1"></textarea>

                                        <button type="submit" class="text-sm bg-blue-500 text-white px-3 py-1 rounded">
                                            Reply
                                        </button>
                                    </div>
                                </form>
                            </div>

                            @if ($comment->user_id == auth()->id())
                                <button type="button" class="text-red-500 text-xs delete-comment"
                                    data-id="{{ $comment->id }}">
                                    <i class="fa-solid fa-trash"></i> Trash
                                </button>
                            @endif
                        </div>

                        <!-- REPLIES -->
                        @foreach ($comment->replies as $reply)
                            <div class="flex items-start gap-3 pl-10" id="comment_{{ $reply->id }}">

                                <img src="{{ $reply->user->image ? asset('storage/' . $reply->user->image) : asset('images/avatars/avatar-1.jpg') }}"
                                    class="w-5 h-5 rounded-full">

                                <div class="flex-1">
                                    <b>{{ $reply->user->first_name }} {{ $reply->user->last_name }}</b>
                                    <p>{{ $reply->body }}</p>
                                </div>

                                @if ($reply->user_id == auth()->id())
                                    <button type="button" class="text-red-500 text-xs delete-comment"
                                        data-id="{{ $reply->id }}">
                                        <i class="fa-solid fa-trash"></i> Trash
                                    </button>
                                @endif
                            </div>
                        @endforeach

                    </div>
                @endforeach
            </div>

            <!-- ADD COMMENT -->
            <form id="commentForm_{{ $post->id }}" data-post-id="{{ $post->id }}">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">

                <div class="sm:px-4 sm:py-3 p-2.5 border-t flex items-center gap-2">

                    <img src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('images/avatars/avatar-1.jpg') }}"
                        class="w-6 h-6 rounded-full">

                    <textarea name="comment" placeholder="Add Comment..." rows="1" class="w-full border rounded px-3 py-1"></textarea>

                    <button type="submit" class="text-sm bg-blue-500 text-white px-4 py-1 rounded">
                        Comment
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection

@section('script')
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        lucide.createIcons()
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('click', '.like-button', function(e) {
            e.preventDefault();

            const button = $(this);
            const postId = button.closest('.like-section').data('post-id');

            $.ajax({
                url: "{{ route('toggle.like') }}",
                method: "POST",
                data: {
                    post_id: postId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    const icon = button.find('i');

                    if (response.status === 'liked') {
                        icon.removeClass('far').addClass('fas text-red-500');
                        icon.addClass('scale-125');
                        setTimeout(() => icon.removeClass('scale-125'), 150);
                    } else {
                        icon.removeClass('fas text-red-500').addClass('far');
                    }

                    button.siblings('.like-count').text(response.likes_count);
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const videos = document.querySelectorAll('.reel-video');

            videos.forEach(video => {
                video.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (this.paused) {
                        this.play();
                    } else {
                        this.pause();
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener('submit', function(e) {
            if (!e.target.matches('form[id^="commentForm_"]')) return;

            e.preventDefault();

            const form = e.target;
            const postId = form.dataset.postId;
            const formData = new FormData(form);

            fetch("{{ route('comments.store') }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const list = document.getElementById(`commentList_${postId}`);

                        list.insertAdjacentHTML('beforeend', `
                <div class="flex items-start gap-3 comment-item" id="comment_${data.comment.id}">
                    <img src="${data.comment.image}" class="w-6 h-6 rounded-full">
                    <div class="flex-1">
                        <b>${data.comment.first_name} ${data.comment.last_name}</b>
                        <p>${data.comment.body}</p>
                    </div>
                    <button class="delete-comment text-red-500 text-xs" data-id="${data.comment.id}">
                        <i class="fa-solid fa-trash"></i> Trash
                    </button>
                </div>
            `);

                        document.getElementById(`commentCount_${postId}`).textContent = data.total_comments;
                        form.reset();
                    }
                });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Delete comment
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('delete-comment')) {
                    let commentId = e.target.dataset.id;
                    let commentEl = document.getElementById('comment_' + commentId);
                    if (!commentEl) return;

                    let commentList = commentEl.closest('[id^="commentList_"]');
                    let postId = commentList ? commentList.dataset.postId : null;

                    // if (!confirm("Are you sure you want to Delete this comment?")) return;

                    // Add smooth slide (wipe) animation
                    commentEl.classList.add('slide-wipe');

                    commentEl.addEventListener('animationend', () => {
                        fetch("{{ route('comments.destroy', '') }}/" + commentId, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    commentEl.remove();

                                    // Update comment count
                                    if (postId && data.total_comments !== undefined) {
                                        const countSpan = document.querySelector(
                                            `#commentCount_${postId}`);
                                        if (countSpan) countSpan.textContent = data
                                            .total_comments;
                                    }
                                } else {
                                    alert(data.message || 'Unable to delete comment.');
                                }
                            })
                            .catch(err => console.error(err));
                    }, {
                        once: true
                    });
                }
            });

            // Toggle reply form
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('reply-btn')) {
                    let commentId = e.target.dataset.id;
                    let form = document.querySelector(`.reply-form[data-comment-id="${commentId}"]`);
                    if (form) form.classList.toggle('hidden');
                }
            });

            // Submit reply using event delegation
            document.addEventListener('submit', function(e) {
                if (e.target.classList.contains('reply-form')) {
                    e.preventDefault();
                    let form = e.target;
                    let postId = form.closest('[id^="commentList_"]').dataset.postId;
                    let parentId = form.dataset.commentId;

                    let formData = new FormData(form);
                    formData.append('parent_id', parentId);
                    formData.append('post_id', postId);

                    fetch("{{ route('comments.store') }}", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": form.querySelector('input[name="_token"]').value,
                                'Accept': 'application/json'
                            },
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                let newReply = `
                        <div class="flex items-start gap-3 relative comment-item" id="comment_${data.comment.id}">
                            <a href="#">
                                <img src="${data.comment.image}" alt="${data.comment.first_name}" class="w-6 h-6 mt-1 rounded-full">
                            </a>
                            <div class="flex-1">
                                <a href="#" class="text-black font-medium inline-block dark:text-white">
                                    ${data.comment.first_name} ${data.comment.last_name}
                                </a>
                                <p class="mt-0.5">${data.comment.body}</p>
                            </div>
                            <button type="button" class="text-red-500 text-xs delete-comment" data-id="${data.comment.id}">
                                <i class="fa-solid fa-trash"></i> Trash
                            </button>
                        </div>
                    `;
                                form.insertAdjacentHTML('beforebegin', newReply);

                                // Update total comment count instantly
                                const countSpan = document.querySelector(`#commentCount_${postId}`);
                                if (countSpan) countSpan.textContent = data.total_comments;

                                form.querySelector('textarea[name="comment"]').value = "";
                                form.classList.add('hidden');
                            }
                        })
                        .catch(err => console.error(err));
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const token = '{{ csrf_token() }}';

            function removePost(postId) {
                const postEl = document.querySelector(`.post-item[data-post-id="${postId}"]`);
                if (postEl) postEl.remove();
            }

            function removeUserPosts(userId) {
                document.querySelectorAll(`.post-item[data-user-id="${userId}"]`).forEach(el => el.remove());
            }

            // Event delegation for all buttons
            document.body.addEventListener('click', function(e) {
                // Find button with dataset.postId or dataset.userId
                const postId = e.target.closest('[data-post-id]')?.dataset.postId;
                const userId = e.target.closest('[data-user-id]')?.dataset.userId;

                // Block Post
                if (e.target.closest('.block-post-btn')) {
                    fetch("{{ route('block.post') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({
                                post_id: postId
                            })
                        })
                        .then(r => r.json())
                        .then(res => {
                            alert(res.message);
                            removePost(postId);
                        });
                }

                // Block User
                if (e.target.closest('.block-user-btn')) {
                    fetch("{{ route('block.user') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({
                                blocked_id: userId
                            })
                        })
                        .then(r => r.json())
                        .then(res => {
                            alert(res.message);
                            removeUserPosts(userId);
                            $('body').fadeOut(200, function() {
                                location.reload();
                            });
                        });
                }

                // Report Post
                if (e.target.closest('.report-post-btn')) {
                    const btn = e.target.closest('.report-post-btn');
                    const postId = btn.dataset.postId;
                    const reason = btn.dataset.reason;

                    fetch("{{ route('report.post') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({
                                post_id: postId,
                                reason: reason
                            })
                        })
                        .then(r => r.json())
                        .then(res => {
                            alert(res.message);
                            // removePost(postId);
                            $('body').fadeOut(200, function() {
                                location.reload();
                            });
                        });
                }

                // Report User
                if (e.target.closest('.report-user-btn')) {
                    const btn = e.target.closest('.report-user-btn');
                    const userId = btn.dataset.userId;
                    const reason = btn.dataset.reason;

                    fetch("{{ route('report.user') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({
                                reported_user_id: userId,
                                reason: reason
                            })
                        })
                        .then(r => r.json())
                        .then(res => {
                            alert(res.message);
                            // removeUserPosts(userId);
                            $('body').fadeOut(200, function() {
                                location.reload();
                            });
                        });
                }

                // Bookmark Post
                if (e.target.closest('.bookmark-btn')) {
                    fetch("{{ route('bookmark') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({
                                post_id: postId
                            })
                        })
                        .then(r => r.json())
                        .then(res => {
                            if (res.status === 'added') alert('Post bookmarked!');
                            else alert('Bookmark removed!');
                        });
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.body.addEventListener('click', async function(e) {
                const btn = e.target.closest('.mute-user-btn');
                if (!btn) return;

                const userId = btn.dataset.userId;
                if (!userId) return;

                if (!confirm('Mute this user?')) return;

                try {
                    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
                    const csrf = tokenMeta ? tokenMeta.getAttribute('content') : '';

                    const res = await fetch(`/mute-user/${userId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json'
                        }
                    });

                    const data = await res.json();

                    if (!res.ok) {
                        alert(data.message || 'Something went wrong');
                        return;
                    }

                    // show message
                    alert(data.message || (data.status === 'muted' ? 'User muted' : 'User unmuted'));

                    // if muted => remove all posts by user immediately
                    if (data.status === 'muted') {
                        document.querySelectorAll(`[data-user-id="${userId}"]`).forEach(el => el
                            .remove());
                    } else if (data.status === 'unmuted') {
                        // unmuted: nothing to do client-side (if you want to re-fetch posts, implement fetch)
                    }
                } catch (err) {
                    console.error(err);
                    alert('Error muting user');
                }
            });
        });
    </script>

    <script>
        function copyUserLink(userId) {
            // Automatically detect website base URL
            const baseUrl = window.location.origin;
            const profileLink = `${baseUrl}/user/${userId}`;

            // Copy to clipboard
            navigator.clipboard.writeText(profileLink)
                .then(() => {
                    alert('Link copied successfully!');
                })
                .catch(() => {
                    alert('Failed to copy link.');
                });
        }
    </script>

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
            if (!confirm('Are you sure to unfriend this user?')) return;

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
                    }
                })
                .catch(() => alert("Network error"));
        }
    </script>

    <script>
        // Preview uploaded Status image
        document.getElementById('uploadStatusImage').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                const preview = document.getElementById('createStatusImage');
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            }
        });
    </script>

    <script>
        document.getElementById('statusForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const formData = new FormData(form);
            const btn = form.querySelector('button[type="submit"]');

            btn.disabled = true;
            btn.innerText = "Uploading...";

            fetch("{{ route('status.store') }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    btn.disabled = false;
                    btn.innerText = "Create";

                    if (data.success) {
                        // Close modal
                        UIkit.modal('#create-story').hide();

                        // Optional toast
                        UIkit.notification({
                            message: '<span class="text-white">Status uploaded successfully!</span>',
                            status: 'success',
                            pos: 'top-right',
                            timeout: 2000
                        });

                        // Slight reload to show the new status
                        $('body').fadeOut(200, function() {
                            location.reload();
                        });
                    } else {
                        UIkit.notification({
                            message: '<span class="text-white">' + (data.message ||
                                'Something went wrong') + '</span>',
                            status: 'danger',
                            pos: 'top-right'
                        });
                    }
                })
                .catch(err => {
                    btn.disabled = false;
                    btn.innerText = "Create";
                    console.error(err);
                    UIkit.notification({
                        message: '<span class="text-white">Upload failed. Check console.</span>',
                        status: 'danger',
                        pos: 'top-right'
                    });
                });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const loadMoreBtn = document.getElementById('loadMoreBtn');
            const wrapper = document.getElementById('loadMoreWrapper');
            if (!loadMoreBtn) return;

            loadMoreBtn.addEventListener('click', function() {

                const page = this.dataset.nextPage;

                // Save scroll position
                const scrollY = window.scrollY;

                fetch(`{{ route('feed') }}?page=${page}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.text())
                    .then(html => {

                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        const newPosts = doc.querySelectorAll('.post-item');
                        const container = document.getElementById('post-container');

                        newPosts.forEach(post => wrapper.before(post));

                        // Restore scroll position
                        window.scrollTo({
                            top: scrollY,
                            behavior: 'instant'
                        });

                        const newBtn = doc.getElementById('loadMoreBtn');
                        if (newBtn) {
                            loadMoreBtn.dataset.nextPage = newBtn.dataset.nextPage;
                        } else {
                            loadMoreBtn.remove();
                        }
                    });
            });
        });
    </script>

    <script>
        document.getElementById('post-container').addEventListener('click', function(e) {

            const media = e.target.closest('.media-preview');
            if (!media) return;

            const src = media.dataset.src;
            const type = media.dataset.type;

            const modal = document.getElementById('mediaModal');
            const content = document.getElementById('modalContent');

            content.innerHTML = '';

            if (type === 'video') {
                content.innerHTML = `
        <video controls autoplay class="w-full max-h-[90vh] rounded-lg">
            <source src="${src}">
        </video>
    `;
            } else {
                content.innerHTML = `
        <img src="${src}" class="max-w-full max-h-[90vh] object-contain rounded-lg mx-auto block">
    `;
            }

            modal.classList.remove('hidden');
        });

        // Close modal
        document.getElementById('closeModal').addEventListener('click', () => {
            closeMediaModal();
        });

        document.getElementById('mediaModal').addEventListener('click', function(e) {
            if (e.target === this) closeMediaModal();
        });

        function closeMediaModal() {
            const modal = document.getElementById('mediaModal');
            const content = document.getElementById('modalContent');

            modal.classList.add('hidden');
            content.innerHTML = '';
        }
    </script>

    {{-- <script>
        // Disable right-click
        document.addEventListener("contextmenu", function(e) {
            e.preventDefault();
        }, false);

        // Disable Ctrl+U, Ctrl+Shift+I, Ctrl+Shift+C, Ctrl+Shift+J, F12
        document.addEventListener("keydown", function(e) {
            // Ctrl+U or Ctrl+Shift+I or Ctrl+Shift+C or Ctrl+Shift+J
            if (
                (e.ctrlKey && e.key === "u") || (e.ctrlKey && e.key === "U") ||
                (e.ctrlKey && e.shiftKey && ["I", "C", "J"].includes(e.key)) ||
                e.key === "F12"
            ) {
                e.preventDefault();
            }
        });
    </script> --}}

    <script>
        function copyPostLink(postId) {
            let url = "{{ url('/user/post') }}/" + postId;

            navigator.clipboard.writeText(url).then(function() {
                alert("Post link copied successfully!");
            }).catch(function(err) {
                alert("Failed to copy link");
            });
        }
    </script>
@endsection

@section('css')
    <style>
        .sidebar-scroll {
            max-height: calc(100vh - 100px);
            overflow-y: auto;
            overflow-x: hidden;

            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .sidebar-scroll::-webkit-scrollbar {
            display: none;
        }

        .inner-scroll {
            max-height: 300px;
            overflow-y: auto;
            overflow-x: hidden;

            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE/Edge */
        }

        .inner-scroll::-webkit-scrollbar {
            display: none;
            /* Chrome/Safari */
        }
    </style>

    <style>
        .side-list::-webkit-scrollbar {
            width: 6px;
        }

        .side-list::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }
    </style>

    <style>
        .stories_status {
            margin: 0 5px;
        }

        .floating-chat {
            border: 2px solid black;
            background: white;
            width: 10%;
            height: 50px;
            position: fixed;
            bottom: 50px;
            right: 50px;
            border-radius: 30px;
            z-index: 999;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background 0.6s ease;
        }

        /* TARGET the generated SVG and force black */
        .floating-chat svg,
        .floating-chat svg * {
            stroke: #000 !important;
            fill: none;
            /* Lucide icons are outline by default */
            margin: 0 5px;
        }

        .floating-chat:hover svg,
        .floating-chat:hover svg * {
            stroke: #fff !important;
            fill: #fff !important;
            /* if you want solid fill */
        }

        .floating-chat:hover {
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: white;
            /* so text + icon are visible on gradient */
        }
    </style>

    <style>
        .trending-text {
            font-weight: bold;
            font-size: 1rem;
            background: linear-gradient(270deg, #ff6ec4, #7873f5, #42d392, #fdd835);
            background-size: 800% 800%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientMove 1s ease infinite;
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }
    </style>

    <style>
        @keyframes slideWipe {
            0% {
                transform: translateX(0);
                opacity: 1;
            }

            100% {
                transform: translateX(100px);
                opacity: 0;
            }
        }

        .slide-wipe {
            animation: slideWipe 0.4s ease-in-out forwards;
        }
    </style>

    <style>
        /* Hide scrollbar but keep scroll */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            /* IE & Edge */
            scrollbar-width: none;
            /* Firefox */
        }

        .user-avatar {
            position: relative;
            display: inline-block;
        }

        .user-status-icon {
            position: absolute;
            left: 50%;
            bottom: -13px;
            /* distance below image */
            transform: translateX(-50%);
            font-size: 16px;
            color: #2563eb;
        }
    </style>
@endsection
