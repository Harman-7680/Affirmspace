@extends('layouts.seo')

@section('meta')
    <meta name="description"
        content="Chat anonymously with LGBTQ+ people who get it. Private one-on-one and group chats, moderated for safety, free to join — no identity required.">

    <title>AffirmSpace – Anonymous, Safe LGBTQ+ Chat Platform</title>

    <meta name="author" content="AffirmSpace">

    <meta name="keywords"
        content="LGBTQ+ chat, anonymous LGBTQ+ chat, safe LGBTQ+ chat platform, LGBTQ+ messaging, gay chat, lesbian chat, transgender chat, LGBTQ+ group chat, private LGBTQ+ chat">

    <link rel="canonical" href="https://affirmspace.com/lgbtq-chat">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- FAQ Schema --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [
            {
                "@type": "Question",
                "name": "Is AffirmSpace Chat really anonymous?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Yes. AffirmSpace allows members to participate using a username without requiring them to display their real name or profile photo in every conversation. Members choose how much personal information they reveal."
                }
            },
            {
                "@type": "Question",
                "name": "How is chat moderated?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "AffirmSpace provides reporting and blocking tools to help members respond to uncomfortable or inappropriate interactions. Moderation procedures and response times may vary according to the type of report and the available review process."
                }
            },
            {
                "@type": "Question",
                "name": "Can I switch between anonymous and verified mode?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Members can choose how much information they share on AffirmSpace. Any future identity-verification feature should be reviewed according to the current verification and privacy options available inside the platform."
                }
            },
            {
                "@type": "Question",
                "name": "Is there a cost to chat?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "AffirmSpace is free to join. Access to particular features may depend on the current product and pricing model shown inside the platform."
                }
            },
            {
                "@type": "Question",
                "name": "Can I report someone who makes me uncomfortable?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Yes. AffirmSpace provides report and block options to help members manage uncomfortable or inappropriate interactions."
                }
            },
            {
                "@type": "Question",
                "name": "Is AffirmSpace only for India?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "No. AffirmSpace was built by a team based in India but is designed for LGBTQ+ people worldwide."
                }
            }
        ]
    }
    </script>

    {{-- WebPage Schema --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "name": "AffirmSpace – Anonymous, Safe LGBTQ+ Chat Platform",
        "url": "https://affirmspace.com/lgbtq-chat",
        "description": "Private, anonymous and inclusive LGBTQ+ chat for meaningful conversations, friendships and community connections."
    }
    </script>
@endsection


@section('css')
    <style>
        /* =========================================================
               AFFIRMSPACE CHAT PAGE
            ========================================================= */

        .as-chat-page {
            --as-gradient: linear-gradient(90deg, #ff512f, #dd2476);
            --as-orange: #ff512f;
            --as-pink: #dd2476;
            --as-dark: #171725;
            --as-text: #555568;
            --as-light: #fff8fb;
            --as-border: rgba(25, 25, 45, 0.08);
            font-family: 'Inter', sans-serif;
            color: var(--as-dark);
            overflow: hidden;
            background: #ffffff;
        }

        .as-chat-page *,
        .as-chat-page *::before,
        .as-chat-page *::after {
            box-sizing: border-box;
        }

        .as-chat-page img {
            max-width: 100%;
        }

        .as-chat-page a {
            text-decoration: none;
        }

        .as-chat-container {
            width: min(1180px, calc(100% - 40px));
            margin: 0 auto;
        }

        .as-chat-section {
            padding: 100px 0;
        }

        .as-chat-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: var(--as-pink);
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 1.4px;
            text-transform: uppercase;
            margin-bottom: 18px;
        }

        .as-chat-eyebrow::before {
            content: "";
            width: 28px;
            height: 3px;
            border-radius: 20px;
            background: var(--as-gradient);
        }

        .as-chat-heading {
            max-width: 760px;
            margin: 0 auto 18px;
            text-align: center;
            font-size: clamp(32px, 4vw, 52px);
            line-height: 1.12;
            font-weight: 800;
            letter-spacing: -1.5px;
        }

        .as-chat-heading span {
            background: var(--as-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .as-chat-description {
            max-width: 780px;
            margin: 0 auto;
            color: var(--as-text);
            font-size: 16px;
            line-height: 1.9;
            text-align: center;
        }

        .as-chat-section-intro {
            text-align: center;
            margin-bottom: 55px;
        }

        .as-chat-primary-btn,
        .as-chat-secondary-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 52px;
            padding: 15px 25px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 800;
            transition: 0.3s ease;
        }

        .as-chat-primary-btn {
            color: #ffffff;
            background: var(--as-gradient);
            box-shadow: 0 12px 30px rgba(221, 36, 118, 0.22);
        }

        .as-chat-primary-btn:hover {
            color: #ffffff;
            transform: translateY(-3px);
            box-shadow: 0 17px 35px rgba(221, 36, 118, 0.3);
        }

        .as-chat-secondary-btn {
            color: var(--as-dark);
            background: #ffffff;
            border: 1px solid rgba(25, 25, 45, 0.12);
        }

        .as-chat-secondary-btn:hover {
            color: var(--as-pink);
            border-color: rgba(221, 36, 118, 0.35);
            transform: translateY(-3px);
        }

        /* =========================================================
               HERO
            ========================================================= */

        .as-chat-hero {
            position: relative;
            min-height: 670px;
            display: flex;
            align-items: center;
            background:
                radial-gradient(circle at 85% 15%, rgba(255, 81, 47, 0.12), transparent 28%),
                radial-gradient(circle at 15% 80%, rgba(221, 36, 118, 0.10), transparent 30%),
                #fff9fb;
            isolation: isolate;
        }

        .as-chat-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -1;
            background-image:
                linear-gradient(rgba(221, 36, 118, 0.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(221, 36, 118, 0.035) 1px, transparent 1px);
            background-size: 42px 42px;
            mask-image: linear-gradient(to bottom, black, transparent);
        }

        .as-chat-hero-grid {
            display: grid;
            grid-template-columns: 1.02fr 0.98fr;
            align-items: center;
            gap: 60px;
        }

        .as-chat-hero-copy {
            position: relative;
            z-index: 2;
        }

        .as-chat-hero-copy h1 {
            margin: 0 0 25px;
            font-size: clamp(40px, 5vw, 70px);
            line-height: 1.06;
            letter-spacing: -2.5px;
            font-weight: 800;
        }

        .as-chat-hero-copy h1 span {
            background: var(--as-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .as-chat-hero-copy p {
            max-width: 590px;
            margin: 0 0 30px;
            color: var(--as-text);
            font-size: 18px;
            line-height: 1.8;
        }

        .as-chat-hero-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 14px;
        }

        .as-chat-founding-line {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 24px;
            color: #777789;
            font-size: 13px;
            line-height: 1.6;
        }

        .as-chat-founding-line i {
            color: var(--as-pink);
        }

        .as-chat-hero-visual {
            position: relative;
            min-height: 520px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .as-chat-hero-image-card {
            position: relative;
            width: min(100%, 500px);
            border-radius: 38px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(50, 25, 60, 0.16);
            transform: rotate(2deg);
        }

        .as-chat-hero-image-card img {
            display: block;
            width: 100%;
            height: 520px;
            object-fit: cover;
        }

        .as-chat-hero-image-card::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg,
                    rgba(20, 10, 30, 0.02),
                    rgba(20, 10, 30, 0.25));
            pointer-events: none;
        }

        .as-chat-floating-card {
            position: absolute;
            z-index: 3;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 18px;
            border: 1px solid rgba(255, 255, 255, 0.75);
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(14px);
            box-shadow: 0 18px 45px rgba(40, 20, 50, 0.14);
            animation: asChatFloat 5s ease-in-out infinite;
        }

        .as-chat-floating-card i {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 13px;
            color: #ffffff;
            background: var(--as-gradient);
        }

        .as-chat-floating-card strong {
            display: block;
            color: var(--as-dark);
            font-size: 13px;
            font-weight: 800;
        }

        .as-chat-floating-card small {
            display: block;
            margin-top: 3px;
            color: #777789;
            font-size: 11px;
        }

        .as-chat-floating-card.one {
            top: 42px;
            right: -12px;
        }

        .as-chat-floating-card.two {
            bottom: 38px;
            left: -22px;
            animation-delay: 1.2s;
        }

        .as-chat-floating-emoji {
            position: absolute;
            color: rgba(221, 36, 118, 0.55);
            font-size: 30px;
            animation: asChatFloat 6s ease-in-out infinite;
        }

        .as-chat-floating-emoji.one {
            top: 5%;
            left: 3%;
        }

        .as-chat-floating-emoji.two {
            right: 5%;
            bottom: 5%;
            animation-delay: 1.4s;
        }

        @keyframes asChatFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-12px);
            }
        }

        /* =========================================================
               INTRO / WHY CHAT
            ========================================================= */

        .as-chat-why {
            background: #ffffff;
        }

        .as-chat-why-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 45px;
        }

        .as-chat-mini-card {
            padding: 30px 24px;
            text-align: center;
            background: #ffffff;
            border: 1px solid var(--as-border);
            border-radius: 24px;
            box-shadow: 0 10px 35px rgba(30, 20, 50, 0.045);
            transition: 0.3s ease;
        }

        .as-chat-mini-card:hover {
            transform: translateY(-7px);
            border-color: rgba(221, 36, 118, 0.2);
            box-shadow: 0 18px 45px rgba(221, 36, 118, 0.1);
        }

        .as-chat-mini-card img {
            width: 78px;
            height: 78px;
            object-fit: contain;
            margin-bottom: 18px;
        }

        .as-chat-mini-card h3 {
            margin: 0 0 10px;
            font-size: 18px;
            line-height: 1.35;
            font-weight: 800;
        }

        .as-chat-mini-card p {
            margin: 0;
            color: var(--as-text);
            font-size: 14px;
            line-height: 1.7;
        }

        /* =========================================================
               FEATURE SLIDER
            ========================================================= */

        .as-chat-features {
            padding: 100px 0;
            background: #fff8fb;
        }

        .as-chat-feature-slider {
            position: relative;
            overflow: hidden;
            min-height: 470px;
            border-radius: 34px;
            background: var(--as-gradient);
            box-shadow: 0 25px 70px rgba(221, 36, 118, 0.16);
        }

        .as-chat-feature-slider[data-active="2"] {
            background: linear-gradient(90deg, #4b0082, #8a2be2);
        }

        .as-chat-feature-slider[data-active="3"] {
            background: linear-gradient(90deg, #11998e, #38ef7d);
        }

        .as-chat-feature-slider[data-active="4"] {
            background: linear-gradient(90deg, #f7971e, #ffd200);
        }

        .as-chat-feature-slider[data-active="5"] {
            background: linear-gradient(90deg, #2193b0, #6dd5ed);
        }

        .as-chat-feature-track {
            position: relative;
            min-height: 410px;
        }

        .as-chat-feature-slide {
            display: none;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 50px;
            min-height: 410px;
            padding: 55px 75px;
            color: #ffffff;
        }

        .as-chat-feature-slide.active {
            display: grid;
            animation: asChatSlideIn 0.45s ease;
        }

        @keyframes asChatSlideIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .as-chat-feature-copy i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            margin-bottom: 25px;
            border-radius: 22px;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.2);
            font-size: 27px;
        }

        .as-chat-feature-copy h3 {
            max-width: 560px;
            margin: 0 0 18px;
            font-size: clamp(28px, 3.2vw, 46px);
            line-height: 1.12;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .as-chat-feature-copy p {
            max-width: 530px;
            margin: 0;
            font-size: 16px;
            line-height: 1.8;
            color: rgba(255, 255, 255, 0.9);
        }

        .as-chat-feature-image {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .as-chat-feature-image img {
            width: 300px;
            height: 310px;
            object-fit: cover;
            border-radius: 36px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.2);
        }

        .as-chat-feature-navigation {
            display: flex;
            justify-content: center;
            gap: 12px;
            padding: 0 20px 35px;
        }

        .as-chat-feature-dot {
            width: 13px;
            height: 13px;
            padding: 0;
            border: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.4);
            cursor: pointer;
            transition: 0.3s ease;
        }

        .as-chat-feature-dot.active,
        .as-chat-feature-dot:hover {
            background: #ffffff;
            transform: scale(1.25);
        }

        /* =========================================================
               COMMUNITY SECTION
            ========================================================= */

        .as-chat-community {
            background: #ffffff;
        }

        .as-chat-split-card {
            display: grid;
            grid-template-columns: 0.9fr 1.1fr;
            align-items: center;
            gap: 55px;
            padding: 32px;
            border-radius: 34px;
            background: #fff8f4;
            box-shadow: 0 0 0 1px rgba(30, 20, 50, 0.03);
        }

        .as-chat-split-image img {
            display: block;
            width: 100%;
            min-height: 390px;
            object-fit: cover;
            border-radius: 26px;
        }

        .as-chat-split-copy h2 {
            margin: 0 0 22px;
            font-size: clamp(28px, 3.5vw, 43px);
            line-height: 1.15;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .as-chat-split-copy h2 span {
            background: var(--as-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .as-chat-split-copy p {
            margin: 0 0 18px;
            color: var(--as-text);
            font-size: 15px;
            line-height: 1.9;
        }

        .as-chat-check-list {
            display: grid;
            gap: 13px;
            padding: 0;
            margin: 24px 0 0;
            list-style: none;
        }

        .as-chat-check-list li {
            position: relative;
            padding-left: 34px;
            color: #555568;
            font-size: 15px;
            line-height: 1.6;
        }

        .as-chat-check-list li::before {
            content: "✓";
            position: absolute;
            left: 0;
            top: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 23px;
            height: 23px;
            border-radius: 50%;
            color: #ffffff;
            background: var(--as-gradient);
            font-size: 12px;
            font-weight: 800;
        }

        /* =========================================================
               MORE THAN CHAT
            ========================================================= */

        .as-chat-more {
            background: #fff8fb;
        }

        .as-chat-more-card {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            align-items: center;
            gap: 55px;
            padding: 38px;
            border-radius: 34px;
            background: #ffffff;
            box-shadow: 0 15px 50px rgba(30, 20, 50, 0.06);
        }

        .as-chat-more-copy h2 {
            margin: 0 0 20px;
            font-size: clamp(28px, 3.5vw, 43px);
            line-height: 1.15;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .as-chat-more-copy p {
            margin: 0 0 18px;
            color: var(--as-text);
            font-size: 15px;
            line-height: 1.9;
        }

        .as-chat-more-image img {
            display: block;
            width: 100%;
            border-radius: 28px;
            object-fit: cover;
        }

        /* =========================================================
               WHY MEMBERS CHOOSE
            ========================================================= */

        .as-chat-choose {
            background: #ffffff;
        }

        .as-chat-choose-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
        }

        .as-chat-choose-card {
            padding: 32px 26px;
            border-radius: 25px;
            border: 1px solid transparent;
            transition: 0.3s ease;
        }

        .as-chat-choose-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 40px rgba(30, 20, 50, 0.07);
        }

        .as-chat-choose-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 62px;
            height: 62px;
            margin-bottom: 22px;
            border-radius: 19px;
            background: #ffffff;
            box-shadow: 0 8px 22px rgba(30, 20, 50, 0.07);
            font-size: 25px;
        }

        .as-chat-choose-card h3 {
            margin: 0 0 12px;
            font-size: 20px;
            font-weight: 800;
        }

        .as-chat-choose-card p {
            margin: 0;
            color: var(--as-text);
            font-size: 14px;
            line-height: 1.8;
        }

        .as-chat-purple {
            background: #f4efff;
        }

        .as-chat-blue {
            background: #edf5ff;
        }

        .as-chat-pink {
            background: #ffeef5;
        }

        .as-chat-green {
            background: #eefbf2;
        }

        .as-chat-orange {
            background: #fff6e8;
        }

        .as-chat-violet {
            background: #f3efff;
        }

        /* =========================================================
               HOW IT WORKS
            ========================================================= */

        .as-chat-how {
            background: #fff8fb;
        }

        .as-chat-steps {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .as-chat-step {
            position: relative;
            padding: 35px 27px;
            text-align: center;
            background: #ffffff;
            border: 1px solid var(--as-border);
            border-radius: 26px;
            box-shadow: 0 10px 35px rgba(30, 20, 50, 0.04);
        }

        .as-chat-step-number {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            margin: 0 auto 22px;
            border-radius: 25px;
            background: #fff0f5;
        }

        .as-chat-step-number img {
            width: 65px;
            height: 65px;
            object-fit: contain;
        }

        .as-chat-step h3 {
            margin: 0 0 12px;
            font-size: 20px;
            font-weight: 800;
        }

        .as-chat-step p {
            margin: 0;
            color: var(--as-text);
            font-size: 14px;
            line-height: 1.8;
        }

        /* =========================================================
               FAQ
            ========================================================= */

        .as-chat-faq {
            background: #ffffff;
        }

        .as-chat-faq-list {
            max-width: 920px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .as-chat-faq-item {
            overflow: hidden;
            border: 1px solid #eeeeee;
            border-radius: 17px;
            background: #ffffff;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.035);
            transition: 0.3s ease;
        }

        .as-chat-faq-item:hover {
            border-color: rgba(221, 36, 118, 0.2);
            box-shadow: 0 12px 30px rgba(221, 36, 118, 0.07);
        }

        .as-chat-faq-question {
            width: 100%;
            min-height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 20px 24px;
            border: 0;
            background: #ffffff;
            color: var(--as-dark);
            font-family: inherit;
            font-size: 16px;
            font-weight: 800;
            line-height: 1.5;
            text-align: left;
            cursor: pointer;
        }

        .as-chat-faq-question:hover {
            color: var(--as-pink);
        }

        .as-chat-faq-question::after {
            content: "+";
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #fff1f5;
            color: var(--as-pink);
            font-size: 23px;
            font-weight: 400;
            transition: 0.3s ease;
        }

        .as-chat-faq-question.active::after {
            content: "−";
            color: #ffffff;
            background: var(--as-gradient);
            transform: rotate(180deg);
        }

        .as-chat-faq-answer {
            max-height: 0;
            overflow: hidden;
            background: #ffffff;
            transition: max-height 0.35s ease;
        }

        .as-chat-faq-answer p {
            margin: 0;
            padding: 0 70px 24px 24px;
            color: var(--as-text);
            font-size: 15px;
            line-height: 1.8;
        }

        /* =========================================================
               CROSS NAVIGATION
            ========================================================= */

        .as-chat-explore {
            background: #fff8fb;
        }

        .as-chat-explore-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }

        .as-chat-explore-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 190px;
            padding: 25px;
            border: 1px solid rgba(25, 25, 45, 0.07);
            border-radius: 23px;
            background: #ffffff;
            transition: 0.3s ease;
        }

        .as-chat-explore-card:hover {
            transform: translateY(-6px);
            border-color: rgba(221, 36, 118, 0.2);
            box-shadow: 0 15px 35px rgba(221, 36, 118, 0.08);
        }

        .as-chat-explore-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            margin-bottom: 20px;
            border-radius: 15px;
            color: #ffffff;
            background: var(--as-gradient);
            font-size: 20px;
        }

        .as-chat-explore-card h3 {
            margin: 0 0 8px;
            font-size: 17px;
            font-weight: 800;
        }

        .as-chat-explore-card p {
            margin: 0 0 18px;
            color: var(--as-text);
            font-size: 13px;
            line-height: 1.6;
        }

        .as-chat-explore-card span {
            color: var(--as-pink);
            font-size: 13px;
            font-weight: 800;
        }

        /* =========================================================
               FINAL CTA
            ========================================================= */

        .as-chat-final-cta {
            position: relative;
            padding: 105px 20px;
            overflow: hidden;
            text-align: center;
            color: #ffffff;
            background: var(--as-gradient);
        }

        .as-chat-final-cta::before,
        .as-chat-final-cta::after {
            content: "";
            position: absolute;
            width: 320px;
            height: 320px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 50%;
        }

        .as-chat-final-cta::before {
            top: -180px;
            left: -100px;
        }

        .as-chat-final-cta::after {
            right: -100px;
            bottom: -180px;
        }

        .as-chat-final-cta-content {
            position: relative;
            z-index: 2;
            max-width: 760px;
            margin: 0 auto;
        }

        .as-chat-final-cta h2 {
            margin: 0 0 18px;
            font-size: clamp(32px, 4vw, 55px);
            line-height: 1.1;
            font-weight: 800;
            letter-spacing: -1.5px;
        }

        .as-chat-final-cta p {
            max-width: 650px;
            margin: 0 auto 30px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 17px;
            line-height: 1.8;
        }

        .as-chat-final-cta .as-chat-primary-btn {
            color: var(--as-pink);
            background: #ffffff;
            box-shadow: 0 12px 30px rgba(50, 10, 30, 0.15);
        }

        .as-chat-final-cta .as-chat-primary-btn:hover {
            color: var(--as-pink);
            background: #ffffff;
        }

        .as-chat-final-secondary {
            display: inline-block;
            margin-top: 22px;
            color: #ffffff;
            font-size: 14px;
            font-weight: 800;
            text-decoration: underline !important;
            text-underline-offset: 4px;
        }

        /* =========================================================
               RESPONSIVE DESIGN
            ========================================================= */

        @media (max-width: 1100px) {
            .as-chat-hero-grid {
                gap: 35px;
            }

            .as-chat-hero-copy h1 {
                font-size: 53px;
            }

            .as-chat-why-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .as-chat-explore-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .as-chat-floating-card.one {
                right: 0;
            }

            .as-chat-floating-card.two {
                left: 0;
            }
        }

        @media (max-width: 900px) {
            .as-chat-section {
                padding: 75px 0;
            }

            .as-chat-hero {
                padding: 75px 0;
            }

            .as-chat-hero-grid {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .as-chat-hero-copy p {
                margin-left: auto;
                margin-right: auto;
            }

            .as-chat-hero-actions {
                justify-content: center;
            }

            .as-chat-founding-line {
                justify-content: center;
            }

            .as-chat-hero-visual {
                min-height: 450px;
                margin-top: 10px;
            }

            .as-chat-hero-image-card {
                max-width: 440px;
            }

            .as-chat-feature-slide {
                grid-template-columns: 1fr;
                gap: 30px;
                text-align: center;
                padding: 45px 35px;
            }

            .as-chat-feature-copy p {
                margin-left: auto;
                margin-right: auto;
            }

            .as-chat-feature-copy i {
                margin-bottom: 18px;
            }

            .as-chat-feature-image img {
                width: 230px;
                height: 245px;
            }

            .as-chat-split-card,
            .as-chat-more-card {
                grid-template-columns: 1fr;
                gap: 35px;
            }

            .as-chat-split-copy,
            .as-chat-more-copy {
                text-align: center;
            }

            .as-chat-check-list {
                max-width: 530px;
                margin-left: auto;
                margin-right: auto;
                text-align: left;
            }

            .as-chat-choose-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .as-chat-steps {
                grid-template-columns: 1fr;
                max-width: 570px;
                margin-left: auto;
                margin-right: auto;
            }
        }

        @media (max-width: 600px) {
            .as-chat-container {
                width: min(100% - 30px, 1180px);
            }

            .as-chat-section {
                padding: 60px 0;
            }

            .as-chat-hero {
                padding: 55px 0 65px;
            }

            .as-chat-hero-copy h1 {
                font-size: 40px;
                letter-spacing: -1.4px;
            }

            .as-chat-hero-copy p {
                font-size: 15px;
                line-height: 1.75;
            }

            .as-chat-hero-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .as-chat-primary-btn,
            .as-chat-secondary-btn {
                width: 100%;
            }

            .as-chat-founding-line {
                align-items: flex-start;
                text-align: left;
            }

            .as-chat-hero-visual {
                min-height: 350px;
            }

            .as-chat-hero-image-card {
                width: 88%;
                border-radius: 27px;
            }

            .as-chat-hero-image-card img {
                height: 360px;
            }

            .as-chat-floating-card {
                padding: 10px 12px;
                gap: 8px;
            }

            .as-chat-floating-card i {
                width: 32px;
                height: 32px;
                border-radius: 10px;
                font-size: 13px;
            }

            .as-chat-floating-card strong {
                font-size: 11px;
            }

            .as-chat-floating-card small {
                font-size: 9px;
            }

            .as-chat-floating-card.one {
                top: 5px;
                right: -4px;
            }

            .as-chat-floating-card.two {
                bottom: 5px;
                left: -4px;
            }

            .as-chat-why-grid {
                grid-template-columns: 1fr;
            }

            .as-chat-mini-card {
                padding: 27px 22px;
            }

            .as-chat-heading {
                font-size: 31px;
                letter-spacing: -0.8px;
            }

            .as-chat-description {
                font-size: 14px;
                line-height: 1.8;
            }

            .as-chat-feature-slider {
                border-radius: 25px;
            }

            .as-chat-feature-slide {
                min-height: 510px;
                padding: 38px 23px;
            }

            .as-chat-feature-copy h3 {
                font-size: 29px;
            }

            .as-chat-feature-copy p {
                font-size: 14px;
            }

            .as-chat-feature-image img {
                width: 205px;
                height: 220px;
                border-radius: 25px;
            }

            .as-chat-split-card,
            .as-chat-more-card {
                padding: 20px;
                border-radius: 25px;
            }

            .as-chat-split-image img {
                min-height: 250px;
                border-radius: 20px;
            }

            .as-chat-split-copy h2,
            .as-chat-more-copy h2 {
                font-size: 29px;
            }

            .as-chat-split-copy p,
            .as-chat-more-copy p {
                font-size: 14px;
            }

            .as-chat-choose-grid {
                grid-template-columns: 1fr;
            }

            .as-chat-choose-card {
                padding: 28px 23px;
            }

            .as-chat-step {
                padding: 30px 22px;
            }

            .as-chat-faq-question {
                min-height: 65px;
                padding: 17px 18px;
                font-size: 14px;
                gap: 12px;
            }

            .as-chat-faq-question::after {
                width: 32px;
                height: 32px;
                font-size: 21px;
            }

            .as-chat-faq-answer p {
                padding: 0 18px 20px;
                font-size: 14px;
            }

            .as-chat-explore-grid {
                grid-template-columns: 1fr;
            }

            .as-chat-final-cta {
                padding: 75px 20px;
            }

            .as-chat-final-cta h2 {
                font-size: 35px;
            }

            .as-chat-final-cta p {
                font-size: 15px;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .as-chat-page *,
            .as-chat-page *::before,
            .as-chat-page *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
@endsection


@section('content')
    <div class="as-chat-page">

        {{-- =====================================================
         HERO
    ====================================================== --}}
        <section class="as-chat-hero">
            <div class="as-chat-container">
                <div class="as-chat-hero-grid">

                    <div class="as-chat-hero-copy">
                        <div class="as-chat-eyebrow">LGBTQ+ Chat</div>

                        <h1>
                            Private, Safe &amp;
                            <span>Anonymous</span>
                        </h1>

                        <p>
                            Talk to people who already understand you — no labels required,
                            no explaining yourself from scratch. One-on-one messages,
                            group chats by topic, and full control over how much you share.
                        </p>

                        <div class="as-chat-hero-actions">
                            <a href="{{ url('/register') }}" class="as-chat-primary-btn">
                                Start Chatting Free
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>

                            <a href="{{ route('community') }}" class="as-chat-secondary-btn">
                                Explore Community
                            </a>
                        </div>

                        <div class="as-chat-founding-line">
                            <i class="fa-solid fa-heart"></i>
                            <span>
                                Early, real, and growing. Join as a founding member and help
                                shape what this community becomes.
                            </span>
                        </div>
                    </div>

                    <div class="as-chat-hero-visual">

                        <div class="as-chat-floating-emoji one">💬</div>
                        <div class="as-chat-floating-emoji two">💖</div>

                        <div class="as-chat-hero-image-card">
                            <img src="{{ asset('images/chat/Chat_Header_Banner.jpeg') }}"
                                alt="LGBTQ+ people connecting through safe and inclusive online chat">
                        </div>

                        <div class="as-chat-floating-card one">
                            <i class="fa-solid fa-shield-heart"></i>
                            <div>
                                <strong>Privacy Comes First</strong>
                                <small>Share on your own terms</small>
                            </div>
                        </div>

                        <div class="as-chat-floating-card two">
                            <i class="fa-solid fa-comments"></i>
                            <div>
                                <strong>Real Conversations</strong>
                                <small>Connect beyond small talk</small>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>


        {{-- =====================================================
         WHAT IS AFFIRMSPACE CHAT
    ====================================================== --}}
        <section class="as-chat-section as-chat-why">
            <div class="as-chat-container">

                <div class="as-chat-section-intro">
                    <div class="as-chat-eyebrow">What Is AffirmSpace Chat?</div>

                    <h2 class="as-chat-heading">
                        Conversations Where You Can
                        <span>Be Understood</span>
                    </h2>

                    <p class="as-chat-description">
                        AffirmSpace Chat is built for gay, lesbian, bisexual, transgender,
                        non-binary, pansexual, and asexual people — and anyone still figuring
                        it out — who want more than surface-level small talk.
                        You can talk here without starting every conversation with an explanation.
                    </p>

                    <p class="as-chat-description" style="margin-top:18px;">
                        Many LGBTQ+ people experience a lack of inclusivity, identity
                        misunderstandings, or interactions that simply do not feel comfortable
                        on mainstream chat platforms. AffirmSpace Chat is designed around
                        respect, choice, and conversations that feel more natural.
                    </p>
                </div>

                <div class="as-chat-why-grid">

                    <div class="as-chat-mini-card">
                        <img src="{{ asset('images/chat/Private_Chat.png') }}" alt="Private chat icon">

                        <h3>Private Conversations</h3>

                        <p>
                            Talk one-on-one and take conversations at your own pace.
                        </p>
                    </div>

                    <div class="as-chat-mini-card">
                        <img src="{{ asset('images/chat/Lgbt_Friendly.png') }}" alt="LGBTQ-friendly community icon">

                        <h3>LGBTQ+ Friendly</h3>

                        <p>
                            Connect in a space designed around identity and inclusion.
                        </p>
                    </div>

                    <div class="as-chat-mini-card">
                        <img src="{{ asset('images/chat/Group_Chat.png') }}" alt="Group chat icon">

                        <h3>Group Chats</h3>

                        <p>
                            Discover conversations around shared interests and experiences.
                        </p>
                    </div>

                    <div class="as-chat-mini-card">
                        <img src="{{ asset('images/chat/Real_Connections.png') }}" alt="Meaningful connections icon">

                        <h3>Real Connections</h3>

                        <p>
                            Build friendships, support networks, and meaningful relationships.
                        </p>
                    </div>

                </div>
            </div>
        </section>


        {{-- =====================================================
         CHAT FEATURES
    ====================================================== --}}
        <section class="as-chat-features">
            <div class="as-chat-container">

                <div class="as-chat-section-intro">
                    <div class="as-chat-eyebrow">Explore Chat Features</div>

                    <h2 class="as-chat-heading">
                        Everything You Need to
                        <span>Connect Comfortably</span>
                    </h2>

                    <p class="as-chat-description">
                        Whether you want a private conversation, a group discussion,
                        or simply a place to meet people who understand you,
                        AffirmSpace gives you room to connect at your own pace.
                    </p>
                </div>

                <div class="as-chat-feature-slider" id="asChatFeatureSlider" data-active="1">

                    <div class="as-chat-feature-track">

                        <div class="as-chat-feature-slide active" data-slide="1">
                            <div class="as-chat-feature-copy">
                                <i class="fa-solid fa-user-secret"></i>

                                <h3>
                                    Anonymous LGBTQ+ Chat Without Revealing Your Identity
                                </h3>

                                <p>
                                    Chat under a username instead of your real name or photo.
                                    Reveal as much or as little as you want, whenever you are
                                    ready. You decide how visible you want to be.
                                </p>
                            </div>

                            <div class="as-chat-feature-image">
                                <img src="{{ asset('images/chat/anonymouschat.png') }}"
                                    alt="Anonymous LGBTQ+ chat feature">
                            </div>
                        </div>


                        <div class="as-chat-feature-slide" data-slide="2">
                            <div class="as-chat-feature-copy">
                                <i class="fa-solid fa-lock"></i>

                                <h3>
                                    One-on-One Private Conversations
                                </h3>

                                <p>
                                    Message one person directly in a private thread.
                                    Take time to build trust, share something personal,
                                    or simply get to know someone slowly.
                                </p>
                            </div>

                            <div class="as-chat-feature-image">
                                <img src="{{ asset('images/chat/private.png') }}"
                                    alt="Private one-on-one chat feature">
                            </div>
                        </div>


                        <div class="as-chat-feature-slide" data-slide="3">
                            <div class="as-chat-feature-copy">
                                <i class="fa-solid fa-comments"></i>

                                <h3>
                                    LGBTQ+ Group Chat Rooms
                                </h3>

                                <p>
                                    Join conversations based on identity, interests,
                                    or shared experiences. Drop in for one conversation
                                    or become part of an ongoing group.
                                </p>
                            </div>

                            <div class="as-chat-feature-image">
                                <img src="{{ asset('images/chat/groupchat.png') }}" alt="LGBTQ+ group chat rooms">
                            </div>
                        </div>


                        <div class="as-chat-feature-slide" data-slide="4">
                            <div class="as-chat-feature-copy">
                                <i class="fa-solid fa-shield-halved"></i>

                                <h3>
                                    Private, Safe &amp; Moderated
                                </h3>

                                <p>
                                    AffirmSpace provides reporting and blocking tools
                                    to help members manage uncomfortable interactions
                                    and support respectful conversations.
                                </p>
                            </div>

                            <div class="as-chat-feature-image">
                                <img src="{{ asset('images/chat/safety.png') }}"
                                    alt="Chat safety and moderation feature">
                            </div>
                        </div>


                        <div class="as-chat-feature-slide" data-slide="5">
                            <div class="as-chat-feature-copy">
                                <i class="fa-solid fa-bolt"></i>

                                <h3>
                                    Instant Chat &amp; Easy Sign-Up
                                </h3>

                                <p>
                                    Create your profile and begin exploring conversations
                                    in minutes. Start with the information you are
                                    comfortable sharing and update your profile over time.
                                </p>
                            </div>

                            <div class="as-chat-feature-image">
                                <img src="{{ asset('images/chat/instant.png') }}"
                                    alt="Easy sign-up and instant chat feature">
                            </div>
                        </div>

                    </div>

                    <div class="as-chat-feature-navigation">
                        <button type="button" class="as-chat-feature-dot active" data-slide="1"
                            aria-label="Show anonymous chat feature"></button>

                        <button type="button" class="as-chat-feature-dot" data-slide="2"
                            aria-label="Show private conversation feature"></button>

                        <button type="button" class="as-chat-feature-dot" data-slide="3"
                            aria-label="Show group chat feature"></button>

                        <button type="button" class="as-chat-feature-dot" data-slide="4"
                            aria-label="Show safety feature"></button>

                        <button type="button" class="as-chat-feature-dot" data-slide="5"
                            aria-label="Show easy sign-up feature"></button>
                    </div>

                </div>
            </div>
        </section>


        {{-- =====================================================
         LGBTQ+ COMMUNITY
    ====================================================== --}}
        <section class="as-chat-section as-chat-community">
            <div class="as-chat-container">

                <div class="as-chat-split-card">

                    <div class="as-chat-split-image">
                        <img src="{{ asset('images/chat/space.png') }}"
                            alt="A welcoming space for LGBTQ+ community conversations">
                    </div>

                    <div class="as-chat-split-copy">

                        <div class="as-chat-eyebrow">Built Around Belonging</div>

                        <h2>
                            A Space Built for the
                            <span>LGBTQ+ Community</span>
                        </h2>

                        <p>
                            AffirmSpace Chat is not just another chat platform.
                            It is built with a clear understanding of the challenges
                            LGBTQ+ individuals can face in online spaces.
                        </p>

                        <p>
                            People may experience a lack of inclusivity, misunderstanding
                            of their identity, or interactions that feel unsafe or
                            uncomfortable.
                        </p>

                        <ul class="as-chat-check-list">
                            <li>Identity is respected by default.</li>
                            <li>Conversations can happen at your own pace.</li>
                            <li>You can connect around shared experiences and interests.</li>
                            <li>You decide how much personal information to reveal.</li>
                        </ul>

                        <p style="margin-top:22px;">
                            Whether someone identifies as gay, lesbian, queer, trans,
                            non-binary, pansexual, asexual, or is still exploring their
                            identity, AffirmSpace is designed to help people find
                            meaningful common ground.
                        </p>

                    </div>

                </div>
            </div>
        </section>


        {{-- =====================================================
         MORE THAN JUST CHAT
    ====================================================== --}}
        <section class="as-chat-section as-chat-more">
            <div class="as-chat-container">

                <div class="as-chat-more-card">

                    <div class="as-chat-more-copy">

                        <div class="as-chat-eyebrow">More Than Messaging</div>

                        <h2>
                            More Than
                            <span
                                style="background:var(--as-gradient);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;">
                                Just Chat
                            </span>
                        </h2>

                        <p>
                            AffirmSpace goes beyond basic messaging. It is a space where
                            you can connect with like-minded people, share experiences,
                            build friendships, and find emotional support.
                        </p>

                        <ul class="as-chat-check-list">
                            <li>Connect with people who understand your experiences.</li>
                            <li>Share personal stories and perspectives.</li>
                            <li>Build friendships and long-term connections.</li>
                            <li>Find conversations that feel meaningful.</li>
                            <li>Explore identity and community at your own pace.</li>
                        </ul>

                        <p style="margin-top:22px;">
                            You do not need a special reason to start a conversation.
                            Sometimes, simply finding someone who understands can make
                            a meaningful difference.
                        </p>

                    </div>

                    <div class="as-chat-more-image">
                        <img src="{{ asset('images/chat/justchat.png') }}"
                            alt="Meaningful LGBTQ+ conversations and emotional support">
                    </div>

                </div>
            </div>
        </section>


        {{-- =====================================================
         WHY MEMBERS CHOOSE AFFIRMSPACE
    ====================================================== --}}
        <section class="as-chat-section as-chat-choose">
            <div class="as-chat-container">

                <div class="as-chat-section-intro">
                    <div class="as-chat-eyebrow">Why AffirmSpace?</div>

                    <h2 class="as-chat-heading">
                        Designed for
                        <span>Meaningful Connection</span>
                    </h2>

                    <p class="as-chat-description">
                        AffirmSpace brings together conversation, identity, community,
                        and connection in one inclusive digital space.
                    </p>
                </div>

                <div class="as-chat-choose-grid">

                    <div class="as-chat-choose-card as-chat-purple">
                        <div class="as-chat-choose-icon">👥</div>

                        <h3>Inclusive Community</h3>

                        <p>
                            Built around LGBTQ+ identities, experiences, and shared interests.
                        </p>
                    </div>

                    <div class="as-chat-choose-card as-chat-blue">
                        <div class="as-chat-choose-icon">🔒</div>

                        <h3>Privacy First</h3>

                        <p>
                            Choose how much information you want to reveal while connecting
                            with others.
                        </p>
                    </div>

                    <div class="as-chat-choose-card as-chat-pink">
                        <div class="as-chat-choose-icon">💗</div>

                        <h3>Meaningful Connections</h3>

                        <p>
                            Focus on genuine conversations instead of endless scrolling.
                        </p>
                    </div>

                    <div class="as-chat-choose-card as-chat-green">
                        <div class="as-chat-choose-icon">🛡️</div>

                        <h3>Safe Environment</h3>

                        <p>
                            Reporting and blocking tools help members manage uncomfortable
                            interactions.
                        </p>
                    </div>

                    <div class="as-chat-choose-card as-chat-orange">
                        <div class="as-chat-choose-icon">💬</div>

                        <h3>Group Discussions</h3>

                        <p>
                            Find conversations based on interests, identity, and shared
                            experiences.
                        </p>
                    </div>

                    <div class="as-chat-choose-card as-chat-violet">
                        <div class="as-chat-choose-icon">⚡</div>

                        <h3>Easy to Use</h3>

                        <p>
                            Create your profile and begin exploring conversations in minutes.
                        </p>
                    </div>

                </div>
            </div>
        </section>


        {{-- =====================================================
         HOW AFFIRMSPACE CHAT WORKS
    ====================================================== --}}
        <section class="as-chat-section as-chat-how">
            <div class="as-chat-container">

                <div class="as-chat-section-intro">
                    <div class="as-chat-eyebrow">Simple to Begin</div>

                    <h2 class="as-chat-heading">
                        How AffirmSpace Chat
                        <span>Works</span>
                    </h2>

                    <p class="as-chat-description">
                        Start with a conversation and let meaningful connections develop
                        naturally.
                    </p>
                </div>

                <div class="as-chat-steps">

                    <div class="as-chat-step">
                        <div class="as-chat-step-number">
                            <img src="{{ asset('images/chat/Browse_Connect.png') }}" alt="Browse and connect">
                        </div>

                        <h3>Browse &amp; Connect</h3>

                        <p>
                            Explore group chats by topic or identity, or find people
                            with similar interests. No swiping required — chat comes first.
                        </p>
                    </div>

                    <div class="as-chat-step">
                        <div class="as-chat-step-number">
                            <img src="{{ asset('images/chat/Start_Messaging.png') }}" alt="Start messaging">
                        </div>

                        <h3>Start Messaging</h3>

                        <p>
                            Send messages and, where supported by the platform,
                            share different types of media in your conversations.
                        </p>
                    </div>

                    <div class="as-chat-step">
                        <div class="as-chat-step-number">
                            <img src="{{ asset('images/chat/Build_Relationships.png') }}"
                                alt="Build relationships">
                        </div>

                        <h3>Build Relationships</h3>

                        <p>
                            Move from a first conversation to friendship, a support
                            network, or something more — at whatever pace feels right.
                        </p>
                    </div>

                </div>
            </div>
        </section>


        {{-- =====================================================
         FAQ
    ====================================================== --}}
        <section class="as-chat-section as-chat-faq">
            <div class="as-chat-container">

                <div class="as-chat-section-intro">
                    <div class="as-chat-eyebrow">Frequently Asked Questions</div>

                    <h2 class="as-chat-heading">
                        Questions About
                        <span>AffirmSpace Chat?</span>
                    </h2>

                    <p class="as-chat-description">
                        Here are answers to some common questions about privacy,
                        conversations, and getting started.
                    </p>
                </div>

                <div class="as-chat-faq-list">

                    <div class="as-chat-faq-item">
                        <button type="button" class="as-chat-faq-question">
                            Is AffirmSpace Chat really anonymous?
                        </button>

                        <div class="as-chat-faq-answer">
                            <p>
                                Yes. You can participate using a username without needing
                                to display your real name or profile photo in every
                                conversation. You choose when and how much personal
                                information you want to reveal.
                            </p>
                        </div>
                    </div>


                    <div class="as-chat-faq-item">
                        <button type="button" class="as-chat-faq-question">
                            How is chat moderated?
                        </button>

                        <div class="as-chat-faq-answer">
                            <p>
                                AffirmSpace provides reporting and blocking tools to help
                                members manage uncomfortable or inappropriate interactions.
                                The review process and response time may depend on the
                                nature of the report and the moderation process currently
                                used by AffirmSpace.
                            </p>
                        </div>
                    </div>


                    <div class="as-chat-faq-item">
                        <button type="button" class="as-chat-faq-question">
                            Can I switch between anonymous and verified mode?
                        </button>

                        <div class="as-chat-faq-answer">
                            <p>
                                Members can choose how much information they share on
                                AffirmSpace. Any identity-verification option should be
                                understood according to the verification and privacy
                                controls currently available inside the platform.
                            </p>
                        </div>
                    </div>


                    <div class="as-chat-faq-item">
                        <button type="button" class="as-chat-faq-question">
                            Is there a cost to chat?
                        </button>

                        <div class="as-chat-faq-answer">
                            <p>
                                AffirmSpace is free to join. Access to specific features
                                may depend on the current product and pricing model shown
                                inside the platform.
                            </p>
                        </div>
                    </div>


                    <div class="as-chat-faq-item">
                        <button type="button" class="as-chat-faq-question">
                            Can I report someone who makes me uncomfortable?
                        </button>

                        <div class="as-chat-faq-answer">
                            <p>
                                Yes. AffirmSpace provides report and block options to help
                                members manage uncomfortable or inappropriate interactions.
                                If someone makes you feel unsafe, use the available
                                reporting and blocking controls.
                            </p>
                        </div>
                    </div>


                    <div class="as-chat-faq-item">
                        <button type="button" class="as-chat-faq-question">
                            Is AffirmSpace only for India?
                        </button>

                        <div class="as-chat-faq-answer">
                            <p>
                                No. AffirmSpace was built by a team based in India but is
                                designed for LGBTQ+ people worldwide. Chat is intended
                                for members regardless of where they are located.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </section>


        {{-- =====================================================
         LOOKING FOR SOMETHING MORE SPECIFIC?
    ====================================================== --}}
        <section class="as-chat-section as-chat-explore">
            <div class="as-chat-container">

                <div class="as-chat-section-intro">
                    <div class="as-chat-eyebrow">Explore More</div>

                    <h2 class="as-chat-heading">
                        Looking for Something
                        <span>More Specific?</span>
                    </h2>

                    <p class="as-chat-description">
                        AffirmSpace brings different ways to connect, learn, and find support
                        together in one platform.
                    </p>
                </div>

                <div class="as-chat-explore-grid">

                    <a href="{{ route('chatAndDating') }}" class="as-chat-explore-card">
                        <div>
                            <div class="as-chat-explore-icon">
                                <i class="fa-solid fa-heart"></i>
                            </div>

                            <h3>Dating</h3>

                            <p>
                                Ready to date, not just chat?
                            </p>
                        </div>

                        <span>
                            Browse LGBTQ+ Dating →
                        </span>
                    </a>


                    <a href="{{ route('counselling') }}" class="as-chat-explore-card">
                        <div>
                            <div class="as-chat-explore-icon">
                                <i class="fa-solid fa-hand-holding-heart"></i>
                            </div>

                            <h3>Counselling</h3>

                            <p>
                                Need professional support?
                            </p>
                        </div>

                        <span>
                            Find a Counsellor →
                        </span>
                    </a>


                    <a href="{{ route('events') }}" class="as-chat-explore-card">
                        <div>
                            <div class="as-chat-explore-icon">
                                <i class="fa-solid fa-calendar-days"></i>
                            </div>

                            <h3>Events</h3>

                            <p>
                                Want to meet people in person or at an event?
                            </p>
                        </div>

                        <span>
                            See LGBTQ+ Events →
                        </span>
                    </a>


                    <a href="{{ route('community') }}" class="as-chat-explore-card">
                        <div>
                            <div class="as-chat-explore-icon">
                                <i class="fa-solid fa-users"></i>
                            </div>

                            <h3>Community</h3>

                            <p>
                                Looking for groups and discussions?
                            </p>
                        </div>

                        <span>
                            Explore the Community →
                        </span>
                    </a>

                </div>
            </div>
        </section>


        {{-- =====================================================
         FINAL CTA
    ====================================================== --}}
        <section class="as-chat-final-cta">
            <div class="as-chat-final-cta-content">

                <h2>Your People Are Already Here</h2>

                <p>
                    You do not need a reason to be ready. Start a conversation,
                    join a group, or simply see who is around.
                </p>

                <a href="{{ url('/register') }}" class="as-chat-primary-btn">
                    Start Chatting Free
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

                <br>

                <a href="{{ route('chatAndDating') }}" class="as-chat-final-secondary">
                    Explore Dating on AffirmSpace →
                </a>

            </div>
        </section>

    </div>
@endsection


@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /* =====================================================
               FEATURE SLIDER
            ====================================================== */

            const slider = document.getElementById('asChatFeatureSlider');

            if (slider) {
                const slides = slider.querySelectorAll('.as-chat-feature-slide');
                const dots = slider.querySelectorAll('.as-chat-feature-dot');
                let currentSlide = 1;
                let autoPlay;

                function showChatSlide(slideNumber) {
                    slides.forEach(function(slide) {
                        slide.classList.remove('active');
                    });

                    dots.forEach(function(dot) {
                        dot.classList.remove('active');
                    });

                    const selectedSlide = slider.querySelector(
                        '.as-chat-feature-slide[data-slide="' + slideNumber + '"]'
                    );

                    const selectedDot = slider.querySelector(
                        '.as-chat-feature-dot[data-slide="' + slideNumber + '"]'
                    );

                    if (selectedSlide) {
                        selectedSlide.classList.add('active');
                    }

                    if (selectedDot) {
                        selectedDot.classList.add('active');
                    }

                    slider.setAttribute('data-active', slideNumber);
                    currentSlide = slideNumber;
                }

                function startChatAutoPlay() {
                    autoPlay = setInterval(function() {
                        let nextSlide = currentSlide + 1;

                        if (nextSlide > slides.length) {
                            nextSlide = 1;
                        }

                        showChatSlide(nextSlide);
                    }, 5000);
                }

                function resetChatAutoPlay() {
                    clearInterval(autoPlay);
                    startChatAutoPlay();
                }

                dots.forEach(function(dot) {
                    dot.addEventListener('click', function() {
                        const slideNumber = parseInt(
                            dot.getAttribute('data-slide'),
                            10
                        );

                        showChatSlide(slideNumber);
                        resetChatAutoPlay();
                    });
                });

                showChatSlide(1);
                startChatAutoPlay();

                slider.addEventListener('mouseenter', function() {
                    clearInterval(autoPlay);
                });

                slider.addEventListener('mouseleave', function() {
                    startChatAutoPlay();
                });
            }


            /* =====================================================
               FAQ ACCORDION
            ====================================================== */

            const faqQuestions = document.querySelectorAll(
                '.as-chat-faq-question'
            );

            faqQuestions.forEach(function(question) {
                question.addEventListener('click', function() {

                    const answer = question.nextElementSibling;
                    const isActive = question.classList.contains('active');

                    faqQuestions.forEach(function(otherQuestion) {
                        otherQuestion.classList.remove('active');

                        const otherAnswer = otherQuestion.nextElementSibling;

                        if (otherAnswer) {
                            otherAnswer.style.maxHeight = null;
                        }
                    });

                    if (!isActive && answer) {
                        question.classList.add('active');
                        answer.style.maxHeight = answer.scrollHeight + 'px';
                    }

                });
            });

        });
    </script>
@endsection
