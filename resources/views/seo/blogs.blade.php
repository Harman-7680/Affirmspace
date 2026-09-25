@extends('layouts.seo')

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs – AffirmSpace</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('css')
    <style>
        /* =========================
               AFFIRMSPACE BLOG FONT
            ========================= */

        .blog-hero,
        .blog-page,
        .blog-hero h1,
        .blog-hero p,
        #searchInput,
        .category-title,
        .blog-card,
        .blog-content,
        .blog-content h3,
        .blog-content p,
        .blog-content span {
            font-family: 'Inter', sans-serif !important;
        }

        /* HERO SECTION */
        .blog-hero {
            text-align: center;
            padding: 80px 8%;
            background: linear-gradient(135deg, #fbc2eb, #a6c1ee);
        }

        .blog-hero h1 {
            font-size: 36px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .blog-hero p {
            color: #555;
            margin-bottom: 20px;
            font-weight: 400;
        }

        /* SEARCH BAR */
        #searchInput {
            padding: 12px 20px;
            width: 300px;
            border-radius: 25px;
            border: none;
            outline: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            font-weight: 400;
        }

        /* CATEGORY TITLE */
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
            opacity: 0;
            animation: fadeInUp 0.8s ease forwards;
        }

        .category-title::after {
            content: "";
            display: block;
            width: 60%;
            height: 4px;
            margin: 10px auto 0;
            border-radius: 5px;
            background: linear-gradient(45deg, #ff416c, #ff4b2b);
            transition: 0.3s ease;
        }

        .category-title:hover::after {
            width: 80%;
        }

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
            align-items: stretch;
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
            display: flex;
            flex-direction: column;
            text-align: left !important;
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
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            text-align: left !important;
        }

        .blog-content h3 {
            font-size: 16px;
            color: #333;
            margin-bottom: 8px;
            text-align: left;
            font-weight: 600;
        }

        .blog-content p {
            font-size: 14px;
            color: #666;
            line-height: 1.5;
            margin-bottom: 15px;
            flex-grow: 1;
            text-align: left;
            font-weight: 400;
        }

        /* READ MORE BUTTON */
        .blog-content span {
            color: #ff416c;
            font-weight: 600;
            margin-top: auto;
            display: inline-block;
            text-align: left;
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

        <p>
            Guidance, support, and real conversations for your journey
        </p>

        <!-- SEARCH BAR -->
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
                            <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->short_description }}">
                        @endif


                        <div class="blog-content">

                            <h3>
                                {{ $blog->short_description }}
                            </h3>


                            <!-- Quill content ko clean aur properly limit karne ke liye -->

                            <p>
                                {!! \Illuminate\Support\Str::limit(strip_tags($blog->long_description, '<p><strong><em>'), 90, '...') !!}
                            </p>


                            <span>
                                Read More →
                            </span>

                        </div>

                    </a>
                @endforeach

            </div>

        @empty

            <p style="text-align:center;">
                No blogs found
            </p>
        @endforelse

    </section>


    <!-- ================= SEARCH SCRIPT ================= -->

    <script>
        document
            .getElementById("searchInput")
            .addEventListener("keyup", function() {

                let value = this.value.toLowerCase();

                let categories = document.querySelectorAll(".blog-container");


                categories.forEach(container => {

                    let cards = container.querySelectorAll(".blog-card");

                    let visibleCount = 0;


                    cards.forEach(card => {

                        let title = card.dataset.title || "";

                        let desc = card.dataset.desc || "";


                        if (
                            title.includes(value) ||
                            desc.includes(value)
                        ) {

                            card.style.display = "flex";

                            visibleCount++;

                        } else {

                            card.style.display = "none";

                        }

                    });


                    // Category hide/show logic

                    let categoryTitle = container.previousElementSibling;


                    if (visibleCount === 0) {

                        container.style.display = "none";

                        if (categoryTitle) {
                            categoryTitle.style.display = "none";
                        }

                    } else {

                        container.style.display = "flex";

                        if (categoryTitle) {
                            categoryTitle.style.display = "block";
                        }

                    }

                });

            });
    </script>

@endsection
