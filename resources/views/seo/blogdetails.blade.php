@extends('layouts.seo')

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs – AffirmSpace</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('content')
    <h2>{{ $blog->slug }}</h2>

    <p>{{ $blog->short_description }}</p>

    @if ($blog->image)
        <img src="{{ asset('storage/' . $blog->image) }}" width="300">
    @endif

    <p><strong>Category:</strong> {{ $blog->category }}</p>

    <hr>

    <h4>All Comments</h4>

    @forelse($blog->comments as $comment)
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
            <strong>{{ $comment->name }}</strong>
            <p>{{ $comment->comment }}</p>
        </div>
    @empty
        <p>No comments yet</p>
    @endforelse

    <hr>

    <h4>Leave a Comment</h4>

    <form action="{{ route('blog.comment.store', $blog->id) }}" method="POST">
        @csrf

        <div style="margin-bottom:10px;">
            <input type="text" name="name" placeholder="Your Name" required
                style="width:100%; padding:8px; border:1px solid #ccc;">
        </div>

        <div style="margin-bottom:10px;">
            <textarea name="comment" placeholder="Write your comment..." required
                style="width:100%; padding:8px; border:1px solid #ccc;"></textarea>
        </div>

        <button type="submit" style="background:#007bff; color:#fff; padding:8px 15px; border:none;">
            Submit Comment
        </button>
    </form>

    {{-- success message --}}
    @if (session('success'))
        <p style="color:green; margin-top:10px;">
            {{ session('success') }}
        </p>
    @endif
@endsection
