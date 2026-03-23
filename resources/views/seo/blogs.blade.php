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

        <!-- CATEGORY 1 -->
        <h2 class="category-title">🌈 LGBTQ+ Basics</h2>
        <div class="blog-container" data-category="basics">

            <a href="/what-is-lgbtq" class="blog-card" data-title="what is lgbtq">
                <img src="images/blog/blog1.jpeg" alt="">
                <div class="blog-content">
                    <h3>What Is LGBTQ+? Meaning, Full Form & Everything You Need to Know</h3>
                    <p>Learn the meaning, full form, and everything about LGBTQ+ identities.</p>
                    <span>Read More →</span>
                </div>
            </a>

            <a href="/lgbtq-full-form-meaning" class="blog-card" data-title="lgbtq full form">
                <img src="images/blog2.jpg">
                <div class="blog-content">
                    <h3>LGBTQ+ Full Form Explained</h3>
                    <p>Understand what each letter means in a simple way.</p>
                    <span>Read More →</span>
                </div>
            </a>

        </div>


        <!-- CATEGORY 2 -->
        <h2 class="category-title">🧬 Identity & Expression</h2>
        <div class="blog-container">

            <a href="/types-of-lgbtq-identities" class="blog-card" data-title="types of lgbtq identities">
                <img src="images/blog3.jpg">
                <div class="blog-content">
                    <h3>Types of LGBTQ+ Identities</h3>
                    <p>Explore gender identities and sexual orientations.</p>
                    <span>Read More →</span>
                </div>
            </a>

        </div>


        <!-- CATEGORY 3 -->
        <h2 class="category-title">💜 Mental Health & Support</h2>
        <div class="blog-container">

            <a href="/lgbtq-mental-health-support" class="blog-card" data-title="mental health lgbtq">
                <img src="images/blog4.jpg">
                <div class="blog-content">
                    <h3>LGBTQ+ Mental Health Support</h3>
                    <p>Find support and improve emotional well-being.</p>
                    <span>Read More →</span>
                </div>
            </a>

        </div>

    </section>

    <script>
        const searchInput = document.getElementById("searchInput");
        const cards = document.querySelectorAll(".blog-card");

        searchInput.addEventListener("keyup", function() {
            const value = this.value.toLowerCase();

            cards.forEach(card => {
                const title = card.dataset.title.toLowerCase();

                if (title.includes(value)) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
        });
    </script>
@endsection
