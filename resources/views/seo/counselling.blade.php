@extends('layouts.seo')

@section('meta')
    <meta name="description"
        content="Talk to LGBTQ+-friendly, identity-affirming counsellors online or in person. Confidential, judgment-free support — no explaining your identity first.">

    <title>AffirmSpace – LGBTQ+ Counselling & Mental Health Support</title>

    <meta name="author" content="AffirmSpace">

    <meta name="keywords"
        content="LGBTQ+ counselling, LGBTQ+ mental health support, LGBTQ+ counsellors, LGBTQ+ therapists, LGBTQ+ counselling platform, LGBTQ+ mental wellness, LGBTQ+ therapy">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <!-- WebPage Schema -->
    <script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "AffirmSpace – LGBTQ+ Counselling & Mental Health Support",
    "url": "https://affirmspace.com/lgbtq-mental-health-counselling",
    "description": "Connect with LGBTQ+-friendly, identity-affirming counsellors for confidential support online or in person."
}
</script>

    <!-- FAQ Schema -->
    <script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        {
            "@type": "Question",
            "name": "Is counselling on AffirmSpace confidential?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "Your conversations with a counsellor are private. AffirmSpace is designed to provide a supportive, confidential space for people seeking LGBTQ+-friendly counselling."
            }
        },
        {
            "@type": "Question",
            "name": "How are counsellors verified before being listed?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "AffirmSpace reviews counsellor qualifications and supporting documentation before approving counsellors for listing on the platform."
            }
        },
        {
            "@type": "Question",
            "name": "Can I book online or in-person counselling sessions?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "Yes. Depending on the counsellor's availability, sessions may be available online or in person."
            }
        },
        {
            "@type": "Question",
            "name": "What can LGBTQ+ counselling help me with?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "Counsellors may support people with identity and coming-out concerns, anxiety and depression, relationships and family issues, gender-related concerns, and general mental wellbeing. Areas of support vary by counsellor."
            }
        },
        {
            "@type": "Question",
            "name": "Is there a cost to book a counselling session?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "Session pricing depends on the counsellor and the available service. Please check the counsellor's profile or booking information for current pricing."
            }
        },
        {
            "@type": "Question",
            "name": "Does AffirmSpace provide therapy directly?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "No. AffirmSpace helps people find and connect with LGBTQ+-friendly counsellors. Counselling and professional care are provided directly by the counsellor."
            }
        },
        {
            "@type": "Question",
            "name": "Is AffirmSpace only for people in India?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "No. AffirmSpace was built by a team based in India but is designed for LGBTQ+ people worldwide."
            }
        }
    ]
}
</script>
@endsection

