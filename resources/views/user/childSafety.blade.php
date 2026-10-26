@extends('layouts.seo')

@section('meta')
    <title>Child Safety Standards – AffirmSpace</title>
    <meta name="description"
        content="Read AffirmSpace's Child Safety Standards, including our zero-tolerance policy for child sexual abuse and exploitation, reporting procedures, and safety measures.">
    <meta name="author" content="AffirmSpace">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('css')
    <style>
        .as-child-page {
            font-family: 'Inter', sans-serif;
            color: #222;
            background: #fff;
            overflow: hidden
        }

        .as-child-page *,
        .as-child-page *::before,
        .as-child-page *::after {
            box-sizing: border-box
        }

        .as-child-hero {
            position: relative;
            min-height: 430px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #111
        }

        .as-child-hero-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center
        }

        .as-child-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(255, 81, 47, .92), rgba(221, 36, 118, .88));
            opacity: .94
        }

        .as-child-hero-content {
            position: relative;
            z-index: 2;
            width: min(100% - 40px, 950px);
            margin: 0 auto;
            padding: 80px 20px;
            text-align: center;
            color: #fff
        }

        .as-child-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 20px;
            padding: 8px 16px;
            border: 1px solid rgba(255, 255, 255, .35);
            border-radius: 999px;
            background: rgba(255, 255, 255, .12);
            backdrop-filter: blur(8px);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase
        }

        .as-child-hero h1 {
            margin: 0 0 20px;
            font-size: clamp(38px, 5vw, 62px);
            line-height: 1.1;
            font-weight: 800;
            letter-spacing: -1.5px;
            color: #fff
        }

        .as-child-hero p {
            max-width: 760px;
            margin: 0 auto;
            color: rgba(255, 255, 255, .95);
            font-size: 17px;
            line-height: 1.75
        }

        .as-child-container {
            width: min(100%, 1080px);
            margin: 0 auto
        }

        .as-child-intro-section {
            padding: 85px 20px 35px
        }

        .as-child-intro {
            position: relative;
            padding: 34px 38px;
            border: 1px solid #f0e7eb;
            border-radius: 22px;
            background: linear-gradient(135deg, #fff, #fff8fa);
            box-shadow: 0 12px 40px rgba(221, 36, 118, .07)
        }

        .as-child-intro:before {
            content: "";
            position: absolute;
            top: 0;
            left: 32px;
            right: 32px;
            height: 3px;
            border-radius: 0 0 10px 10px;
            background: linear-gradient(90deg, #ff512f, #dd2476)
        }

        .as-child-intro-top {
            display: flex;
            align-items: flex-start;
            gap: 18px;
            margin-bottom: 20px
        }

        .as-child-icon {
            width: 48px;
            height: 48px;
            flex: 0 0 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            border-radius: 14px;
            background: linear-gradient(135deg, rgba(255, 81, 47, .12), rgba(221, 36, 118, .12));
            color: #dd2476;
            font-size: 19px
        }

        .as-child-intro .as-child-icon {
            margin-bottom: 0
        }

        .as-child-intro h2 {
            margin: 0 0 5px;
            color: #222;
            font-size: 22px;
            line-height: 1.35;
            font-weight: 750
        }

        .as-child-effective {
            margin: 0;
            color: #777;
            font-size: 13px;
            line-height: 1.6
        }

        .as-child-intro p {
            margin: 0;
            color: #666;
            font-size: 15px;
            line-height: 1.8
        }

        .as-child-section {
            padding: 35px 20px 85px
        }

        .as-child-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 22px
        }

        .as-child-card {
            position: relative;
            padding: 30px;
            border: 1px solid #eee;
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 7px 28px rgba(0, 0, 0, .045);
            transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease
        }

        .as-child-card:hover {
            transform: translateY(-4px);
            border-color: rgba(221, 36, 118, .18);
            box-shadow: 0 15px 38px rgba(221, 36, 118, .09)
        }

        .as-child-wide {
            grid-column: 1/-1
        }

        .as-child-card h2 {
            margin: 0 0 12px;
            color: #222;
            font-size: 21px;
            line-height: 1.4;
            font-weight: 750
        }

        .as-child-card p {
            margin: 0;
            color: #666;
            font-size: 15px;
            line-height: 1.8
        }

        .as-child-card p+p {
            margin-top: 14px
        }

        .as-child-card ul {
            margin: 16px 0 0;
            padding: 0;
            list-style: none
        }

        .as-child-card li {
            position: relative;
            margin-bottom: 14px;
            padding-left: 27px;
            color: #555;
            font-size: 14.5px;
            line-height: 1.75;
            overflow-wrap: anywhere
        }

        .as-child-card li:last-child {
            margin-bottom: 0
        }

        .as-child-card li:before {
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
            font-weight: 800
        }

        .as-child-card li strong {
            color: #333;
            font-weight: 700
        }

        .as-child-highlight {
            background: linear-gradient(135deg, #fff8fa 0%, #fff 55%, #fff8f5 100%)
        }

        .as-child-warning {
            background: linear-gradient(135deg, #fff5f5, #fff)
        }

        .as-child-summary {
            padding: 85px 20px;
            background: #fafafa
        }

        .as-child-heading {
            max-width: 720px;
            margin: 0 auto 42px;
            text-align: center
        }

        .as-child-heading .eyebrow {
            display: inline-block;
            margin-bottom: 12px;
            color: #dd2476;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1.3px;
            text-transform: uppercase
        }

        .as-child-heading h2 {
            margin: 0 0 13px;
            color: #222;
            font-size: clamp(28px, 4vw, 38px);
            line-height: 1.2;
            font-weight: 800
        }

        .as-child-heading p {
            margin: 0;
            color: #6a6a6a;
            font-size: 15px;
            line-height: 1.75
        }

        .as-child-summary-grid {
            width: min(100%, 950px);
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 15px
        }

        .as-child-summary-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 19px 20px;
            border: 1px solid #eee;
            border-radius: 15px;
            background: #fff;
            box-shadow: 0 5px 18px rgba(0, 0, 0, .035)
        }

        .as-child-summary-item i {
            width: 35px;
            height: 35px;
            flex: 0 0 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #fff0f4;
            color: #dd2476;
            font-size: 13px
        }

        .as-child-summary-item span {
            color: #444;
            font-size: 14px;
            line-height: 1.6;
            font-weight: 600
        }

        .as-child-contact-section {
            padding: 85px 20px
        }

        .as-child-contact {
            position: relative;
            width: min(100%, 1000px);
            margin: 0 auto;
            padding: 45px;
            overflow: hidden;
            border-radius: 26px;
            background: linear-gradient(135deg, #fff5f7, #fff9f5);
            border: 1px solid #f3e4e9
        }

        .as-child-contact:after {
            content: "";
            position: absolute;
            width: 280px;
            height: 280px;
            right: -110px;
            top: -120px;
            border-radius: 50%;
            background: rgba(221, 36, 118, .07)
        }

        .as-child-contact-content {
            position: relative;
            z-index: 2;
            max-width: 800px
        }

        .as-child-contact h2 {
            margin: 0 0 12px;
            color: #222;
            font-size: 28px;
            line-height: 1.3;
            font-weight: 800
        }

        .as-child-contact p {
            margin: 0 0 18px;
            color: #666;
            font-size: 15px;
            line-height: 1.8
        }

        .as-child-email {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: #dd2476;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            overflow-wrap: anywhere
        }

        .as-child-email:hover {
            text-decoration: underline
        }

        .as-child-contact-details {
            margin-top: 22px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px
        }

        .as-child-detail {
            padding: 15px;
            border: 1px solid #f0e4e8;
            border-radius: 13px;
            background: rgba(255, 255, 255, .75);
            overflow-wrap: anywhere
        }

        .as-child-detail span {
            display: block;
            margin-bottom: 5px;
            color: #999;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .6px;
            text-transform: uppercase
        }

        .as-child-detail strong {
            color: #444;
            font-size: 13px;
            font-weight: 600
        }

        .as-child-final-section {
            padding: 60px 20px 100px;
            background: #fff
        }

        .as-child-final {
            width: min(100%, 850px);
            margin: 0 auto;
            text-align: center
        }

        .as-child-final-icon {
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 22px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(255, 81, 47, .12), rgba(221, 36, 118, .12));
            color: #dd2476;
            font-size: 25px
        }

        .as-child-final h2 {
            margin: 0 0 16px;
            color: #222;
            font-size: clamp(29px, 4vw, 40px);
            line-height: 1.2;
            font-weight: 800
        }

        .as-child-final p {
            max-width: 760px;
            margin: 0 auto;
            color: #666;
            font-size: 16px;
            line-height: 1.85
        }

        @media(max-width:900px) {
            .as-child-grid {
                grid-template-columns: 1fr
            }

            .as-child-wide {
                grid-column: auto
            }

            .as-child-summary-grid {
                grid-template-columns: 1fr
            }

            .as-child-contact-details {
                grid-template-columns: 1fr
            }

            .as-child-intro-section,
            .as-child-section,
            .as-child-summary,
            .as-child-contact-section {
                padding-left: 18px;
                padding-right: 18px
            }
        }

        @media(max-width:650px) {
            .as-child-hero {
                min-height: 390px
            }

            .as-child-hero-content {
                width: min(100% - 24px, 950px);
                padding: 65px 12px
            }

            .as-child-hero h1 {
                font-size: 37px;
                letter-spacing: -1px
            }

            .as-child-hero p {
                font-size: 15px
            }

            .as-child-intro {
                padding: 30px 24px
            }

            .as-child-card {
                padding: 26px 23px
            }

            .as-child-contact {
                padding: 32px 25px
            }

            .as-child-contact h2 {
                font-size: 25px
            }
        }

        @media(max-width:420px) {
            .as-child-hero {
                min-height: 365px
            }

            .as-child-hero h1 {
                font-size: 32px
            }

            .as-child-eyebrow {
                font-size: 10px;
                padding: 7px 12px
            }

            .as-child-intro {
                padding: 26px 20px
            }

            .as-child-intro-top {
                gap: 13px
            }

            .as-child-intro .as-child-icon {
                width: 42px;
                height: 42px;
                flex-basis: 42px;
                font-size: 17px
            }

            .as-child-intro h2 {
                font-size: 19px
            }

            .as-child-card {
                padding: 24px 20px;
                border-radius: 18px
            }

            .as-child-card h2 {
                font-size: 19px
            }

            .as-child-card p,
            .as-child-card li {
                font-size: 14px
            }

            .as-child-contact {
                padding: 28px 20px;
                border-radius: 20px
            }
        }
    </style>
@endsection

@section('content')
    <div class="as-child-page">

        <section class="as-child-hero">
            <img src="{{ asset('images/coursel.png') }}" alt="AffirmSpace community" class="as-child-hero-image">
            <div class="as-child-overlay"></div>
            <div class="as-child-hero-content">
                <div class="as-child-eyebrow">
                    <i class="fa-solid fa-shield-heart"></i>
                    Safety &amp; Protection
                </div>
                <h1>Child Safety Standards</h1>
                <p>AffirmSpace has zero tolerance for child sexual abuse and exploitation. Protecting minors is a
                    fundamental priority.</p>
            </div>
        </section>

        <section class="as-child-intro-section">
            <div class="as-child-container">
                <div class="as-child-intro">
                    <div class="as-child-intro-top">
                        <div class="as-child-icon"><i class="fa-solid fa-shield-halved"></i></div>
                        <div>
                            <h2>Our Child Safety Commitment</h2>
                            <p class="as-child-effective">Effective Date: 26-10-2026</p>
                        </div>
                    </div>
                    <p>
                        These standards explain how AffirmSpace addresses child sexual abuse and exploitation (CSAE),
                        including child sexual abuse material (CSAM), grooming, and behavior that harms or endangers minors.
                        They apply to profiles, photos, posts, chats, events, and counselling features. These standards are
                        published by <strong>[AffirmSpace legal entity name]</strong>, registered at
                        <strong>[registered business address]</strong>.
                    </p>
                </div>
            </div>
        </section>

        <section class="as-child-section">
            <div class="as-child-container">
                <div class="as-child-grid">

                    <article class="as-child-card as-child-highlight">
                        <div class="as-child-icon"><i class="fa-solid fa-user-check"></i></div>
                        <h2>1. Who Can Use AffirmSpace</h2>
                        <p>AffirmSpace is strictly for users aged 18 or older. Minors may not create accounts or use any
                            part of the platform.</p>
                        <p>If we discover or receive a report that an account belongs to someone under 18, we will
                            investigate promptly and remove the account when the age violation is confirmed.</p>
                    </article>

                    <article class="as-child-card as-child-warning">
                        <div class="as-child-icon"><i class="fa-solid fa-ban"></i></div>
                        <h2>2. What Is Not Allowed</h2>
                        <p>The following conduct is strictly prohibited on AffirmSpace:</p>
                        <ul>
                            <li>Sexual content involving a minor, including images, videos, text, drawings, or AI-generated
                                material.</li>
                            <li>Sexualizing a minor or directing sexual conversation at anyone under 18.</li>
                            <li>Grooming or building trust with a minor for exploitation or abuse.</li>
                            <li>Requesting, sharing, trading, or linking to child sexual abuse material.</li>
                            <li>Attempting to meet a minor for sexual purposes.</li>
                            <li>Threatening, blackmailing, coercing, or pressuring a minor.</li>
                        </ul>
                        <p style="margin-top:18px">These rules apply even if the conduct is described as a joke, fiction, or
                            occurs in a private chat.</p>
                    </article>

                    <article class="as-child-card">
                        <div class="as-child-icon"><i class="fa-solid fa-gavel"></i></div>
                        <h2>3. Enforcement and Consequences</h2>
                        <p>When we identify a violation, we may take the following actions based on its severity and
                            applicable law:</p>
                        <ul>
                            <li>Remove prohibited content and restrict access to it.</li>
                            <li>Suspend or permanently terminate the account involved, including without prior warning where
                                appropriate.</li>
                            <li>Report suspected illegal conduct to relevant authorities where required or appropriate.</li>
                            <li>Preserve relevant information for lawful investigations, subject to applicable legal
                                requirements.</li>
                        </ul>
                        <p style="margin-top:18px">Reports may be made under applicable laws, including India's Protection
                            of Children from Sexual Offences (POCSO) Act, 2012 and Information Technology Act, 2000, and to
                            NCMEC where applicable.</p>
                    </article>

                    <article class="as-child-card">
                        <div class="as-child-icon"><i class="fa-solid fa-list-check"></i></div>
                        <h2>4. Community Guidelines and Terms</h2>
                        <p>These child safety standards supplement our Community Guidelines and Terms &amp; Conditions. They
                            do not limit our ability to take action under those policies or applicable law.</p>
                        <p>AffirmSpace may review reports, restrict accounts, and take other reasonable steps to protect
                            users and support child safety.</p>
                    </article>

                    <article class="as-child-card as-child-wide as-child-highlight">
                        <div class="as-child-icon"><i class="fa-solid fa-flag"></i></div>
                        <h2>5. How to Report a Concern</h2>
                        <p>If you see content or behavior that may put a child at risk, report it to us immediately.</p>
                        <ul>
                            <li><strong>Email:</strong> <a href="mailto:info@affirmspace.com?subject=Child%20Safety"
                                    class="as-child-email">info@affirmspace.com</a> — use the subject line “Child Safety”.
                            </li>
                            <li><strong>Contact form:</strong> Use our Report a Problem page and begin the subject with
                                “[Report]”.</li>
                            <li><strong>In-app reporting:</strong> [Add in-app reporting instructions once this feature is
                                available.]</li>
                        </ul>
                        <p style="margin-top:18px">Where possible, include the username or profile involved, a brief
                            description, the date and time, and where you encountered the content.</p>
                        <p style="margin-top:12px"><strong>Do not forward, upload, or share suspected child sexual abuse
                                material.</strong> Describe where you encountered it so our team can investigate safely.</p>
                        <p style="margin-top:12px">Reports are treated as urgent and reviewed by our team. You may report a
                            concern without providing identifying information beyond what is necessary to contact you.</p>
                    </article>

                    <article class="as-child-card">
                        <div class="as-child-icon"><i class="fa-solid fa-truck-medical"></i></div>
                        <h2>6. If a Child Is in Immediate Danger</h2>
                        <p>Contact local emergency services first if a child is in immediate danger.</p>
                        <ul>
                            <li><strong>India:</strong> Child Helpline 1098 and the National Cyber Crime Reporting Portal.
                            </li>
                            <li><strong>United States:</strong> NCMEC CyberTipline.</li>
                            <li><strong>Elsewhere:</strong> Contact local police or your national child protection hotline.
                            </li>
                        </ul>
                        <p style="margin-top:18px">Official reporting resources:</p>
                        <ul>
                            <li><a href="https://www.cybercrime.gov.in/" target="_blank" rel="noopener noreferrer">India
                                    National Cyber Crime Reporting Portal</a></li>
                            <li><a href="https://report.cybertip.org/" target="_blank" rel="noopener noreferrer">NCMEC
                                    CyberTipline</a></li>
                        </ul>
                    </article>

                    <article class="as-child-card">
                        <div class="as-child-icon"><i class="fa-solid fa-address-card"></i></div>
                        <h2>7. Child Safety Point of Contact</h2>
                        <p>Contact our team to report a child safety concern or request a review.</p>
                        <ul>
                            <li><strong>Contact role:</strong> [Name or role, e.g., Grievance Officer — AffirmSpace Support
                                Team]</li>
                            <li><strong>Email:</strong> <a href="mailto:info@affirmspace.com?subject=Child%20Safety"
                                    class="as-child-email">info@affirmspace.com</a></li>
                        </ul>
                        <p style="margin-top:18px">Please use “Child Safety” in your email subject so your report can be
                            identified quickly.</p>
                    </article>

                    <article class="as-child-card">
                        <div class="as-child-icon"><i class="fa-solid fa-heart"></i></div>
                        <h2>8. Staying Safe</h2>
                        <p>If you are under 18 and have reached AffirmSpace, do not use the platform. If someone online has
                            made you feel unsafe or pressured you, it is not your fault.</p>
                        <p>Tell a trusted adult or contact Child Helpline 1098 in India if you need help.</p>
                        <p style="margin-top:14px">Parents or guardians who believe a minor is using AffirmSpace can contact
                            <a href="mailto:info@affirmspace.com" class="as-child-email">info@affirmspace.com</a>.</p>
                    </article>

                    <article class="as-child-card">
                        <div class="as-child-icon"><i class="fa-solid fa-rotate"></i></div>
                        <h2>9. Updates to These Standards</h2>
                        <p>We review these standards regularly and may update them to reflect changes to our platform,
                            safety practices, or applicable requirements.</p>
                        <p>The effective date displayed at the top of this page indicates when the current version takes
                            effect. Please check this page periodically for updates.</p>
                    </article>

                </div>
            </div>
        </section>

        <section class="as-child-summary">
            <div class="as-child-heading">
                <span class="eyebrow">Our Commitment</span>
                <h2>Child Safety Is Non-Negotiable</h2>
                <p>We expect every user to help keep AffirmSpace safe and free from child sexual abuse and exploitation.</p>
            </div>

            <div class="as-child-summary-grid">
                <div class="as-child-summary-item"><i class="fa-solid fa-ban"></i><span>Strictly prohibited: CSAE, CSAM,
                        grooming, and sexual exploitation of minors.</span></div>
                <div class="as-child-summary-item"><i class="fa-solid fa-user-shield"></i><span>AffirmSpace is only for
                        users aged 18 and older.</span></div>
                <div class="as-child-summary-item"><i class="fa-solid fa-flag"></i><span>Report concerns promptly through
                        our designated contact channels.</span></div>
                <div class="as-child-summary-item"><i class="fa-solid fa-scale-balanced"></i><span>Violations may result in
                        account removal and reports to relevant authorities.</span></div>
            </div>
        </section>

        <section class="as-child-contact-section">
            <div class="as-child-contact">
                <div class="as-child-contact-content">
                    <div class="as-child-icon"><i class="fa-solid fa-headset"></i></div>
                    <h2>Report a Child Safety Concern</h2>
                    <p>If you believe a child may be at risk, contact our team immediately. Do not attach or forward
                        suspected child sexual abuse material.</p>
                    <a href="mailto:info@affirmspace.com?subject=Child%20Safety" class="as-child-email">
                        <i class="fa-solid fa-envelope"></i> info@affirmspace.com
                    </a>

                    <div class="as-child-contact-details">
                        <div class="as-child-detail"><span>Email Subject</span><strong>Child Safety</strong></div>
                        <div class="as-child-detail"><span>Include</span><strong>Username and incident details</strong>
                        </div>
                        <div class="as-child-detail"><span>Urgent Risk</span><strong>Contact local emergency
                                services</strong></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="as-child-final-section">
            <div class="as-child-final">
                <div class="as-child-final-icon"><i class="fa-solid fa-shield-heart"></i></div>
                <h2>A Safer Space for Everyone</h2>
                <p>AffirmSpace is committed to responding to child safety concerns seriously and promptly. Every report can
                    help us identify risks and take appropriate action to protect children.</p>
            </div>
        </section>

    </div>
@endsection