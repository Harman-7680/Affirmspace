@extends('layouts.seo')

@section('meta')
    <title>Safety Tips – AffirmSpace</title>

    <meta name="description"
        content="Stay safer on AffirmSpace with practical tips for chatting, protecting your identity, meeting people in person, recognizing red flags, and reporting concerns.">

    <meta name="author" content="AffirmSpace">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
@endsection


@section('css')
<style id="as-safety-css">

    /* =========================================================
       AFFIRMSPACE SAFETY TIPS
       ========================================================= */

    .as-safety-page {
        font-family: 'Inter', sans-serif;
        color: #222;
        background: #fff;
        overflow: hidden;
    }

    .as-safety-page *,
    .as-safety-page *::before,
    .as-safety-page *::after {
        box-sizing: border-box;
    }


    /* =========================================================
       HERO
       ========================================================= */

    .as-safety-hero {
        position: relative;
        min-height: 430px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: #111;
    }

    .as-safety-hero-image {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .as-safety-hero-overlay {
        position: absolute;
        inset: 0;
        background:
            linear-gradient(
                90deg,
                rgba(255, 81, 47, 0.92),
                rgba(221, 36, 118, 0.88)
            );
        opacity: 0.91;
    }

    .as-safety-hero-content {
        position: relative;
        z-index: 2;
        width: min(100% - 40px, 950px);
        margin: 0 auto;
        padding: 80px 20px;
        text-align: center;
        color: #fff;
    }

    .as-safety-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 20px;
        padding: 8px 16px;
        border: 1px solid rgba(255,255,255,.35);
        border-radius: 999px;
        background: rgba(255,255,255,.12);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
    }

    .as-safety-eyebrow i {
        font-size: 13px;
    }

    .as-safety-hero h1 {
        margin: 0 0 20px;
        font-size: clamp(40px, 5vw, 64px);
        line-height: 1.08;
        font-weight: 800;
        letter-spacing: -1.8px;
    }

    .as-safety-hero p {
        max-width: 770px;
        margin: 0 auto;
        color: rgba(255,255,255,.94);
        font-size: 17px;
        line-height: 1.75;
    }


    /* =========================================================
       INTRO
       ========================================================= */

    .as-safety-intro-section {
        padding: 85px 20px 35px;
        background: #fff;
    }

    .as-safety-container {
        width: min(100%, 1080px);
        margin: 0 auto;
    }

    .as-safety-intro {
        position: relative;
        padding: 34px 38px;
        border: 1px solid #f0e7eb;
        border-radius: 22px;
        background: linear-gradient(
            135deg,
            #fff,
            #fff8fa
        );
        box-shadow: 0 12px 40px rgba(221, 36, 118, .07);
    }

    .as-safety-intro::before {
        content: "";
        position: absolute;
        top: 0;
        left: 32px;
        right: 32px;
        height: 3px;
        border-radius: 0 0 10px 10px;
        background: linear-gradient(90deg, #ff512f, #dd2476);
    }

    .as-safety-intro-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
        border-radius: 14px;
        background: linear-gradient(
            135deg,
            rgba(255,81,47,.12),
            rgba(221,36,118,.12)
        );
        color: #dd2476;
        font-size: 21px;
    }

    .as-safety-intro h2 {
        margin: 0 0 12px;
        color: #222;
        font-size: 25px;
        line-height: 1.3;
        font-weight: 750;
    }

    .as-safety-intro p {
        margin: 0;
        color: #666;
        font-size: 15px;
        line-height: 1.8;
    }


    /* =========================================================
       SAFETY CARDS
       ========================================================= */

    .as-safety-section {
        padding: 35px 20px 85px;
        background: #fff;
    }

    .as-safety-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px;
    }

    .as-safety-card {
        position: relative;
        padding: 30px;
        border: 1px solid #eeeeee;
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 7px 28px rgba(0,0,0,.045);
        transition:
            transform .28s ease,
            box-shadow .28s ease,
            border-color .28s ease;
    }

    .as-safety-card:hover {
        transform: translateY(-4px);
        border-color: rgba(221,36,118,.18);
        box-shadow: 0 15px 38px rgba(221,36,118,.09);
    }

    .as-safety-card-wide {
        grid-column: 1 / -1;
    }

    .as-safety-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        border-radius: 14px;
        background: linear-gradient(
            135deg,
            rgba(255,81,47,.11),
            rgba(221,36,118,.11)
        );
        color: #dd2476;
        font-size: 19px;
    }

    .as-safety-card h2 {
        margin: 0 0 12px;
        color: #222;
        font-size: 21px;
        line-height: 1.35;
        font-weight: 750;
    }

    .as-safety-card p {
        margin: 0;
        color: #666;
        font-size: 15px;
        line-height: 1.8;
    }

    .as-safety-card ul {
        margin: 16px 0 0;
        padding: 0;
        list-style: none;
    }

    .as-safety-card li {
        position: relative;
        margin-bottom: 14px;
        padding-left: 27px;
        color: #555;
        font-size: 14.5px;
        line-height: 1.75;
    }

    .as-safety-card li:last-child {
        margin-bottom: 0;
    }

    .as-safety-card li::before {
        content: "✓";
        position: absolute;
        left: 0;
        top: 2px;
        width: 19px;
        height: 19px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #fff0f4;
        color: #dd2476;
        font-size: 11px;
        font-weight: 800;
    }


    /* =========================================================
       RED FLAGS
       ========================================================= */

    .as-safety-red-flags {
        background:
            linear-gradient(
                135deg,
                #fff8f8 0%,
                #fff 55%,
                #fff8fa 100%
            );
    }

    .as-safety-red-flags .as-safety-icon {
        background: linear-gradient(
            135deg,
            rgba(255,81,47,.14),
            rgba(221,36,118,.14)
        );
    }

    .as-safety-red-flags li::before {
        content: "!";
        background: #fff1f1;
        color: #dd2476;
    }


    /* =========================================================
       SECTION HEADING
       ========================================================= */

    .as-safety-heading {
        max-width: 720px;
        margin: 0 auto 42px;
        text-align: center;
    }

    .as-safety-heading .eyebrow {
        display: inline-block;
        margin-bottom: 12px;
        color: #dd2476;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 1.3px;
        text-transform: uppercase;
    }

    .as-safety-heading h2 {
        margin: 0 0 13px;
        color: #222;
        font-size: clamp(28px, 4vw, 38px);
        line-height: 1.2;
        font-weight: 800;
        letter-spacing: -.7px;
    }

    .as-safety-heading p {
        margin: 0;
        color: #6a6a6a;
        font-size: 15px;
        line-height: 1.75;
    }


    /* =========================================================
       MENTAL HEALTH
       ========================================================= */

    .as-safety-support-section {
        padding: 85px 20px;
        background: #fafafa;
    }

    .as-safety-support-card {
        width: min(100%, 900px);
        margin: 0 auto;
        padding: 38px;
        display: grid;
        grid-template-columns: 64px 1fr;
        gap: 24px;
        align-items: start;
        border: 1px solid #eeeeee;
        border-radius: 22px;
        background: #fff;
        box-shadow: 0 10px 35px rgba(0,0,0,.05);
    }

    .as-safety-support-icon {
        width: 58px;
        height: 58px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 17px;
        background: linear-gradient(90deg, #ff512f, #dd2476);
        color: #fff;
        font-size: 22px;
        box-shadow: 0 8px 20px rgba(221,36,118,.18);
    }

    .as-safety-support-card h2 {
        margin: 0 0 12px;
        color: #222;
        font-size: 22px;
        line-height: 1.35;
        font-weight: 750;
    }

    .as-safety-support-card p {
        margin: 0;
        color: #666;
        font-size: 15px;
        line-height: 1.8;
    }

    .as-safety-support-card p + p {
        margin-top: 14px;
    }

    .as-safety-inline-link {
        color: #dd2476;
        font-weight: 700;
        text-decoration: none;
    }

    .as-safety-inline-link:hover {
        text-decoration: underline;
    }


    /* =========================================================
       IF SOMETHING FEELS WRONG
       ========================================================= */

    .as-safety-report-section {
        padding: 85px 20px;
        background: #fff;
    }

    .as-safety-report-card {
        position: relative;
        width: min(100%, 1000px);
        margin: 0 auto;
        padding: 45px;
        overflow: hidden;
        border-radius: 26px;
        background: linear-gradient(
            135deg,
            #fff5f7,
            #fff9f5
        );
        border: 1px solid #f3e4e9;
    }

    .as-safety-report-card::after {
        content: "";
        position: absolute;
        width: 280px;
        height: 280px;
        right: -110px;
        top: -120px;
        border-radius: 50%;
        background: rgba(221,36,118,.07);
    }

    .as-safety-report-content {
        position: relative;
        z-index: 2;
        max-width: 780px;
    }

    .as-safety-report-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
        border-radius: 15px;
        background: linear-gradient(90deg, #ff512f, #dd2476);
        color: #fff;
        font-size: 20px;
    }

    .as-safety-report-card h2 {
        margin: 0 0 12px;
        color: #222;
        font-size: 28px;
        line-height: 1.25;
        font-weight: 800;
    }

    .as-safety-report-card p {
        margin: 0 0 22px;
        color: #666;
        font-size: 15px;
        line-height: 1.8;
    }

    .as-safety-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .as-safety-primary-btn,
    .as-safety-secondary-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        padding: 14px 23px;
        border-radius: 999px;
        text-decoration: none !important;
        font-size: 14px;
        font-weight: 700;
        transition:
            transform .25s ease,
            box-shadow .25s ease,
            background .25s ease;
    }

    .as-safety-primary-btn {
        color: #fff !important;
        background: linear-gradient(90deg, #ff512f, #dd2476);
        box-shadow: 0 8px 22px rgba(221,36,118,.18);
    }

    .as-safety-primary-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(221,36,118,.24);
    }

    .as-safety-secondary-btn {
        color: #dd2476 !important;
        border: 1px solid rgba(221,36,118,.28);
        background: #fff;
    }

    .as-safety-secondary-btn:hover {
        transform: translateY(-2px);
        border-color: #dd2476;
        box-shadow: 0 8px 22px rgba(221,36,118,.09);
    }


    /* =========================================================
       EMERGENCY NOTICE
       ========================================================= */

    .as-safety-emergency {
        width: min(100%, 1000px);
        margin: 24px auto 0;
        padding: 22px 25px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        border: 1px solid #f0d9de;
        border-radius: 17px;
        background: #fff8f9;
    }

    .as-safety-emergency i {
        flex-shrink: 0;
        margin-top: 3px;
        color: #dd2476;
        font-size: 18px;
    }

    .as-safety-emergency p {
        margin: 0;
        color: #555;
        font-size: 14px;
        line-height: 1.7;
    }

    .as-safety-emergency strong {
        color: #333;
    }


    /* =========================================================
       FINAL NOTE
       ========================================================= */

    .as-safety-final-section {
        padding: 85px 20px 100px;
        background: #fff;
    }

    .as-safety-final {
        width: min(100%, 850px);
        margin: 0 auto;
        text-align: center;
    }

    .as-safety-final-icon {
        width: 64px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 22px;
        border-radius: 50%;
        background: linear-gradient(
            135deg,
            rgba(255,81,47,.12),
            rgba(221,36,118,.12)
        );
        color: #dd2476;
        font-size: 25px;
    }

    .as-safety-final h2 {
        margin: 0 0 16px;
        color: #222;
        font-size: clamp(29px, 4vw, 40px);
        line-height: 1.2;
        font-weight: 800;
        letter-spacing: -.7px;
    }

    .as-safety-final p {
        max-width: 720px;
        margin: 0 auto;
        color: #666;
        font-size: 16px;
        line-height: 1.85;
    }


    /* =========================================================
       RESPONSIVE
       ========================================================= */

    @media (max-width: 900px) {

        .as-safety-hero {
            min-height: 390px;
        }

        .as-safety-grid {
            grid-template-columns: 1fr;
        }

        .as-safety-card-wide {
            grid-column: auto;
        }

        .as-safety-intro-section,
        .as-safety-section,
        .as-safety-support-section,
        .as-safety-report-section {
            padding-left: 18px;
            padding-right: 18px;
        }
    }


    @media (max-width: 650px) {

        .as-safety-hero-content {
            width: min(100% - 24px, 950px);
            padding: 65px 12px;
        }

        .as-safety-hero h1 {
            font-size: 39px;
            letter-spacing: -1px;
        }

        .as-safety-hero p {
            font-size: 15px;
            line-height: 1.7;
        }

        .as-safety-intro {
            padding: 30px 24px;
        }

        .as-safety-card {
            padding: 26px 23px;
        }

        .as-safety-support-card {
            grid-template-columns: 1fr;
            padding: 28px 24px;
        }

        .as-safety-report-card {
            padding: 32px 25px;
        }

        .as-safety-buttons {
            flex-direction: column;
        }

        .as-safety-primary-btn,
        .as-safety-secondary-btn {
            width: 100%;
        }

        .as-safety-emergency {
            padding: 20px;
        }

        .as-safety-final-section {
            padding-bottom: 75px;
        }
    }


    @media (max-width: 420px) {

        .as-safety-hero {
            min-height: 365px;
        }

        .as-safety-hero-content {
            padding-top: 55px;
            padding-bottom: 55px;
        }

        .as-safety-eyebrow {
            font-size: 10px;
            padding: 7px 12px;
        }

        .as-safety-hero h1 {
            font-size: 34px;
        }

        .as-safety-intro {
            padding: 26px 20px;
            border-radius: 18px;
        }

        .as-safety-card {
            padding: 24px 20px;
            border-radius: 18px;
        }

        .as-safety-card h2 {
            font-size: 19px;
        }

        .as-safety-card p,
        .as-safety-card li {
            font-size: 14px;
        }

        .as-safety-report-card {
            padding: 28px 20px;
            border-radius: 20px;
        }

        .as-safety-report-card h2 {
            font-size: 25px;
        }

        .as-safety-final-section {
            padding-left: 18px;
            padding-right: 18px;
        }
    }

