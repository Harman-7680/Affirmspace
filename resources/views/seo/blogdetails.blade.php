@extends('layouts.seo')

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs – AffirmSpace</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('content')
    <div class="blog-container">

        <!-- Blog Card -->
        <div class="blog-card">

            @if ($blog->image)
                <div class="blog-img-left">
                    <img src="{{ asset('storage/' . $blog->image) }}">
                </div>
            @endif

            <div class="blog-content-right">
                <h1 class="blog-title">{{ $blog->short_description }}</h1>

                <p class="blog-desc">{{ $blog->long_description }}</p>

                <span class="blog-category">
                    {{ $blog->category }}
                </span>
            </div>

        </div>

        <!-- Comments -->
        <div class="comment-section">
            <h3>💬 Comments</h3>

            @forelse($blog->comments as $comment)
                <div class="comment-box">
                    <strong>{{ $comment->name }}</strong>
                    <p>{{ $comment->comment }}</p>
                </div>
            @empty
                <p class="no-comment">No comments yet</p>
            @endforelse
        </div>

        <!-- Comment Form -->
        <div class="form-section">
            <h3>Leave a Comment</h3>

            <form action="{{ route('blog.comment.store', $blog->id) }}" method="POST">
                @csrf

                <input type="text" name="name" placeholder="Your Name" required class="input-field">

                <textarea name="comment" placeholder="Write your comment..." required class="input-field textarea"></textarea>

                <button type="submit" class="btn-submit">
                    Submit Comment
                </button>
            </form>

            @if (session('success'))
                <p class="success-msg">
                    {{ session('success') }}
                </p>
            @endif
        </div>

    </div>
@endsection

@section('css')
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fb;
        }

        /* Container */
        .blog-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
        }

        /* Blog Card */
        .blog-card {
            display: flex;
            gap: 20px;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            align-items: center;
            transition: 0.3s;
        }

        .blog-card:hover {
            transform: translateY(-3px);
        }

        /* Left Image */
        .blog-img-left {
            width: 40%;
        }

        .blog-img-left img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 10px;
            transition: 0.3s;
        }

        .blog-img-left img:hover {
            transform: scale(1.05);
        }

        /* Right Content */
        .blog-content-right {
            width: 60%;
        }

        .blog-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .blog-desc {
            color: #555;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .blog-category {
            display: inline-block;
            background: #007bff;
            color: #fff;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
        }

        /* Comments */
        .comment-section {
            margin-top: 20px;
        }

        .comment-section h3 {
            margin-bottom: 15px;
        }

        .comment-box {
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .comment-box strong {
            display: block;
            margin-bottom: 5px;
        }

        .no-comment {
            color: #888;
        }

        /* Form */
        .form-section {
            margin-top: 30px;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .input-field {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: 0.3s;
        }

        .input-field:focus {
            border-color: #007bff;
            outline: none;
        }

        .textarea {
            min-height: 100px;
        }

        /* Button */
        .btn-submit {
            background: #007bff;
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background: #0056b3;
        }

        /* Success */
        .success-msg {
            margin-top: 10px;
            color: green;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .blog-card {
                flex-direction: column;
            }

            .blog-img-left,
            .blog-content-right {
                width: 100%;
            }

            .blog-img-left img {
                height: 200px;
            }
        }
    </style>
@endsection
