@extends('layouts.seo')

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community – AffirmSpace</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('css')
    <style>
        .community-page {
            font-family: 'Inter', sans-serif;
        }

        /* HERO */

        .community-hero {
            padding: 90px 8%;
            text-align: center;
            background: #f9fafb;
        }

        .hero-subtitle {
            color: #dd2476;
            margin: 10px 0;
            font-weight: 600;
        }

        .hero-description {
            max-width: 700px;
            margin: auto;
            color: #555;
            margin-bottom: 30px;
        }

        .primary-btn {
            display: inline-block;
            padding: 14px 32px;
            border-radius: 30px;
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: white;
            font-weight: 600;
            text-decoration: none;
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
    </style>
@endsection

@section('content')
    <main class="community-page">

        <!-- HERO -->

        <section class="community-hero">

            <h1>🌈 AffirmSpace LGBTQ+ Community</h1>

            <h3 class="hero-subtitle">Connect. Share. Belong.</h3>

            <p class="hero-description">
                AffirmSpace provides a welcoming space where LGBTQ+ individuals can interact,
                share experiences, and build genuine connections within a supportive and respectful community.
            </p>

            <a href="/register" class="primary-btn">Join the Community</a>

        </section>

        <!-- COMMUNITY FEATURES -->

        <section class="community-features">

            <h2>Community Features</h2>

            <div class="feature-grid">

                <div class="feature-card">
                    <img src="{{ asset('images/community/Inclusive_Community.jpeg') }}" height="50" alt="">
                    <h3> Inclusive Community</h3>
                    <p>
                        AffirmSpace welcomes people from across the LGBTQ+ spectrum, creating a space
                        where identities are respected and celebrated.
                    </p>
                </div>

                <div class="feature-card">
                    <img src="{{ asset('images/community/Meaningful_Connections.jpeg') }}" height="50" alt="">
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
                    <h3>Join the Platform</h3>
                    <p>Create your profile and express your identity.</p>
                </div>

                <div class="step-card">
                    <h3>Discover People</h3>
                    <p>Find members with shared interests and experiences.</p>
                </div>

                <div class="step-card">
                    <h3>Start Conversations</h3>
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
                        src="{{ asset('images/community/Respect_for_All.jpeg') }}" height="30" alt="">
                    Respect for All</div>

                <div class="value-card" style="display: flex; align-items: center; justify-content: center;"><img
                        src="{{ asset('images/community/Supportive_Conversations.jpeg') }}" height="30" alt="">
                    Supportive Conversations</div>

                <div class="value-card" style="display: flex; align-items: center; justify-content: center;"><img
                        src="{{ asset('images/community/Safe_Digital_Spaces.jpeg') }}" height="30" alt=""> Safe
                    Digital Spaces</div>

                <div class="value-card" style="display: flex; align-items: center; justify-content: center;"><img
                        src="{{ asset('images/community/Meaningful Connections_2.jpeg') }}" height="30" alt="">
                    Meaningful Connections</div>

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
