@extends('layouts.seo')

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs – AffirmSpace</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('css')
    <style>
        /* HERO SECTION */
        .blog-hero {
            text-align: center;
            padding: 80px 8%;
            background: linear-gradient(135deg, #fbc2eb, #a6c1ee);
        }

        .blog-hero h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .blog-hero p {
            color: #555;
            margin-bottom: 20px;
        }

        /* SEARCH BAR */
        #searchInput {
            padding: 12px 20px;
            width: 300px;
            border-radius: 25px;
            border: none;
            outline: none;
        }

        /* CATEGORY TITLE */
        /* ================= PREMIUM CATEGORY TITLE ================= */
        .category-title {
            margin: 70px 0 30px;
            font-size: 26px;
            font-weight: 700;
            text-align: center;
            color: #333;
            position: relative;
            display: inline-block;
            left: 50%;
            transform: translateX(-50%);

            /* smooth fade-in animation */
            opacity: 0;
            animation: fadeInUp 0.8s ease forwards;
        }

        /* 🔥 GRADIENT UNDERLINE */
        .category-title::after {
            content: "";
            display: block;
            width: 60%;
            height: 4px;
            margin: 10px auto 0;

            border-radius: 5px;

            /* SAME GRADIENT AS YOUR BUTTON */
            background: linear-gradient(45deg, #ff416c, #ff4b2b);

            transition: 0.3s ease;
        }

        /* ✨ HOVER EFFECT (subtle grow) */
        .category-title:hover::after {
            width: 80%;
        }

        /* 🎬 ANIMATION */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate(-50%, 20px);
            }

            to {
                opacity: 1;
                transform: translate(-50%, 0);
            }
        }

        /* BLOG GRID */
        .blog-container {
            display: flex;
            gap: 25px;
            flex-wrap: wrap;
            padding: 0 8%;
        }

        /* BLOG CARD */
        .blog-card {
            width: 320px;
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            text-decoration: none;
            color: inherit;
            transition: 0.3s;

            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        /* IMAGE */
        .blog-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        /* CONTENT */
        .blog-content {
            padding: 20px;
        }

        .blog-content h3 {
            font-size: 16px;
        }

        .blog-content p {
            font-size: 14px;
            color: #666;
        }

        .blog-content span {
            color: #ff416c;
            font-weight: 600;
        }

        /* HOVER */
        .blog-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 30px rgba(255, 65, 108, 0.4);
        }
    </style>
@endsection

@section('content')
    <!-- ================= BLOG PAGE ================= -->
    <section class="blog-hero">
        <h1>Insights & Stories</h1>
        <p>Guidance, support, and real conversations for your journey</p>

        <!-- 🔍 SEARCH BAR -->
        <input type="text" id="searchInput" placeholder="🔍 Search articles...">
    </section>

    <!-- ================= BLOG CONTENT ================= -->
    <section class="blog-page">

        @forelse($blogs->reverse() as $category => $items)
            {{-- CATEGORY TITLE --}}
            <h2 class="category-title">
                {{ ucfirst(str_replace('-', ' ', $category)) }}
            </h2>

            {{-- BLOGS --}}
            <div class="blog-container">

                @foreach ($items as $blog)
                    <a href="{{ route('blog.detail', [$blog->category, $blog->slug]) }}" class="blog-card"
                        data-title="{{ strtolower($blog->slug) }}"
                        data-desc="{{ strtolower($blog->short_description . ' ' . $blog->long_description) }}">

                        @if ($blog->image)
                            <img src="{{ asset('storage/' . $blog->image) }}">
                        @endif

                        <div class="blog-content">
                            <p>{{ $blog->short_description }}</p>
                            <p style="font-weight:900;">{{ $blog->long_description }}</p>

                            <span>Read More →</span>
                        </div>
                    </a>
                @endforeach

            </div>
        @empty
            <p style="text-align:center;">No blogs found</p>
        @endforelse

    </section>

    <script>
        document.getElementById("searchInput").addEventListener("keyup", function() {

            let value = this.value.toLowerCase();

            let categories = document.querySelectorAll(".blog-container");

            categories.forEach(container => {

                let cards = container.querySelectorAll(".blog-card");
                let visibleCount = 0;

                cards.forEach(card => {

                    let title = card.dataset.title || "";
                    let desc = card.dataset.desc || "";

                    if (title.includes(value) || desc.includes(value)) {
                        card.style.display = "block";
                        visibleCount++;
                    } else {
                        card.style.display = "none";
                    }

                });

                // 🔥 category hide/show logic
                let categoryTitle = container.previousElementSibling;

                if (visibleCount === 0) {
                    container.style.display = "none";
                    if (categoryTitle) categoryTitle.style.display = "none";
                } else {
                    container.style.display = "flex";
                    if (categoryTitle) categoryTitle.style.display = "block";
                }

            });

        });
    </script>
@endsection
