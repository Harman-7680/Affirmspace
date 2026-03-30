@extends('layouts.seo')

@section('meta')
    <meta name="description"
        content="Learn about AffirmSpace’s mission to build a safe LGBTQ+ community platform for connection, dating, and mental health support in an inclusive space.">
    <title>About AffirmSpace – LGBTQ+ Community Platform</title>
    <meta name="author" content="AffirmSpace">

    <meta name="keywords"
        content="LGBTQ+ community platform, safe LGBTQ+ community, gay chat platform, LGBTQ+ counselling platform, alternative to LGBTQ dating apps">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('css')
    <style>
        /* SECTION */
        .features {
            background: #ffffff;
            padding: 90px 8%;
        }

        /* GRID - FORCE 3 CARDS */
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-top: 50px;
        }

        /* CARD DESIGN */
        .feature-card {
            background: #f9fafb;
            padding: 30px 25px;
            border-radius: 18px;
            position: relative;
            transition: all 0.35s ease;
            border: 1px solid #e5e7eb;
        }

        /* SUBTLE INNER GLOW */
        .feature-card::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 18px;
            background: linear-gradient(135deg, #ff512f, #dd2476);
            opacity: 0;
            transition: 0.35s ease;
            z-index: 0;
        }

        /* CONTENT ABOVE */
        .feature-card * {
            position: relative;
            z-index: 1;
        }

        /* HOVER EFFECT (GRADIENT SHADOW ONLY) */
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow:
                0 15px 40px rgba(255, 65, 108, 0.25),
                0 0 25px rgba(221, 36, 118, 0.25);
        }

        /* HEADING */

        .feature-card h3 {
            font-size: 1.15rem;
            margin-bottom: 12px;
            font-weight: 600;
            color: #222;
            /* normal text color */
        }

        /* TEXT */
        .feature-card p {
            color: #555;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* LINKS */
        .feature-link {
            text-decoration: none;
            color: #111;
            font-weight: 600;
            transition: 0.3s;
        }

        .feature-link:hover {
            color: #dd2476;
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .feature-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .feature-grid {
                grid-template-columns: 1fr;
            }
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

        <img src="images/coursel.png" class="parallax-img"
            alt="LGBTQ community celebrating pride with rainbow flags and joy">

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
                <h3>🛡️ A Safe LGBTQ+ Community</h3>
                <p>
                    <a href="{{ route('/') }}" class="feature-link"><b>AffirmSpace</b></a> was
                    created to provide a secure and inclusive environment where people can express their identity freely and
                    connect without fear of judgment.
                    <a href="{{ route('community') }}" class="feature-link"><b>As a safe LGBTQ+ community platform,</b></a>
                    we prioritize respectful interaction, privacy, and meaningful conversations for individuals across the
                    LGBTQ+ spectrum.
                </p>
            </div>

            <div class="feature-card">
                <h3>💬 Meaningful LGBTQ+ Chat & Real Connections</h3>
                <p>
                    Whether you're looking for casual conversations, friendships, or long-term relationships, AffirmSpace
                    helps people connect through inclusive
                    <a href="{{ route('chat') }}" class="feature-link"><b>LGBTQ+ chat and community</b></a>
                    discussions in a safe environment.
                </p>
            </div>

            <div class="feature-card">
                <h3>❤️ Beyond Traditional LGBTQ Dating Apps</h3>
                <p>
                    Unlike many
                    <a href="{{ route('chatAndDating') }}" class="feature-link"><b>LGBTQ dating apps</b></a>
                    that focus only on swiping and quick matches, AffirmSpace promotes deeper
                    connections built on trust, shared experiences, and mutual understanding within the community.
                </p>
            </div>

            <div class="feature-card">
                <h3>🧠 Built-In Counselling Support</h3>
                <p>
                    AffirmSpace goes beyond social networking by integrating
                    <a href="{{ route('counselling') }}" class="feature-link"><b>LGBTQ-friendly counselling support</b></a>
                    directly into the platform. Users can access guidance for mental health, identity challenges,
                    relationships,
                    and personal growth through trained counsellors and supervised interns.
                </p>
            </div>

            <div class="feature-card">
                <h3>🌈 Identity & Pronoun Respect</h3>
                <p>
                    We believe identity deserves recognition and respect. AffirmSpace allows members to express themselves
                    through customizable profiles, pronoun options, and inclusive identity choices.
                </p>
            </div>

            <div class="feature-card">
                <h3>🚀 Our Vision</h3>
                <p>
                    Our vision is to build a trusted global platform where LGBTQ+ individuals can connect, share
                    experiences, and find the understanding and support they deserve. AffirmSpace aims to create a space
                    where community, relationships, and mental well-being are supported together in one safe digital
                    environment.
                </p>
            </div>

        </div>

    </section>
@endsection
