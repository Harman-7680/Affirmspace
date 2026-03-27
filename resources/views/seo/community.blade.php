@extends('layouts.seo')

@section('meta')
    <meta name="description"
        content="Join AffirmSpace, a safe LGBTQ+ community platform to connect, share experiences, and build meaningful, supportive relationships.">

    <title>LGBTQ+ Community Platform – Connect & Share | AffirmSpace</title>
    <meta name="author" content="AffirmSpace">
    <meta name="keywords"
        content="LGBTQ+ community, LGBTQ+ community platform, online LGBTQ+ community, safe LGBTQ+ community, inclusive LGBTQ+ community				">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('css')
    <style>
        .community-page {
            font-family: 'Inter', sans-serif;
        }

        /* HERO */
        .community-hero {
            background: #f9fafb;
            padding: 80px 0;
        }

        /* CENTER CONTENT */
        .community-hero .container {
            max-width: 1200px;
            margin: auto;
            padding: 0 20px;
        }

        /* GRID LAYOUT */
        .community-hero .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 50px;
        }

        /* TEXT */

        .community-hero .hero-text h1 {
            font-size: 46px;
            font-weight: 700;
            color: #222;
            line-height: 1.2;
        }

        .community-hero .hero-subtitle {
            color: #dd2476;
            margin: 15px 0;
            font-weight: 600;
            font-size: 20px;
        }

        .community-hero .hero-description {
            max-width: 520px;
            color: #555;
            line-height: 1.6;
        }

        /* BUTTON */

        .community-hero .hero-buttons {
            margin-top: 25px;
        }

        .community-hero .primary-btn {
            display: inline-block;
            padding: 14px 30px;
            border-radius: 30px;
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: white;
            font-weight: 600;
            text-decoration: none;
        }

        /* IMAGE */

        .community-hero .hero-image img {
            width: 100%;
            max-width: 450px;
        }

        /* ============================= */
        /* RESPONSIVE */
        /* ============================= */

        @media (max-width: 900px) {

            .community-hero .hero-grid {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .community-hero .hero-description {
                margin: auto;
            }
        }


        /* FEATURES */

        .community-features {
            padding: 90px 8%;
            text-align: center;
            background: white;
        }

        .feature-grid {
            margin-top: 50px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;
        }

        .feature-card {
            background: #f9fafb;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        /* STEPS */
        .community-steps {
            padding: 90px 8%;
            background: #f9fafb;
            text-align: center;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;
            margin-top: 50px;
        }

        .step-card {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        /* WHY */
        .community-why {
            padding: 90px 8%;
            text-align: center;
            background: white;
        }

        .community-why p {
            max-width: 750px;
            margin: auto;
            color: #555;
        }

        /* VALUES */
        .community-values {
            padding: 90px 8%;
            background: #f9fafb;
            text-align: center;
        }

        .values-grid {
            margin-top: 50px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .value-card {
            background: white;
            padding: 22px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
            font-weight: 600;
        }

        /* CTA */
        .community-cta {
            padding: 100px 8%;
            text-align: center;
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: white;
        }

        .cta-btn {
            display: inline-block;
            margin-top: 25px;
            padding: 14px 30px;
            border-radius: 30px;
            background: white;
            color: #dd2476;
            font-weight: 600;
            text-decoration: none;
        }

        /* MOBILE */

        @media(max-width:768px) {

            .community-hero {
                padding: 70px 6%;
            }

        }

        /* community differnt buttons */

        .step-btn {
            display: inline-block;
            padding: 12px 22px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            color: white;
            transition: all 0.3s ease;
            margin-bottom: 10px;
        }

        /* Button Colors */
        .btn-1 {
            background: linear-gradient(45deg, #ff416c, #ff4b2b);
            /* red-pink */
        }

        .btn-2 {
            background: linear-gradient(45deg, #ff9a44, #fc6076);
            /* orange */
        }

        .btn-3 {
            background: linear-gradient(45deg, #a18cd1, #fbc2eb);
            /* purple */
        }

        /* Hover effect */
        .step-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
    </style>
@endsection

@section('content')
    <main class="community-page">

        <!-- HERO -->

        <section class="community-hero">
            <div class="container">

                <div class="hero-grid">

                    <!-- LEFT SIDE -->
                    <div class="hero-text">
                        <h1>🌈 AffirmSpace LGBTQ+ Community</h1>

                        <h3 class="hero-subtitle">Connect. Share. Belong.</h3>

                        <p class="hero-description">
                            AffirmSpace provides a welcoming space where LGBTQ+ individuals can interact,
                            share experiences, and build genuine connections within a supportive and respectful community.
                        </p>

                        <div class="hero-buttons">
                            <a href="/register" class="primary-btn">Join the Community</a>
                        </div>
                    </div>

                    <!-- RIGHT SIDE -->
                    <div class="hero-image">
                        <img src="images/community/communityheader.png" alt="Community">
                    </div>

                </div>

            </div>
        </section>

        <!-- COMMUNITY FEATURES -->

        <section class="community-features">

            <h2>Community Features</h2>

            <div class="feature-grid">

                <div class="feature-card">
                    <img src="{{ asset('images/community/Inclusive_Community.jpeg') }}" height="50"
                        alt="">
                    <h3> Inclusive Community</h3>
                    <p>
                        AffirmSpace welcomes people from across the LGBTQ+ spectrum, creating a space
                        where identities are respected and celebrated.
                    </p>
                </div>

                <div class="feature-card">
                    <img src="{{ asset('images/community/Meaningful_Connections.jpeg') }}" height="50"
                        alt="">
                    <h3> Meaningful Connections</h3>
                    <p>
                        Meet like-minded individuals, engage in thoughtful conversations,
                        and build friendships within the community.
                    </p>
                </div>

                <div class="feature-card">
                    <img src="{{ asset('images/community/Safe_Respectful_Environment.jpeg') }}" height="50"
                        alt="">
                    <h3> Safe & Respectful Environment</h3>
                    <p>
                        The platform prioritizes privacy, moderation, and respectful communication
                        so everyone feels comfortable participating.
                    </p>
                </div>

            </div>

        </section>

        <!-- HOW COMMUNITY WORKS -->
        <section class="community-steps">

            <h2>How the AffirmSpace Community Works</h2>

            <div class="steps-grid">

                <div class="step-card">
                    <a href="{{ route('login') }}" class="step-btn btn-1">Join the Platform →</a>
                    <p>Create your profile and express your identity.</p>
                </div>

                <div class="step-card">
                    <a href="{{ route('chatAndDating') }}" class="step-btn btn-2">Discover People →</a>
                    <p>Find members with shared interests and experiences.</p>
                </div>

                <div class="step-card">
                    <a href="{{ route('chat') }}" class="step-btn btn-3">Start Conversations →</a>
                    <p>Interact through posts, comments, and discussions.</p>
                </div>

            </div>

        </section>
        <!-- WHY COMMUNITY MATTERS -->

        <section class="community-why">

            <h2>Why Community Matters</h2>

            <p>
                For many LGBTQ+ individuals, finding a space where they feel understood can be transformative.
                AffirmSpace is designed to create a positive digital environment where people can connect,
                support one another, and feel a sense of belonging.
            </p>

        </section>

        <!-- COMMUNITY VALUES -->

        <section class="community-values">

            <h2>Our Community Values</h2>

            <div class="values-grid">

                <div class="value-card" style="display: flex; align-items: center; justify-content: center;"><img
                        src="{{ asset('images/community/Respect_for_All.png') }}" height="75" alt="">
                    Respect for All</div>

                <div class="value-card" style="display: flex; align-items: center; justify-content: center;"><img
                        src="{{ asset('images/community/Supportive_Conversations.png') }}" height="75"
                        alt=""> Supportive Conversations</div>

                <div class="value-card" style="display: flex; align-items: center; justify-content: center;"><img
                        src="{{ asset('images/community/Safe_Digital_Spaces.png') }}" height="75" alt="">
                    Safe Digital Spaces</div>

                <div class="value-card" style="display: flex; align-items: center; justify-content: center;"><img
                        src="{{ asset('images/community/Meaningful Connections_2.png') }}" height="75"
                        alt=""> Meaningful Connections</div>

            </div>

        </section>

        <!-- CTA -->

        <section class="community-cta">

            <h2>Become Part of the Community</h2>

            <p>
                Join AffirmSpace and connect with people who share your experiences and values.
            </p>

            <a href="/register" class="cta-btn">Join the Community</a>

        </section>

    </main>
@endsection
