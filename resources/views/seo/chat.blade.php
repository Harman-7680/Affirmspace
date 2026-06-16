@extends('layouts.seo')

@section('meta')
    <meta name="description"
        content="Chat privately on a safe LGBTQ+ chat platform. Connect with like-minded people, share experiences, and build real conversations securely and anonymously.">

    <title>LGBTQ+ Chat Platform – Private & Safe Chat | AffirmSpace</title>
    <meta name="author" content="AffirmSpace">
    <meta name="keywords"
        content="LGBTQ+ chat, LGBTQ+ chat platform, safe LGBTQ+ chat, LGBTQ+ messaging platform, LGBTQ+ community chat">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <!-- FAQ Schema -->
    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What is Affirmspace LGBTQ+ Chat?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Affirmspace is a safe and inclusive LGBTQ+ chat platform where gay, lesbian, bisexual, queer, transgender, non-binary individuals and allies can connect, chat, and build meaningful relationships."
      }
    },
    {
      "@type": "Question",
      "name": "Is Affirmspace free to use?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. Users can join Affirmspace, connect with the community, and access chat features without any cost."
      }
    },
    {
      "@type": "Question",
      "name": "Can I chat anonymously on Affirmspace?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. Affirmspace allows users to connect comfortably while maintaining their privacy and sharing only the information they choose."
      }
    },
    {
      "@type": "Question",
      "name": "Is Affirmspace only for LGBTQ+ individuals?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Affirmspace is designed primarily for LGBTQ+ individuals, including gay, lesbian, bisexual, queer, transgender, and non-binary people, while also welcoming supportive allies."
      }
    },
    {
      "@type": "Question",
      "name": "Is Affirmspace a safe LGBTQ+ chat platform?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Affirmspace focuses on creating a respectful and inclusive environment through community guidelines, moderation, and privacy-focused features."
      }
    },
    {
      "@type": "Question",
      "name": "Can I make friends on Affirmspace?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. Many users join Affirmspace to meet like-minded people, build friendships, join community discussions, and connect with others who share similar experiences."
      }
    }
  ]
}
</script>

    <!-- WebPage Schema -->
    <script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@type":"WebPage",
  "name":"LGBTQ+ Chat Online",
  "url":"https://affirmspace.com/lgbtq-chat",
  "description":"Safe LGBTQ+ chat platform for gay, lesbian, queer, trans and non-binary individuals."
}
</script>
@endsection

