@extends('layouts.app_admin')

@section('content')
    <div class="container-fluid" style="padding-left: 300px; padding-right: 20px;">
        <div class="container py-4">
            <h1 class="display-5 font-weight-bold mb-1">User Posts</h1>

            <div class="mt-4">
                <a href="{{ url()->previous() }}" class="btn btn-outline-primary">&larr; Back</a>
            </div><br>

            @if ($posts->count() > 0)
                <div class="row">
                    @foreach ($posts as $post)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-60 shadow-sm">

                                @php
                                    $mediaPath = $post->post_image;
                                    $extension = pathinfo($mediaPath, PATHINFO_EXTENSION);
                                    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                                    $videoExtensions = ['mp4', 'webm', 'ogg'];
                                @endphp

                                @if (in_array(strtolower($extension), $imageExtensions))
                                    <img src="{{ asset('storage/' . $mediaPath) }}" alt="Post Image" class="card-img-top"
                                        style="height: 200px; object-fit: cover;">
                                @elseif (in_array(strtolower($extension), $videoExtensions))
                                    <video controls style="width: 100%; height: 200px; object-fit: cover;"
                                        class="card-img-top">
                                        <source src="{{ asset('storage/' . $mediaPath) }}" type="video/{{ $extension }}">
                                        Your browser does not support the video tag.
                                    </video>
                                @endif

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">Caption : {{ $post->caption ?? 'Untitled' }}</h5>
                                    <p class="card-subtitle mb-2 text-muted">{{ $post->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info text-center">
                    No posts found for this user.
                </div>
            @endif
        </div>
    </div>
@endsection
