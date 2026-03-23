@extends('layouts.seo')

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog – AffirmSpace</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('content')
    <div class="main-wrapper">

        <!-- BLOG SECTION -->
        <div class="blog-layout">

            <!-- LEFT IMAGE -->
            @if ($blog->image)
                <div class="blog-image-box">
                    <img src="{{ asset('storage/' . $blog->image) }}">
                </div>
            @endif

            <!-- RIGHT CONTENT -->
            <div class="blog-content">

                <span class="category">{{ ucfirst(str_replace('-', ' ', $blog->category)) }}</span>

                <h1>{{ $blog->short_description }}</h1>

                <p class="desc">{{ $blog->long_description }}</p>

            </div>

        </div>

        <!-- COMMENTS -->
        <div class="comments-wrapper">
            <h3>💬 Community Thoughts</h3>

            @forelse($blog->comments as $comment)
                <div class="comment-card">
                    <div class="avatar">
                        {{ strtoupper(substr($comment->name, 0, 1)) }}
                    </div>

                    <div class="comment-content">
                        <h5>{{ $comment->name }}</h5>
                        <p>{{ $comment->comment }}</p>
                    </div>
                </div>
            @empty
                <p class="empty">No comments yet</p>
            @endforelse
        </div>

        <!-- COMMENT FORM -->
        <div class="form-wrapper">

            <h3>✍️ Share Your Thoughts</h3>

            <form action="{{ route('blog.comment.store', $blog->id) }}" method="POST">
                @csrf

                <div class="input-group">
                    <input type="text" name="name" required>
                    <label>Your Name</label>
                </div>

                <div class="input-group">
                    <textarea name="comment" required></textarea>
                    <label>Your Comment</label>
                </div>

                <button type="submit">Post Comment</button>
            </form>

            @if (session('success'))
                <p class="success">{{ session('success') }}</p>
            @endif

        </div>

    </div>
@endsection

@section('css')
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #eef2ff, #f8fafc);
        }

        /* MAIN */
        .main-wrapper {
            max-width: 1100px;
            margin: 40px auto;
            padding: 20px;
        }

        /* BLOG LAYOUT */
        .blog-layout {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 30px;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
        }

        /* IMAGE */
        .blog-image-box img {
            width: 100%;
            height: 320px;
            object-fit: cover;
            border-radius: 12px;
        }

        /* CONTENT */
        .blog-content h1 {
            font-size: 30px;
            font-weight: 800;
            margin: 10px 0;
        }

        .blog-content .desc {
            color: #555;
            line-height: 1.6;
        }

        .category {
            background: linear-gradient(135deg, #6366f1, #3b82f6);
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
        }

        /* COMMENTS */
        .comments-wrapper {
            margin-top: 40px;
        }

        .comment-card {
            display: flex;
            gap: 15px;
            background: white;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }

        .avatar {
            width: 40px;
            height: 40px;
            background: #6366f1;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* FORM */
        .form-wrapper {
            margin-top: 40px;
            padding: 25px;
            border-radius: 16px;
            background: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group input,
        .input-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            outline: none;
        }

        .input-group label {
            position: absolute;
            top: 12px;
            left: 12px;
            font-size: 13px;
            color: #777;
            transition: 0.3s;
            background: white;
            padding: 0 5px;
        }

        .input-group input:focus+label,
        .input-group textarea:focus+label,
        .input-group input:valid+label,
        .input-group textarea:valid+label {
            top: -8px;
            font-size: 11px;
            color: #3b82f6;
        }

        /* BUTTON */
        button {
            background: linear-gradient(135deg, #6366f1, #3b82f6);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.9;
        }

        /* SUCCESS */
        .success {
            color: green;
            margin-top: 10px;
        }

        /* RESPONSIVE */
        @media(max-width:768px) {
            .blog-layout {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection
