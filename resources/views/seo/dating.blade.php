@extends('layouts.seo')

@section('meta')
    <meta name="description"
        content="Find meaningful LGBTQ+ relationships on a safe LGBTQ+ dating app and platform. Meet, chat, and build real connections with like-minded people securely.">
    <title>LGBTQ+ Dating App – Find Real Connections | AffirmSpace</title>
    <meta name="author" content="AffirmSpace">
    <meta name="keywords"
        content="LGBTQ+ dating, LGBTQ+ dating platform, safe LGBTQ+ dating, LGBTQ+ dating app / website, LGBTQ+ relationships">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('css')
    <style>
        /* GLOBAL */

        /* CONTAINER */

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 60px 20px;
        }


        /* HERO (MATCH CHAT PAGE) */

        .chat-hero {
            background: #f8f9ff;
        }


        /* GRID */

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 40px;
        }


        /* TEXT */

        .hero-text h1 {
            font-size: 48px;
            font-weight: 700;
            color: #222;
            line-height: 1.2;
        }

        .hero-text span {
            color: #ff4d7e;
        }

        .hero-text p {
            margin-top: 20px;
            font-size: 18px;
            color: #555;
            line-height: 1.6;
            max-width: 520px;
        }


        /* BUTTONS */

        .hero-buttons {
            margin-top: 30px;
            display: flex;
            gap: 15px;
        }

        .btn-primary {
            background: linear-gradient(90deg, #ff4d7e, #ff7a5c);
            color: #fff;
            padding: 14px 28px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
        }

        .btn-outline {
            border: 2px solid #ddd;
            padding: 12px 28px;
            border-radius: 30px;
            text-decoration: none;
            color: #333;
        }


        /* IMAGE */

        .hero-image img {
            width: 100%;
            max-width: 450px;
        }



        /* WHY DATING */

        .why-dating {
            background: #f8f9ff;
            text-align: center;
        }

        .why-dating h2 {
            font-size: 34px;
            margin-bottom: 20px;
        }

        .features-grid {
            margin-top: 40px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .feature-card {
            background: white;
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
        }

        .icon {
            font-size: 32px;
            margin-bottom: 10px;
        }

        /* FEATURE IMAGES */

        .feature-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            margin-bottom: 15px;
            border-radius: 12px;
        }



        /* HOW IT WORKS */

        .how-works {
            position: relative;
            overflow: hidden;
            padding: 120px 0;
            text-align: center;
            color: white;
        }


        /* BACKGROUND IMAGE (PARALLAX READY) */

        .bg-image {
            position: absolute;
            top: -10%;
            /* extra space for smooth movement */
            left: 0;
            width: 100%;
            height: 120%;
            /* bigger for parallax */
            z-index: 0;
        }

        .bg-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: translateY(0);
            will-change: transform;
            /* 🔥 smooth performance */
        }


        /* DARK OVERLAY */

        .how-works::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.1);
            z-index: 1;
        }


        /* CONTENT ABOVE IMAGE */

        .how-works .container {
            position: relative;
            z-index: 2;
        }


        /* HEADING */

        .how-works h2 {
            font-size: 36px;
            color: white;
            margin-bottom: 10px;
        }


        /* GRID */

        .steps {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-top: 50px;
        }


        /* CARDS */

        .step {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(12px);
            padding: 35px 25px;
            border-radius: 16px;
            transition: 0.3s ease;
            color: white;
        }

        .step:hover {
            transform: translateY(-8px);
            background: rgba(255, 255, 255, 0.18);
        }


        /* STEP IMAGES */

        .step-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            margin-bottom: 15px;
            border-radius: 12px;
        }


        /* TEXT */

        .step h3 {
            margin-bottom: 10px;
            font-size: 18px;
        }

        .step p {
            font-size: 14px;
            line-height: 1.6;
            opacity: 0.9;
        }

        /* COMMUNITY SECTION */

        .community-section {
            background: #f4f5ff;
            text-align: center;
        }

        .community-box {
            max-width: 800px;
            margin: auto;
        }

        .community-section h2 {
            font-size: 32px;
        }

        .community-section p {
            margin-top: 20px;
            line-height: 1.7;
            font-size: 17px;
        }



        /* CTA SECTION */

        .dating-cta {
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: white;
            text-align: center;
            padding: 80px 0;
        }

        .cta-box h2 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .cta-box p {
            font-size: 18px;
            opacity: 0.95;
        }


        /* BUTTON MARGIN FIX */

        .dating-cta .btn-primary {
            margin-top: 35px;
        }



        /* RESPONSIVE */

        @media(max-width:900px) {

            .hero-grid {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-text p {
                margin-left: auto;
                margin-right: auto;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .steps {
                grid-template-columns: 1fr;
            }

            .hero-text h1 {
                font-size: 40px;
            }

            .hero-text h2 {
                font-size: 22px;
            }

        }
    </style>
@endsection

@section('content')
    <section class="chat-hero">
        <div class="container">

            <div class="hero-grid">

                <div class="hero-text">
                    <h1>Find Meaningful LGBTQ+ <br><span>Connections</span></h1>

                    <p>
                        Discover people who understand you. AffirmSpace helps the LGBTQ+ community connect,
                        build relationships, and explore dating in a safe and respectful environment.
                    </p>

                    <div class="hero-buttons">
                        <a href="{{ 'login' }}" class="btn-primary">Start Exploring</a>
                        <a href="{{ 'register' }}?role=0" class="btn-outline">Create Your Profile</a>
                    </div>
                </div>

                <div class="hero-image">
                    <img src="images/dating/datingheader.png"
                        alt="LGBTQ couple holding hands showing love and relationship.">
                </div>

            </div>

        </div>
    </section>

    <section class="why-dating">
        <div class="container">

            <h2>Why Choose AffirmSpace for Dating</h2>

            <div class="features-grid">

                <div class="feature-card">
                    <img src="images/dating/Datingspace.png" class="feature-img"
                        alt="Shield with rainbow heart showing LGBTQ love and protection.">
                    <h3>Safe LGBTQ+ Dating Space</h3>
                    <p>
                        Meet people who respect your identity and values in a safe and inclusive environment.
                    </p>
                </div>

                <div class="feature-card">
                    <img src="images/dating/Authentication.png" class="feature-img"
                        alt="Person inside shield with checkmark on rainbow LGBTQ background.">
                    <h3>Authentic Profiles</h3>
                    <p>
                        Find genuine connections with real people from the LGBTQ+ community.
                    </p>
                </div>

                <div class="feature-card">
                    <img src="images/dating/Connections.png" class="feature-img"
                        alt="Two hands holding heart showing love and connection.">
                    <h3>Meaningful Connections</h3>
                    <p>
                        Whether you're looking for friendship, dating, or a relationship,
                        AffirmSpace helps you connect with like-minded people.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <section class="how-works">

        <div class="bg-image">
            <img src="images/dating/datingwork.jpeg"
                alt="Light rainbow gradient with faint hearts and check icons pattern.">
        </div>

        <div class="container">

            <h2>How It Works</h2>

            <div class="steps">

                <div class="step">
                    <img src="images/dating/1.png" class="step-img" alt="Number one on purple background.">
                    <h3>Create Your Profile</h3>
                    <p>
                        Share your interests, identity, and what you're looking for.
                    </p>
                </div>

                <div class="step">
                    <img src="images/dating/2.png" class="step-img" alt="Number two on red background">
                    <h3>Discover People</h3>
                    <p>
                        Browse profiles and find people who share your values.
                    </p>
                </div>

                <div class="step">
                    <img src="images/dating/3.png" class="step-img" alt="Number three on blue background.">
                    <h3>Start a Conversation</h3>
                    <p>
                        Match and begin meaningful conversations in a safe space.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <section class="community-section">
        <div class="container community-box">

            <h2>Built for the LGBTQ+ Community</h2>

            <p>
                AffirmSpace is designed to be more than just a dating platform.
                It’s a community where LGBTQ+ individuals can connect freely,
                express themselves openly, and build meaningful relationships
                without fear of judgment.
            </p>

        </div>
    </section>

    <section class="dating-cta">
        <div class="container cta-box">

            <h2>Start Your Journey Today</h2>

            <p style="margin-bottom: 28px;">
                Join AffirmSpace and meet people who truly understand you.
            </p>

            <a href="{{ 'register' }}?role=0" class="btn-primary">Create Your Profile</a>

        </div>
    </section>
@endsection

@section('script')
    <script>
        window.addEventListener("scroll", function() {

            const section = document.querySelector(".how-works");
            const bg = document.querySelector(".bg-image img");

            const rect = section.getBoundingClientRect();
            const speed = 0.3; // adjust speed (0.2–0.5 best)

            if (rect.top < window.innerHeight && rect.bottom > 0) {
                let offset = rect.top * speed;
                bg.style.transform = "translateY(" + offset + "px)";
            }

        });
    </script>
@endsection
