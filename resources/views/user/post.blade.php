@extends('layouts.app1')

@section('content')
    <br><br>
    <div class="max-w-2xl mx-auto mt-10 px-4">

        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white tracking-wide">
                Post Details
            </h1>
        </div>

        <!-- Post Section -->
        <div class="max-w-3xl mx-auto">

            <div class="j-post-card">

                <!-- Post Header -->
                <div class="j-post-header">

                    <div class="j-post-user">
                        <img src="{{ optional($post->user)->image ? Storage::url($post->user->image) : asset('images/avatars/avatar-1.jpg') }}"
                            alt="User Image">

                        <div>
                            <h2>
                                {{ optional($post->user)->first_name }}
                                {{ optional($post->user)->last_name }}
                            </h2>
                            <span>
                                {{ $post->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>

                </div>

                <!-- Post Content -->
                @if ($post->content)
                    <div class="j-post-content">
                        {{ $post->content }}
                    </div>
                @endif

                <!-- Post Image -->
                @if ($post->post_image)
                    <div class="j-post-image">
                        <img src="{{ Storage::url($post->post_image) }}" alt="Post Image">
                    </div>
                @endif

                <!-- Post Stats -->
                <div class="j-post-stats">
                    <span>👍 {{ $post->likes->count() }} Likes</span>
                    <span>💬 {{ $post->total_comments }} Comments</span>
                </div>

            </div>

        </div>

    </div>
@endsection


@section('css')
    <style>
        .j-post-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            padding: 22px;
            transition: all 0.3s ease-in-out;
        }

        .dark .j-post-card {
            background: #1f2937;
            border-color: #374151;
        }

        .j-post-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(255, 81, 47, 0.25);
        }

        /* Header */
        .j-post-header {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }

        .j-post-user {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .j-post-user img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #f3f4f6;
        }

        .dark .j-post-user img {
            border-color: #374151;
        }

        .j-post-user h2 {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
        }

        .dark .j-post-user h2 {
            color: #ffffff;
        }

        .j-post-user span {
            font-size: 12px;
            color: #6b7280;
        }

        /* Content */
        .j-post-content {
            margin-top: 12px;
            font-size: 15px;
            line-height: 1.6;
            color: #374151;
        }

        .dark .j-post-content {
            color: #d1d5db;
        }

        /* Image */
        .j-post-image {
            margin-top: 16px;
        }

        .j-post-image img {
            width: 100%;
            border-radius: 14px;
            object-fit: cover;
            max-height: 450px;
            transition: transform 0.3s ease;
        }

        .j-post-image img:hover {
            transform: scale(1.02);
        }

        /* Stats */
        .j-post-stats {
            margin-top: 16px;
            padding-top: 12px;
            border-top: 1px solid #e5e7eb;
            font-size: 14px;
            color: #6b7280;
            display: flex;
            justify-content: space-between;
        }

        .dark .j-post-stats {
            border-color: #374151;
            color: #9ca3af;
        }
    </style>
@endsection
