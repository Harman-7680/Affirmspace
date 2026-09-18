@extends('layouts.seo')

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AffirmSpace – LGBTQ+ Dating, Chat & Support App</title>

    <meta name="description"
        content="Download AffirmSpace: an LGBTQ+ app for dating, chat, community, and counselling — built for gay, lesbian, bisexual, transgender, non-binary, pansexual, and asexual people.">

    <meta name="keywords"
        content="LGBTQ app, LGBTQ dating app, gay dating app, lesbian dating app, LGBTQ chat, LGBTQ community, LGBTQ counselling, queer social network, transgender dating">

    <meta name="robots" content="index, follow">

    <link rel="canonical" href="{{ url()->current() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
@endsection


@section('css')
    <style>
        /* =========================================================
           AFFIRMSPACE DOWNLOAD PAGE
           ========================================================= */

        .as-download-page {
            font-family: 'Inter', sans-serif;
            color: #222;
            background: #fff;
            overflow: hidden;
        }

        .as-download-page *,
        .as-download-page *::before,
        .as-download-page *::after {
            box-sizing: border-box;
        }


        /* =========================================================
           GLOBAL
           ========================================================= */

        .as-download-page img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        .as-container {
            width: min(1180px, calc(100% - 40px));
            margin: 0 auto;
        }

        .as-section {
            padding: 95px 0;
        }

        .as-section-heading {
            max-width: 760px;
            margin: 0 auto 55px;
            text-align: center;
        }

        .as-section-heading h2 {
            margin: 0 0 16px;
            font-size: 40px;
            line-height: 1.18;
            font-weight: 800;
            letter-spacing: -1px;
            color: #191919;
        }

        .as-section-heading p {
            margin: 0;
            font-size: 17px;
            line-height: 1.75;
            color: #666;
        }

        .as-gradient-text {
            background: linear-gradient(90deg, #ff512f, #dd2476);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }


        /* =========================================================
           HERO
           ========================================================= */

        .as-download-hero {
            position: relative;
            padding: 90px 0 80px;
            background:
                radial-gradient(circle at 10% 20%, rgba(255, 81, 47, 0.08), transparent 32%),
                radial-gradient(circle at 90% 30%, rgba(221, 36, 118, 0.08), transparent 32%),
                #fff;
        }

        .as-hero-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(340px, .95fr);
            align-items: center;
            gap: 70px;
        }

        .as-hero-content {
            max-width: 650px;
        }

        .as-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 16px;
            margin-bottom: 22px;
            border-radius: 50px;
            background: #fff3f6;
            color: #dd2476;
            font-size: 13px;
            font-weight: 700;
            border: 1px solid rgba(221, 36, 118, .12);
        }

        .as-hero-content h1 {
            margin: 0 0 22px;
            font-size: clamp(42px, 5vw, 64px);
            line-height: 1.06;
            letter-spacing: -2.5px;
            font-weight: 800;
            color: #181818;
        }

        .as-hero-content>p {
            margin: 0 0 30px;
            max-width: 650px;
            font-size: 18px;
            line-height: 1.75;
            color: #5f5f5f;
        }

        .as-google-play {
            display: inline-block;
            transition: transform .25s ease, filter .25s ease;
        }

        .as-google-play img {
            width: 190px;
        }

        .as-google-play:hover {
            transform: translateY(-3px);
            filter: drop-shadow(0 8px 15px rgba(221, 36, 118, .18));
        }

        .as-trust-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 28px;
        }

        .as-trust-item {
            padding: 10px 13px;
            border-radius: 50px;
            background: #fafafa;
            border: 1px solid #eeeeee;
            color: #555;
            font-size: 12px;
            font-weight: 600;
        }

        .as-hero-phone {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .as-hero-phone-frame {
            position: relative;
            width: min(380px, 100%);
            padding: 14px;
            border-radius: 42px;
            background: linear-gradient(145deg, #fff, #f7f7f7);
            box-shadow:
                0 35px 80px rgba(0, 0, 0, .13),
                0 10px 30px rgba(221, 36, 118, .08);
            border: 1px solid #eeeeee;
        }

        .as-hero-phone-frame img {
            width: 100%;
            border-radius: 31px;
        }


        /* =========================================================
           HOW IT WORKS
           ========================================================= */

        .as-how-section {
            background: #fafafa;
        }

        .as-steps {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 22px;
        }

        .as-step-card {
            position: relative;
            padding: 30px 25px;
            background: #fff;
            border: 1px solid #eeeeee;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .04);
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .as-step-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 40px rgba(221, 36, 118, .09);
        }

        .as-step-number {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            margin-bottom: 22px;
            border-radius: 14px;
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: #fff;
            font-size: 17px;
            font-weight: 800;
        }

        .as-step-card h3 {
            margin: 0 0 12px;
            font-size: 18px;
            line-height: 1.35;
            font-weight: 750;
            color: #222;
        }

        .as-step-card p {
            margin: 0;
            font-size: 14px;
            line-height: 1.7;
            color: #6a6a6a;
        }


        /* =========================================================
           FEATURE SECTIONS
           ========================================================= */

        .as-feature-section {
            background: #fff;
        }

        .as-feature-section.as-feature-alt {
            background: #fafafa;
        }

        .as-feature-grid {
            display: grid;
            grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr);
            align-items: center;
            gap: 80px;
        }

        .as-feature-grid.reverse {
            grid-template-columns: minmax(0, 1.1fr) minmax(0, .9fr);
        }

        .as-feature-grid.reverse .as-feature-image {
            order: 2;
        }

        .as-feature-grid.reverse .as-feature-content {
            order: 1;
        }

        .as-feature-image {
            display: flex;
            justify-content: center;
        }

        .as-feature-image-frame {
            width: min(390px, 100%);
            padding: 12px;
            background: #fff;
            border: 1px solid #eeeeee;
            border-radius: 32px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, .10);
        }

        .as-feature-image-frame img {
            width: 100%;
            border-radius: 23px;
        }

        .as-feature-content {
            max-width: 650px;
        }

        .as-feature-label {
            display: inline-block;
            margin-bottom: 15px;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: .8px;
            text-transform: uppercase;
            color: #dd2476;
        }

        .as-feature-content h2 {
            margin: 0 0 18px;
            font-size: 39px;
            line-height: 1.18;
            letter-spacing: -1px;
            font-weight: 800;
            color: #1c1c1c;
        }

        .as-feature-content>p {
            margin: 0 0 30px;
            font-size: 16px;
            line-height: 1.8;
            color: #666;
        }

        .as-feature-list {
            display: grid;
            gap: 18px;
        }

        .as-feature-item {
            display: flex;
            gap: 14px;
            align-items: flex-start;
        }

        .as-feature-icon {
            flex: 0 0 40px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: #fff2f5;
            color: #dd2476;
            font-size: 17px;
            font-weight: 800;
        }

        .as-feature-item h3 {
            margin: 0 0 5px;
            font-size: 16px;
            line-height: 1.4;
            font-weight: 750;
            color: #242424;
        }

        .as-feature-item p {
            margin: 0;
            font-size: 14px;
            line-height: 1.65;
            color: #707070;
        }


        /* =========================================================
           MORE THAN SOCIAL
           ========================================================= */

        .as-more-section {
            background:
                radial-gradient(circle at 0% 50%, rgba(255, 81, 47, .06), transparent 30%),
                radial-gradient(circle at 100% 50%, rgba(221, 36, 118, .06), transparent 30%),
                #fff;
        }

        .as-more-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .as-more-card {
            padding: 28px 23px;
            background: #fff;
            border: 1px solid #eeeeee;
            border-radius: 18px;
            box-shadow: 0 7px 25px rgba(0, 0, 0, .04);
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .as-more-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(221, 36, 118, .08);
        }

        .as-more-card .icon {
            width: 44px;
            height: 44px;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: #fff;
            font-size: 17px;
            font-weight: 800;
        }

        .as-more-card h3 {
            margin: 0 0 10px;
            font-size: 17px;
            font-weight: 750;
            color: #222;
        }

        .as-more-card p {
            margin: 0;
            font-size: 14px;
            line-height: 1.7;
            color: #6b6b6b;
        }


        /* =========================================================
           FAQ
           ========================================================= */

        .as-faq-section {
            background: #fafafa;
        }

        .as-faq-container {
            max-width: 950px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .as-faq-item {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .04);
            transition: all .3s ease;
        }

        .as-faq-item:hover {
            border-color: rgba(221, 36, 118, .18);
            box-shadow: 0 10px 30px rgba(221, 36, 118, .08);
            transform: translateY(-2px);
        }

        .as-faq-question {
            width: 100%;
            min-height: 72px;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            border: 0;
            background: #fff;
            color: #222;
            font-family: inherit;
            font-size: 16px;
            font-weight: 700;
            line-height: 1.5;
            text-align: left;
            cursor: pointer;
            transition: all .3s ease;
        }

        .as-faq-question:hover {
            color: #dd2476;
        }

        .as-faq-question::after {
            content: "+";
            flex-shrink: 0;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #fff1f5;
            color: #dd2476;
            font-size: 23px;
            font-weight: 400;
            line-height: 1;
            transition: all .3s ease;
        }

        .as-faq-question.active::after {
            content: "−";
            color: #fff;
            background: linear-gradient(90deg, #ff512f, #dd2476);
            transform: rotate(180deg);
        }

        .as-faq-answer {
            max-height: 0;
            overflow: hidden;
            background: #fff;
            transition: max-height .35s ease;
        }

        .as-faq-answer p {
            margin: 0;
            padding: 0 70px 24px 24px;
            color: #666;
            font-size: 15px;
            line-height: 1.75;
        }


        /* =========================================================
           EXPLORE
           ========================================================= */

        .as-explore-section {
            background: #fff;
        }

        .as-explore-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }

        .as-explore-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 22px;
            border-radius: 17px;
            border: 1px solid #eeeeee;
            background: #fff;
            color: #222;
            text-decoration: none;
            box-shadow: 0 6px 20px rgba(0, 0, 0, .035);
            transition: all .3s ease;
        }

        .as-explore-card:hover {
            transform: translateY(-4px);
            border-color: rgba(221, 36, 118, .2);
            box-shadow: 0 12px 30px rgba(221, 36, 118, .08);
        }

        .as-explore-card span:first-child {
            font-size: 16px;
            font-weight: 750;
        }

        .as-explore-arrow {
            color: #dd2476;
            font-size: 20px;
            transition: transform .25s ease;
        }

        .as-explore-card:hover .as-explore-arrow {
            transform: translateX(4px);
        }


        /* =========================================================
           FINAL CTA
           ========================================================= */

        .as-final-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #ff512f, #dd2476);
        }

        .as-final-inner {
            text-align: center;
            color: #fff;
        }

        .as-final-inner h2 {
            margin: 0 0 15px;
            font-size: clamp(34px, 5vw, 50px);
            line-height: 1.15;
            font-weight: 800;
            letter-spacing: -1.5px;
        }

        .as-final-inner>p {
            max-width: 650px;
            margin: 0 auto 30px;
            font-size: 17px;
            line-height: 1.7;
            color: rgba(255, 255, 255, .9);
        }

        .as-final-inner .as-google-play img {
            width: 200px;
        }

        .as-screenshot-strip {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
            max-width: 820px;
            margin: 60px auto 0;
        }

        .as-strip-image {
            padding: 9px;
            background: rgba(255, 255, 255, .15);
            border: 1px solid rgba(255, 255, 255, .25);
            border-radius: 25px;
            backdrop-filter: blur(8px);
        }

        .as-strip-image img {
            width: 100%;
            border-radius: 18px;
        }


        /* =========================================================
           RESPONSIVE
           ========================================================= */

        @media (max-width: 1050px) {

            .as-hero-grid {
                gap: 45px;
            }

            .as-feature-grid,
            .as-feature-grid.reverse {
                gap: 50px;
            }

            .as-steps {
                grid-template-columns: repeat(2, 1fr);
            }

            .as-more-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .as-explore-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }


        @media (max-width: 800px) {

            .as-section {
                padding: 70px 0;
            }

            .as-download-hero {
                padding: 65px 0;
            }

            .as-hero-grid {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .as-hero-content {
                max-width: 720px;
                margin: 0 auto;
            }

            .as-hero-content>p {
                margin-left: auto;
                margin-right: auto;
            }

            .as-trust-row {
                justify-content: center;
            }

            .as-hero-phone {
                max-width: 390px;
                margin: 0 auto;
            }

            .as-feature-grid,
            .as-feature-grid.reverse {
                grid-template-columns: 1fr;
                gap: 45px;
            }

            .as-feature-grid.reverse .as-feature-image {
                order: 1;
            }

            .as-feature-grid.reverse .as-feature-content {
                order: 2;
            }

            .as-feature-content {
                max-width: 720px;
                margin: 0 auto;
            }

            .as-feature-content h2 {
                font-size: 34px;
            }
        }


        @media (max-width: 600px) {

            .as-container {
                width: min(100% - 28px, 1180px);
            }

            .as-section {
                padding: 58px 0;
            }

            .as-section-heading {
                margin-bottom: 38px;
            }

            .as-section-heading h2 {
                font-size: 31px;
            }

            .as-section-heading p {
                font-size: 15px;
            }

            .as-hero-content h1 {
                font-size: 40px;
                letter-spacing: -1.5px;
            }

            .as-hero-content>p {
                font-size: 16px;
            }

            .as-google-play img {
                width: 175px;
            }

            .as-trust-item {
                font-size: 11px;
            }

            .as-steps {
                grid-template-columns: 1fr;
            }

            .as-more-grid {
                grid-template-columns: 1fr;
            }

            .as-explore-grid {
                grid-template-columns: 1fr;
            }

            .as-feature-content h2 {
                font-size: 30px;
            }

            .as-feature-content>p {
                font-size: 15px;
            }

            .as-faq-question {
                min-height: 64px;
                padding: 17px 17px;
                font-size: 14px;
            }

            .as-faq-question::after {
                width: 32px;
                height: 32px;
                font-size: 20px;
            }

            .as-faq-answer p {
                padding: 0 20px 20px 17px;
                font-size: 14px;
            }

            .as-screenshot-strip {
                grid-template-columns: 1fr;
                max-width: 280px;
                gap: 18px;
            }

            .as-final-section {
                padding: 70px 0;
            }

            .as-final-inner h2 {
                font-size: 34px;
            }

            .as-final-inner>p {
                font-size: 15px;
            }
        }


        @media (max-width: 380px) {

            .as-hero-content h1 {
                font-size: 34px;
            }

            .as-hero-badge {
                font-size: 11px;
            }

            .as-feature-content h2 {
                font-size: 27px;
            }

            .as-step-card {
                padding: 25px 20px;
            }
        }
    </style>
@endsection


@section('content')
    <div class="as-download-page">

        {{-- =====================================================
         HERO
    ====================================================== --}}

        <section class="as-download-hero">

            <div class="as-container">

                <div class="as-hero-grid">

                    <div class="as-hero-content">

                        <div class="as-hero-badge">
                            LGBTQ+ Dating • Chat • Community • Support
                        </div>

                        <h1>
                            Connect, Chat, Date & Find Support —
                            <span class="as-gradient-text">All in One App</span>
                        </h1>

                        <p>
                            Join a growing LGBTQ+ community looking for meaningful connections,
                            friendships, dating, and professional counselling — all in one place.
                        </p>

                        <a href="https://play.google.com/store/apps/details?id=com.affirmspace.app" target="_blank"
                            rel="noopener noreferrer" class="as-google-play">
                            <img src="{{ asset('images/googlebadge.png') }}"
                                alt="Download AffirmSpace on Google Play">
                        </a>

                        <div class="as-trust-row">

                            <div class="as-trust-item">
                                🛡 LGBTQ+ Inclusive
                            </div>

                            <div class="as-trust-item">
                                💚 Safe Community
                            </div>

                            <div class="as-trust-item">
                                👨‍⚕️ Professional Counsellors
                            </div>

                            <div class="as-trust-item">
                                🔒 Privacy Focused
                            </div>

                        </div>

                    </div>


                    <div class="as-hero-phone">

                        <div class="as-hero-phone-frame">

                            <img src="{{ asset('images/app_images/top.png') }}"
                                alt="AffirmSpace app home screen showing dating, chat, and community options">

                        </div>

                    </div>

                </div>

            </div>

        </section>



        {{-- =====================================================
         HOW AFFIRMSPACE WORKS
    ====================================================== --}}

        <section class="as-section as-how-section">

            <div class="as-container">

                <div class="as-section-heading">

                    <h2>
                        How <span class="as-gradient-text">AffirmSpace</span> Works
                    </h2>

                    <p>
                        One account gives you access to different ways of connecting,
                        depending on what you are looking for.
                    </p>

                </div>


                <div class="as-steps">

                    <div class="as-step-card">

                        <div class="as-step-number">01</div>

                        <h3>Create Your Account</h3>

                        <p>
                            Sign up and build a profile that reflects your identity
                            and pronouns, in just a couple of minutes.
                        </p>

                    </div>


                    <div class="as-step-card">

                        <div class="as-step-number">02</div>

                        <h3>Tell Us What You're Looking For</h3>

                        <p>
                            Dating, friendship, community, or support — set your intent
                            so what you see actually matches what you need.
                        </p>

                    </div>


                    <div class="as-step-card">

                        <div class="as-step-number">03</div>

                        <h3>Discover & Connect</h3>

                        <p>
                            Browse people, chat rooms, and counsellors based on what
                            you're looking for, not a one-size-fits-all feed.
                        </p>

                    </div>


                    <div class="as-step-card">

                        <div class="as-step-number">04</div>

                        <h3>Chat, Connect & Grow</h3>

                        <p>
                            Build real relationships at your own pace, across dating,
                            chat, community, and care.
                        </p>

                    </div>

                </div>

            </div>

        </section>



        {{-- =====================================================
         DISCOVERY
    ====================================================== --}}

        <section class="as-section as-feature-section">

            <div class="as-container">

                <div class="as-feature-grid">

                    <div class="as-feature-image">

                        <div class="as-feature-image-frame">

                            <img src="{{ asset('images/app_images/1.png') }}"
                                alt="AffirmSpace discovery screen showing profile matches based on interests">

                        </div>

                    </div>


                    <div class="as-feature-content">

                        <span class="as-feature-label">
                            Discover People
                        </span>

                        <h2>
                            Find People Who
                            <span class="as-gradient-text">Match Your Vibe</span>
                        </h2>

                        <p>
                            Not everyone is looking for the same thing. Some people want
                            deep conversations. Some are looking for friendship. Others
                            want emotional support, dating, travel partners, or simply
                            a safe space to talk. AffirmSpace helps you express your
                            personality and connect with people who genuinely align with
                            your interests and values.
                        </p>


                        <div class="as-feature-list">

                            <div class="as-feature-item">

                                <div class="as-feature-icon">✓</div>

                                <div>

                                    <h3>Personalized Matching</h3>

                                    <p>
                                        See people and rooms based on what you've told
                                        AffirmSpace you're looking for, not a generic
                                        algorithm guessing on your behalf.
                                    </p>

                                </div>

                            </div>


                            <div class="as-feature-item">

                                <div class="as-feature-icon">✓</div>

                                <div>

                                    <h3>Better Recommendations</h3>

                                    <p>
                                        The more you use AffirmSpace, the better it gets
                                        at surfacing people and conversations actually
                                        relevant to you.
                                    </p>

                                </div>

                            </div>


                            <div class="as-feature-item">

                                <div class="as-feature-icon">✓</div>

                                <div>

                                    <h3>Authentic Connections</h3>

                                    <p>
                                        Profiles are built around real identity fields,
                                        so who you meet is who they actually say they are
                                        — not a generic template.
                                    </p>

                                </div>

                            </div>


                            <div class="as-feature-item">

                                <div class="as-feature-icon">✓</div>

                                <div>

                                    <h3>Interest-Based Discovery</h3>

                                    <p>
                                        Find people and groups organized around shared
                                        interests and experiences, not just proximity
                                        or a swipe queue.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>



        {{-- =====================================================
         COUNSELLING
    ====================================================== --}}

        <section class="as-section as-feature-section as-feature-alt">

            <div class="as-container">

                <div class="as-feature-grid reverse">

                    <div class="as-feature-image">

                        <div class="as-feature-image-frame">

                            <img src="{{ asset('images/app_images/2.png') }}"
                                alt="AffirmSpace counsellor booking screen showing LGBTQ+-friendly therapist profiles">

                        </div>

                    </div>


                    <div class="as-feature-content">

                        <span class="as-feature-label">
                            Professional Support
                        </span>

                        <h2>
                            Access
                            <span class="as-gradient-text">Professional Support</span>
                        </h2>

                        <p>
                            Finding the right counsellor shouldn't be difficult.
                            Browse profiles, compare professionals, and connect with
                            counsellors who understand your experiences and can provide
                            guidance in a safe, supportive environment. Whether you're
                            navigating identity, relationships, anxiety, stress, or
                            life transitions, support is always within reach.
                        </p>


                        <div class="as-feature-list">

                            <div class="as-feature-item">

                                <div class="as-feature-icon">♥</div>

                                <div>

                                    <h3>Mental Wellbeing</h3>

                                    <p>
                                        Access guidance for identity, relationships,
                                        and everyday mental health — not just crisis support.
                                    </p>

                                </div>

                            </div>


                            <div class="as-feature-item">

                                <div class="as-feature-icon">✓</div>

                                <div>

                                    <h3>LGBTQ+ Aware Professionals</h3>

                                    <p>
                                        Every listed counsellor is reviewed with
                                        LGBTQ+-friendly care specifically in mind,
                                        not added as an afterthought.
                                    </p>

                                </div>

                            </div>


                            <div class="as-feature-item">

                                <div class="as-feature-icon">→</div>

                                <div>

                                    <h3>Easy Booking</h3>

                                    <p>
                                        Book a session directly through the app,
                                        without back-and-forth emails or phone calls.
                                    </p>

                                </div>

                            </div>


                            <div class="as-feature-item">

                                <div class="as-feature-icon">🔒</div>

                                <div>

                                    <h3>Confidential Sessions</h3>

                                    <p>
                                        Your sessions are private — AffirmSpace does
                                        not share session content with anyone.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>



        {{-- =====================================================
         PRIVACY
    ====================================================== --}}

        <section class="as-section as-feature-section">

            <div class="as-container">

                <div class="as-feature-grid">

                    <div class="as-feature-image">

                        <div class="as-feature-image-frame">

                            <img src="{{ asset('images/app_images/3.png') }}"
                                alt="AffirmSpace privacy settings screen showing visibility and blocking controls">

                        </div>

                    </div>


                    <div class="as-feature-content">

                        <span class="as-feature-label">
                            Privacy & Control
                        </span>

                        <h2>
                            Your Privacy,
                            <span class="as-gradient-text">Your Control</span>
                        </h2>

                        <p>
                            Your comfort matters. AffirmSpace gives you full control
                            over your experience through privacy settings, account
                            management tools, blocking features, and customizable
                            preferences. We believe safe communities start with
                            empowering users.
                        </p>


                        <div class="as-feature-list">

                            <div class="as-feature-item">

                                <div class="as-feature-icon">◉</div>

                                <div>

                                    <h3>Private Accounts</h3>

                                    <p>
                                        Choose full visibility, semi-anonymous, or fully
                                        anonymous — and change it anytime.
                                    </p>

                                </div>

                            </div>


                            <div class="as-feature-item">

                                <div class="as-feature-icon">✓</div>

                                <div>

                                    <h3>Block & Report Tools</h3>

                                    <p>
                                        Report or block anyone in one tap, no explanation
                                        required.
                                    </p>

                                </div>

                            </div>


                            <div class="as-feature-item">

                                <div class="as-feature-icon">⚙</div>

                                <div>

                                    <h3>Account Controls</h3>

                                    <p>
                                        Manage exactly what's visible, to whom, across
                                        dating, chat, and community.
                                    </p>

                                </div>

                            </div>


                            <div class="as-feature-item">

                                <div class="as-feature-icon">✓</div>

                                <div>

                                    <h3>Safe Community Guidelines</h3>

                                    <p>
                                        Every group and conversation is covered by the
                                        same community guidelines, enforced consistently.
                                    </p>

                                </div>

                            </div>


                            <div class="as-feature-item">

                                <div class="as-feature-icon">🔒</div>

                                <div>

                                    <h3>User-First Privacy</h3>

                                    <p>
                                        Your data isn't sold.
                                        <a href="/privacy-policy"
                                            style="color:#dd2476;font-weight:700;text-decoration:none;">
                                            Read our Privacy Policy
                                        </a>
                                        for exactly what's collected and why.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>



        {{-- =====================================================
         MORE THAN SOCIAL APP
    ====================================================== --}}

        <section class="as-section as-more-section">

            <div class="as-container">

                <div class="as-section-heading">

                    <h2>
                        More Than a
                        <span class="as-gradient-text">Social App</span>
                    </h2>

                    <p>
                        AffirmSpace brings different parts of LGBTQ+ life together
                        so you can use the platform in the way that works for you.
                    </p>

                </div>


                <div class="as-more-grid">

                    <div class="as-more-card">

                        <div class="icon">💬</div>

                        <h3>Community Conversations</h3>

                        <p>
                            Join engaging conversations and meet like-minded people
                            beyond dating.
                        </p>

                    </div>


                    <div class="as-more-card">

                        <div class="icon">♥</div>

                        <h3>Meaningful Dating</h3>

                        <p>
                            Find people who share your values, not just your location.
                        </p>

                    </div>


                    <div class="as-more-card">

                        <div class="icon">🤝</div>

                        <h3>Friendships & Support</h3>

                        <p>
                            Build friendships and get emotional support, no dating
                            angle required.
                        </p>

                    </div>


                    <div class="as-more-card">

                        <div class="icon">🏳️‍🌈</div>

                        <h3>LGBTQ+ Community</h3>

                        <p>
                            A safe, inclusive, and welcoming space for gay, lesbian,
                            bisexual, transgender, non-binary, pansexual, and asexual
                            people — and anyone still figuring it out.
                        </p>

                    </div>

                </div>

            </div>

        </section>



        {{-- =====================================================
         FAQ
    ====================================================== --}}

        <section class="as-section as-faq-section">

            <div class="as-container">

                <div class="as-section-heading">

                    <h2>
                        Frequently Asked
                        <span class="as-gradient-text">Questions</span>
                    </h2>

                    <p>
                        A few things you may want to know before joining AffirmSpace.
                    </p>

                </div>


                <div class="as-faq-container">


                    <div class="as-faq-item">

                        <button type="button" class="as-faq-question">
                            Is AffirmSpace available on iOS?
                        </button>

                        <div class="as-faq-answer">

                            <p>
                                AffirmSpace availability depends on the current app
                                store release. Check the available download options
                                shown on this page for the latest availability.
                            </p>

                        </div>

                    </div>


                    <div class="as-faq-item">

                        <button type="button" class="as-faq-question">
                            Do I have to pay to join AffirmSpace?
                        </button>

                        <div class="as-faq-answer">

                            <p>
                                AffirmSpace is currently available to join. Any feature
                                limits or future pricing will be communicated clearly
                                in the app.
                            </p>

                        </div>

                    </div>


                    <div class="as-faq-item">

                        <button type="button" class="as-faq-question">
                            Can I use AffirmSpace anonymously?
                        </button>

                        <div class="as-faq-answer">

                            <p>
                                Yes. You choose your visibility level at signup —
                                fully public, semi-anonymous, or fully anonymous —
                                and can change it anytime.
                            </p>

                        </div>

                    </div>


                    <div class="as-faq-item">

                        <button type="button" class="as-faq-question">
                            Does AffirmSpace provide therapy directly?
                        </button>

                        <div class="as-faq-answer">

                            <p>
                                No. AffirmSpace helps you find and book LGBTQ+-friendly
                                counsellors — the care itself happens between you and them.
                            </p>

                        </div>

                    </div>


                    <div class="as-faq-item">

                        <button type="button" class="as-faq-question">
                            Can I use only one part of AffirmSpace?
                        </button>

                        <div class="as-faq-answer">

                            <p>
                                That's fine. You can use as much or as little of the app
                                as you want — dating, chat, community, and counselling
                                all work independently from one account.
                            </p>

                        </div>

                    </div>


                </div>

            </div>

        </section>



        {{-- =====================================================
         EXPLORE
    ====================================================== --}}

        <section class="as-section as-explore-section">

            <div class="as-container">

                <div class="as-section-heading">

                    <h2>
                        Explore Before You
                        <span class="as-gradient-text">Download</span>
                    </h2>

                    <p>
                        See what different parts of AffirmSpace are about before
                        you join the community.
                    </p>

                </div>


                <div class="as-explore-grid">

                    <a href="{{ route('chatAndDating') }}" class="as-explore-card">

                        <span>
                            LGBTQ+ Dating
                        </span>

                        <span class="as-explore-arrow">
                            →
                        </span>

                    </a>


                    <a href="{{ route('chat') }}" class="as-explore-card">

                        <span>
                            LGBTQ+ Chat
                        </span>

                        <span class="as-explore-arrow">
                            →
                        </span>

                    </a>


                    <a href="{{ route('counselling') }}" class="as-explore-card">

                        <span>
                            Counselling & Support
                        </span>

                        <span class="as-explore-arrow">
                            →
                        </span>

                    </a>


                    <a href="{{ route('community') }}" class="as-explore-card">

                        <span>
                            LGBTQ+ Community
                        </span>

                        <span class="as-explore-arrow">
                            →
                        </span>

                    </a>

                </div>

            </div>

        </section>



        {{-- =====================================================
         FINAL CTA
    ====================================================== --}}

        <section class="as-final-section">

            <div class="as-container">

                <div class="as-final-inner">

                    <h2>
                        Ready to Join the Community?
                    </h2>

                    <p>
                        Download AffirmSpace today and start building meaningful
                        connections.
                    </p>


                    <a href="https://play.google.com/store/apps/details?id=com.affirmspace.app" target="_blank"
                        rel="noopener noreferrer" class="as-google-play">

                        <img src="{{ asset('images/googlebadge.png') }}"
                            alt="Download AffirmSpace on Google Play">

                    </a>


                    <div class="as-screenshot-strip">

                        <div class="as-strip-image">

                            <img src="{{ asset('images/app_images/2.png') }}"
                                alt="AffirmSpace counsellor booking screen">

                        </div>


                        <div class="as-strip-image">

                            <img src="{{ asset('images/app_images/1.png') }}"
                                alt="AffirmSpace discovery and matching screen">

                        </div>


                        <div class="as-strip-image">

                            <img src="{{ asset('images/app_images/3.png') }}"
                                alt="AffirmSpace privacy and account settings screen">

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>
@endsection


@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const questions = document.querySelectorAll('.as-faq-question');

            questions.forEach(function(question) {

                question.addEventListener('click', function() {

                    const answer = question.nextElementSibling;

                    if (!answer) {
                        return;
                    }

                    const isOpen = question.classList.contains('active');

                    // Close all other FAQ items
                    questions.forEach(function(otherQuestion) {

                        if (otherQuestion !== question) {

                            otherQuestion.classList.remove('active');

                            const otherAnswer = otherQuestion.nextElementSibling;

                            if (otherAnswer) {
                                otherAnswer.style.maxHeight = null;
                            }

                        }

                    });


                    // Toggle selected FAQ
                    if (isOpen) {

                        question.classList.remove('active');

                        answer.style.maxHeight = null;

                    } else {

                        question.classList.add('active');

                        answer.style.maxHeight = answer.scrollHeight + 'px';

                    }

                });

            });

        });
    </script>
@endsection