@section('css')
    <style>
        /* =========================================================
           GLOBAL
        ========================================================= */

        .counselling-page {
            width: 100%;
            overflow: hidden;
        }

        .counselling-page a {
            text-decoration: none;
        }


        /* =========================================================
           HERO
        ========================================================= */

        .therapy-hero {
            background: #fffaf8;
            padding: 55px 0 70px;
            overflow: hidden;
        }

        .therapy-container {
            max-width: 1200px;
            margin: auto;
            padding: 0 20px;
        }

        .therapy-grid {
            display: grid;
            grid-template-columns: 46% 54%;
            gap: 45px;
            align-items: center;
        }

        .therapy-tag {
            display: inline-block;
            color: #ff5f87;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1.8px;
            margin-bottom: 18px;
        }

        .therapy-content h1 {
            font-size: 62px;
            line-height: 1.04;
            color: #222;
            font-weight: 700;
            margin-bottom: 22px;
            letter-spacing: -2.5px;
        }

        .therapy-content h1 span {
            color: #ff4f7d;
            font-style: italic;
        }

        .therapy-content p {
            color: #666;
            font-size: 18px;
            line-height: 1.8;
            max-width: 520px;
            margin-bottom: 30px;
        }

        .therapy-buttons {
            display: flex;
            gap: 14px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .therapy-btn {
            padding: 15px 24px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 15px;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .primary-btn {
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: white !important;
        }

        .secondary-btn {
            border: 1px solid #ffb8c8;
            color: #e83e8c !important;
            background: white;
        }

        .therapy-btn:hover {
            transform: translateY(-2px);
        }

        .therapist-link {
            display: inline-block;
            color: #e83e8c;
            font-size: 14px;
            font-weight: 600;
            margin-top: 8px;
        }

        .therapist-link:hover {
            text-decoration: underline;
        }

        .therapy-image {
            position: relative;
        }

        .therapy-image img {
            width: 100%;
            border-radius: 32px;
            display: block;
        }


        /* =========================================================
           HERO SUPPORTING LINE
        ========================================================= */

        .hero-supporting-line {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-top: 18px;
            color: #777;
            font-size: 13px;
            line-height: 1.5;
        }

        .hero-supporting-line span {
            color: #e83e8c;
            font-size: 16px;
        }


        /* =========================================================
           TRUST CARDS
        ========================================================= */

        .therapy-features-wrapper {
            padding: 35px 0 60px;
            background: #fff;
        }

        .therapy-features-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 22px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .therapy-feature {
            background: #ffffff;
            border-radius: 18px;
            padding: 30px 22px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .therapy-feature:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 38px rgba(0, 0, 0, 0.10);
        }

        .feature-icon {
            font-size: 2.4rem;
            margin-bottom: 16px;
            display: block;
        }

        .therapy-feature h4 {
            font-size: 1.05rem;
            margin-bottom: 9px;
            color: #1f2937;
            font-weight: 700;
        }

        .therapy-feature p {
            color: #6b7280;
            line-height: 1.55;
            font-size: 13px;
            margin: 0;
        }


        /* =========================================================
           SUPPORT / WHAT WE CAN HELP WITH
        ========================================================= */

        .support-section {
            padding: 30px 0 80px;
            background: white;
        }

        .support-container {
            max-width: 1250px;
            margin: auto;
            padding: 0 20px;
        }

        .support-grid {
            background: linear-gradient(90deg, #fdf3ef, #fff4f5);
            border-radius: 30px;
            display: grid;
            grid-template-columns: 50% 50%;
            gap: 45px;
            align-items: center;
            overflow: hidden;
        }

        .support-left {
            position: relative;
            min-height: 520px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .support-left video {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 30px;
            z-index: 2;
            position: relative;
            display: block;
        }

        .support-left::before {
            content: "";
            position: absolute;
            width: 520px;
            height: 520px;
            border-radius: 50%;
            background: radial-gradient(circle,
                    rgba(255, 220, 214, 0.7) 0%,
                    rgba(255, 220, 214, 0.2) 40%,
                    transparent 70%);
            z-index: 1;
        }

        .support-right {
            padding: 45px 45px 45px 0;
        }

        .support-tag {
            color: #ff5f87;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1.6px;
            display: block;
            margin-bottom: 22px;
        }

        .support-right h2 {
            font-size: 50px;
            line-height: 1.08;
            color: #222;
            font-weight: 700;
            margin-bottom: 22px;
            letter-spacing: -2px;
            max-width: 540px;
        }

        .support-right h2 span {
            color: #ff5f8f;
            font-style: italic;
        }

        .support-right>p {
            color: #666;
            font-size: 17px;
            line-height: 1.8;
            max-width: 520px;
            margin-bottom: 25px;
        }

        .support-identity-line {
            color: #333;
            font-size: 15px;
            line-height: 1.7;
            margin-bottom: 25px;
        }

        .support-identity-line strong {
            color: #e83e8c;
        }

        .support-link {
            color: #e83e8c;
            font-weight: 700;
            font-size: 16px;
        }

        .support-link:hover {
            text-decoration: underline;
        }


        /* =========================================================
           SUPPORT AREAS
        ========================================================= */

        .support-areas {
            margin-top: 25px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .support-area {
            background: rgba(255, 255, 255, 0.75);
            border: 1px solid rgba(232, 62, 140, 0.10);
            border-radius: 12px;
            padding: 12px 14px;
            color: #343434;
            font-size: 13px;
            line-height: 1.4;
        }

        .support-area span {
            color: #e83e8c;
            margin-right: 6px;
        }


        /* =========================================================
           INTRODUCTION
        ========================================================= */

        .about-counselling {
            padding: 85px 20px;
            background: #fffaf8;
        }

        .about-counselling-inner {
            max-width: 950px;
            margin: 0 auto;
            text-align: center;
        }

        .section-eyebrow {
            color: #e83e8c;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 2px;
            margin-bottom: 14px;
        }

        .about-counselling h2 {
            font-size: clamp(36px, 5vw, 56px);
            line-height: 1.1;
            color: #151b3d;
            letter-spacing: -1.8px;
            margin-bottom: 25px;
        }

        .about-counselling h2 span {
            color: #e83e8c;
            font-style: italic;
        }

        .about-counselling p {
            color: #555;
            font-size: 18px;
            line-height: 1.8;
            margin-bottom: 18px;
        }

        .about-counselling .disclaimer {
            background: white;
            border: 1px solid #f1dce3;
            border-radius: 16px;
            padding: 20px 24px;
            margin-top: 30px;
            color: #555;
            font-size: 14px;
            line-height: 1.7;
        }


        /* =========================================================
           COUNSELLORS
        ========================================================= */

        .counsellors-section {
            padding: 85px 20px;
            background: white;
        }

        .counsellors-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .counsellors-header {
            text-align: center;
            max-width: 780px;
            margin: 0 auto 45px;
        }

        .counsellors-header h2 {
            font-size: clamp(36px, 5vw, 54px);
            line-height: 1.1;
            color: #151b3d;
            letter-spacing: -1.8px;
            margin-bottom: 18px;
        }

        .counsellors-header h2 span {
            color: #e83e8c;
            font-style: italic;
        }

        .counsellors-header p {
            color: #666;
            font-size: 17px;
            line-height: 1.7;
        }

        .counsellors-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 22px;
        }

        .counsellor-card {
            border: 1px solid #f0e4e8;
            border-radius: 20px;
            padding: 26px 22px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: 0.3s ease;
        }

        .counsellor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 18px 38px rgba(0, 0, 0, 0.09);
        }

        .counsellor-photo {
            width: 92px;
            height: 92px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            margin: 0 auto 18px;
            background: #fff0f4;
        }

        .counsellor-placeholder {
            width: 92px;
            height: 92px;
            border-radius: 50%;
            background: #fff0f4;
            color: #e83e8c;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            font-size: 34px;
        }

        .counsellor-card h3 {
            text-align: center;
            color: #222;
            font-size: 19px;
            margin-bottom: 7px;
        }

        .counsellor-credentials {
            text-align: center;
            color: #e83e8c;
            font-size: 13px;
            font-weight: 700;
            line-height: 1.5;
            margin-bottom: 12px;
        }

        .counsellor-card p {
            color: #666;
            font-size: 13px;
            line-height: 1.65;
            text-align: center;
            margin: 0;
        }

        .counsellors-placeholder {
            max-width: 800px;
            margin: 0 auto;
            border: 1px dashed #e8a9bc;
            background: #fff8fa;
            border-radius: 18px;
            padding: 30px;
            text-align: center;
        }

        .counsellors-placeholder h3 {
            color: #222;
            margin-bottom: 10px;
        }

        .counsellors-placeholder p {
            color: #666;
            margin: 0;
            line-height: 1.7;
            font-size: 14px;
        }


        /* =========================================================
           SOMEWHERE TO PUT IT DOWN
        ========================================================= */

        .af-counselling-section {
            position: relative;
            width: 100%;
            overflow: hidden;
            padding: 80px 30px 65px;

            background:
                linear-gradient(135deg,
                    #fff9f7 0%,
                    #fff3f4 50%,
                    #fff8f7 100%);

            color: #111a45;
        }

        .af-counselling-decoration {
            position: absolute;
            pointer-events: none;
            border: 2px solid rgba(244, 45, 111, 0.10);
            border-radius: 50%;
        }

        .af-decoration-top {
            width: 360px;
            height: 360px;
            right: -170px;
            top: -170px;
        }

        .af-decoration-bottom {
            width: 300px;
            height: 300px;
            left: -170px;
            bottom: -180px;
        }

        .af-counselling-header {
            position: relative;
            z-index: 2;
            max-width: 850px;
            margin: 0 auto 35px;
            text-align: center;
        }

        .af-counselling-eyebrow {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 9px;
            margin-bottom: 15px;
            color: #ed2b68;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 2.5px;
        }

        .af-counselling-eyebrow span {
            color: #f3a7ba;
            font-size: 15px;
        }

        .af-counselling-header h2 {
            margin: 0;
            color: #121b46;
            font-size: clamp(42px, 5vw, 64px);
            line-height: 1.08;
            font-weight: 700;
            letter-spacing: -2px;
        }

        .af-counselling-header h2 em {
            color: #ed2b68;
            font-style: italic;
        }

        .af-counselling-header p {
            max-width: 760px;
            margin: 18px auto 0;
            color: #3d3e47;
            font-size: 21px;
            line-height: 1.5;
        }

        .af-counselling-visual {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 1500px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .af-counselling-visual img {
            display: block;
            width: 100%;
            max-width: 1500px;
            height: auto;
            object-fit: contain;
            border: 0;
        }

        .af-support-message {
            position: relative;
            z-index: 3;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            max-width: 800px;
            margin: 25px auto 0;
        }

        .af-support-icon {
            width: 64px;
            height: 64px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #ffe4eb;
            color: #ed2b68;
        }

        .af-support-icon svg {
            width: 39px;
            height: 39px;
        }

        .af-support-message p {
            margin: 0;
            color: #111a45;
            font-size: 19px;
            line-height: 1.45;
        }

        .af-support-message strong {
            color: #ed2b68;
        }


        /* =========================================================
           BOOKING FLOW
        ========================================================= */

        .booking-flow-section {
            padding: 90px 20px;
            background: #fff;
        }

        .booking-flow-container {
            max-width: 1150px;
            margin: 0 auto;
        }

        .booking-flow-header {
            text-align: center;
            max-width: 760px;
            margin: 0 auto 45px;
        }

        .booking-flow-header h2 {
            color: #151b3d;
            font-size: clamp(36px, 5vw, 54px);
            line-height: 1.1;
            letter-spacing: -1.8px;
            margin-bottom: 18px;
        }

        .booking-flow-header h2 span {
            color: #e83e8c;
            font-style: italic;
        }

        .booking-flow-header p {
            color: #666;
            font-size: 17px;
            line-height: 1.7;
        }

        .booking-steps {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .booking-step {
            position: relative;
            padding: 30px 23px;
            border-radius: 18px;
            background: #fffaf8;
            border: 1px solid #f5e4e9;
        }

        .step-number {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .booking-step h3 {
            color: #222;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .booking-step p {
            color: #666;
            font-size: 14px;
            line-height: 1.7;
            margin: 0;
        }


        /* =========================================================
           FAQ
        ========================================================= */

        .faq-section {
            padding: 85px 20px;
            background: #fffaf8;
        }

        .faq-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .faq-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .faq-header h2 {
            color: #151b3d;
            font-size: clamp(36px, 5vw, 54px);
            line-height: 1.1;
            letter-spacing: -1.8px;
        }

        .faq-header h2 span {
            color: #e83e8c;
            font-style: italic;
        }

        .faq-item {
            background: white;
            border: 1px solid #f0e3e8;
            border-radius: 15px;
            padding: 22px 25px;
            margin-bottom: 14px;
        }

        .faq-item h3 {
            color: #222;
            font-size: 17px;
            margin: 0 0 10px;
        }

        .faq-item p {
            color: #666;
            font-size: 14px;
            line-height: 1.7;
            margin: 0;
        }


        /* =========================================================
           CRISIS / URGENT SUPPORT
        ========================================================= */

        .urgent-support {
            max-width: 900px;
            margin: 45px auto 0;
            background: #fff;
            border-left: 4px solid #e83e8c;
            border-radius: 12px;
            padding: 20px 24px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.04);
        }

        .urgent-support h3 {
            color: #222;
            font-size: 17px;
            margin-bottom: 8px;
        }

        .urgent-support p {
            color: #666;
            font-size: 14px;
            line-height: 1.7;
            margin: 0;
        }


        /* =========================================================
           EXPLORE MORE
        ========================================================= */

        .explore-section {
            padding: 75px 20px;
            background: white;
        }

        .explore-container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .explore-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .explore-header h2 {
            color: #151b3d;
            font-size: 38px;
            letter-spacing: -1px;
        }

        .explore-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }

        .explore-card {
            border: 1px solid #f0e3e8;
            border-radius: 16px;
            padding: 25px 20px;
            text-align: center;
            transition: 0.3s;
            background: #fff;
        }

        .explore-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.07);
        }

        .explore-card h3 {
            color: #222;
            font-size: 17px;
            margin-bottom: 8px;
        }

        .explore-card a {
            color: #e83e8c;
            font-size: 14px;
            font-weight: 700;
        }


        /* =========================================================
           FINAL CTA
        ========================================================= */

        .therapy-hero-banner {
            background: linear-gradient(90deg, #ff512f, #dd2476);
            border-radius: 28px;
            padding: 35px 45px;
            margin: 40px 20px 60px;
            color: white;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .therapy-hero-inner {
            display: flex;
            align-items: center;
            gap: 55px;
            max-width: 1150px;
            margin: 0 auto;
        }

        .hero-image-side {
            flex: 0 0 35%;
            display: flex;
            justify-content: center;
        }

        .hero-image {
            width: 100%;
            max-width: 340px;
            height: auto;
            filter: drop-shadow(20px 25px 40px rgba(0, 0, 0, 0.25));
        }

        .hero-text-side {
            flex: 1;
        }

        .pre-title {
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }

        .main-title {
            font-size: 2.7rem;
            line-height: 1.15;
            font-weight: 700;
            margin-bottom: 22px;
        }

        .features-list {
            display: flex;
            flex-wrap: wrap;
            gap: 13px 25px;
            margin-bottom: 22px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1rem;
        }

        .feature-item .check {
            font-weight: 700;
        }

        .btn-flexible-wrapper {
            flex: 0 0 auto;
            text-align: center;
        }

        .book-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: #fff;
            color: #e83e8c !important;
            padding: 16px 28px;
            border-radius: 50px;
            font-size: 1.05rem;
            font-weight: 700;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .book-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 35px rgba(0, 0, 0, 0.25);
        }

        .flexible-text {
            margin-top: 10px;
            font-size: 13px;
            opacity: 0.92;
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 1100px) {

            .therapy-grid {
                grid-template-columns: 1fr;
            }

            .therapy-content {
                text-align: center;
            }

            .therapy-content p {
                margin-left: auto;
                margin-right: auto;
            }

            .therapy-buttons {
                justify-content: center;
            }

            .hero-supporting-line {
                justify-content: center;
            }

            .therapy-features-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .counsellors-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .booking-steps {
                grid-template-columns: repeat(2, 1fr);
            }

            .explore-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .support-grid {
                grid-template-columns: 1fr;
            }

            .support-right {
                padding: 40px;
                text-align: center;
            }

            .support-right h2,
            .support-right>p {
                margin-left: auto;
                margin-right: auto;
            }

            .support-areas {
                max-width: 650px;
                margin-left: auto;
                margin-right: auto;
                text-align: left;
            }

            .therapy-hero-inner {
                flex-wrap: wrap;
            }

            .hero-image-side {
                flex: 1;
            }

            .hero-text-side {
                flex: 1;
            }

            .btn-flexible-wrapper {
                width: 100%;
            }
        }


        @media (max-width: 768px) {

            .therapy-hero {
                padding: 45px 0 55px;
            }

            .therapy-content h1 {
                font-size: 42px;
            }

            .therapy-content p {
                font-size: 16px;
            }

            .therapy-buttons {
                flex-direction: column;
            }

            .therapy-btn {
                width: 100%;
            }

            .therapy-features-grid {
                grid-template-columns: 1fr 1fr;
                gap: 16px;
            }

            .therapy-feature {
                padding: 25px 15px;
            }

            .feature-icon {
                font-size: 2rem;
            }

            .therapy-feature h4 {
                font-size: 14px;
            }

            .therapy-feature p {
                font-size: 11px;
            }

            .support-grid {
                border-radius: 24px;
            }

            .support-left {
                min-height: 420px;
            }

            .support-left video {
                width: 100%;
                height: 420px;
                border-radius: 24px;
            }

            .support-right {
                padding: 30px 22px 35px;
            }

            .support-right h2 {
                font-size: 38px;
            }

            .support-right>p {
                font-size: 16px;
            }

            .support-areas {
                grid-template-columns: 1fr;
            }

            .about-counselling {
                padding: 65px 20px;
            }

            .about-counselling p {
                font-size: 16px;
            }

            .counsellors-section {
                padding: 65px 20px;
            }

            .counsellors-grid {
                grid-template-columns: 1fr 1fr;
            }

            .af-counselling-section {
                padding: 55px 15px 45px;
            }

            .af-counselling-header {
                margin-bottom: 25px;
            }

            .af-counselling-eyebrow {
                font-size: 12px;
                letter-spacing: 1.7px;
            }

            .af-counselling-header h2 {
                font-size: 38px;
            }

            .af-counselling-header p {
                font-size: 16px;
            }

            .af-support-message {
                align-items: flex-start;
                gap: 12px;
                margin-top: 22px;
            }

            .af-support-icon {
                width: 48px;
                height: 48px;
            }

            .af-support-icon svg {
                width: 30px;
                height: 30px;
            }

            .af-support-message p {
                font-size: 15px;
            }

            .booking-flow-section {
                padding: 65px 20px;
            }

            .booking-steps {
                grid-template-columns: 1fr;
            }

            .faq-section {
                padding: 65px 20px;
            }

            .explore-grid {
                grid-template-columns: 1fr 1fr;
            }

            .therapy-hero-banner {
                padding: 40px 25px;
                border-radius: 22px;
                margin-left: 15px;
                margin-right: 15px;
            }

            .therapy-hero-inner {
                flex-direction: column;
                text-align: center;
                gap: 25px;
            }

            .hero-image {
                max-width: 270px;
            }

            .main-title {
                font-size: 2.2rem;
            }

            .features-list {
                justify-content: center;
            }

            .btn-flexible-wrapper {
                width: 100%;
            }

            .book-btn {
                width: 100%;
            }
        }


        @media (max-width: 520px) {

            .therapy-content h1 {
                font-size: 34px;
                letter-spacing: -1.5px;
            }

            .therapy-features-grid {
                grid-template-columns: 1fr;
            }

            .hero-supporting-line {
                align-items: flex-start;
                text-align: left;
            }

            .counsellors-grid {
                grid-template-columns: 1fr;
            }

            .counsellor-card {
                max-width: 380px;
                margin: 0 auto;
                width: 100%;
            }

            .af-counselling-header h2 {
                font-size: 33px;
            }

            .af-counselling-header p {
                font-size: 15px;
            }

            .af-support-message {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .explore-grid {
                grid-template-columns: 1fr;
            }

            .therapy-hero-banner {
                padding: 35px 20px;
            }

            .main-title {
                font-size: 2rem;
            }

            .features-list {
                flex-direction: column;
                align-items: center;
            }

            .urgent-support {
                padding: 18px;
            }
        }
    </style>
@endsection

@section('content')

    <div class="counselling-page">


        <!-- =====================================================
             HERO
        ====================================================== -->

        <section class="therapy-hero">

            <div class="therapy-container">

                <div class="therapy-grid">

                    <div class="therapy-content">

                        <span class="therapy-tag">
                            ♡ COUNSELLING THAT CARES
                        </span>

                        <h1>
                            LGBTQ+ Counselling —
                            Support From People Who
                            <span>Understand</span>
                        </h1>

                        <p>
                            Talk to counsellors who don't need your identity
                            explained to them first. Confidential sessions,
                            online or in person, at your pace.
                        </p>

                        <div class="therapy-buttons">

                            <a href="{{ url('login') }}" class="therapy-btn primary-btn">
                                📅 Book a Session
                            </a>

                            <a href="{{ url('register') }}?role=1" class="therapy-btn secondary-btn">
                                Are you a counsellor?
                            </a>

                        </div>

                        <a href="{{ url('register') }}?role=1" class="therapist-link">
                            Join AffirmSpace as a counsellor →
                        </a>

                        <div class="hero-supporting-line">
                            <span>✓</span>
                            <div>
                                Early, real, and growing — every counsellor is
                                personally reviewed before being listed.
                            </div>
                        </div>

                    </div>


                    <div class="therapy-image">

                        <img src="{{ asset('images/counselling/Header_Image_Counselling.png') }}"
                            alt="LGBTQ+ counselling session">

                    </div>

                </div>

            </div>

        </section>



        <!-- =====================================================
             TRUST ROW
        ====================================================== -->

        <div class="therapy-features-wrapper">

            <div class="therapy-features-grid">

                <div class="therapy-feature">

                    <div class="feature-icon">🔒</div>

                    <h4>
                        100% Confidential
                    </h4>

                    <p>
                        Your sessions are private.
                    </p>

                </div>


                <div class="therapy-feature">

                    <div class="feature-icon">🛡️</div>

                    <h4>
                        Personally Reviewed Counsellors
                    </h4>

                    <p>
                        Professional qualifications and supporting
                        documentation are reviewed before listing.
                    </p>

                </div>


                <div class="therapy-feature">

                    <div class="feature-icon">🏳️‍🌈</div>

                    <h4>
                        Judgment-Free Space
                    </h4>

                    <p>
                        Identity-affirming care, not identity-explaining care.
                    </p>

                </div>


                <div class="therapy-feature">

                    <div class="feature-icon">⏰</div>

                    <h4>
                        Flexible Sessions
                    </h4>

                    <p>
                        Online or in person, depending on availability.
                    </p>

                </div>

            </div>

        </div>



        <!-- =====================================================
             WHAT WE CAN HELP YOU FIND SUPPORT FOR
        ====================================================== -->

        <section class="support-section">

            <div class="support-container">

                <div class="support-grid">

                    <div class="support-left">

                        <video autoplay muted loop playsinline>

                            <source src="{{ asset('images/counselling/counseling_video.mp4') }}" type="video/mp4">

                        </video>

                    </div>


                    <div class="support-right">

                        <span class="support-tag">
                            SUPPORT FOR WHEREVER YOU ARE
                        </span>

                        <h2>
                            Whatever you're
                            going through, you
                            don't have to face it
                            <span>alone.</span>
                        </h2>

                        <p>
                            AffirmSpace helps you find LGBTQ+-friendly
                            counsellors who can support you through
                            life's challenges, identity questions,
                            relationships, and personal wellbeing.
                        </p>

                        <p class="support-identity-line">
                            AffirmSpace connects gay, lesbian, bisexual,
                            transgender, non-binary, pansexual, and asexual
                            people — and anyone still figuring things out —
                            with counsellors who understand that identity
                            can be an important part of the conversation.
                        </p>


                        <div class="support-areas">

                            <div class="support-area">
                                <span>✓</span>
                                Identity and coming-out support
                            </div>

                            <div class="support-area">
                                <span>✓</span>
                                Anxiety and depression
                            </div>

                            <div class="support-area">
                                <span>✓</span>
                                Relationship and family counselling
                            </div>

                            <div class="support-area">
                                <span>✓</span>
                                Gender-related concerns
                            </div>

                            <div class="support-area">
                                <span>✓</span>
                                General mental wellness
                            </div>

                        </div>


                        <a href="#support-areas" class="support-link" style="display:none;">
                            Explore All Areas →
                        </a>

                    </div>

                </div>

            </div>

        </section>



        <!-- =====================================================
             WHAT IS AFFIRMSPACE COUNSELLING
        ====================================================== -->

        <section class="about-counselling">

            <div class="about-counselling-inner">

                <div class="section-eyebrow">
                    WHAT IS AFFIRMSPACE COUNSELLING?
                </div>

                <h2>
                    Care where you don't have to
                    <span>explain yourself first.</span>
                </h2>

                <p>
                    AffirmSpace connects LGBTQ+ people with
                    LGBTQ+-friendly counsellors who already understand
                    the experiences and questions that can come with
                    identity, relationships, family, self-confidence,
                    and mental wellbeing.
                </p>

                <p>
                    Whether you're looking for someone to talk to about
                    coming out, relationships, anxiety, identity,
                    gender-related concerns, or simply want a supportive
                    space to work through what's on your mind, you can
                    explore counsellors and choose someone who feels right
                    for you.
                </p>

                <div class="disclaimer">
                    <strong>Important:</strong>
                    AffirmSpace does not provide medical advice or treatment
                    directly. We help you find and connect with
                    LGBTQ+-friendly counsellors. The counselling and
                    professional care itself happens between you and the
                    counsellor.
                </div>

            </div>

        </section>



        <!-- =====================================================
             MEET OUR COUNSELLORS
             
             IMPORTANT:
             Replace the placeholder cards below with your REAL
             counsellor names, photos, credentials and specialties.
             Do NOT publish invented credentials.
        ====================================================== -->

        <section class="counsellors-section">

            <div class="counsellors-container">

                <div class="counsellors-header">

                    <div class="section-eyebrow">
                        MEET OUR COUNSELLORS
                    </div>

                    <h2>
                        Real people. Real
                        <span>understanding.</span>
                    </h2>

                    <p>
                        Get to know the counsellors available through
                        AffirmSpace, including their professional background,
                        areas of focus, and approach to LGBTQ+-affirming care.
                    </p>

                </div>


                {{-- 
            =====================================================
            REPLACE THIS PLACEHOLDER WITH YOUR REAL COUNSELLORS.

            Example:

            <div class="counsellors-grid">

                <div class="counsellor-card">

                    <img
                        src="{{ asset('public/images/counsellors/name.jpg') }}"
                        alt="Counsellor Name"
                        class="counsellor-photo">

                    <h3>
                        Counsellor Name
                    </h3>

                    <div class="counsellor-credentials">
                        Real Credentials Here
                    </div>

                    <p>
                        Real specialty and counselling approach here.
                    </p>

                </div>

            </div>

            IMPORTANT:
            Only publish credentials/registration information that
            you have actually verified.
            =====================================================
        --}}


                @if (isset($counsellors) && count($counsellors) > 0)
                    <div class="counsellors-grid">

                        @foreach ($counsellors as $counsellor)
                            <div class="counsellor-card">

                                @if (!empty($counsellor->image))
                                    <img src="{{ asset($counsellor->image) }}" alt="{{ $counsellor->name }}"
                                        class="counsellor-photo">
                                @else
                                    <div class="counsellor-placeholder">
                                        ♡
                                    </div>
                                @endif


                                <h3>
                                    {{ $counsellor->name }}
                                </h3>


                                @if (!empty($counsellor->credentials))
                                    <div class="counsellor-credentials">
                                        {{ $counsellor->credentials }}
                                    </div>
                                @endif


                                @if (!empty($counsellor->description))
                                    <p>
                                        {{ $counsellor->description }}
                                    </p>
                                @endif

                            </div>
                        @endforeach

                    </div>
                @else
                    <div class="counsellors-placeholder">

                        <h3>
                            Our counsellor profiles are coming together.
                        </h3>

                        <p>
                            AffirmSpace is growing its network of
                            LGBTQ+-friendly counsellors. Individual profiles
                            with professional credentials, specialties, and
                            approaches will appear here as they are published.
                        </p>

                    </div>
                @endif

            </div>

        </section>



        <!-- =====================================================
             SOMEWHERE TO PUT IT DOWN
        ====================================================== -->

        <section class="af-counselling-section">

            <div class="af-counselling-decoration af-decoration-top"></div>

            <div class="af-counselling-decoration af-decoration-bottom"></div>


            <div class="af-counselling-header">

                <div class="af-counselling-eyebrow">

                    <span>♥</span>

                    SOMETIMES, YOU JUST NEED

                </div>


                <h2>
                    Somewhere to <em>put it down.</em>
                </h2>


                <p>
                    You don't have to carry everything alone.
                    Talking about what you're going through can be
                    the first step toward feeling lighter.
                </p>

            </div>


            <div class="af-counselling-visual">

                <img src="{{ asset('images/counselling/new2.png') }}"
                    alt="LGBTQ+ counselling support at AffirmSpace">

            </div>


            <div class="af-support-message">

                <div class="af-support-icon">

                    <svg viewBox="0 0 48 48" aria-hidden="true">

                        <path d="M24 5
                            L39 11
                            V22
                            C39 32 32 39 24 43
                            C16 39 9 32 9 22
                            V11Z" fill="none" stroke="currentColor" stroke-width="2.5" />

                        <path d="M24 17
                            C20 12 14 15 14 20
                            C14 25 24 31 24 31
                            C24 31 34 25 34 20
                            C34 15 28 12 24 17Z" fill="none" stroke="currentColor" stroke-width="2" />

                    </svg>

                </div>


                <p>
                    At AffirmSpace, your conversations are private,
                    supportive, and
                    <strong>always judgment-free.</strong>
                </p>

            </div>

        </section>



        <!-- =====================================================
             HOW BOOKING A SESSION WORKS
        ====================================================== -->

        <section class="booking-flow-section">

            <div class="booking-flow-container">

                <div class="booking-flow-header">

                    <div class="section-eyebrow">
                        HOW BOOKING WORKS
                    </div>

                    <h2>
                        Counselling that starts
                        <span>with your choice.</span>
                    </h2>

                    <p>
                        Find someone who feels right for you, choose an
                        available time, and take things at your own pace.
                    </p>

                </div>


                <div class="booking-steps">

                    <div class="booking-step">

                        <div class="step-number">
                            1
                        </div>

                        <h3>
                            Browse Counsellors
                        </h3>

                        <p>
                            See counsellor profiles, professional credentials,
                            specialties, and approach before choosing who
                            you want to talk to.
                        </p>

                    </div>


                    <div class="booking-step">

                        <div class="step-number">
                            2
                        </div>

                        <h3>
                            Book a Session
                        </h3>

                        <p>
                            Pick a time that works for you based on the
                            counsellor's available schedule.
                        </p>

                    </div>


                    <div class="booking-step">

                        <div class="step-number">
                            3
                        </div>

                        <h3>
                            Meet, Your Way
                        </h3>

                        <p>
                            Join your session by video, call, or in person,
                            depending on the counsellor's available options.
                        </p>

                    </div>


                    <div class="booking-step">

                        <div class="step-number">
                            4
                        </div>

                        <h3>
                            Continue at Your Pace
                        </h3>

                        <p>
                            Book follow-up sessions with the same counsellor
                            or explore someone different. There is no set
                            path you have to follow.
                        </p>

                    </div>

                </div>

            </div>

        </section>



        <!-- =====================================================
             FAQ
        ====================================================== -->

        <section class="faq-section">

            <div class="faq-container">

                <div class="faq-header">

                    <div class="section-eyebrow">
                        FREQUENTLY ASKED QUESTIONS
                    </div>

                    <h2>
                        Questions?
                        <span>We've got you.</span>
                    </h2>

                </div>


                <div class="faq-item">

                    <h3>
                        Is counselling on AffirmSpace confidential?
                    </h3>

                    <p>
                        Your conversations with a counsellor are private.
                        AffirmSpace is designed to provide a supportive,
                        confidential space for people seeking
                        LGBTQ+-friendly counselling.
                    </p>

                </div>


                <div class="faq-item">

                    <h3>
                        How are counsellors verified before being listed?
                    </h3>

                    <p>
                        AffirmSpace reviews professional qualifications and
                        supporting documentation before approving counsellors
                        for listing on the platform.
                    </p>

                </div>


                <div class="faq-item">

                    <h3>
                        Can I book online or in-person sessions?
                    </h3>

                    <p>
                        Yes. Availability depends on the counsellor.
                        Depending on their available services, you may be
                        able to choose between online and in-person sessions.
                    </p>

                </div>


                <div class="faq-item">

                    <h3>
                        What can LGBTQ+ counselling help me with?
                    </h3>

                    <p>
                        Counsellors may support people with identity and
                        coming-out concerns, anxiety and depression,
                        relationships and family issues, gender-related
                        concerns, and general mental wellbeing. Areas of
                        support vary by counsellor.
                    </p>

                </div>


                <div class="faq-item">

                    <h3>
                        Is there a cost to book a counselling session?
                    </h3>

                    <p>
                        Session pricing depends on the counsellor and the
                        available service. Please check the counsellor's
                        profile or booking information for current pricing.
                    </p>

                </div>


                <div class="faq-item">

                    <h3>
                        Does AffirmSpace provide therapy directly?
                    </h3>

                    <p>
                        No. AffirmSpace does not provide medical advice or
                        treatment directly. We help you find and connect
                        with LGBTQ+-friendly counsellors. The care itself
                        happens directly between you and the counsellor.
                    </p>

                </div>


                <div class="faq-item">

                    <h3>
                        Is AffirmSpace only for India?
                    </h3>

                    <p>
                        No. AffirmSpace was built by a team based in India
                        but is designed for LGBTQ+ people worldwide.
                    </p>

                </div>


                <!-- URGENT SUPPORT -->

                <div class="urgent-support">

                    <h3>
                        I need support urgently — is this the right place?
                    </h3>

                    <p>
                        This page is designed for finding ongoing counselling,
                        not emergency or crisis support. If you or someone
                        else is in immediate danger, contact your local
                        emergency service or an appropriate crisis helpline
                        in your country.
                    </p>

                </div>

            </div>

        </section>



        <!-- =====================================================
             LOOKING FOR SOMETHING ELSE?
        ====================================================== -->

        <section class="explore-section">

            <div class="explore-container">

                <div class="explore-header">

                    <div class="section-eyebrow">
                        LOOKING FOR SOMETHING MORE SPECIFIC?
                    </div>

                    <h2>
                        Find your space on AffirmSpace
                    </h2>

                </div>


                <div class="explore-grid">

                    <div class="explore-card">

                        <h3>
                            Want to talk to people?
                        </h3>

                        <a href="{{ url('lgbtq-chat') }}">
                            Explore LGBTQ+ Chat →
                        </a>

                    </div>


                    <div class="explore-card">

                        <h3>
                            Looking for dating or friendship?
                        </h3>

                        <a href="{{ url('lgbtq-dating-app') }}">
                            Explore LGBTQ+ Dating →
                        </a>

                    </div>


                    <div class="explore-card">

                        <h3>
                            Want to meet people in person?
                        </h3>

                        <a href="{{ url('lgbtq-events') }}">
                            See LGBTQ+ Events →
                        </a>

                    </div>


                    <div class="explore-card">

                        <h3>
                            Looking for groups and discussions?
                        </h3>

                        <a href="{{ url('lgbtq-community') }}">
                            Explore the Community →
                        </a>

                    </div>

                </div>

            </div>

        </section>



        <!-- =====================================================
             FINAL CTA
        ====================================================== -->

        <div class="therapy-hero-banner">

            <div class="therapy-hero-inner">


                <div class="hero-image-side">

                    <img src="{{ asset('images/counselling/chair.png') }}" alt="Counselling support"
                        class="hero-image">

                </div>


                <div class="hero-text-side">

                    <p class="pre-title">
                        READY TO TAKE THE FIRST STEP?
                    </p>

                    <h2 class="main-title">
                        You deserve support.
                        Let's work together.
                    </h2>


                    <div class="features-list">

                        <div class="feature-item">
                            <span class="check">✔</span>
                            Judgment-free support
                        </div>

                        <div class="feature-item">
                            <span class="check">✔</span>
                            Personalized care
                        </div>

                        <div class="feature-item">
                            <span class="check">✔</span>
                            Support at your pace
                        </div>

                    </div>

                </div>


                <div class="btn-flexible-wrapper">

                    <a href="{{ url('login') }}" class="book-btn">
                        📅 Book Your Session
                    </a>

                    <p class="flexible-text">
                        Flexible slots • Online &amp; Offline
                    </p>

                </div>

            </div>

        </div>
        ```

    </div>

@endsection
