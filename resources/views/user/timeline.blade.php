@extends('layouts.app1')

@section('')
    <!-- main contents -->
    <main id="site__main" class="2xl:ml-[--w-side]  xl:ml-[--w-side-sm] p-2.5 h-[calc(100vh-var(--m-top))] mt-[--m-top]">
        <div class="max-w-[1065px] mx-auto max-lg:-m-2.5">
            <!-- cover  -->
            <div class="bg-white shadow lg:rounded-b-2xl lg:-mt-10 dark:bg-dark2">

                <!-- cover -->
                <div class="relative overflow-hidden w-full lg:h-72 h-48">
                    <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('assets/images/avatars/profile-cover.jpg') }}"
                        alt="Cover Photo" class="h-full w-full object-cover inset-0">
                    <!-- overly -->
                    <div class="w-full bottom-0 absolute left-0 bg-gradient-to-t from-black/60 pt-20 z-10"></div>
                </div>

                <!-- user info -->
                <div class="p-3">

                    <div class="flex flex-col justify-center md:items-center lg:-mt-48 -mt-28">

                        <div class="relative lg:h-48 lg:w-48 w-28 h-28 mb-4 z-10">
                            {{-- <button type="button"
                                class="absolute -bottom-3 left-1/2 -translate-x-1/2 bg-white shadow p-1.5 rounded-full sm:flex hidden">
                                <ion-icon name="camera" class="text-2xl md hydrated" role="img"
                                    aria-label="camera"></ion-icon></button> --}}
                        </div>

                        <h3 class="md:text-3xl text-base font-bold text-black dark:text-white"> {{ $user->first_name }}
                            {{ $user->last_name }} </h3>

                        <p class="mt-2 text-gray-500 dark:text-white/80"> {{ $user->pronouns }} </p>
                    </div>
                </div>
            </div>

            <div class="flex 2xl:gap-12 gap-10 mt-8 max-lg:flex-col" id="js-oversized">
                <!-- feed story -->
                <div class="flex-1 xl:space-y-6 space-y-3">
                    <!--  post image-->
                    @foreach ($all_posts as $post)
                        <div class="bg-white rounded-xl shadow-sm text-sm font-medium border1 dark:bg-dark2">

                            <!-- Post heading -->
                            <div class="flex gap-3 sm:p-4 p-2.5 text-sm font-medium">
                                <a href="#">
                                    <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('images/avatars/avatar-1.jpg') }}"
                                        alt="" class="w-9 h-9 rounded-full">
                                </a>
                                <div class="flex-1">
                                    <a href="#">
                                        <h4 class="text-black dark:text-white">{{ $user->first_name }}
                                            {{ $user->last_name }}</h4>
                                    </a>
                                    <div class="text-xs text-gray-500 dark:text-white/80">
                                        {{ $post->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>

                            <!-- Post image -->
                            @if ($post->post_image)
                                @php
                                    $fileExtension = pathinfo($post->post_image, PATHINFO_EXTENSION);
                                    $isVideo = in_array(strtolower($fileExtension), ['mp4', 'mov', 'avi', 'webm']);
                                @endphp

                                <div class="relative w-full lg:h-96 h-full sm:px-4">
                                    @if ($isVideo)
                                        <video controls class="sm:rounded-lg w-full h-full object-cover">
                                            <source src="{{ asset('storage/' . $post->post_image) }}"
                                                type="video/{{ $fileExtension }}">
                                            Your browser does not support the video tag.
                                        </video>
                                    @else
                                        <img src="{{ asset('storage/' . $post->post_image) }}" alt="Image Not Found"
                                            class="sm:rounded-lg w-full h-full object-cover">
                                    @endif
                                </div>
                            @endif

                            <!-- Post icons -->
                            <div class="sm:p-4 p-2.5 flex items-center gap-4 text-xs font-semibold">
                                <!-- Like button with count -->
                                <div x-data="{ open: false }">
                                    <div class="flex items-center gap-2.5">
                                        <!-- Heart Button -->
                                        <button @click="open = true" type="button"
                                            class="button-icon text-red-500 bg-red-100 dark:bg-slate-700">
                                            <ion-icon class="text-lg" name="heart"></ion-icon>
                                        </button>

                                        <!-- Likes count (also opens modal) -->
                                        <a href="javascript:void(0);" @click="open = true">
                                            {{ $post->likes->count() }}
                                        </a>
                                    </div>

                                    <!-- Modal -->
                                    <div x-show="open" x-transition
                                        class="fixed inset-0 flex items-center justify-center z-50" style="display: none;">
                                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-96 p-5">
                                            <div class="flex justify-between items-center mb-3">
                                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Liked by
                                                </h2>
                                                <button @click="open = false"
                                                    class="text-gray-500 hover:text-gray-700">&times;</button>
                                            </div>

                                            <!-- List of users who liked -->
                                            <ul class="space-y-3">
                                                @forelse($post->likes as $like)
                                                    <li class="flex items-center gap-3">
                                                        <img src="{{ $like->user->image ? asset('storage/' . $like->user->image) : asset('images/avatars/avatar-1.jpg') }}"
                                                            class="w-8 h-8 rounded-full" alt="User">
                                                        <span class="text-gray-800 dark:text-gray-200">
                                                            {{ $like->user->first_name }} {{ $like->user->last_name }}
                                                        </span>
                                                    </li>
                                                @empty
                                                    <li class="text-gray-600 dark:text-gray-400 text-sm">No likes yet</li>
                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <button type="button" class="button-icon bg-slate-200/70 dark:bg-slate-700">
                                        <ion-icon class="text-lg" name="chatbubble-ellipses"></ion-icon>
                                    </button>
                                    <span>{{ $post->comments->count() }}</span>
                                </div>
                            </div>

                            <div class="sm:p-4 p-2.5 border-t border-gray-100 font-normal space-y-3 relative dark:border-slate-700/40"
                                x-data="{ showAll: false }">

                                @forelse ($post->comments as $index => $comment)
                                    <div class="flex items-start gap-3 relative" @class(['hidden' => $index > 1 && !request()->ajax()])
                                        x-show="showAll || {{ $index < 2 ? 'true' : 'false' }}" x-transition>

                                        <a href="#">
                                            <img src="{{ $comment->user->image ? asset('storage/' . $comment->user->image) : asset('images/avatars/avatar-1.jpg') }}"
                                                alt="{{ $comment->user->name }}" class="w-6 h-6 mt-1 rounded-full">
                                        </a>
                                        <div class="flex-1">
                                            <a href="#" class="text-black font-medium inline-block dark:text-white">
                                                {{ $comment->user->first_name }} {{ $comment->user->last_name }}
                                            </a>
                                            <p class="mt-0.5"> {{ $comment->body }} </p>

                                            {{-- Replies --}}
                                            @foreach ($comment->replies as $reply)
                                                <div class="flex items-start gap-3 ml-6 mt-2">
                                                    <a href="#">
                                                        <img src="{{ $reply->user->image ? asset('storage/' . $reply->user->image) : asset('images/avatars/avatar-1.jpg') }}"
                                                            alt="{{ $reply->user->name }}"
                                                            class="w-5 h-5 mt-1 rounded-full">
                                                    </a>
                                                    <div class="flex-1">
                                                        <a href="#"
                                                            class="text-black font-medium inline-block dark:text-white">
                                                            {{ $reply->user->first_name }} {{ $reply->user->last_name }}
                                                        </a>
                                                        <p class="mt-0.5">{{ $reply->body }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500">No comments yet.</p>
                                @endforelse

                                @if ($post->comments->count() > 2)
                                    <button @click="showAll = !showAll"
                                        class="flex items-center gap-1.5 text-gray-500 hover:text-blue-500 mt-2"
                                        x-show="!showAll">
                                        <ion-icon name="chevron-down-outline"
                                            class="ml-auto duration-200 group-aria-expanded:rotate-180"></ion-icon>
                                        More Comments
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <!-- placeholder -->
                    <div class="rounded-xl shadow-sm p-4 space-y-4 bg-slate-200/40 animate-pulse border1 dark:bg-dark2">
                        <div class="flex gap-3">
                            <div class="w-9 h-9 rounded-full bg-slate-300/20"></div>
                            <div class="flex-1 space-y-3">
                                <div class="w-40 h-5 rounded-md bg-slate-300/20"></div>
                                <div class="w-24 h-4 rounded-md bg-slate-300/20"></div>
                            </div>
                            <div class="w-6 h-6 rounded-full bg-slate-300/20"></div>
                        </div>

                        <div class="w-full h-52 rounded-lg bg-slate-300/10 my-3"> </div>

                        <div class="flex gap-3">
                            <div class="w-16 h-5 rounded-md bg-slate-300/20"></div>
                            <div class="w-14 h-5 rounded-md bg-slate-300/20"></div>
                            <div class="w-6 h-6 rounded-full bg-slate-300/20 ml-auto"></div>
                            <div class="w-6 h-6 rounded-full bg-slate-300/20  "></div>
                        </div>
                    </div>
                </div>

                <!-- sidebar -->

                <div class="lg:w-[400px]">

                    <div class="lg:space-y-4 lg:pb-8 max-lg:grid sm:grid-cols-2 max-lg:gap-6"
                        uk-sticky="media: 1024; end: #js-oversized; offset: 80">

                        <div class="box p-5 px-6">

                            <div class="flex items-ce justify-between text-black dark:text-white">
                                <h3 class="font-bold text-lg"> Intro </h3>
                            </div>

                            <ul class="text-gray-700 space-y-4 mt-4 text-sm dark:text-white/80">

                                @if (!empty($user->address))
                                    <li class="flex items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                        </svg>
                                        <div>
                                            Live In <span
                                                class="font-semibold text-black dark:text-white">{{ $user->address }}</span>
                                        </div>
                                    </li>
                                @endif

                                @if (!empty($user->relationship))
                                    <li class="flex items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                        </svg>
                                        <div><span class="font-semibold text-black dark:text-white">
                                                {{ $user->relationship }}
                                            </span>
                                        </div>
                                    </li>
                                @endif

                                <li class="flex items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12.75 19.5v-.75a7.5 7.5 0 00-7.5-7.5H4.5m0-6.75h.75c7.87 0 14.25 6.38 14.25 14.25v.75M6 18.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                    </svg>

                                    <div> Friends
                                        <span class="font-semibold text-black dark:text-white">
                                            {{-- {{ $authFriendCount }} People --}}
                                            {{ $friends->count() }} People
                                        </span>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="box p-5 px-6">
                            {{-- <div class="flex items-ce justify-between text-black dark:text-white">
                                <h3 class="font-bold text-lg">
                                    Friends
                                    <span class="block text-sm text-gray-500 mt-0.5 font-normal dark:text-white">
                                        {{ $friends->count() }} Friends
                                    </span>
                                </h3>
                            </div> --}}

                            <div class="grid grid-cols-3 gap-2 gap-y-5 text-center text-sm mt-4 mb-2">
                                @forelse ($friends as $friend)
                                    <div>
                                        <div class="relative w-full aspect-square rounded-full overflow-hidden">
                                            <img src="{{ $friend->image ? asset('storage/' . $friend->image) : asset('images/avatars/avatar-1.jpg') }}"
                                                alt="Image Not Found" class="object-cover w-full h-full inset-0">
                                        </div>
                                        <div class="mt-2 line-clamp-1">
                                            {{ $friend->first_name }} {{ $friend->last_name }}
                                        </div>
                                    </div>
                                @empty
                                    <p class="col-span-3 text-gray-500 dark:text-gray-300 text-sm text-center">
                                        No friends yet.
                                    </p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Groups You Manage  -->
                        {{-- <div class="bg-white rounded-xl shadow p-5 px-6 border1 dark:bg-dark2">

                            <div class="flex items-baseline justify-between text-black dark:text-white">
                                <h3 class="font-bold text-base"> Suggested Manage </h3>
                                <a href="#" class="text-sm text-blue-500">See all</a>
                            </div>

                            <div class="side-list">

                                <div class="side-list-item">
                                    <a href="timeline-group.html">
                                        <img src="assets/images/avatars/avatar-2.jpg" alt=""
                                            class="side-list-image rounded-full">
                                    </a>
                                    <div class="flex-1">
                                        <a href="timeline-group.html">
                                            <h4 class="side-list-title"> John Michael</h4>
                                        </a>
                                        <div class="side-list-info"> Updated 6 day ago </div>
                                    </div>
                                    <button class="button bg-primary-soft dark:text-white">Like</button>
                                </div>
                                <div class="side-list-item">
                                    <a href="timeline-group.html">
                                        <img src="assets/images/avatars/avatar-4.jpg" alt=""
                                            class="side-list-image rounded-full">
                                    </a>
                                    <div class="flex-1">
                                        <a href="timeline-group.html">
                                            <h4 class="side-list-title"> Martin Gray</h4>
                                        </a>
                                        <div class="side-list-info"> Updated 2 month ago </div>
                                    </div>
                                    <button class="button bg-primary-soft dark:text-white">Like</button>
                                </div>
                                <div class="side-list-item">
                                    <a href="timeline-group.html">
                                        <img src="assets/images/avatars/avatar-3.jpg" alt=""
                                            class="side-list-image rounded-full">
                                    </a>
                                    <div class="flex-1">
                                        <a href="timeline-group.html">
                                            <h4 class="side-list-title"> Monroe Parker</h4>
                                        </a>
                                        <div class="side-list-info"> Updated 1 week ago </div>
                                    </div>
                                    <button class="button bg-primary-soft dark:text-white">Like</button>
                                </div>
                                <div class="side-list-item">
                                    <a href="timeline-group.html">
                                        <img src="assets/images/avatars/avatar-1.jpg" alt=""
                                            class="side-list-image rounded-full">
                                    </a>
                                    <div class="flex-1">
                                        <a href="timeline-group.html">
                                            <h4 class="side-list-title"> Jesse Steeve</h4>
                                        </a>
                                        <div class="side-list-info"> Updated 2 day ago </div>
                                    </div>
                                    <button class="button bg-primary-soft dark:text-white">Like</button>
                                </div>

                            </div>

                            <button
                                class="bg-secondery w-full text-black py-1.5 font-medium px-3.5 rounded-md text-sm mt-2 dark:text-white">See
                                all</button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </main>
    </div>
@endsection

@section('content')
    <!-- main contents -->
    <main class="max-w-4xl mx-auto mt-[--m-top] p-4">
        <!-- j profile starts here -->
        <div class="bg-white rounded-2xl shadow-lg p-6 dark:bg-dark2">

            {{-- Top Profile Section --}}
            <div class="flex flex-col items-center text-center">
                <div class="w-28 h-28 rounded-full overflow-hidden shadow-lg">
                    <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('images/avatars/avatar-1.jpg') }}"
                        alt="Profile Picture" class="w-full h-full object-cover">
                </div>

                <h2 class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $user->first_name }} {{ $user->last_name }}
                </h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm">
                    {{ $user->bio ?? 'Holistic wellness enthusiast. Sharing positive vibes & healthy habits.' }}
                </p>
            </div>

            {{-- Stats --}}
            <div class="flex justify-center gap-6 mt-6">
                <div class="text-center">
                    <p class="text-xl font-bold text-indigo-600">{{ $authFriendCount ?? '0' }}</p>
                    <p class="text-sm text-gray-500">Friends</p>
                </div>
                <div class="text-center">
                    <p class="text-xl font-bold text-indigo-600">{{ $posts_count ?? '0' }}</p>
                    <p class="text-sm text-gray-500">Posts</p>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex justify-center gap-3 mt-6">
                <button
                    class="border border-gray-300 px-5 py-2 rounded-full font-medium text-gray-700 hover:bg-gray-100 transition"
                    onclick="copyProfileLink({{ auth()->user()->id }})">
                    Share Profile
                </button>
            </div>

            {{-- Tabs --}}
            <div class="flex justify-center gap-4 mt-8 border-b pb-2">
                <button class="text-indigo-600 font-semibold border-b-2 border-indigo-600 pb-1">Posts</button>
                <button class="text-gray-500 hover:text-indigo-600 transition">Tweets</button>
            </div>

            {{-- POSTS GRID --}}
            <div class="grid sm:grid-cols-3 gap-4 mt-6">
                @forelse($all_posts as $post)
                    <div class="rounded-xl overflow-hidden shadow bg-white p-3">

                        {{-- POST MEDIA --}}
                        @php
                            $ext = pathinfo($post->post_image, PATHINFO_EXTENSION);
                            $isVideo = in_array(strtolower($ext), ['mp4', 'mov', 'avi', 'webm']);
                        @endphp

                        @if ($post->post_image)
                            @if ($isVideo)
                                <video controls class="w-full h-40 rounded-lg object-cover">
                                    <source src="{{ asset('storage/' . $post->post_image) }}">
                                </video>
                            @else
                                <img src="{{ asset('storage/' . $post->post_image) }}"
                                    class="w-full h-40 rounded-lg object-cover">
                            @endif
                        @endif

                        {{-- LIKE + COMMENT BUTTONS --}}
                        <div class="flex items-center gap-6 mt-3 text-sm text-gray-700">

                            <div x-data="{ open: false }" class="flex items-center gap-2">

                                <button type="button" @click="open=true"
                                    class="button-icon bg-red-100 text-red-600 hover:bg-red-200 rounded-full p-2 transition">
                                    <ion-icon class="text-lg" name="heart"></ion-icon>
                                </button>

                                <span>{{ $post->likes->count() }}</span>

                                {{-- LIKE POPUP --}}
                                <div x-show="open" x-transition
                                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
                                    style="display:none">

                                    <div class="bg-white rounded-2xl w-full max-w-xl h-[70vh] flex flex-col">

                                        <div class="flex justify-between items-center px-6 py-4 border-b">
                                            <h2 class="font-semibold text-lg">Liked by</h2>
                                            <button @click="open=false" class="text-2xl">&times;</button>
                                        </div>

                                        <div class="flex-1 overflow-y-auto px-6 py-4 space-y-4">
                                            @forelse($post->likes as $like)
                                                <div class="flex items-center gap-4">
                                                    <img src="{{ $like->user->image ? asset('storage/' . $like->user->image) : asset('images/avatars/avatar-1.jpg') }}"
                                                        class="w-10 h-10 rounded-full">
                                                    <span class="font-medium">
                                                        {{ $like->user->first_name }} {{ $like->user->last_name }}
                                                    </span>
                                                </div>
                                            @empty
                                                <p class="text-center text-gray-500">No likes yet</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div x-data="{ open: false }" class="flex items-center gap-2">
                                <button type="button" @click="open=true"
                                    class="button-icon bg-blue-100 text-blue-600 hover:bg-blue-200 rounded-full p-2 transition">
                                    <ion-icon class="text-lg" name="chatbubble-ellipses"></ion-icon>
                                </button>

                                <span>
                                    {{ $post->comments->count() + $post->comments->sum(fn($c) => $c->replies->count()) }}
                                </span>

                                {{-- COMMENT POPUP --}}
                                <div x-show="open" x-transition
                                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
                                    style="display:none">

                                    <div class="bg-white rounded-2xl w-full max-w-2xl h-[80vh] flex flex-col">

                                        <div class="flex justify-between items-center px-6 py-4 border-b">
                                            <h2 class="font-semibold text-lg">Comments</h2>
                                            <button @click="open=false" class="text-2xl">&times;</button>
                                        </div>

                                        <div class="flex-1 overflow-y-auto px-6 py-4 space-y-6">

                                            @forelse($post->comments as $comment)
                                                {{-- COMMENT --}}
                                                <div>
                                                    <div class="flex gap-4">
                                                        <img src="{{ $comment->user->image ? asset('storage/' . $comment->user->image) : asset('images/avatars/avatar-1.jpg') }}"
                                                            class="w-9 h-9 rounded-full">

                                                        <div class="bg-gray-100 rounded-xl px-4 py-2 w-full">
                                                            <p class="text-sm font-semibold">
                                                                {{ $comment->user->first_name }}
                                                                {{ $comment->user->last_name }}
                                                            </p>
                                                            <p class="text-sm">{{ $comment->body }}</p>
                                                        </div>
                                                    </div>

                                                    {{-- REPLIES --}}
                                                    @if ($comment->replies->count())
                                                        <div class="ml-14 mt-3 space-y-3 border-l pl-4">
                                                            @foreach ($comment->replies as $reply)
                                                                <div class="flex gap-3">
                                                                    <img src="{{ $reply->user->image ? asset('storage/' . $reply->user->image) : asset('images/avatars/avatar-1.jpg') }}"
                                                                        class="w-7 h-7 rounded-full">

                                                                    <div class="bg-gray-50 rounded-xl px-3 py-2 w-full">
                                                                        <p class="text-xs font-semibold">
                                                                            {{ $reply->user->first_name }}
                                                                            {{ $reply->user->last_name }}
                                                                        </p>
                                                                        <p class="text-xs">{{ $reply->body }}</p>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            @empty
                                                <p class="text-center text-gray-500">No comments yet</p>
                                            @endforelse

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="col-span-3 text-center text-gray-500">
                        No posts yet
                    </p>
                @endforelse
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>
        function copyProfileLink(userId) {
            // Generate the URL using current website origin
            const profileLink = `${window.location.origin}/user/${userId}`;

            // Copy to clipboard
            navigator.clipboard.writeText(profileLink).then(() => {
                alert("Profile link copied to clipboard!");
            }).catch(err => {
                console.error("Could not copy text: ", err);
            });
        }
    </script>
@endsection