</style>
@endsection


@section('content')

<div class="as-safety-page">

    {{-- =====================================================
         HERO
         ===================================================== --}}
    <section class="as-safety-hero">

        <img
            src="{{ asset('images/coursel.png') }}"
            alt="LGBTQ+ community"
            class="as-safety-hero-image"
        >

        <div class="as-safety-hero-overlay"></div>

        <div class="as-safety-hero-content">

            <div class="as-safety-eyebrow">
                <i class="fa-solid fa-shield-heart"></i>
                Stay Safe on AffirmSpace
            </div>

            <h1>Safety Tips</h1>

            <p>
                A few simple habits can go a long way in keeping your
                experience safer — especially when chatting with new
                people or meeting someone in person for the first time.
            </p>

        </div>

    </section>


    {{-- =====================================================
         INTRO
         ===================================================== --}}
    <section class="as-safety-intro-section">

        <div class="as-safety-container">

            <div class="as-safety-intro">

                <div class="as-safety-intro-icon">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>

                <h2>Your Safety Matters</h2>

                <p>
                    AffirmSpace is built to be a safe space — but a few
                    habits go a long way in keeping your experience safe
                    too, especially when chatting with new people or
                    meeting someone in person for the first time.
                </p>

            </div>

        </div>

    </section>


    {{-- =====================================================
         MAIN SAFETY TIPS
         ===================================================== --}}
    <section class="as-safety-section">

        <div class="as-safety-container">

            <div class="as-safety-grid">


                {{-- BEFORE YOU CHAT --}}
                <article class="as-safety-card">

                    <div class="as-safety-icon">
                        <i class="fa-solid fa-comments"></i>
                    </div>

                    <h2>Before You Chat</h2>

                    <ul>

                        <li>
                            Take your time getting to know someone before
                            sharing personal details like your workplace,
                            home address, or daily routine.
                        </li>

                        <li>
                            Be cautious if someone asks for money, gifts,
                            or financial information — this is a common
                            scam tactic, not normal behavior.
                        </li>

                        <li>
                            If a conversation feels off, or someone is
                            pushing you to move too fast, trust that instinct.
                        </li>

                    </ul>

                </article>


                {{-- PROTECT IDENTITY --}}
                <article class="as-safety-card">

                    <div class="as-safety-icon">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>

                    <h2>Protecting Your Identity</h2>

                    <ul>

                        <li>
                            You're never obligated to share your orientation
                            or gender identity with anyone before you're
                            ready to.
                        </li>

                        <li>
                            Be mindful of details in your photos or bio that
                            could reveal your location, workplace, or identity
                            to people you haven't chosen to share that with.
                        </li>

                        <li>
                            If you're not fully out yet, consider what
                            information could unintentionally out you to
                            someone you know, and adjust your profile
                            accordingly.
                        </li>

                        <li>
                            Never share someone else's identity, orientation,
                            or personal details without their permission —
                            and expect the same in return.
                        </li>

                    </ul>

                </article>


                {{-- MEETING IN PERSON --}}
                <article class="as-safety-card as-safety-card-wide">

                    <div class="as-safety-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>

                    <h2>Meeting in Person</h2>

                    <ul>

                        <li>
                            Meet in a public place for the first time —
                            a café, restaurant, or public event works well.
                        </li>

                        <li>
                            Tell a friend or family member where you're going,
                            who you're meeting, and when you expect to be back.
                        </li>

                        <li>
                            Arrange your own transportation to and from the
                            meeting, so you're not relying on the other person
                            to get home.
                        </li>

                        <li>
                            Stay sober enough to make clear decisions,
                            especially on a first meeting.
                        </li>

                        <li>
                            It's okay to leave at any point if something
                            feels wrong — you don't owe anyone an explanation.
                        </li>

                    </ul>

                </article>


                {{-- RED FLAGS --}}
                <article class="as-safety-card as-safety-card-wide as-safety-red-flags">

                    <div class="as-safety-icon">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>

                    <h2>Recognizing Red Flags</h2>

                    <ul>

                        <li>
                            Refuses to video call or meet in a public place.
                        </li>

                        <li>
                            Asks for money, gifts, or financial help early on.
                        </li>

                        <li>
                            Pressures you for personal information, explicit
                            photos, or to move off the app quickly.
                        </li>

                        <li>
                            Profile details don't add up, or photos seem
                            inconsistent with their story.
                        </li>

                    </ul>

                </article>

            </div>

        </div>

    </section>


    {{-- =====================================================
         MENTAL HEALTH
         ===================================================== --}}
    <section class="as-safety-support-section">

        <div class="as-safety-heading">

            <span class="eyebrow">Your Wellbeing</span>

            <h2>Your Mental Health Matters Too</h2>

            <p>
                Dating and connecting with community can bring up a lot —
                and that's normal.
            </p>

        </div>


        <div class="as-safety-support-card">

            <div class="as-safety-support-icon">
                <i class="fa-solid fa-heart-pulse"></i>
            </div>

            <div>

                <h2>Support Is Available</h2>

                <p>
                    Dating and connecting with community can bring up a lot —
                    that's normal. If you need support, AffirmSpace's
                    counselling feature connects you with counsellors.
                </p>

                <p>
                    You can also read more in our guide on
                    <a href="{{ url('/lgbtq-mental-health-counselling') }}"
                       class="as-safety-inline-link">
                        LGBTQ+ Mental Health Support
                    </a>.
                </p>

            </div>

        </div>

    </section>


    {{-- =====================================================
         IF SOMETHING FEELS WRONG
         ===================================================== --}}
    <section class="as-safety-report-section">

        <div class="as-safety-report-card">

            <div class="as-safety-report-content">

                <div class="as-safety-report-icon">
                    <i class="fa-solid fa-flag"></i>
                </div>

                <h2>If Something Feels Wrong</h2>

                <p>
                    Trust yourself. You can block or unmatch anyone at any
                    time, and report behavior that concerns you through our
                    Report a Problem page.
                </p>

                <div class="as-safety-buttons">

                    <a
                        href="{{ route('report-a-problem') }}"
                        class="as-safety-primary-btn">
                        <i class="fa-solid fa-arrow-right"></i>
                        Report a Problem
                    </a>

                    <a
                        href="{{ route('community-guidelines') }}"
                        class="as-safety-secondary-btn">
                        <i class="fa-solid fa-shield-heart"></i>
                        Community Guidelines
                    </a>

                </div>

            </div>

        </div>


        {{-- EMERGENCY NOTICE --}}
        <div class="as-safety-emergency">

            <i class="fa-solid fa-triangle-exclamation"></i>

            <p>
                <strong>If you're ever in immediate danger,</strong>
                please contact local emergency services first.
            </p>

        </div>

    </section>


    {{-- =====================================================
         FINAL NOTE
         ===================================================== --}}
    <section class="as-safety-final-section">

        <div class="as-safety-final">

            <div class="as-safety-final-icon">
                <i class="fa-solid fa-heart"></i>
            </div>

            <h2>Stay Safe. Stay You.</h2>

            <p>
                Your safety and comfort matter. Take your time, protect
                your personal information, trust your instincts, and don't
                hesitate to step away from a situation that doesn't feel right.
            </p>

        </div>

    </section>

</div>

@endsection