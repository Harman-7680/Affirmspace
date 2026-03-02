@php use Illuminate\Support\Str; @endphp

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

@extends('layouts.app1')

@section('title')
    Home Page
@endsection

@section('content')
    <a href="{{ route('messages') }}" class="floating-chat">
        <!-- <i data-lucide="message-square" class="w-6 h-6 text-black"></i> -->
        <i data-lucide="message-square" class="w-6 h-6 ms-3" style="color: black !important;"></i>
        Message
    </a>
    <!-- main contents -->
    <main id="site__main" class="2xl:ml-[--w-side]  xl:ml-[--w-side-sm] p-2.5 h-[calc(100vh-var(--m-top))] mt-[--m-top]">

        <!-- timeline -->
        <div class="lg:flex 2xl:gap-16 gap-12 max-w-[1065px] mx-auto" id="js-oversized">
            <div class="max-w-[680px] mx-auto">
                <div class="mb-8">
                    <h3 class="font-extrabold text-2xl  text-black dark:text-white">Stories</h3>
                    <div class="relative" tabindex="-1" uk-slider="auto play: true;finite: true" uk-lightbox="">
                        <div class="py-5 uk-slider-container">
                            <ul class="uk-slider-items w-[calc(100%+14px)]"
                                uk-scrollspy="target: > li; cls: uk-animation-scale-up; delay: 20;repeat:true">
                                <li class="md:pr-3" uk-scrollspy-class="uk-animation-fade">
                                    <div class="md:w-20 md:h-20 w-20 h-20 rounded-full relative border-2 border-dashed grid place-items-center bg-slate-200 border-slate-300 dark:border-slate-700 dark:bg-dark2 shrink-0"
                                        uk-toggle="target: #create-story">
                                        <ion-icon name="camera" class="text-2xl"></ion-icon>
                                    </div>
                                </li>

                                <!-- USER STATUSES LOOP -->
                                @foreach ($statuses as $userId => $userStatuses)
                                    @php
                                        $firstStatus = $userStatuses->first();
                                        $user = $firstStatus->user;
                                    @endphp

                                    <li class="pr-[12px] hover:scale-[1.15] hover:-rotate-2 duration-300 stories_status">
                                        <a href="{{ asset('storage/' . $firstStatus->image) }}"
                                            data-caption="{{ $user->first_name }}" data-type="image"
                                            data-uk-lightbox="animation: slide">

                                            <div
                                                class="md:w-20 md:h-20 w-20 h-20 relative md:border-4 border-2 shadow border-white rounded-full overflow-hidden dark:border-slate-700">
                                                <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('images/avatars/avatar-1.jpg') }}"
                                                    alt="" class="absolute w-full h-full object-cover">
                                            </div>
                                        </a>

                                        {{-- <h6 class="text-black dark:text-white"> {{ $user->first_name }}</h6> --}}

                                        {{-- Hidden links for all statuses of this user --}}
                                        @foreach ($userStatuses->skip(1) as $status)
                                            <a href="{{ asset('storage/' . $status->image) }}" class="hidden"
                                                data-caption="{{ $user->first_name }}" data-type="image"
                                                data-uk-lightbox="animation: slide"></a>
                                        @endforeach
                                    </li>
                                @endforeach

                                <li class="md:pr-3 pr-2">
                                    {{-- <div
                                        class="md:w-20 md:h-20 w-20 h-20 bg-slate-200/60 rounded-full dark:bg-dark2 animate-pulse">
                                    </div> --}}
                                </li>
                            </ul>
                        </div>
                        <div class="max-md:hidden">
                            <button type="button"
                                class="absolute -translate-y-1/2 bg-white shadow rounded-full top-1/2 -left-3.5 grid w-8 h-8 place-items-center dark:bg-dark3"
                                uk-slider-item="previous"> <ion-icon name="chevron-back"
                                    class="text-2xl"></ion-icon></button>
                            <button type="button"
                                class="absolute -right-2 -translate-y-1/2 bg-white shadow rounded-full top-1/2 grid w-8 h-8 place-items-center dark:bg-dark3"
                                uk-slider-item="next"> <ion-icon name="chevron-forward" class="text-2xl"></ion-icon>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- feed story -->
                {{-- <div class="md:max-w-[580px] mx-auto flex-1 xl:space-y-6 space-y-3"> --}}
                <div id="post-container"
                    class="md:max-w-[580px] mx-auto flex-1 xl:space-y-6 space-y-3 overflow-y-auto h-screen no-scrollbar">

                    <!-- post heading -->
                    @foreach ($other_users as $post)
                        <!--  post image-->
                        <div class="bg-white rounded-xl shadow-sm text-sm font-medium border1 dark:bg-dark2 post-item"
                            data-post-id="{{ $post->id }}" data-user-id="{{ $post->user->id }}">

                            <div class="flex gap-3 sm:p-4 p-2.5 text-sm font-medium">
                                <a
                                    href="{{ $post->user->id === auth()->id() ? route('timeline') : route('user.profile', ['id' => $post->user->id]) }}">
                                    <img src="{{ $post->user->image ? asset('storage/' . $post->user->image) : asset('images/avatars/avatar-1.jpg') }}"
                                        class="w-10 h-10 rounded-full object-cover mr-3" alt="">
                                </a>
                                <div class="flex-1">
                                    <a>
                                        <h4 class="text-black dark:text-white"> {{ $post->user->first_name }}
                                            {{ $post->user->last_name }} </h4>
                                    </a>
                                    <div class="text-xs text-gray-500 dark:text-white/80">
                                        {{ $post->caption }}</div>
                                    <div class="text-xs text-black-500 dark:text-white/80">
                                        {{ $post->updated_at->diffForHumans() }}</div>
                                </div>

                                <div x-data="{ mainOpen: false, blockOpen: false, reportOpen: false }" class="relative flex items-center justify-end gap-2">

                                    <!-- Three dot menu -->
                                    <div class="relative">
                                        <button @click="mainOpen = !mainOpen"
                                            class="text-gray-500 hover:text-gray-700 dark:hover:text-white">
                                            <ion-icon name="ellipsis-vertical" class="text-2xl"></ion-icon>
                                        </button>

                                        <!-- Main Menu -->
                                        <div x-show="mainOpen" @click.away="mainOpen = false" x-transition
                                            class="absolute right-0 top-10 w-44 bg-white dark:bg-dark2 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg py-2 z-50">

                                            @if ($post->user_id == auth()->id())
                                                <!-- Logged-in user's post: Only Bookmark and Copy Link -->
                                                <button
                                                    class="bookmark-btn block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700"
                                                    data-post-id="{{ $post->id }}">
                                                    Bookmark
                                                </button>

                                                <button onclick="copyUserLink({{ $post->user->id }})"
                                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                    Copy Link
                                                </button>
                                            @else
                                                <!-- Other user's post: Block, Report, Mute User -->
                                                <button @click="blockOpen = !blockOpen"
                                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                    Block
                                                </button>

                                                <button @click="reportOpen = !reportOpen"
                                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                    Report
                                                </button>

                                                <button
                                                    class="mute-user-btn block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
                                                    data-user-id="{{ $post->user->id }}">
                                                    Mute User
                                                </button>
                                                <button
                                                    class="bookmark-btn block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700"
                                                    data-post-id="{{ $post->id }}">
                                                    Bookmark
                                                </button>

                                                <button onclick="copyUserLink({{ $post->user->id }})"
                                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                    Copy Link
                                                </button>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Block Dropdown -->
                                    @if ($post->user_id != auth()->id())
                                        <div x-show="blockOpen" @click.away="blockOpen = false" x-transition
                                            class="absolute right-full mr-2 top-10 w-52
       bg-white dark:bg-dark2
       border border-gray-200 dark:border-gray-700
       rounded-lg shadow-lg py-2 z-50">
                                            <h4 class="px-4 py-2 font-semibold text-gray-700 dark:text-gray-200">Block
                                                Options</h4>
                                            <button
                                                class="block-post-btn block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700"
                                                data-post-id="{{ $post->id }}">
                                                Block Post
                                            </button>
                                            <button
                                                class="block-user-btn block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700"
                                                data-user-id="{{ $post->user->id }}">
                                                Block User
                                            </button>
                                        </div>
                                    @endif

                                    <!-- Report Dropdown -->
                                    @if ($post->user_id != auth()->id())
                                        <div x-show="reportOpen" @click.away="reportOpen = false" x-transition
                                            class="absolute right-full mr-2 top-10 w-52
       bg-white dark:bg-dark2
       border border-gray-200 dark:border-gray-700
       rounded-lg shadow-lg py-2 z-50">
                                            <h4 class="px-4 py-2 font-semibold text-gray-700 dark:text-gray-200">Report
                                                Options</h4>

                                            <!-- Post Reports -->
                                            <button
                                                class="report-post-btn block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700"
                                                data-post-id="{{ $post->id }}" data-reason="Spam">
                                                Report Spam Post
                                            </button>
                                            <button
                                                class="report-post-btn block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700"
                                                data-post-id="{{ $post->id }}" data-reason="Inappropriate Content">
                                                Report Inappropriate Post
                                            </button>
                                            <button
                                                class="report-post-btn block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700"
                                                data-post-id="{{ $post->id }}" data-reason="Harassment">
                                                Report Harassment
                                            </button>

                                            <hr class="my-1 border-gray-200 dark:border-gray-700">

                                            <!-- User Reports -->
                                            <button
                                                class="report-user-btn block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700"
                                                data-user-id="{{ $post->user->id }}" data-reason="Abuse">
                                                Report Abuse User
                                            </button>
                                            <button
                                                class="report-user-btn block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700"
                                                data-user-id="{{ $post->user->id }}" data-reason="Fake Profile">
                                                Report Fake User
                                            </button>
                                            <button
                                                class="report-user-btn block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700"
                                                data-user-id="{{ $post->user->id }}" data-reason="Harassment">
                                                Report Harassment User
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- its js apply bottom of this file --}}
                            @php
                                $file = $post->post_image;
                                $isVideo = Str::endsWith($file, ['.mp4', '.mov', '.avi', '.webm']);
                            @endphp

                            <div class="relative w-full max-h-[500px] sm:px-4 cursor-pointer media-preview"
                                data-src="{{ asset('storage/' . $file) }}"
                                data-type="{{ $isVideo ? 'video' : 'image' }}">

                                @if ($isVideo)
                                    <video autoplay muted loop playsinline preload="metadata"
                                        class="reel-video w-full h-auto rounded-lg object-cover">
                                        <source src="{{ asset('storage/' . $file) }}"
                                            type="video/{{ pathinfo($file, PATHINFO_EXTENSION) }}">
                                    </video>
                                @else
                                    <img src="{{ $file ? asset('storage/' . $file) : asset('images/avatars/avatar-1.jpg') }}"
                                        class="w-full h-auto rounded-lg object-cover">
                                @endif
                            </div>

                            <!-- post icons -->
                            <div class="sm:p-4 p-2.5 flex items-center gap-4 text-xs font-semibold">
                                <div>
                                    <div class="like-section" data-post-id="{{ $post->id }}">
                                        @php
                                            $isLiked = $post->likes->contains('user_id', auth()->id());
                                        @endphp

                                        <button
                                            class="like-button text-red-500 transition-transform duration-300 text-xl ml-8">
                                            <i class="fa{{ $isLiked ? 's' : 'r' }} fa-heart"></i>
                                        </button>

                                        <span class="like-count text-sm ml-8">{{ $post->likes->count() }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <button type="button" class="button-icon bg-slate-200/70 dark:bg-slate-700">
                                        <ion-icon class="text-lg" name="chatbubble-ellipses"></ion-icon>
                                    </button>
                                    <span id="commentCount_{{ $post->id }}">{{ $post->total_comments }}</span>
                                </div>

                                <!-- Share Button -->
                                <div class="flex items-center gap-3">
                                    <button type="button" onclick="copyPostLink({{ $post->id }})"
                                        class="button-icon bg-slate-200/70 dark:bg-slate-700">
                                        <ion-icon class="text-lg" name="share-social"></ion-icon>
                                    </button>
                                </div>
                            </div>

                            <!-- comments -->
                            <div id="commentList_{{ $post->id }}" data-post-id="{{ $post->id }}"
                                class="sm:p-4 p-2.5 border-t border-gray-100 font-normal space-y-3 relative dark:border-slate-700/40"
                                x-data="{ showAll: false }">

                                @forelse (($post->comments ?? collect())->where('parent_id', null) as $index => $comment)
                                    <div class="flex flex-col gap-2 relative comment-item"
                                        id="comment_{{ $comment->id }}" @class(['hidden' => $index > 1 && !request()->ajax()])
                                        x-show="showAll || {{ $index < 2 ? 'true' : 'false' }}" x-transition>

                                        <!-- Top-level comment -->
                                        <div class="flex items-start gap-3">
                                            <a href="#">
                                                <img src="{{ $comment->user->image ? asset('storage/' . $comment->user->image) : asset('images/avatars/avatar-1.jpg') }}"
                                                    alt="" class="w-6 h-6 mt-1 rounded-full">
                                            </a>

                                            <div class="flex-1">
                                                <a href="#"
                                                    class="text-black font-medium inline-block dark:text-white">
                                                    {{ $comment->user->first_name }} {{ $comment->user->last_name }}
                                                </a>
                                                <p class="mt-0.5">{{ $comment->body }}</p>

                                                <!-- Reply Button -->
                                                <button type="button" class="text-sm text-blue-500 reply-btn"
                                                    data-id="{{ $comment->id }}">
                                                    Reply ?
                                                </button>

                                                <!-- Reply Form (hidden initially) -->
                                                <form class="reply-form hidden mt-1"
                                                    data-comment-id="{{ $comment->id }}">
                                                    @csrf
                                                    <div
                                                        class="sm:px-4 sm:py-3 p-2.5 border-t border-gray-100 flex items-center gap-1 dark:border-slate-700/40">
                                                        <img src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('images/avatars/avatar-1.jpg') }}"
                                                            alt="" class="w-6 h-6 rounded-full">

                                                        <div class="flex-1 relative overflow-hidden h-10">
                                                            <textarea name="comment" placeholder="Write a reply..." rows="1"
                                                                class="w-full resize-none !bg-transparent px-4 py-2 focus:!border-transparent focus:!ring-transparent"></textarea>
                                                        </div>

                                                        <button type="submit"
                                                            class="text-sm rounded-full py-1.5 px-3.5 bg-secondery">
                                                            Reply
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Delete Button for comment owner -->
                                            @if ($comment->user_id == auth()->id())
                                                <button type="button" class="text-red-500 text-xs delete-comment"
                                                    data-id="{{ $comment->id }}">
                                                    <i class="fa-solid fa-trash"></i> Trash
                                                </button>
                                            @endif
                                        </div>

                                        <!-- Replies -->
                                        @foreach ($comment->replies ?? collect() as $reply)
                                            <div class="flex items-start gap-3 pl-6 ml-6 mt-2 reply-item"
                                                id="comment_{{ $reply->id }}">
                                                <a href="#">
                                                    <img src="{{ $reply->user->image ? asset('storage/' . $reply->user->image) : asset('images/avatars/avatar-1.jpg') }}"
                                                        alt="" class="w-5 h-5 mt-1 rounded-full">
                                                </a>
                                                <div class="flex-1">
                                                    <a href="#"
                                                        class="text-black font-medium inline-block dark:text-white">
                                                        {{ $reply->user->first_name }} {{ $reply->user->last_name }}
                                                    </a>
                                                    <p class="mt-0.5">{{ $reply->body }}</p>
                                                </div>

                                                <!-- Delete Button for reply owner -->
                                                @if ($reply->user_id == auth()->id())
                                                    <button type="button" class="text-red-500 text-xs delete-comment"
                                                        data-id="{{ $reply->id }}">
                                                        <i class="fa-solid fa-trash"></i> Trash
                                                    </button>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @empty
                                    <p class="text-gray-500"></p>
                                @endforelse

                                <!-- Show more button -->
                                @if (($post->comments ?? collect())->where('parent_id', null)->count() > 2)
                                    <button @click="showAll = !showAll"
                                        class="flex items-center gap-1.5 text-gray-500 hover:text-blue-500 mt-2"
                                        x-show="!showAll">
                                        <ion-icon name="chevron-down-outline"
                                            class="ml-auto duration-200 group-aria-expanded:rotate-180"></ion-icon>
                                        More Comments
                                    </button>
                                @endif
                            </div>

                            {{-- Add comment --}}
                            <form id="commentForm_{{ $post->id }}" data-post-id="{{ $post->id }}">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <div
                                    class="sm:px-4 sm:py-3 p-2.5 border-t border-gray-100 flex items-center gap-1 dark:border-slate-700/40">
                                    <img src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('images/avatars/avatar-1.jpg') }}"
                                        alt="" class="w-6 h-6 rounded-full">

                                    <div class="flex-1 relative overflow-hidden h-10">
                                        <textarea name="comment" placeholder="Add Comment...." rows="1"
                                            class="w-full resize-none !bg-transparent px-4 py-2 focus:!border-transparent focus:!ring-transparent"></textarea>
                                    </div>
                                    <button type="submit" class="text-sm rounded-full py-1.5 px-3.5 bg-secondery">
                                        Comment
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endforeach

                    @if ($other_users->hasMorePages())
                        <div class="text-center mt-6" id="loadMoreWrapper">
                            <button type="button" id="loadMoreBtn"
                                data-next-page="{{ $other_users->currentPage() + 1 }}"
                                class="px-6 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700">
                                Load More
                            </button>
                        </div>
                    @endif

                    <!-- placeholder -->
                    {{-- <div
                        class="w-[580px] rounded-xl shadow-sm p-4 space-y-4 bg-slate-200/40 animate-pulse border1 dark:bg-dark2">
                        <div class="flex gap-3">
                            <div class="w-9 h-9 rounded-full bg-slate-300/20"></div>
                            <div class="flex-1 space-y-3">
                                <div class="w-40 h-5 rounded-md bg-slate-300/20"></div>
                                <div class="w-24 h-4 rounded-md bg-slate-300/20"></div>
                            </div>
                            <div class="w-6 h-6 rounded-full bg-slate-300/20"></div>
                        </div>

                        <div class="w-full h-[208px] rounded-lg bg-slate-300/10 my-3"></div>
                        <div class="flex gap-3">
                            <div class="w-16 h-5 rounded-md bg-slate-300/20"></div>
                            <div class="w-14 h-5 rounded-md bg-slate-300/20"></div>
                            <div class="w-6 h-6 rounded-full bg-slate-300/20 ml-auto"></div>
                            <div class="w-6 h-6 rounded-full bg-slate-300/20"></div>
                        </div>
                    </div> --}}
                </div>
            </div>

            <!-- sidebar -->
            <div class="flex-1">
                <div uk-sticky="media: 1024; end: #js-oversized; offset: 80">
                    <div class="lg:space-y-4 lg:pb-8 max-lg:grid sm:grid-cols-2 max-lg:gap-6 sidebar-scroll">
                        {{-- People You May Know Section (role == 0) --}}

                        {{-- if scroller needed to every box give this class to box inner-scroll --}}
                        <div class="box p-5 px-6 inner-scroll" x-data="{
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
                                    this.showCount += 1;
                                }
                            }
                        }">
                            <div class="flex items-baseline justify-between text-black dark:text-white mb-4">
                                <i data-lucide="users" class="w-6 h-6"></i>
                                <h3 class="font-bold text-base">People you may know</h3>
                            </div>

                            <div class="mb-4">
                                <input type="text" x-model="search" placeholder="Search user..."
                                    class="w-full px-3 py-2 border rounded text-sm focus:outline-none focus:ring focus:border-blue-300">
                            </div>

                            <template x-for="user in filteredUsers" :key="user.id">
                                <div class="side-list-item flex items-center space-x-3 mb-4">
                                    <a :href="'/user/' + user.id" class="user-avatar relative inline-block">
                                        <!-- User Image -->
                                        <img :src="(!user.image || user.image === '0') ? '/images/avatars/avatar-1.jpg' :
                                        '/storage/' + user.image"
                                            alt="" class="side-list-image rounded-full w-10 h-10 object-cover">

                                        <!-- Bow Icon Below -->
                                        <div x-show="user.UserStatus == 1" class="user-status-icon text-blue-600 text-sm">
                                            🎀
                                        </div>
                                    </a>

                                    <div class="flex-1">
                                        <a :href="'/user/' + user.id">
                                            <h4 class="font-semibold text-sm"
                                                x-text="user.first_name + ' ' + user.last_name">
                                            </h4>
                                        </a>
                                        <div class="text-xs text-gray-500"
                                            x-text="user.friend_count + ' Follower' + (user.friend_count !== 1 ? 's' : '')">
                                        </div>
                                    </div>

                                    <!-- Follow -->
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
                        if (data.status === 'success') {
                            user.friendship_status = 'pending';
                            user.friendship_sender = {{ auth()->id() }};
                        } else {
                            alert(data.message || 'Request already sent');
                        }
                    })
                    .catch(() => alert('Server error'));
                "
                                            class="px-3 py-1 text-sm rounded bg-blue-500 text-white hover:bg-blue-600 transition">
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
                                        <button @click="unfriend(user)"
                                            class="button bg-green-500 text-white text-sm px-3 py-1 hover:bg-green-600 transition">
                                            Following
                                        </button>
                                    </template>
                                </div>
                            </template>

                            <div class="text-center"
                                x-show="filteredUsers.length < allUsers.filter(user => 
                            (user.first_name + ' ' + user.last_name).toLowerCase().includes(search.toLowerCase())
                            ).length">
                                <button @click="seeMore" class="text-sm text-blue-500 hover:underline">
                                    See more
                                </button>
                            </div>
                        </div>

                        {{-- Counselors Section (role == 1) --}}
                        <div class="box p-5 px-6 mt-4 inner-scroll" x-data="{
                            showAll: false,
                            selectedPrice: '',
                            selectedRating: '',
                            selectedSpecialization: '',
                            specializations: [],
                            counselors: {{ $all_users->where('role', 1)->values()->map(function ($u) {
                                    return [
                                        'id' => $u->id,
                                        'first_name' => $u->first_name,
                                        'last_name' => $u->last_name,
                                        'average_rating' => $u->average_rating,
                                        'image' => $u->image ? asset('storage/' . $u->image) : asset('images/avatars/avatar-1.jpg'),
                                        'price' => $u->price ?? 0,
                                        'profileUrl' => route('counselor.profile', $u->id),
                                        'specialization' => $u->specialization->name ?? 'General',
                                    ];
                                })->toJson() }},
                        
                            filteredCounselors() {
                                return this.counselors.filter(c => {
                                    const price = parseInt(c.price);
                                    const rating = parseFloat(c.average_rating ?? 0);
                        
                                    // Price filter
                                    if (this.selectedPrice === '0-499' && price >= 500) return false;
                                    if (this.selectedPrice === '500-999' && (price < 500 || price > 999)) return false;
                                    if (this.selectedPrice === '1000-999999' && price < 1000) return false;
                        
                                    // Rating filter
                                    if (this.selectedRating === '4' && rating < 4) return false;
                                    if (this.selectedRating === '3' && (rating < 3 || rating >= 4)) return false;
                                    if (this.selectedRating === '0' && rating >= 3) return false;
                        
                                    // Specialization filter
                                    if (this.selectedSpecialization && c.specialization !== this.selectedSpecialization) return false;
                        
                                    return true;
                                });
                            }
                        }">

                            <div class="flex items-baseline justify-between text-black dark:text-white mb-3">
                                <i data-lucide="stethoscope" class="w-6 h-6 "></i>
                                <h3 class="font-bold text-base">Contact Counselors</h3>
                            </div>

                            <!-- Filters Container -->
                            <div class="mb-4 space-y-3">
                                <!-- Specialization Filter (Full Width) -->
                                <div x-init="fetch('{{ route('specializations.fetch') }}')
                                    .then(res => res.json())
                                    .then(data => { specializations = data })">
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Specialization:
                                    </label>

                                    <select x-model="selectedSpecialization"
                                        class="w-full mt-1 border border-gray-300 rounded p-2">
                                        <option value="">All Specializations</option>

                                        <template x-for="spec in specializations" :key="spec.id">
                                            <option :value="spec.name" x-text="spec.name"></option>
                                        </template>
                                    </select>
                                </div>

                                <div class="flex gap-3">

                                    <!-- Price Filter -->
                                    <div class="w-1/2">
                                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Price:</label>
                                        <select x-model="selectedPrice"
                                            class="w-full mt-1 border border-gray-300 rounded p-2">
                                            <option value="">All Prices</option>
                                            <option value="0-499">Below ₹500</option>
                                            <option value="500-999">₹500 - ₹999</option>
                                            <option value="1000-999999">₹1000 & Above</option>
                                        </select>
                                    </div>

                                    <!-- Rating Filter -->
                                    <div class="w-1/2">
                                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Rating:</label>
                                        <select x-model="selectedRating"
                                            class="w-full mt-1 border border-gray-300 rounded p-2">
                                            <option value="">All Ratings</option>
                                            <option value="4">4 ★ & above</option>
                                            <option value="3">3–3.9 ★</option>
                                            <option value="0">Below 3 ★</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Counselor List -->
                            <div class="side-list">
                                <template x-for="(user, index) in filteredCounselors()" :key="user.id">
                                    <div class="side-list-item" x-show="(!showAll && index < 2) || (showAll && index < 3)"
                                        x-cloak>
                                        <a :href="user.profileUrl">
                                            <img :src="user.image" alt=""
                                                class="side-list-image rounded-full w-10 h-10 object-cover">
                                        </a>
                                        <div class="flex-1">
                                            <a :href="user.profileUrl">
                                                <h4 class="side-list-title"
                                                    x-text="user.first_name + ' ' + user.last_name">
                                                </h4>
                                            </a>
                                            <div class="side-list-info">
                                                ₹<span x-text="user.price"></span> | ⭐
                                                <span x-text="user.average_rating.toFixed(1)"></span>
                                                <br>
                                                {{-- <span class="text-xs text-gray-600" x-text="user.specialization"></span> --}}
                                            </div>
                                        </div>
                                        <a :href="user.profileUrl" class="button bg-blue-500 text-white">Contact</a>
                                    </div>
                                </template>
                                <div class="text-center mt-3" x-show="!showAll && filteredCounselors().length > 2">
                                    <button @click="showAll = true" class="text-blue-500 hover:underline text-sm">See
                                        More</button>
                                </div>
                            </div>
                        </div>

                        <div class="box p-5 px-6 mt-4 inner-scroll" x-data="{
                            showAll: false,
                            events: {{ $events->map(function ($e) {
                                    return [
                                        'id' => $e->id,
                                        'name' => $e->name,
                                        'city' => $e->city,
                                        'timing' => \Carbon\Carbon::parse($e->timing)->format('d M Y h:i A'),
                                        'image' => $e->image ? asset('storage/' . $e->image) : asset('images/default-event.jpg'),
                                        // 'detailsUrl' => route('events.show', $e->id),
                                    ];
                                })->toJson() }},
                            filteredEvents() {
                                return this.events;
                            }
                        }" x-show="events.length > 0"
                            x-cloak>

                            <div class="flex items-center gap-2 mb-3 text-black dark:text-white">
                                {{-- <i data-lucide="party-popper" class="w-6 h-6"></i> --}}
                                <h3 class="font-bold text-base trending-text">
                                    Trending Nearby Events
                                </h3>
                            </div>

                            <div class="side-list">
                                <template x-for="(event, index) in filteredEvents()" :key="event.id">
                                    <div class="side-list-item flex items-center justify-between mb-3"
                                        x-show="(!showAll && index < 3) || showAll" x-cloak>
                                        {{-- <a :href="event.detailsUrl"> --}}
                                        <a>
                                            <img :src="event.image" alt=""
                                                class="side-list-image rounded w-64 h-32 object-cover">
                                        </a>
                                        <div class="flex-1 ml-3">
                                            <a>
                                                <h4 class="side-list-title font-semibold text-gray-800 dark:text-white"
                                                    x-text="event.name"></h4>
                                            </a>
                                            <div class="side-list-info text-sm text-gray-600 dark:text-gray-300">
                                                <span x-text="event.city"></span> <br>
                                                <span x-text="event.timing"></span>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <div class="text-center mt-3" x-show="!showAll && filteredEvents().length > 3">
                                    <button @click="showAll = true" class="text-blue-500 hover:underline text-sm">
                                        See More
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- @include('layouts.chatbot') --}}

    <!-- create story -->
    <div class="hidden lg:p-20" id="create-story" uk-modal="">

        <div
            class="uk-modal-dialog tt relative overflow-hidden mx-auto bg-white p-7 shadow-xl rounded-lg md:w-[520px] w-full dark:bg-dark2">

            <div class="text-center py-3 border-b -m-7 mb-0 dark:border-slate-700">
                <h2 class="text-sm font-medium"> Create Story </h2>

                <!-- close button -->
                <button type="button" class="button__ico absolute top-0 right-0 m-2.5 uk-modal-close">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="space-y-5 mt-7 mr-1">
                <form id="statusForm" enctype="multipart/form-data">
                    @csrf

                    <div>
                        <label for="status-text" class="text-base">What do you have in mind?</label>
                        <input type="text" name="caption" id="status-text"
                            class="w-full mt-3 border rounded px-3 py-2 mb-1">
                    </div>

                    <div
                        class="w-full h-72 relative border1 rounded-lg overflow-hidden bg-[url('../images/ad_pattern.png')] bg-repeat">

                        <input type="file" name="image" id="uploadStatusImage" accept="image/*" required
                            class="hidden">

                        <div onclick="document.getElementById('uploadStatusImage').click()"
                            class="flex flex-col justify-center items-center absolute -translate-x-1/2 left-1/2 bottom-0 z-10 w-full pb-6 pt-10 cursor-pointer bg-gradient-to-t from-gray-700/60">
                            <ion-icon name="image" class="text-3xl text-teal-600"></ion-icon>
                            <span class="text-white mt-2">Click to Upload Image</span>
                        </div>

                        <img id="createStatusImage" src="#" alt="" style="display:none;"
                            class="w-full h-full absolute object-cover">
                    </div>

                    <div class="flex justify-between items-center mt-4">
                        <div class="flex items-start gap-2">
                            <ion-icon name="time-outline"
                                class="text-3xl text-sky-600 rounded-full bg-blue-50 dark:bg-transparent"></ion-icon>
                            <p class="text-sm text-gray-500 font-medium">
                                Your Status will be available <br> for <span class="text-gray-800">24 Hours</span>
                            </p>
                        </div>
                        <button type="submit" class="button bg-blue-500 text-white px-8">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="mediaModal" class="fixed inset-0 hidden z-50 flex items-center justify-center backdrop-blur-sm">

        <button id="closeModal" class="absolute top-4 right-4 text-white text-3xl font-bold">&times;</button>
        <div id="modalContent" class="max-w-4xl w-full px-4"></div>
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
