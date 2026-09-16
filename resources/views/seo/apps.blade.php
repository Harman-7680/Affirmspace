@extends('layouts.seo')

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Affirmspace for gay, lesbian, bisexual, transgender, queer and non-binary people seeking chat, dating,
        friendships and support.</title>
    <meta name="description"
        content="Download Affirmspace for gay, lesbian, bisexual, transgender, queer and non-binary people seeking chat, dating, friendships and support.">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
@endsection


@section('css')
    <style>
        /* =========================
           HERO SECTION
        ========================= */

        .hero-section {
            width: 100%;
            background: #fff;
            overflow: hidden;
            padding: 70px 6%;
            position: relative;
            font-family: sans-serif;
        }

        /* =========================
           MAIN CONTAINER
        ========================= */

        .hero-container {
            max-width: 1300px;
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
        }

        /* =========================
           LEFT SIDE
        ========================= */

        .hero-left {
            width: 50%;
            position: relative;
            z-index: 5;
        }

        /* HEADING */

        .hero-left h1 {
            font-size: 58px;
            line-height: 1.12;
            font-weight: 800;
            color: #18153b;
            margin-bottom: 24px;
            letter-spacing: -1px;
        }

        /* PURPLE TEXT */

        .hero-left h1 span {
            color: #7c3aed;
        }

        /* PARAGRAPH */

        .hero-left p {
            font-size: 19px;
            line-height: 1.8;
            color: #555;
            max-width: 520px;
            margin-bottom: 38px;
        }


        /* =========================
           STORE BUTTONS
        ========================= */

        .hero-store-buttons {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 42px;
        }

        /* BUTTON IMAGES */

        .hero-store-buttons img {
            height: 58px;
            width: auto;
            transition: 0.3s ease;
        }

        /* HOVER */

        .hero-store-buttons img:hover {
            transform: translateY(-3px);
        }


        /* =========================
           FEATURES
        ========================= */

        .hero-features {
            display: flex;
            align-items: center;
            gap: 32px;
            flex-wrap: wrap;
        }

        /* SINGLE FEATURE */

        .feature-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ICON */

        .feature-item span {
            font-size: 18px;
        }

        /* TEXT */

        .feature-item p {
            margin: 0;
            font-size: 15px;
            color: #555;
            font-weight: 600;
            line-height: normal;
        }


        /* =========================
           RIGHT SIDE
        ========================= */

        .hero-right {
            width: 50%;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 650px;
        }

        /* PURPLE BACKGROUND SHAPE */

        .hero-bg {
            position: absolute;
            width: 620px;
            height: 620px;
            background: #f4ebff;
            border-radius: 50px;
            right: -120px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1;
        }

        /* HEART */

        .hero-heart {
            position: absolute;
            left: 90px;
            top: 48%;
            transform: translateY(-50%);
            font-size: 80px;
            color: #a855f7;
            z-index: 2;
            font-weight: 300;
        }

        /* MOBILE IMAGE */

        .hero-mobile {
            width: 450px;
            max-width: 100%;
            position: relative;
            z-index: 3;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media(max-width:1100px) {

            .hero-left h1 {
                font-size: 46px;
            }

            .hero-bg {
                width: 500px;
                height: 500px;
            }

            .hero-mobile {
                width: 290px;
            }

        }


        /* TABLET */

        @media(max-width:900px) {

            .hero-container {
                flex-direction: column;
                text-align: center;
            }

            .hero-left {
                width: 100%;
            }

            .hero-right {
                width: 100%;
                min-height: 480px;
            }

            .hero-left p {
                margin-left: auto;
                margin-right: auto;
            }

            .hero-store-buttons {
                justify-content: center;
            }

            .hero-features {
                justify-content: center;
            }

            .hero-bg {
                width: 430px;
                height: 430px;
                right: auto;
            }

            .hero-heart {
                left: 10%;
                font-size: 60px;
            }

            .hero-mobile {
                width: 260px;
            }

        }


        /* MOBILE */

        @media(max-width:600px) {

            .hero-section {
                padding: 55px 5%;
            }

            .hero-left h1 {
                font-size: 36px;
            }

            .hero-left p {
                font-size: 16px;
            }

            .hero-store-buttons img {
                height: 52px;
            }

            .hero-features {
                gap: 18px;
            }

            .feature-item p {
                font-size: 14px;
            }

            .hero-bg {
                width: 320px;
                height: 320px;
            }

            .hero-mobile {
                width: 220px;
            }

            .hero-heart {
                font-size: 45px;
                left: 0;
            }

        }

        /* ===================================
           MAIN SECTION
        =================================== */

        .app-features-section {
            width: 100%;
            background: #fff;
            padding: 80px 6%;
            overflow: hidden;
            font-family: sans-serif;
        }

        /* ===================================
           ROW
        =================================== */

        .feature-row {
            max-width: 1300px;
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 60px;
            margin-bottom: 120px;
            position: relative;
        }

        /* REVERSE ROW */

        .reverse-row {
            flex-direction: row;
        }

        /* ===================================
           IMAGE SIDE
        =================================== */

        .feature-image-side {
            flex: 1;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* MOBILE IMAGE */

        .feature-mobile-image {
            width: 300px;
            max-width: 100%;
            transition: 0.4s ease;
            position: relative;
            z-index: 3;
        }

        /* IMAGE HOVER */

        .feature-mobile-image:hover {
            transform: scale(1.05);
        }

        /* FLOATING HEART */

        .floating-heart {
            position: absolute;
            left: 10px;
            top: 20%;
            font-size: 65px;
            color: #e9c9ff;
            z-index: 1;
        }

        /* ===================================
           CONTENT SIDE
        =================================== */

        .feature-content-side {
            flex: 1;
        }

        /* NUMBER */

        .feature-number {
            width: 48px;
            height: 48px;
            background: #7c3aed;
            color: #fff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-bottom: 22px;
            font-size: 18px;
        }

        /* TITLE */

        .feature-content-side h2 {
            font-size: 48px;
            line-height: 1.2;
            color: #17153a;
            margin-bottom: 22px;
            font-weight: 800;
        }

        /* PURPLE TEXT */

        .feature-content-side h2 span {
            color: #7c3aed;
        }

        /* DESCRIPTION */

        .feature-content-side p {
            font-size: 18px;
            line-height: 1.9;
            color: #555;
            margin-bottom: 35px;
            max-width: 560px;
        }

        /* ===================================
           MINI CARDS
        =================================== */

        .mini-feature-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
        }

        /* CARD */

        .mini-feature-card {
            width: 180px;
            min-height: 130px;
            border: 1px solid #ececec;
            border-radius: 22px;
            padding: 24px 18px;
            background: #fff;
            transition: 0.35s ease;
            cursor: pointer;
        }

        /* CARD HOVER */

        .mini-feature-card:hover {
            transform: translateY(-8px) scale(1.03);
            box-shadow: 0 15px 35px rgba(124, 58, 237, 0.12);
        }

        /* ICON */

        .mini-icon {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: #f5ecff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 18px;
            transition: 0.35s ease;
        }

        /* ICON HOVER */

        .mini-feature-card:hover .mini-icon {
            transform: scale(1.15);
        }

        /* CARD TEXT */

        .mini-feature-card h4 {
            font-size: 16px;
            line-height: 1.5;
            color: #17153a;
            margin: 0;
        }

        /* ===================================
           RIGHT SIDE ICONS
        =================================== */

        .side-icons {
            display: flex;
            flex-direction: column;
            gap: 28px;
        }

        /* ITEM */

        .side-icon-item {
            display: flex;
            align-items: center;
            gap: 14px;
            transition: 0.3s ease;
        }

        /* HOVER */

        .side-icon-item:hover {
            transform: translateX(8px);
        }

        /* ICON */

        .side-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #f5ecff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            transition: 0.3s ease;
        }

        /* ICON HOVER */

        .side-icon-item:hover .side-icon {
            transform: scale(1.15);
        }

        /* TEXT */

        .side-icon-item p {
            margin: 0;
            font-size: 17px;
            color: #17153a;
            font-weight: 600;
            line-height: 1.5;
        }

        /* ===================================
           PRIVACY GRID
        =================================== */

        .privacy-grid .mini-feature-card {
            width: 165px;
        }

        /* ===================================
           RESPONSIVE
        =================================== */

        @media(max-width:1100px) {

            .feature-content-side h2 {
                font-size: 40px;
            }

            .feature-mobile-image {
                width: 260px;
            }

        }

        @media(max-width:900px) {

            .feature-row {
                flex-direction: column;
                text-align: center;
                margin-bottom: 90px;
            }

            .feature-content-side p {
                margin-left: auto;
                margin-right: auto;
            }

            .mini-feature-grid {
                justify-content: center;
            }

            .side-icons {
                align-items: center;
            }

            .feature-mobile-image {
                width: 240px;
            }

        }

        @media(max-width:600px) {

            .app-features-section {
                padding: 60px 5%;
            }

            .feature-content-side h2 {
                font-size: 34px;
            }

            .feature-content-side p {
                font-size: 16px;
            }

            .mini-feature-card {
                width: 100%;
            }

            .privacy-grid .mini-feature-card {
                width: 100%;
            }

            .feature-mobile-image {
                width: 220px;
            }

            .floating-heart {
                font-size: 45px;
            }

        }

        /* ===================================
           SOCIAL APP SECTION
        =================================== */

        .social-app-section {
            width: 100%;
            background: #faf7ff;
            padding: 80px 6%;
            overflow: hidden;
            font-family: sans-serif;
        }

        /* ===================================
           CONTAINER
        =================================== */

        .social-app-container {
            max-width: 1300px;
            margin: auto;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 60px;
        }

        /* ===================================
           LEFT SIDE
        =================================== */

        .social-left {
            width: 33%;
        }

        /* NUMBER */

        .social-number {
            width: 50px;
            height: 50px;
            background: #7c3aed;
            color: #fff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 24px;
        }

        /* TITLE */

        .social-left h2 {
            font-size: 48px;
            line-height: 1.2;
            color: #17153a;
            margin-bottom: 24px;
            font-weight: 800;
        }

        /* PURPLE TEXT */

        .social-left h2 span {
            color: #7c3aed;
        }

        /* DESCRIPTION */

        .social-left p {
            font-size: 18px;
            line-height: 1.9;
            color: #555;
            max-width: 420px;
        }

        /* ===================================
           RIGHT SIDE
        =================================== */

        .social-right {
            width: 67%;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
        }

        /* ===================================
           CARD
        =================================== */

        .social-card {
            background: #fff;
            border-radius: 24px;
            padding: 28px 26px;
            display: flex;
            align-items: flex-start;
            gap: 18px;
            border: 1px solid #f0ebff;
            transition: 0.35s ease;
            cursor: pointer;
        }

        /* CARD HOVER */

        .social-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 18px 40px rgba(124, 58, 237, 0.12);
        }

        /* ===================================
           ICON
        =================================== */

        .social-icon {
            width: 68px;
            height: 68px;
            min-width: 68px;
            border-radius: 18px;
            background: #f6eeff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            transition: 0.35s ease;
        }

        /* ICON HOVER */

        .social-card:hover .social-icon {
            transform: scale(1.12);
        }

        /* ===================================
           CONTENT
        =================================== */

        .social-card-content h3 {
            font-size: 22px;
            color: #17153a;
            margin-bottom: 10px;
            font-weight: 700;
            line-height: 1.4;
        }

        .social-card-content p {
            font-size: 16px;
            line-height: 1.7;
            color: #666;
            margin: 0;
        }

        /* ===================================
           RESPONSIVE
        =================================== */

        @media(max-width:1000px) {

            .social-app-container {
                flex-direction: column;
            }

            .social-left,
            .social-right {
                width: 100%;
            }

            .social-left {
                text-align: center;
            }

            .social-left p {
                margin: auto;
            }

        }

        @media(max-width:700px) {

            .social-right {
                grid-template-columns: 1fr;
            }

            .social-left h2 {
                font-size: 36px;
            }

            .social-card {
                padding: 24px 20px;
            }

            .social-card-content h3 {
                font-size: 20px;
            }

            .social-card-content p {
                font-size: 15px;
            }

        }

        /* ===================================
           HOW IT WORKS SECTION
        =================================== */

        .how-it-works-section {
            width: 100%;
            background: #fff;
            padding: 80px 6%;
            overflow: hidden;
            font-family: sans-serif;
            text-align: center;
        }

        /* ===================================
           TITLE
        =================================== */

        .how-title {
            font-size: 46px;
            color: #17153a;
            font-weight: 800;
            margin-bottom: 70px;
        }

        /* ===================================
           STEPS CONTAINER
        =================================== */

        .how-steps-container {
            max-width: 1300px;
            margin: auto;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            gap: 28px;
            flex-wrap: wrap;
        }

        /* ===================================
           SINGLE STEP
        =================================== */

        .how-step {
            width: 220px;
            position: relative;
        }

        /* ===================================
           CIRCLE
        =================================== */

        .step-circle {
            width: 140px;
            height: 140px;
            border: 2px solid #eee;
            border-radius: 50%;
            margin: auto;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            transition: 0.35s ease;
        }

        /* HOVER */

        .step-circle:hover {
            transform: translateY(-8px);
            box-shadow: 0 18px 40px rgba(124, 58, 237, 0.12);
        }

        /* ===================================
           STEP NUMBER
        =================================== */

        .step-number {
            position: absolute;
            top: -8px;
            right: 10px;
            width: 38px;
            height: 38px;
            background: #7c3aed;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 700;
        }

        /* OTHER COLORS */

        .pink-number {
            background: #ff4fa0;
        }

        .yellow-number {
            background: #f5b400;
        }

        .green-number {
            background: #4caf50;
        }

        /* ===================================
           ICON
        =================================== */

        .step-icon {
            font-size: 48px;
            transition: 0.35s ease;
        }

        /* ICON HOVER */

        .step-circle:hover .step-icon {
            transform: scale(1.15);
        }

        /* ===================================
           TEXT
        =================================== */

        .how-step h3 {
            font-size: 22px;
            color: #17153a;
            margin-top: 28px;
            margin-bottom: 12px;
            font-weight: 700;
            line-height: 1.4;
        }

        .how-step p {
            font-size: 16px;
            line-height: 1.7;
            color: #666;
            margin: 0;
        }

        /* ===================================
           ARROW
        =================================== */

        .step-arrow {
            font-size: 52px;
            color: #b9a5d8;
            margin-top: 35px;
            font-weight: 300;
        }

        /* ===================================
           RESPONSIVE
        =================================== */

        @media(max-width:1000px) {

            .how-steps-container {
                gap: 45px;
            }

            .step-arrow {
                display: none;
            }

        }

        @media(max-width:700px) {

            .how-title {
                font-size: 34px;
                margin-bottom: 50px;
            }

            .how-step {
                width: 100%;
                max-width: 320px;
            }

            .step-circle {
                width: 120px;
                height: 120px;
            }

            .step-icon {
                font-size: 42px;
            }

            .how-step h3 {
                font-size: 20px;
            }

            .how-step p {
                font-size: 15px;
            }

        }

        /* ===================================
           CTA SECTION
        =================================== */

        .cta-section {
            width: 100%;
            padding: 80px 2%;
            background: #fff;
            overflow: hidden;
            font-family: sans-serif;
        }

        /* ===================================
           CONTAINER
        =================================== */

        .cta-container {
            width: 100%;
            max-width: 1600px;
            margin: auto;
            background: linear-gradient(90deg, #6f2cff 0%, #c13cff 45%, #ff6b7a 100%);
            border-radius: 40px;
            padding: 55px 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 50px;
            position: relative;
            overflow: hidden;
        }

        /* ===================================
           LEFT SIDE
        =================================== */

        .cta-left {
            display: flex;
            align-items: flex-start;
            gap: 28px;
            z-index: 5;
        }

        /* LOGO */

        .cta-logo {
            font-size: 72px;
            line-height: 1;
            animation: floatLogo 3s ease-in-out infinite;
        }

        /* FLOAT */

        @keyframes floatLogo {

            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-8px);
            }

            100% {
                transform: translateY(0px);
            }

        }

        /* TEXT */

        .cta-text h2 {
            font-size: 48px;
            color: #fff;
            font-weight: 800;
            margin-bottom: 16px;
            line-height: 1.2;
        }

        .cta-text p {
            font-size: 19px;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.8;
            margin-bottom: 30px;
            max-width: 520px;
        }

        /* ===================================
           BUTTONS
        =================================== */

        .cta-buttons {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        /* BUTTON IMAGE */

        .cta-buttons img {
            height: 58px;
            width: auto;
            transition: 0.35s ease;
        }

        /* HOVER */

        .cta-buttons img:hover {
            transform: translateY(-4px) scale(1.03);
        }

        /* ===================================
           RIGHT SIDE
        =================================== */

        .cta-right {
            display: flex;
            align-items: flex-end;
            gap: 18px;
            position: relative;
        }

        /* MOBILE IMAGES */

        .cta-mobile {
            object-fit: contain;
            transition: 0.4s ease;
            position: relative;
            z-index: 2;
        }

        /* IMAGE HOVER */

        .cta-mobile:hover {
            transform: translateY(-10px) scale(1.04);
        }

        /* BIG */

        .mobile-big {
            width: 140px;
            z-index: 5;
        }

        /* MEDIUM */

        .mobile-medium {
            width: 180px;
            margin-bottom: -15px;
            z-index: 4;
        }

        /* SMALL */

        .mobile-small {
            width: 115px;
            margin-bottom: -28px;
            z-index: 3;
        }

        /* ===================================
           RESPONSIVE
        =================================== */

        @media(max-width:1100px) {

            .cta-container {
                flex-direction: column;
                text-align: center;
                padding: 55px 40px;
            }

            .cta-left {
                flex-direction: column;
                align-items: center;
            }

            .cta-text p {
                margin-left: auto;
                margin-right: auto;
            }

            .cta-buttons {
                justify-content: center;
            }

        }

        @media(max-width:700px) {

            .cta-section {
                padding: 60px 5%;
            }

            .cta-container {
                border-radius: 30px;
                padding: 45px 25px;
            }

            .cta-text h2 {
                font-size: 34px;
            }

            .cta-text p {
                font-size: 16px;
            }

            .cta-buttons img {
                height: 52px;
            }

            .cta-right {
                gap: 10px;
            }

            .mobile-big {
                width: 140px;
            }

            .mobile-medium {
                width: 120px;
            }

            .mobile-small {
                width: 105px;
            }

        }
    </style>
@endsection


@section('content')
    <!-- =========================
             HERO SECTION START
        ========================= -->

    <section class="hero-section">

        <div class="hero-container">

            <!-- =========================
                     LEFT CONTENT
                ========================= -->
            <div class="hero-left">

                <h1>
                    Connect, Chat,<br>
                    Date & Find Support —
                    <span>All in One Place</span>
                </h1>

                <p>
                    Join thousands of users looking for meaningful
                    connections, community support, friendships,
                    dating opportunities, and professional counselling.
                </p>


                <!-- =========================
                         STORE BUTTONS
                    ========================= -->
                <div class="hero-store-buttons">

                    <!-- GOOGLE PLAY -->
                    <a href="https://play.google.com/store/apps/details?id=com.affirmspace.app" target="_blank">

                        <img src="{{ asset('images/googlebadge.png') }}" alt="Google Play">

                    </a>


                    <!-- APP STORE -->
                    <!-- Uncomment later -->

                    <!--
                        <a href="#" target="_blank">

                            <img src="{{ asset('images/applebadge.svg') }}"
                                alt="App Store">

                        </a>
                        -->

                </div>


                <!-- =========================
                         FEATURES
                    ========================= -->
                <div class="hero-features">

                    <div class="feature-item">
                        <span>🛡️</span>
                        <p>LGBTQ+ Inclusive</p>
                    </div>

                    <div class="feature-item">
                        <span>💚</span>
                        <p>Safe Community</p>
                    </div>

                    <div class="feature-item">
                        <span>👨‍⚕️</span>
                        <p>Professional Counsellors</p>
                    </div>

                    <div class="feature-item">
                        <span>🔒</span>
                        <p>Privacy Focused</p>
                    </div>

                </div>

            </div>


            <!-- =========================
                     RIGHT IMAGE SIDE
                ========================= -->
            <div class="hero-right">

                <!-- BACKGROUND SHAPE -->
                <div class="hero-bg"></div>

                <!-- HEART -->
                <div class="hero-heart">♡</div>

                <!-- MOBILE SCREENSHOT -->
                <img src="images/app_images/top.png" alt="AffirmSpace App" class="hero-mobile">

            </div>

        </div>

    </section>

    @include('seo.how_affirmspace_work')


    <!-- =========================
             HERO SECTION END
        ========================= -->


    <!-- ===================================
             FEATURES SECTION START
        =================================== -->

    <section class="app-features-section">


        <!-- ===================================
                 FEATURE ROW 1
            =================================== -->
        <div class="feature-row">

            <!-- MOBILE IMAGE -->
            <div class="feature-image-side">

                <div class="floating-heart">♡</div>

                <img src="images/app_images/1.png" alt="Find Your Vibe" class="feature-mobile-image">

            </div>





            <!-- CONTENT -->
            <div class="feature-content-side">

                <div class="feature-number">
                    01
                </div>

                <h2>
                    Find People Who <br>
                    <span>Match Your Vibe</span>
                </h2>

                <p>
                    Not everyone is looking for the same thing.
                    Some people want deep conversations.
                    Some are looking for friendships. Others want
                    emotional support, dating, travel partners,
                    or simply a safe space to talk.
                    AffirmSpace helps you express your personality
                    and connect with people who genuinely align
                    with your interests and values.
                </p>


                <!-- SMALL CARDS -->
                <div class="mini-feature-grid">

                    <div class="mini-feature-card">
                        <div class="mini-icon">👥</div>
                        <h4>Personalized Matching</h4>
                    </div>

                    <div class="mini-feature-card">
                        <div class="mini-icon">✨</div>
                        <h4>Better Recommendations</h4>
                    </div>

                    <div class="mini-feature-card">
                        <div class="mini-icon">💜</div>
                        <h4>Authentic Connections</h4>
                    </div>

                    <div class="mini-feature-card">
                        <div class="mini-icon">💗</div>
                        <h4>Interest-Based Discovery</h4>
                    </div>

                </div>

            </div>

        </div>



        <!-- ===================================
                 FEATURE ROW 2
            =================================== -->
        <div class="feature-row reverse-row">


            <!-- CONTENT -->
            <div class="feature-content-side">

                <div class="feature-number">
                    02
                </div>

                <h2>
                    Access Professional <br>
                    <span>Support</span>
                </h2>

                <p>
                    Finding the right counsellor shouldn't be difficult.
                    Browse profiles, compare professionals,
                    and connect with counsellors who understand
                    your experiences and can provide guidance
                    in a safe and supportive environment.
                    Whether you're navigating identity,
                    relationships, anxiety, stress,
                    or life transitions, support is always within reach.
                </p>

            </div>


            <!-- MOBILE IMAGE -->
            <div class="feature-image-side">

                <img src="images/app_images/2.png" alt="Support" class="feature-mobile-image">

            </div>


            <!-- RIGHT ICONS -->
            <div class="side-icons">

                <div class="side-icon-item">
                    <div class="side-icon">🧠</div>
                    <p>Mental Wellbeing</p>
                </div>

                <div class="side-icon-item">
                    <div class="side-icon">🏳️‍🌈</div>
                    <p>LGBTQ+ Aware Professionals</p>
                </div>

                <div class="side-icon-item">
                    <div class="side-icon">📅</div>
                    <p>Easy Booking</p>
                </div>

                <div class="side-icon-item">
                    <div class="side-icon">🔒</div>
                    <p>Confidential Sessions</p>
                </div>

            </div>

        </div>



        <!-- ===================================
                 FEATURE ROW 3
            =================================== -->
        <div class="feature-row">


            <!-- MOBILE IMAGE -->
            <div class="feature-image-side">

                <img src="images/app_images/3.png" alt="Privacy" class="feature-mobile-image">

            </div>


            <!-- CONTENT -->
            <div class="feature-content-side">

                <div class="feature-number">
                    03
                </div>

                <h2>
                    Your Privacy, Your <span>Control</span>
                </h2>

                <p>
                    Your comfort matters.
                    AffirmSpace gives you full control over your experience
                    through powerful privacy settings,
                    account management tools,
                    blocking features, and customizable preferences.
                    We believe safe communities start with empowering users.
                </p>


                <!-- PRIVACY FEATURES -->
                <div class="mini-feature-grid privacy-grid">

                    <div class="mini-feature-card">
                        <div class="mini-icon">🙈</div>
                        <h4>Private Accounts</h4>
                    </div>

                    <div class="mini-feature-card">
                        <div class="mini-icon">🚫</div>
                        <h4>Block & Report Tools</h4>
                    </div>

                    <div class="mini-feature-card">
                        <div class="mini-icon">⚙️</div>
                        <h4>Account Controls</h4>
                    </div>

                    <div class="mini-feature-card">
                        <div class="mini-icon">🛡️</div>
                        <h4>Safe Community Guidelines</h4>
                    </div>

                    <div class="mini-feature-card">
                        <div class="mini-icon">🔐</div>
                        <h4>User-First Privacy</h4>
                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- ===================================
             FEATURES SECTION END
        =================================== -->
    <!-- ===================================
             SOCIAL APP SECTION START
        =================================== -->

    <section class="social-app-section">

        <div class="social-app-container">


            <!-- ===================================
                     LEFT CONTENT
                =================================== -->
            <div class="social-left">

                <!-- NUMBER -->
                <div class="social-number">
                    04
                </div>

                <!-- TITLE -->
                <h2>
                    More Than <br>
                    <span>A Social App</span>
                </h2>

                <!-- DESCRIPTION -->
                <p>
                    AffirmSpace is built for real human connection.
                    Whether you're searching for friendship,
                    dating, support groups, community rooms,
                    or professional counselling,
                    everything you need is in one welcoming platform.
                </p>

            </div>



            <!-- ===================================
                     RIGHT CARDS
                =================================== -->
            <div class="social-right">


                <!-- CARD -->
                <div class="social-card">

                    <div class="social-icon">
                        💬
                    </div>

                    <div class="social-card-content">

                        <h3>Community Conversations</h3>

                        <p>
                            Join engaging conversations
                            and meet like-minded people.
                        </p>

                    </div>

                </div>



                <!-- CARD -->
                <div class="social-card">

                    <div class="social-icon">
                        💖
                    </div>

                    <div class="social-card-content">

                        <h3>Meaningful Dating</h3>

                        <p>
                            Find people who share
                            your values and vibe.
                        </p>

                    </div>

                </div>



                <!-- CARD -->
                <div class="social-card">

                    <div class="social-icon">
                        🫂
                    </div>

                    <div class="social-card-content">

                        <h3>Friendships & Support</h3>

                        <p>
                            Build friendships and get
                            emotional support.
                        </p>

                    </div>

                </div>



                <!-- CARD -->
                <div class="social-card">

                    <div class="social-icon">
                        🏳️‍🌈
                    </div>

                    <div class="social-card-content">

                        <h3>LGBTQ+ Community</h3>

                        <p>
                            A safe, inclusive and
                            welcoming space for all.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- ===================================
             SOCIAL APP SECTION END
        =================================== -->

    <!-- ===================================
             HOW IT WORKS SECTION START
        =================================== -->



    <!-- ===================================
             HOW IT WORKS SECTION END
        =================================== -->

    <!-- ===================================
             CTA SECTION START
        =================================== -->

    <section class="cta-section">

        <div class="cta-container">


            <!-- ===================================
                     LEFT CONTENT
                =================================== -->
            <div class="cta-left">

                <!-- LOGO -->
                <div class="cta-logo">
                    🌈
                </div>

                <!-- TEXT -->
                <div class="cta-text">

                    <h2>
                        Ready to Join the Community?
                    </h2>

                    <p>
                        Download Affirmspace today and start building
                        meaningful connections.
                    </p>


                    <!-- STORE BUTTONS -->
                    <div class="cta-buttons">

                        <!-- GOOGLE PLAY -->
                        <a href="https://play.google.com/store/apps/details?id=com.affirmspace.app" target="_blank">

                            <img src="{{ asset('images/googlebadge.png') }}" alt="Google Play">

                        </a>


                        <!-- APPLE STORE -->
                        <!-- Uncomment later -->

                        <!--
                            <a href="#" target="_blank">

                                <img src="{{ asset('images/applebadge.svg') }}"
                                    alt="App Store">

                            </a>
                            -->

                    </div>

                </div>

            </div>



            <!-- ===================================
                     RIGHT MOBILE IMAGES
                =================================== -->
            <div class="cta-right">


                <!-- BIG IMAGE -->
                <img src="images/app_images/2.png" alt="App Screen" class="cta-mobile mobile-big">


                <!-- MEDIUM IMAGE -->
                <img src="images/app_images/1.png" alt="App Screen" class="cta-mobile mobile-medium">


                <!-- SMALL IMAGE -->
                <img src="images/app_images/3.png" alt="App Screen" class="cta-mobile mobile-small">


            </div>

        </div>

    </section>

    <!-- ===================================
             CTA SECTION END
        =================================== -->
@endsection
