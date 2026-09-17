@extends('layouts.seo')

@section('meta')
    <meta name="description"
        content="Join AffirmSpace, a safe LGBTQ+ community platform to connect, share experiences, and build meaningful, supportive relationships.">

    <title>LGBTQ+ Community Platform – Connect & Share | AffirmSpace</title>

    <meta name="author" content="AffirmSpace">

    <meta name="keywords"
        content="LGBTQ+ community, LGBTQ+ community platform, online LGBTQ+ community, safe LGBTQ+ community, inclusive LGBTQ+ community">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
@endsection


@section('css')
    <style>
        /* ============================================================
       AFFIRMSPACE COMMUNITY PAGE
       FULL RESPONSIVE SYSTEM
       ALL CLASSES ARE SCOPED TO THIS PAGE
       ============================================================ */


        /* ------------------------------------------------------------
       GLOBAL PAGE SAFETY
       ------------------------------------------------------------ */

        .as-community-page {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;

            font-family: 'Inter', sans-serif;

            color: #222;
        }

        .as-community-page *,
        .as-community-page *::before,
        .as-community-page *::after {
            box-sizing: border-box;
        }


        /* ------------------------------------------------------------
       SHARED WIDTH
       ------------------------------------------------------------ */

        .as-community-container {
            width: 100%;
            max-width: 1200px;

            margin: 0 auto;

            padding-left: 24px;
            padding-right: 24px;
        }


        /* ============================================================
       HERO
       ============================================================ */

        .as-community-hero {
            width: 100%;

            background: #f9fafb;

            padding: 90px 0;
        }


        .as-community-hero-grid {
            display: grid;

            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);

            align-items: center;

            gap: 65px;
        }


        /* ------------------------------------------------------------
       HERO TEXT
       ------------------------------------------------------------ */

        .as-community-hero-text {
            min-width: 0;
        }


        .as-community-hero-title {
            margin: 0;

            color: #151515;

            font-size: clamp(38px, 4.5vw, 58px);

            font-weight: 800;

            line-height: 1.08;

            letter-spacing: -2px;

            overflow-wrap: anywhere;
        }


        .as-community-hero-subtitle {
            margin: 20px 0 15px;

            color: #dd2476;

            font-size: 21px;

            font-weight: 700;

            line-height: 1.4;
        }


        .as-community-hero-description {
            max-width: 560px;

            margin: 0;

            color: #555;

            font-size: 17px;

            line-height: 1.75;
        }


        /* ------------------------------------------------------------
       HERO BUTTON
       ------------------------------------------------------------ */

        .as-community-hero-buttons {
            display: flex;

            align-items: center;

            gap: 14px;

            flex-wrap: wrap;

            margin-top: 30px;
        }


        .as-community-primary-btn {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            min-height: 50px;

            padding: 14px 28px;

            color: #ffffff !important;

            background: linear-gradient(90deg,
                    #ff512f,
                    #dd2476);

            border-radius: 30px;

            font-size: 15px;

            font-weight: 700;

            line-height: 1.2;

            text-decoration: none !important;

            white-space: nowrap;

            box-shadow: 0 10px 25px rgba(221, 36, 118, 0.16);

            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease;
        }


        .as-community-primary-btn:hover {
            color: #ffffff !important;

            transform: translateY(-3px);

            box-shadow:
                0 14px 30px rgba(221, 36, 118, 0.23);
        }


        /* ------------------------------------------------------------
       HERO IMAGE
       ------------------------------------------------------------ */

        .as-community-hero-image {
            width: 100%;

            display: flex;

            align-items: center;
            justify-content: center;

            min-width: 0;
        }


        .as-community-hero-image img {
            display: block;

            width: 100%;

            max-width: 520px;
            height: auto;

            object-fit: contain;
        }


        /* ============================================================
       SHARED SECTION HEADING
       ============================================================ */

        .as-community-section-title {
            margin: 0;

            color: #151515;

            font-size: clamp(30px, 4vw, 44px);

            font-weight: 800;

            line-height: 1.15;

            letter-spacing: -1.2px;

            text-align: center;
        }


        /* ============================================================
       COMMUNITY FEATURES
       ============================================================ */

        .as-community-features {
            width: 100%;

            padding: 95px 0;

            background: #ffffff;
        }


        .as-community-feature-grid {
            display: grid;

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

            gap: 28px;

            margin-top: 55px;
        }


        .as-community-feature-card {
            min-width: 0;

            padding: 35px 28px;

            background: #f9fafb;

            border: 1px solid #f0f0f0;

            border-radius: 20px;

            text-align: center;

            box-shadow:
                0 10px 30px rgba(0, 0, 0, 0.045);

            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease,
                border-color 0.25s ease;
        }


        .as-community-feature-card:hover {
            transform: translateY(-6px);

            border-color: rgba(221, 36, 118, 0.14);

            box-shadow:
                0 18px 40px rgba(0, 0, 0, 0.08);
        }


        .as-community-feature-card img {
            display: block;

            width: 60px;
            height: 60px;

            margin: 0 auto 18px;

            object-fit: contain;
        }


        .as-community-feature-card h3 {
            margin: 0 0 12px;

            color: #222;

            font-size: 19px;

            font-weight: 700;

            line-height: 1.35;
        }


        .as-community-feature-card p {
            margin: 0;

            color: #666;

            font-size: 15px;

            line-height: 1.7;
        }


        /* ============================================================
       HOW COMMUNITY WORKS
       ============================================================ */

        .as-community-steps {
            width: 100%;

            padding: 95px 0;

            background: #f9fafb;
        }


        .as-community-steps-grid {
            display: grid;

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

            gap: 28px;

            margin-top: 55px;
        }


        .as-community-step-card {
            min-width: 0;

            padding: 35px 28px;

            background: #ffffff;

            border: 1px solid #eeeeee;

            border-radius: 20px;

            text-align: center;

            box-shadow:
                0 10px 30px rgba(0, 0, 0, 0.05);

            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease;
        }


        .as-community-step-card:hover {
            transform: translateY(-5px);

            box-shadow:
                0 16px 35px rgba(0, 0, 0, 0.08);
        }


        .as-community-step-btn {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            max-width: 100%;

            min-height: 46px;

            padding: 12px 22px;

            margin-bottom: 18px;

            color: #ffffff !important;

            border-radius: 30px;

            font-size: 14px;

            font-weight: 700;

            line-height: 1.25;

            text-decoration: none !important;

            white-space: normal;

            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease;
        }


        .as-community-step-btn:hover {
            color: #ffffff !important;

            transform: translateY(-3px);

            box-shadow:
                0 8px 20px rgba(0, 0, 0, 0.14);
        }


        .as-community-step-btn-1 {
            background:
                linear-gradient(45deg, #ff416c, #ff4b2b);
        }


        .as-community-step-btn-2 {
            background:
                linear-gradient(45deg, #ff9a44, #fc6076);
        }


        .as-community-step-btn-3 {
            background:
                linear-gradient(45deg, #a18cd1, #fbc2eb);
        }


        .as-community-step-card p {
            margin: 0;

            color: #666;

            font-size: 15px;

            line-height: 1.7;
        }


        /* ============================================================
       WHY COMMUNITY MATTERS
       ============================================================ */

        .as-community-why {
            width: 100%;

            padding: 95px 20px;

            background: #ffffff;

            text-align: center;
        }


        .as-community-why-text {
            max-width: 780px;

            margin: 28px auto 0;

            color: #5b5b5b;

            font-size: 16px;

            line-height: 1.8;
        }


        /* ============================================================
       COMMUNITY VALUES
       ============================================================ */

        .as-community-values {
            width: 100%;

            padding: 95px 0;

            background: #f9fafb;
        }


        .as-community-values-grid {
            display: grid;

            grid-template-columns:
                repeat(4, minmax(0, 1fr));

            gap: 20px;

            margin-top: 55px;
        }


        .as-community-value-card {
            min-width: 0;

            min-height: 190px;

            padding: 25px 18px;

            display: flex;

            flex-direction: column;

            align-items: center;
            justify-content: center;

            gap: 12px;

            background: #ffffff;

            border: 1px solid #eeeeee;

            border-radius: 18px;

            color: #333;

            font-size: 15px;

            font-weight: 700;

            line-height: 1.4;

            text-align: center;

            box-shadow:
                0 7px 22px rgba(0, 0, 0, 0.045);

            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease;
        }


        .as-community-value-card:hover {
            transform: translateY(-5px);

            box-shadow:
                0 14px 30px rgba(0, 0, 0, 0.08);
        }


        .as-community-value-card img {
            display: block;

            width: 75px;
            height: 75px;

            object-fit: contain;

            flex-shrink: 0;
        }


        /* ============================================================
       FINAL CTA
       ============================================================ */

        .as-community-cta {
            width: 100%;

            padding: 105px 20px;

            background:
                linear-gradient(90deg,
                    #ff512f,
                    #dd2476);

            color: #ffffff;

            text-align: center;
        }


        .as-community-cta h2 {
            margin: 0;

            color: #ffffff;

            font-size: clamp(32px, 4vw, 48px);

            font-weight: 800;

            line-height: 1.15;

            letter-spacing: -1px;
        }


        .as-community-cta p {
            max-width: 650px;

            margin: 20px auto 0;

            color: rgba(255, 255, 255, 0.94);

            font-size: 17px;

            line-height: 1.7;
        }


        .as-community-cta-btn {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            min-height: 50px;

            margin-top: 30px;

            padding: 14px 30px;

            color: #dd2476 !important;

            background: #ffffff;

            border-radius: 30px;

            font-size: 15px;

            font-weight: 700;

            text-decoration: none !important;

            box-shadow:
                0 10px 25px rgba(0, 0, 0, 0.13);

            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease;
        }


        .as-community-cta-btn:hover {
            color: #dd2476 !important;

            transform: translateY(-3px);

            box-shadow:
                0 15px 30px rgba(0, 0, 0, 0.18);
        }


        /* ============================================================
       TABLET
       ============================================================ */

        @media screen and (max-width: 1000px) {

            .as-community-hero {
                padding: 75px 0;
            }

            .as-community-hero-grid {
                grid-template-columns:
                    minmax(0, 1fr) minmax(0, 1fr);

                gap: 35px;
            }

            .as-community-hero-title {
                font-size: clamp(36px, 5vw, 48px);
            }

            .as-community-feature-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .as-community-steps-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .as-community-values-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

        }


        /* ============================================================
       MOBILE — 768px
       ============================================================ */

        @media screen and (max-width: 768px) {

            .as-community-container {
                padding-left: 18px;
                padding-right: 18px;
            }


            /* HERO */

            .as-community-hero {
                padding: 60px 0 65px;
            }

            .as-community-hero-grid {
                grid-template-columns: 1fr;

                gap: 35px;

                text-align: center;
            }

            .as-community-hero-text {
                width: 100%;
            }

            .as-community-hero-title {
                max-width: 650px;

                margin-left: auto;
                margin-right: auto;

                font-size: clamp(34px, 8vw, 46px);

                letter-spacing: -1.3px;
            }

            .as-community-hero-subtitle {
                font-size: 19px;
            }

            .as-community-hero-description {
                max-width: 600px;

                margin-left: auto;
                margin-right: auto;

                font-size: 16px;

                line-height: 1.7;
            }

            .as-community-hero-buttons {
                justify-content: center;
            }

            .as-community-hero-image {
                order: 2;
            }

            .as-community-hero-image img {
                width: min(100%, 460px);
            }


            /* FEATURES */

            .as-community-features {
                padding: 70px 0;
            }

            .as-community-feature-grid {
                grid-template-columns: 1fr;

                gap: 18px;

                margin-top: 38px;
            }

            .as-community-feature-card {
                padding: 30px 22px;
            }


            /* STEPS */

            .as-community-steps {
                padding: 70px 0;
            }

            .as-community-steps-grid {
                grid-template-columns: 1fr;

                gap: 18px;

                margin-top: 38px;
            }

            .as-community-step-card {
                padding: 30px 22px;
            }


            /* WHY */

            .as-community-why {
                padding: 70px 18px;
            }


            /* VALUES */

            .as-community-values {
                padding: 70px 0;
            }

            .as-community-values-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));

                gap: 15px;

                margin-top: 38px;
            }

            .as-community-value-card {
                min-height: 175px;

                padding: 22px 14px;

                font-size: 14px;
            }


            /* CTA */

            .as-community-cta {
                padding: 75px 18px;
            }

        }


        /* ============================================================
       SMALL PHONE — 480px
       ============================================================ */

        @media screen and (max-width: 480px) {

            .as-community-container {
                padding-left: 15px;
                padding-right: 15px;
            }


            /* HERO */

            .as-community-hero {
                padding: 45px 0 55px;
            }

            .as-community-hero-grid {
                gap: 25px;
            }

            .as-community-hero-title {
                font-size: 34px;

                line-height: 1.1;

                letter-spacing: -1px;
            }

            .as-community-hero-subtitle {
                margin-top: 15px;

                font-size: 18px;
            }

            .as-community-hero-description {
                font-size: 15px;

                line-height: 1.65;
            }

            .as-community-hero-buttons {
                width: 100%;

                margin-top: 24px;
            }

            .as-community-primary-btn {
                width: 100%;

                min-height: 48px;

                padding: 13px 20px;
            }

            .as-community-hero-image img {
                width: 100%;
                max-width: 360px;
            }


            /* SECTION TITLES */

            .as-community-section-title {
                font-size: 30px;

                letter-spacing: -0.8px;
            }


            /* FEATURES */

            .as-community-features {
                padding: 60px 0;
            }

            .as-community-feature-grid {
                margin-top: 32px;
            }

            .as-community-feature-card {
                padding: 27px 19px;

                border-radius: 17px;
            }

            .as-community-feature-card img {
                width: 55px;
                height: 55px;
            }

            .as-community-feature-card h3 {
                font-size: 18px;
            }

            .as-community-feature-card p {
                font-size: 14px;
            }


            /* STEPS */

            .as-community-steps {
                padding: 60px 0;
            }

            .as-community-steps-grid {
                margin-top: 32px;
            }

            .as-community-step-card {
                padding: 27px 19px;

                border-radius: 17px;
            }

            .as-community-step-btn {
                width: 100%;
            }

            .as-community-step-card p {
                font-size: 14px;
            }


            /* WHY */

            .as-community-why {
                padding: 60px 15px;
            }

            .as-community-why-text {
                margin-top: 20px;

                font-size: 15px;

                line-height: 1.7;
            }


            /* VALUES */

            .as-community-values {
                padding: 60px 0;
            }

            .as-community-values-grid {
                grid-template-columns: 1fr;

                gap: 14px;

                margin-top: 32px;
            }

            .as-community-value-card {
                min-height: 150px;

                padding: 20px;

                border-radius: 16px;
            }

            .as-community-value-card img {
                width: 65px;
                height: 65px;
            }


            /* CTA */

            .as-community-cta {
                padding: 65px 15px;
            }

            .as-community-cta h2 {
                font-size: 31px;
            }

            .as-community-cta p {
                font-size: 15px;
            }

            .as-community-cta-btn {
                width: 100%;

                margin-top: 25px;
            }

        }


        /* ============================================================
       VERY SMALL PHONES — 360px
       ============================================================ */

        @media screen and (max-width: 360px) {

            .as-community-hero-title {
                font-size: 31px;
            }

            .as-community-section-title {
                font-size: 27px;
            }

            .as-community-feature-card,
            .as-community-step-card {
                padding-left: 16px;
                padding-right: 16px;
            }

        }
    </style>
@endsection


@section('content')
    <main class="as-community-page">


        <!-- ======================================================
             HERO
             ====================================================== -->

        <section class="as-community-hero">

            <div class="as-community-container">

                <div class="as-community-hero-grid">


                    <!-- LEFT -->

                    <div class="as-community-hero-text">

                        <h1 class="as-community-hero-title">
                            🌈 AffirmSpace LGBTQ+ Community
                        </h1>

                        <h3 class="as-community-hero-subtitle">
                            Connect. Share. Belong.
                        </h3>

                        <p class="as-community-hero-description">
                            AffirmSpace provides a welcoming space where LGBTQ+ individuals can interact,
                            share experiences, and build genuine connections within a supportive and respectful community.
                        </p>


                        <div class="as-community-hero-buttons">

                            <a href="/register" class="as-community-primary-btn">
                                Join the Community
                            </a>

                        </div>

                    </div>


                    <!-- RIGHT -->

                    <div class="as-community-hero-image">

                        <img src="{{ asset('images/community/communityheader.png') }}"
                            alt="Diverse LGBTQ+ community celebrating pride together with rainbow flags, symbolizing inclusivity, equality, and support.">

                    </div>


                </div>

            </div>

        </section>



        <!-- ======================================================
             COMMUNITY FEATURES
             ====================================================== -->

        <section class="as-community-features">

            <div class="as-community-container">

                <h2 class="as-community-section-title">
                    Community Features
                </h2>


                <div class="as-community-feature-grid">


                    <!-- FEATURE 1 -->

                    <div class="as-community-feature-card">

                        <img src="{{ asset('/images/community/Inclusive_Community.jpeg') }}"
                            alt="Rainbow heart representing LGBTQ inclusivity">

                        <h3>
                            Inclusive Community
                        </h3>

                        <p>
                            AffirmSpace welcomes people from across the LGBTQ+ spectrum,
                            creating a space where identities are respected and celebrated.
                        </p>

                    </div>


                    <!-- FEATURE 2 -->

                    <div class="as-community-feature-card">

                        <img src="{{ asset('/images/community/Meaningful_Connections.jpeg') }}"
                            alt="Two hands shaking symbolizing friendship, connection and support">

                        <h3>
                            Meaningful Connections
                        </h3>

                        <p>
                            Meet like-minded individuals, engage in thoughtful conversations,
                            and build friendships within the community.
                        </p>

                    </div>


                    <!-- FEATURE 3 -->

                    <div class="as-community-feature-card">

                        <img src="{{ asset('/images/community/Safe_Respectful_Environment.jpeg') }}"
                            alt="Blue shield with lock showing safety and protection">

                        <h3>
                            Safe & Respectful Environment
                        </h3>

                        <p>
                            The platform prioritizes privacy, moderation, and respectful communication
                            so everyone feels comfortable participating.
                        </p>

                    </div>


                </div>

            </div>

        </section>



        <!-- ======================================================
             HOW COMMUNITY WORKS
             ====================================================== -->

        <section class="as-community-steps">

            <div class="as-community-container">

                <h2 class="as-community-section-title">
                    How the AffirmSpace Community Works
                </h2>


                <div class="as-community-steps-grid">


                    <!-- STEP 1 -->

                    <div class="as-community-step-card">

                        <a href="{{ route('login') }}" class="as-community-step-btn as-community-step-btn-1">
                            Join the Platform →
                        </a>

                        <p>
                            Create your profile and express your identity.
                        </p>

                    </div>


                    <!-- STEP 2 -->

                    <div class="as-community-step-card">

                        <a href="{{ route('chatAndDating') }}" class="as-community-step-btn as-community-step-btn-2">
                            Discover People →
                        </a>

                        <p>
                            Find members with shared interests and experiences.
                        </p>

                    </div>


                    <!-- STEP 3 -->

                    <div class="as-community-step-card">

                        <a href="{{ route('chat') }}" class="as-community-step-btn as-community-step-btn-3">
                            Start Conversations →
                        </a>

                        <p>
                            Interact through posts, comments, and discussions.
                        </p>

                    </div>


                </div>

            </div>

        </section>



        <!-- ======================================================
             WHY COMMUNITY MATTERS
             ====================================================== -->

        <section class="as-community-why">

            <div class="as-community-container">

                <h2 class="as-community-section-title">
                    Why Community Matters
                </h2>

                <p class="as-community-why-text">
                    For many LGBTQ+ individuals, finding a space where they feel understood can be transformative.
                    AffirmSpace is designed to create a positive digital environment where people can connect,
                    support one another, and feel a sense of belonging.
                </p>

            </div>

        </section>



        <!-- ======================================================
             COMMUNITY VALUES
             ====================================================== -->

        <section class="as-community-values">

            <div class="as-community-container">

                <h2 class="as-community-section-title">
                    Our Community Values
                </h2>


                <div class="as-community-values-grid">


                    <!-- VALUE 1 -->

                    <div class="as-community-value-card">

                        <img src="{{ asset('/images/community/Respect_for_All.png') }}"
                            alt="Hands holding a rainbow heart representing respect for all">

                        <span>
                            Respect for All
                        </span>

                    </div>


                    <!-- VALUE 2 -->

                    <div class="as-community-value-card">

                        <img src="{{ asset('/images/community/Supportive_Conversations.png') }}"
                            alt="Chat bubbles with heart representing supportive conversations">

                        <span>
                            Supportive Conversations
                        </span>

                    </div>


                    <!-- VALUE 3 -->

                    <div class="as-community-value-card">

                        <img src="{{ asset('/images/community/Safe_Digital_Spaces.png') }}"
                            alt="Shield with locks representing safe digital spaces">

                        <span>
                            Safe Digital Spaces
                        </span>

                    </div>


                    <!-- VALUE 4 -->

                    <div class="as-community-value-card">

                        <img src="{{ asset('/images/community/Meaningful Connections_2.png') }}"
                            alt="Puzzle heart representing meaningful connections">

                        <span>
                            Meaningful Connections
                        </span>

                    </div>


                </div>

            </div>

        </section>



        <!-- ======================================================
             FINAL CTA
             ====================================================== -->

        <section class="as-community-cta">

            <div class="as-community-container">

                <h2>
                    Become Part of the Community
                </h2>

                <p>
                    Join AffirmSpace and connect with people who share your experiences and values.
                </p>

                <a href="/register" class="as-community-cta-btn">
                    Join the Community
                </a>

            </div>

        </section>


    </main>
@endsection
