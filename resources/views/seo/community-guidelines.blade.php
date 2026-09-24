@extends('layouts.seo')

@section('meta')
    <title>Community Guidelines – AffirmSpace</title>

    <meta name="description"
        content="Read AffirmSpace's Community Guidelines for respectful, safe, and inclusive LGBTQ+ dating, chat, community, and support. Learn what is expected and how violations are handled.">

    <meta name="author" content="AffirmSpace">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
@endsection


@section('css')
<style id="as-guidelines-css">

    /* =========================================================
       AFFIRMSPACE COMMUNITY GUIDELINES
       ========================================================= */

    .as-guidelines-page {
        font-family: 'Inter', sans-serif;
        color: #222;
        background: #fff;
        overflow: hidden;
    }

    .as-guidelines-page *,
    .as-guidelines-page *::before,
    .as-guidelines-page *::after {
        box-sizing: border-box;
    }


    /* =========================================================
       HERO
       ========================================================= */

    .as-guidelines-hero {
        position: relative;
        min-height: 430px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: #111;
    }

    .as-guidelines-hero-image {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .as-guidelines-hero-overlay {
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

    .as-guidelines-hero-content {
        position: relative;
        z-index: 2;
        width: min(100% - 40px, 950px);
        margin: 0 auto;
        text-align: center;
        color: #fff;
        padding: 80px 20px;
    }

    .as-guidelines-eyebrow {
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

    .as-guidelines-eyebrow i {
        font-size: 13px;
    }

    .as-guidelines-hero h1 {
        margin: 0 0 20px;
        font-size: clamp(38px, 5vw, 64px);
        line-height: 1.08;
        font-weight: 800;
        letter-spacing: -1.8px;
    }

    .as-guidelines-hero p {
        max-width: 760px;
        margin: 0 auto;
        color: rgba(255,255,255,.94);
        font-size: 17px;
        line-height: 1.75;
        font-weight: 400;
    }


    /* =========================================================
       INTRO
       ========================================================= */

    .as-guidelines-intro-section {
        padding: 85px 20px 35px;
        background: #fff;
    }

    .as-guidelines-container {
        width: min(100%, 1080px);
        margin: 0 auto;
    }

    .as-guidelines-intro {
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

    .as-guidelines-intro::before {
        content: "";
        position: absolute;
        top: 0;
        left: 32px;
        right: 32px;
        height: 3px;
        border-radius: 0 0 10px 10px;
        background: linear-gradient(90deg, #ff512f, #dd2476);
    }

    .as-guidelines-intro-icon {
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

    .as-guidelines-intro h2 {
        margin: 0 0 12px;
        font-size: 25px;
        line-height: 1.3;
        font-weight: 750;
        color: #222;
    }

    .as-guidelines-intro p {
        margin: 0;
        color: #666;
        font-size: 15px;
        line-height: 1.8;
    }


    /* =========================================================
       GUIDELINES GRID
       ========================================================= */

    .as-guidelines-section {
        padding: 35px 20px 85px;
        background: #fff;
    }

    .as-guidelines-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px;
    }

    .as-guideline-card {
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

    .as-guideline-card:hover {
        transform: translateY(-4px);
        border-color: rgba(221,36,118,.18);
        box-shadow: 0 15px 38px rgba(221,36,118,.09);
    }

    .as-guideline-card-wide {
        grid-column: 1 / -1;
    }

    .as-guideline-icon {
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

    .as-guideline-card h2 {
        margin: 0 0 12px;
        color: #222;
        font-size: 21px;
        line-height: 1.35;
        font-weight: 750;
    }

    .as-guideline-card p {
        margin: 0;
        color: #666;
        font-size: 15px;
        line-height: 1.8;
    }

    .as-guideline-card ul {
        margin: 16px 0 0;
        padding: 0;
        list-style: none;
    }

    .as-guideline-card li {
        position: relative;
        margin-bottom: 14px;
        padding-left: 27px;
        color: #555;
        font-size: 14.5px;
        line-height: 1.75;
    }

    .as-guideline-card li:last-child {
        margin-bottom: 0;
    }

    .as-guideline-card li::before {
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

    .as-guideline-card li strong {
        color: #333;
        font-weight: 700;
    }


    /* =========================================================
       COUNSELLING SPECIAL CARD
       ========================================================= */

    .as-guideline-counselling {
        background:
            linear-gradient(
                135deg,
                #fff8fa 0%,
                #fff 55%,
                #fff8f5 100%
            );
    }


    /* =========================================================
       ENFORCEMENT
       ========================================================= */

    .as-guidelines-enforcement-section {
        padding: 85px 20px;
        background: #fafafa;
    }

    .as-guidelines-section-heading {
        max-width: 720px;
        margin: 0 auto 42px;
        text-align: center;
    }

    .as-guidelines-section-heading .eyebrow {
        display: inline-block;
        margin-bottom: 12px;
        color: #dd2476;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 1.3px;
        text-transform: uppercase;
    }

    .as-guidelines-section-heading h2 {
        margin: 0 0 13px;
        color: #222;
        font-size: clamp(28px, 4vw, 38px);
        line-height: 1.2;
        font-weight: 800;
        letter-spacing: -.7px;
    }

    .as-guidelines-section-heading p {
        margin: 0;
        color: #6a6a6a;
        font-size: 15px;
        line-height: 1.75;
    }

    .as-guidelines-enforcement-card {
        width: min(100%, 900px);
        margin: 0 auto;
        padding: 35px;
        border-radius: 22px;
        background: #fff;
        border: 1px solid #eeeeee;
        box-shadow: 0 10px 35px rgba(0,0,0,.05);
        display: grid;
        grid-template-columns: 65px 1fr;
        gap: 24px;
        align-items: start;
    }

    .as-guidelines-enforcement-icon {
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

    .as-guidelines-enforcement-card h3 {
        margin: 0 0 12px;
        color: #222;
        font-size: 21px;
        font-weight: 750;
    }

    .as-guidelines-enforcement-card p {
        margin: 0;
        color: #666;
        font-size: 15px;
        line-height: 1.8;
    }


    /* =========================================================
       REPORT SECTION
       ========================================================= */

    .as-guidelines-report-section {
        padding: 85px 20px;
        background: #fff;
    }

    .as-guidelines-report-card {
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

    .as-guidelines-report-card::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        right: -100px;
        top: -110px;
        border-radius: 50%;
        background: rgba(221,36,118,.07);
    }

    .as-guidelines-report-content {
        position: relative;
        z-index: 2;
        max-width: 760px;
    }

    .as-guidelines-report-icon {
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

    .as-guidelines-report-card h2 {
        margin: 0 0 12px;
        color: #222;
        font-size: 28px;
        line-height: 1.25;
        font-weight: 800;
    }

    .as-guidelines-report-card p {
        margin: 0 0 22px;
        color: #666;
        font-size: 15px;
        line-height: 1.8;
    }

    .as-guidelines-report-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        padding: 14px 23px;
        border-radius: 999px;
        color: #fff !important;
        background: linear-gradient(90deg, #ff512f, #dd2476);
        text-decoration: none !important;
        font-size: 14px;
        font-weight: 700;
        box-shadow: 0 8px 22px rgba(221,36,118,.18);
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .as-guidelines-report-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(221,36,118,.24);
    }


    /* =========================================================
       FINAL NOTE
       ========================================================= */

    .as-guidelines-final-section {
        padding: 85px 20px 100px;
        background: #fff;
    }

    .as-guidelines-final {
        width: min(100%, 850px);
        margin: 0 auto;
        text-align: center;
    }

    .as-guidelines-final-icon {
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

    .as-guidelines-final h2 {
        margin: 0 0 16px;
        color: #222;
        font-size: clamp(29px, 4vw, 40px);
        line-height: 1.2;
        font-weight: 800;
        letter-spacing: -.7px;
    }

    .as-guidelines-final p {
        margin: 0 auto;
        max-width: 720px;
        color: #666;
        font-size: 16px;
        line-height: 1.85;
    }


    /* =========================================================
       RESPONSIVE
       ========================================================= */

    @media (max-width: 900px) {

        .as-guidelines-hero {
            min-height: 390px;
        }

        .as-guidelines-grid {
            grid-template-columns: 1fr;
        }

        .as-guideline-card-wide {
            grid-column: auto;
        }

        .as-guidelines-intro-section,
        .as-guidelines-section,
        .as-guidelines-enforcement-section,
        .as-guidelines-report-section {
            padding-left: 18px;
            padding-right: 18px;
        }
    }


    @media (max-width: 650px) {

        .as-guidelines-hero-content {
            width: min(100% - 24px, 950px);
            padding: 65px 12px;
        }

        .as-guidelines-hero h1 {
            font-size: 39px;
            letter-spacing: -1px;
        }

        .as-guidelines-hero p {
            font-size: 15px;
            line-height: 1.7;
        }

        .as-guidelines-intro {
            padding: 30px 24px;
        }

        .as-guideline-card {
            padding: 26px 23px;
        }

        .as-guidelines-enforcement-card {
            grid-template-columns: 1fr;
            padding: 28px 24px;
        }

        .as-guidelines-report-card {
            padding: 32px 25px;
        }

        .as-guidelines-final-section {
            padding-bottom: 75px;
        }
    }


    @media (max-width: 420px) {

        .as-guidelines-hero {
            min-height: 365px;
        }

        .as-guidelines-hero-content {
            padding-top: 55px;
            padding-bottom: 55px;
        }

        .as-guidelines-eyebrow {
            font-size: 10px;
            padding: 7px 12px;
        }

        .as-guidelines-hero h1 {
            font-size: 34px;
        }

        .as-guidelines-intro {
            padding: 26px 20px;
            border-radius: 18px;
        }

        .as-guideline-card {
            padding: 24px 20px;
            border-radius: 18px;
        }

        .as-guideline-card h2 {
            font-size: 19px;
        }

        .as-guideline-card p,
        .as-guideline-card li {
            font-size: 14px;
        }

        .as-guidelines-report-card {
            padding: 28px 20px;
            border-radius: 20px;
        }

        .as-guidelines-report-card h2 {
            font-size: 25px;
        }

        .as-guidelines-report-btn {
            width: 100%;
        }
    }

</style>
@endsection


@section('content')

<div class="as-guidelines-page">

    {{-- =====================================================
         HERO
         ===================================================== --}}
    <section class="as-guidelines-hero">

        <img
            src="{{ asset('images/coursel.png') }}"
            alt="LGBTQ+ community"
            class="as-guidelines-hero-image"
        >

        <div class="as-guidelines-hero-overlay"></div>

        <div class="as-guidelines-hero-content">

            <div class="as-guidelines-eyebrow">
                <i class="fa-solid fa-shield-heart"></i>
                Community Standards
            </div>

            <h1>Community Guidelines</h1>

            <p>
                A respectful, inclusive, and safer space for LGBTQ+ people
                to connect, date, find community, and access support.
            </p>

        </div>

    </section>


    {{-- =====================================================
         INTRO
         ===================================================== --}}
    <section class="as-guidelines-intro-section">

        <div class="as-guidelines-container">

            <div class="as-guidelines-intro">

                <div class="as-guidelines-intro-icon">
                    <i class="fa-solid fa-people-group"></i>
                </div>

                <h2>What These Guidelines Are About</h2>

                <p>
                    AffirmSpace is a space built for LGBTQ+ people to connect,
                    date, find community, and access support — safely.
                    These guidelines exist to keep it that way.
                    By using AffirmSpace, you agree to follow them.
                </p>

            </div>

        </div>

    </section>


    {{-- =====================================================
         MAIN GUIDELINES
         ===================================================== --}}
    <section class="as-guidelines-section">

        <div class="as-guidelines-container">

            <div class="as-guidelines-grid">


                {{-- BE RESPECTFUL --}}
                <article class="as-guideline-card">

                    <div class="as-guideline-icon">
                        <i class="fa-solid fa-handshake"></i>
                    </div>

                    <h2>Be Respectful</h2>

                    <ul>
                        <li>
                            No harassment, bullying, or abusive behavior
                            toward anyone.
                        </li>

                        <li>
                            No hate speech, slurs, or discrimination based
                            on someone's identity, orientation, gender,
                            race, religion, caste, disability, or body.
                        </li>

                        <li>
                            Disagreements happen — keep them respectful.
                            Personal attacks aren't allowed.
                        </li>
                    </ul>

                </article>


                {{-- BE REAL --}}
                <article class="as-guideline-card">

                    <div class="as-guideline-icon">
                        <i class="fa-solid fa-user-check"></i>
                    </div>

                    <h2>Be Real</h2>

                    <ul>
                        <li>
                            Use your own photos and real, honest information
                            on your profile.
                        </li>

                        <li>
                            No impersonating another person, celebrity,
                            or organization.
                        </li>

                        <li>
                            No fake profiles, bots, or catfishing.
                        </li>
                    </ul>

                </article>


                {{-- PRIVACY --}}
                <article class="as-guideline-card">

                    <div class="as-guideline-icon">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>

                    <h2>Respect People's Privacy</h2>

                    <ul>
                        <li>
                            Don't share screenshots, photos, chats, or
                            personal details of other users without their
                            consent.
                        </li>

                        <li>
                            Don't out someone's sexual orientation or gender
                            identity to anyone, on or off the platform,
                            without their explicit permission.
                        </li>

                        <li>
                            Outing someone can put them at serious risk —
                            this is taken seriously.
                        </li>

                        <li>
                            Don't use information from someone's profile
                            or conversations to track, contact, or find
                            them outside the app without their consent.
                        </li>
                    </ul>

                </article>


                {{-- CONSENT --}}
                <article class="as-guideline-card">

                    <div class="as-guideline-icon">
                        <i class="fa-solid fa-heart"></i>
                    </div>

                    <h2>Consent Matters</h2>

                    <ul>
                        <li>
                            Unwanted sexual messages, images, or advances
                            are not allowed.
                        </li>

                        <li>
                            Respect when someone says no, stops responding,
                            or blocks you.
                        </li>

                        <li>
                            Nobody is entitled to another person's time,
                            attention, or response.
                        </li>
                    </ul>

                </article>


                {{-- HARMFUL / ILLEGAL --}}
                <article class="as-guideline-card">

                    <div class="as-guideline-icon">
                        <i class="fa-solid fa-ban"></i>
                    </div>

                    <h2>No Harmful or Illegal Content</h2>

                    <ul>
                        <li>
                            No sharing of illegal content of any kind.
                        </li>

                        <li>
                            No promotion of self-harm, violence, or
                            dangerous behavior.
                        </li>

                        <li>
                            No promotion of "conversion therapy" or any
                            practice claiming to change someone's sexual
                            orientation or gender identity.
                        </li>

                        <li>
                            No graphic, exploitative, or non-consensual
                            sexual content.
                        </li>
                    </ul>

                </article>


                {{-- SPAM / SCAMS --}}
                <article class="as-guideline-card">

                    <div class="as-guideline-icon">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>

                    <h2>No Spam or Scams</h2>

                    <ul>
                        <li>
                            No solicitation, advertising, or promotional
                            content unless approved by AffirmSpace
                            (for example, through the Events feature).
                        </li>

                        <li>
                            No requesting money, gifts, or financial
                            information from other users.
                        </li>

                        <li>
                            No phishing links or attempts to move users
                            off-platform for scams.
                        </li>
                    </ul>

                </article>


                {{-- COUNSELLING --}}
                <article class="as-guideline-card as-guideline-card-wide as-guideline-counselling">

                    <div class="as-guideline-icon">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>

                    <h2>Counselling Space</h2>

                    <p>
                        Counselling sessions on AffirmSpace are meant to be
                        a safe, supportive space. Abusive behavior toward
                        counsellors, or misuse of the counselling feature,
                        isn't allowed.
                    </p>

                    <p style="margin-top:14px;">
                        Counsellors on AffirmSpace are expected to maintain
                        professionalism and confidentiality in every session.
                    </p>

                </article>

            </div>

        </div>

    </section>


    {{-- =====================================================
         ENFORCEMENT
         ===================================================== --}}
    <section class="as-guidelines-enforcement-section">

        <div class="as-guidelines-section-heading">

            <span class="eyebrow">Enforcement</span>

            <h2>What Happens If These Guidelines Are Broken?</h2>

            <p>
                We may take action when behavior or content violates these
                guidelines. The response can depend on the nature and
                severity of the violation.
            </p>

        </div>


        <div class="as-guidelines-enforcement-card">

            <div class="as-guidelines-enforcement-icon">
                <i class="fa-solid fa-scale-balanced"></i>
            </div>

            <div>

                <h3>Actions We May Take</h3>

                <p>
                    Depending on the severity, this can include a warning,
                    content removal, or permanent account suspension —
                    with no refund for paid features, as outlined in our
                    Terms &amp; Conditions.
                    Serious violations, including anything involving harm
                    to minors, will be reported to relevant authorities.
                </p>

            </div>

        </div>

    </section>


    {{-- =====================================================
         REPORT
         ===================================================== --}}
    <section class="as-guidelines-report-section">

        <div class="as-guidelines-report-card">

            <div class="as-guidelines-report-content">

                <div class="as-guidelines-report-icon">
                    <i class="fa-solid fa-flag"></i>
                </div>

                <h2>Report Something</h2>

                <p>
                    If you see behavior that breaks these guidelines,
                    please let us know through our Problem page.
                    We review every report.
                </p>

                <a
                    href="{{ route('contactWithAdmin') }}"
                    class="as-guidelines-report-btn">
                    <i class="fa-solid fa-arrow-right"></i>
                    Report a Problem
                </a>

            </div>

        </div>

    </section>


    {{-- =====================================================
         FINAL NOTE
         ===================================================== --}}
    <section class="as-guidelines-final-section">

        <div class="as-guidelines-final">

            <div class="as-guidelines-final-icon">
                <i class="fa-solid fa-heart"></i>
            </div>

            <h2>A Final Note</h2>

            <p>
                These guidelines aren't about restricting who you are —
                they're here to protect a space where LGBTQ+ people can
                show up as themselves without fear.
                Thank you for helping keep AffirmSpace that kind of place.
            </p>

        </div>

    </section>

</div>

@endsection