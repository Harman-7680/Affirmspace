@extends('layouts.seo')

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us – AffirmSpace</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('css')
    <style>
        section {
            padding: 80px 8%;
        }

        section h2 {
            font-size: 2.1rem;
            margin-bottom: 15px;
            text-align: center;
        }

        section p {
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
            color: #555;
        }

        .features {
            background: #ffffff;
        }

        .feature-grid {
            margin-top: 50px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        .feature-card {
            background: #f9fafb;
            padding: 28px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .feature-card h3 {
            margin-bottom: 12px;
            font-size: 1.1rem;
        }

        .feature-card p {
            text-align: left;
            color: #555;
            margin-bottom: 10px;
        }

        .disclaimer {
            margin-top: 35px;
            font-size: 0.9rem;
            text-align: center;
            color: #666;
        }

        .about-parallax {
            position: relative;
            padding: 120px 8%;
            text-align: center;
            color: white;
            overflow: hidden;
        }

        /* IMAGE */

        .parallax-img {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            object-fit: cover;
            z-index: -2;
        }

        /* OVERLAY */

        .about-parallax::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            z-index: -1;
        }

        /* TEXT */

        .about-content {
            max-width: 850px;
            margin: auto;
        }

        .about-content h2 {
            font-size: 2.2rem;
            margin-bottom: 15px;
        }

        .about-content p {
            color: #f0f0f0;
            font-size: 1.05rem;
            line-height: 1.7;
        }

        /* MOBILE FIX */

        @media(max-width:1024px) {

            .parallax-img {
                position: absolute;
                height: 100%;
            }

            .about-parallax {
                padding: 100px 8%;
            }

        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="about-parallax">

        <img src="images/coursel.png" class="parallax-img" alt="AffirmSpace background">

        <div class="about-content">
            <h2>More Than a Dating Platform 🌈</h2>

            <p>
                AffirmSpace is a global LGBTQ+ community, gay chat platform, and
                counselling ecosystem built for connection, safety, and genuine understanding.
                We are not just another gay dating website — we are a space where identity is respected
                and conversations go beyond surface-level attraction.
            </p>
        </div>

    </section>

    <!-- About Content -->
    <section class="features">
        <div class="feature-grid">

            <div class="feature-card">
                <h3>1. A Safe LGBTQ+ Community</h3>
                <p>
                    AffirmSpace was created to provide a secure space for the LGBTQ+ community —
                    including gay, lesbian, bisexual, transgender, non-binary, and questioning individuals.
                    We prioritize safety, moderation, and respectful interaction.
                </p>
            </div>

            <div class="feature-card">
                <h3>2. Meaningful Gay Chat & Connections</h3>
                <p>
                    Whether you're looking for free gay chat, private conversations,
                    friendships, or long-term relationships, our platform helps you meet people
                    in a safe and inclusive environment.
                </p>
            </div>

            <div class="feature-card">
                <h3>3. Beyond Traditional Gay Dating Apps</h3>
                <p>
                    Unlike many gay dating apps focused only on swiping,
                    AffirmSpace encourages authentic conversations, comfort, and respect.
                    We believe connection should be built on understanding — not pressure.
                </p>
            </div>

            <div class="feature-card">
                <h3>4. Built-In Counselling Support</h3>
                <p>
                    AffirmSpace integrates professional and intern counselling support
                    directly into the platform. Users can access emotional guidance,
                    relationship advice, and safe discussions when needed.
                </p>
            </div>

            <div class="feature-card">
                <h3>5. Identity & Pronoun Respect</h3>
                <p>
                    We empower users to express their true identity through customizable
                    profiles, pronoun selection, and inclusive profile options.
                    Everyone deserves to feel seen and respected.
                </p>
            </div>

            <div class="feature-card">
                <h3>6. Our Vision</h3>
                <p>
                    Our mission is to build a trusted global LGBTQ+ social platform
                    that combines dating, community, and mental well-being —
                    creating a digital space where people can truly belong.
                </p>
            </div>

        </div>

        <p class="disclaimer">
            Come as you are — Stay because you feel understood 💜
        </p>
    </section>
@endsection