@section('css')
    <style>
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 60px 20px;
        }

        .btn-primary {
            background: linear-gradient(90deg, #ff4d7e, #ff7a5c);
            color: #fff;
            padding: 14px 28px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
        }

        .btn-outline {
            border: 2px solid #ddd;
            padding: 12px 28px;
            border-radius: 30px;
            text-decoration: none;
            color: #333;
        }

        .hero-image img {
            width: 100%;
            max-width: 450px;
        }


        /* WHY CHAT */

        .why-chat {
            text-align: center;
            background: white;
        }

        .why-chat h2 {
            font-size: 34px;
            margin-bottom: 40px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
        }

        .feature-card {
            background: #f9f9ff;
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            margin-top: 30px;
        }

        .feature-card .icon {
            font-size: 32px;
            margin-bottom: 10px;
        }

        /* SECTION */

        .chat-features {
            background: linear-gradient(180deg, #eef5ff 0%, #e8f1ff 100%);
            padding: 90px 8%;
            overflow: hidden;
        }

        /* HEADING */

        .section-heading {
            text-align: center;
            max-width: 850px;
            margin: auto;
            margin-bottom: 80px;
        }

        .small-title {
            display: inline-block;
            font-size: 15px;
            font-weight: 700;
            color: #1d7cff;
            margin-bottom: 14px;
            letter-spacing: .5px;
        }

        .section-heading h2 {
            font-size: 48px;
            line-height: 1.25;
            color: #111827;
            font-weight: 800;
            margin-bottom: 22px;
        }

        .section-heading p {
            font-size: 17px;
            line-height: 1.8;
            color: #4b5563;
        }

        /* FEATURES */

        .features-wrapper {
            max-width: 1100px;
            margin: auto;
        }

        .feature-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 80px;
            padding: 55px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        }

        .feature-row:last-child {
            border-bottom: none;
        }

        .feature-row.reverse {
            flex-direction: row-reverse;
        }

        /* IMAGE */

        .feature-image {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .feature-image img {
            width: 240px;
            max-width: 100%;
            border-radius: 30px;
            filter: drop-shadow(0 14px 35px rgba(0, 119, 255, 0.20));
            transition: 0.3s ease;
        }

        .feature-image img:hover {
            transform: translateY(-6px);
        }

        /* CONTENT */

        .feature-content {
            flex: 1;
        }

        .feature-content h3 {
            font-size: 38px;
            line-height: 1.3;
            color: #111827;
            font-weight: 800;
            max-width: 500px;
        }

        /* RESPONSIVE */

        @media(max-width: 991px) {

            .feature-row,
            .feature-row.reverse {
                flex-direction: column;
                text-align: center;
                gap: 35px;
            }

            .feature-content h3 {
                max-width: 100%;
                font-size: 30px;
            }

            .section-heading h2 {
                font-size: 38px;
            }

            .feature-image img {
                width: 200px;
            }
        }

        @media(max-width: 600px) {

            .chat-features {
                padding: 70px 6%;
            }

            .section-heading h2 {
                font-size: 30px;
            }

            .section-heading p {
                font-size: 15px;
            }

            .feature-content h3 {
                font-size: 24px;
            }

            .feature-image img {
                width: 170px;
            }

            .feature-row {
                padding: 40px 0;
            }
        }

        /* HOW IT WORKS */

        .how-it-works {
            background: #fafafa;
            text-align: center;
        }

        .steps {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-top: 40px;
        }

        .step {
            background: white;
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .step-number {
            width: 40px;
            height: 40px;
            /* background:#ff4d7e; */
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
            margin-bottom: 15px;
            font-weight: 600;
        }

        /* CTA */

        .cta-section {
            background: linear-gradient(90deg, #ff4d7e, #ff7a5c);
            text-align: center;
            color: white;
        }

        .cta-box {
            padding: 60px 20px;
        }

        .btn-light {
            background: white;
            color: #ff4d7e;
            padding: 14px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            margin-top: 20px;
        }


        /* RESPONSIVE */

        @media(max-width:900px) {

            .hero-grid {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .steps {
                grid-template-columns: 1fr;
            }

        }
    </style>


    <style>
        .hero-banner {
            position: relative;
            height: 620px;
            width: 100%;
            background-image: url('images/chat/Chat_Header_Banner.jpeg');
            background-size: cover;
            display: flex;
            align-items: center;
            border-radius: 24px;
            overflow: hidden;
            font-family: 'Inter', system-ui, sans-serif;
        }

        .hero-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                    rgba(124, 58, 237, 0.85) 0%,
                    rgba(124, 58, 237, 0.75) 40%,
                    rgba(0, 0, 0, 0.4) 100%);
            z-index: 1;
        }

        .content-overlay {
            position: relative;
            z-index: 3;
            width: 50%;
            padding-left: 70px;
            color: white;
        }

        .main-heading {
            font-size: 4.5rem;
            font-weight: 700;
            line-height: 1.05;
            margin-bottom: 24px;
        }

        .gradient-text {
            background: linear-gradient(to right, #ffffff, #E0BBFF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sub-text {
            font-size: 1.9rem;
            font-weight: 500;
            line-height: 1.25;
            margin-bottom: 50px;
        }

        .brand-badge {
            display: flex;
            align-items: center;
            gap: 16px;
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(12px);
            padding: 18px 28px;
            border-radius: 9999px;
            width: fit-content;
        }

        .heart-icon {
            width: 54px;
            height: 54px;
            background: white;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
        }

        .brand-name {
            color: white;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .brand-tagline {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
        }

        /* ==================== FLOATING ICONS ==================== */
        .floating-icons {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
            pointer-events: none;
            overflow: hidden;
        }

        .float-icon {
            position: absolute;
            font-size: 2.8rem;
            opacity: 0.85;
            filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.4));
        }

        /* Positions - Right Side */
        .float-icon:nth-child(1) {
            top: 20%;
            left: 68%;
            font-size: 3.5rem;
        }

        .float-icon:nth-child(2) {
            top: 35%;
            left: 80%;
            font-size: 2.4rem;
        }

        .float-icon:nth-child(3) {
            top: 55%;
            left: 65%;
            font-size: 2.8rem;
        }

        .float-icon:nth-child(4) {
            top: 25%;
            left: 85%;
            font-size: 2.3rem;
        }

        .float-icon:nth-child(5) {
            top: 70%;
            left: 73%;
            font-size: 3.0rem;
        }

        .float-icon:nth-child(6) {
            top: 45%;
            left: 88%;
            font-size: 2.5rem;
        }

        .float-icon:nth-child(7) {
            top: 18%;
            left: 75%;
            font-size: 2.6rem;
        }

        .float-icon:nth-child(8) {
            top: 65%;
            left: 82%;
            font-size: 2.9rem;
        }

        /* 1. Upward Floating */
        .up-float {
            animation: floatUp 22s linear infinite;
            animation-delay: var(--delay);
        }

        @keyframes floatUp {
            0% {
                transform: translateY(120px) rotate(0deg);
                opacity: 0;
            }

            15% {
                opacity: 0.85;
            }

            85% {
                opacity: 0.85;
            }

            100% {
                transform: translateY(-800px) rotate(25deg);
                opacity: 0;
            }
        }

        /* 2. Up & Down Bobbing */
        .bob {
            animation: bob 5s ease-in-out infinite;
            animation-delay: var(--delay);
        }

        @keyframes bob {

            0%,
            100% {
                transform: translateY(0) rotate(-8deg);
            }

            50% {
                transform: translateY(-45px) rotate(8deg);
            }
        }

        /* 3. Horizontal Left-Right Movement */
        .horizontal {
            animation: horizontalDrift 14s ease-in-out infinite;
            animation-delay: var(--delay);
        }

        @keyframes horizontalDrift {

            0%,
            100% {
                transform: translateX(0) rotate(-10deg);
            }

            50% {
                transform: translateX(80px) rotate(10deg);
            }
        }

        /* Combine gentle floating with all types */
        .float-icon {
            animation-timing-function: ease-in-out;
        }
    </style>
@endsection

@section('content')
    <section class="hero-banner">

        <!-- Left Content (Unchanged) -->
        <div class="content-overlay">
            <h1 class="main-heading">
                Chat<br><span class="gradient-text">Freely.</span>
            </h1>

            <p class="sub-text">
                Real conversations.<br>
                Real connections.
            </p>

            <div class="brand-badge">
                <div class="heart-icon">❤️</div>
                <div>
                    <div class="brand-name">affirmspace</div>
                    <div class="brand-tagline">Safe • Inclusive • Real</div>
                </div>
            </div>
        </div>

        <!-- Floating Cute Icons with Mixed Animations -->
        <div class="floating-icons">
            <div class="float-icon up-float" style="--delay: 0s;">❤️</div>
            <div class="float-icon horizontal" style="--delay: 1.5s;">💬</div>
            <div class="float-icon bob" style="--delay: 0.3s;">❤️</div>
            <div class="float-icon up-float" style="--delay: 2.4s;">💬</div>
            <div class="float-icon horizontal" style="--delay: 0.8s;">🤝</div>
            <div class="float-icon bob" style="--delay: 1.9s;">💖</div>
            <div class="float-icon up-float" style="--delay: 3.2s;">💬</div>
            <div class="float-icon horizontal" style="--delay: 1.2s;">💖</div>

            <div class="float-icon up-float" style="--delay: 0s;">❤️</div>
            <div class="float-icon horizontal" style="--delay: 1.5s;">💬</div>
            <div class="float-icon bob" style="--delay: 0.3s;">❤️</div>
            <div class="float-icon up-float" style="--delay: 2.4s;">💬</div>
            <div class="float-icon horizontal" style="--delay: 0.8s;">🤝</div>
            <div class="float-icon bob" style="--delay: 1.9s;">💖</div>
            <div class="float-icon up-float" style="--delay: 3.2s;">💬</div>
            <div class="float-icon horizontal" style="--delay: 1.2s;">💖</div>
        </div>

    </section>



    <section class="why-chat">
        <div class="container">

            <h2>🌈 LGBTQ+ Chat – Safe, Anonymous & Inclusive Chat Platform</h2>

            <p>AffirmSpace is a modern platform offering LGBTQ chat online, designed specifically for individuals who want
                more than just surface-level interaction. It is a space where people identifying as gay, lesbian, bisexual,
                queer, trans, and beyond can connect, communicate, and feel understood without judgment.</p>

            <div class="features-grid">

                <div class="feature-card">
                    <div class="icon"><img height="70" src="{{ asset('images/chat/Private_Chat.png') }}"
                            alt="Chat bubbles with lock showing private LGBTQ chat and messaging"></div>
                    <h3>Private & Secure</h3>
                    <p>Encrypted messaging for your privacy.</p>
                </div>

                <div class="feature-card">
                    <div class="icon"><img height="70" src="{{ asset('images/chat/Lgbt_Friendly.png') }}"
                            alt="Rainbow pride flag on pole representing LGBTQ community"></div>
                    <h3>LGBTQ+ Friendly</h3>
                    <p>A safe space to be yourself.</p>
                </div>

                <div class="feature-card">
                    <div class="icon"><img height="80" src="{{ asset('images/chat/Group_Chat.png') }}"
                            alt="Group of friends talking together showing community and connection"></div>
                    <h3>Group Chats</h3>
                    <p>Join communities and discussions.</p>
                </div>

                <div class="feature-card">
                    <div class="icon"><img height="80" src="{{ asset('images/chat/Real_Connections.png') }}"
                            alt="Two hearts together showing friends connection and support."></div>
                    <h3>Real Connections</h3>
                    <p>Build friendships and support.</p>
                </div>

            </div>

        </div>
    </section>

    <!-- LGBTQ+ Chat Features Section -->
    <section class="chat-features">

        <!-- Heading -->
        <div class="section-heading">
            <span class="small-title"></span>

            <h2>
                💬 LGBTQ+ Chat Features</h2>

            <p>
                AffirmSpace offers everything you need to connect comfortably and confidently
            </p>
        </div>

        <div class="features-wrapper">

            <!-- Feature 1 -->
            <div class="feature-row">

                <div class="feature-image">
                    <img src="{{ asset('images/chat/anonymouschat.png') }}" alt="">
                </div>

                <div class="feature-content">
                    <h3>Anonymous LGBTQ+ Chat Without Revealing Your Identity</h3>
                </div>

            </div>

            <!-- Feature 2 -->
            <div class="feature-row reverse">

                <div class="feature-image">
                    <img src="{{ asset('images/chat/private.png') }}" alt="">
                </div>

                <div class="feature-content">
                    <h3>One-on-One Private Conversations</h3>
                </div>

            </div>

            <!-- Feature 3 -->
            <div class="feature-row">

                <div class="feature-image">
                    <img src="{{ asset('images/chat/groupchat.png') }}" alt="">
                </div>

                <div class="feature-content">
                    <h3>LGBTQ+ Group Chat Rooms</h3>
                </div>

            </div>

            <!-- Feature 4 -->
            <div class="feature-row reverse">

                <div class="feature-image">
                    <img src="{{ asset('images/chat/safety.png') }}" alt="">
                </div>

                <div class="feature-content">
                    <h3>Private,Safe & Moderate</h3>
                </div>

            </div>

            <!-- Feature 5 -->
            <div class="feature-row">

                <div class="feature-image">
                    <img src="{{ asset('images/chat/instant.png') }}" alt="">
                </div>

                <div class="feature-content">
                    <h3>⚡ Instant Chat & Easy Sign-Up</h3>
                </div>

            </div>

        </div>
        <p style="text-align: center";>Whether you're here to talk, explore, or connect, everything is designed for
            simplicity and comfort.</p>

    </section>


    <section class="how-it-works">
        <div class="container">

            <h2>How It Works</h2>

            <div class="steps">

                <div class="step">
                    <div class="step-number"><img height="60" src="{{ asset('images/chat/Browse_Connect.png') }}"
                            alt="Hands passing heart showing friends support and connection."></div>
                    <h3>Browse & Connect</h3>
                    <p>Find people to chat with.</p>
                </div>

                <div class="step">
                    <div class="step-number"><img height="60" src="{{ asset('images/chat/Start_Messaging.png') }}"
                            alt="Two people using phones showing messaging and online communication."></div>
                    <h3>Start Messaging</h3>
                    <p>Send text, emojis and media.</p>
                </div>

                <div class="step">
                    <div class="step-number"><img height="60"
                            src="{{ asset('images/chat/Build_Relationships.png') }}"
                            alt="Two hands with heart showing support and connection between friends."></div>
                    <h3>Build Relationships</h3>
                    <p>Make meaningful connections.</p>
                </div>

            </div>

        </div>
    </section>

    <section class="cta-section">
        <div class="container cta-box">

            <h2>Start a Conversation Today!</h2>

            <p>
                Connect with someone and be part of a supportive LGBTQ+ community.
            </p>

            <a href="{{ 'login' }}" class="btn-light">Open Messages</a>

        </div>
    </section>
@endsection
