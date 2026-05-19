@extends('layouts.seo')

@section('meta')
    <meta name="description"
        content="Chat privately on a safe LGBTQ+ chat platform. Connect with like-minded people, share experiences, and build real conversations securely and anonymously.">

    <title>LGBTQ+ Chat Platform – Private & Safe Chat | AffirmSpace</title>
    <meta name="author" content="AffirmSpace">
    <meta name="keywords"
        content="LGBTQ+ chat, LGBTQ+ chat platform, safe LGBTQ+ chat, LGBTQ+ messaging platform, LGBTQ+ community chat">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
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
        }

        .feature-card .icon {
            font-size: 32px;
            margin-bottom: 10px;
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
            /* background-position: center; */
            display: flex;
            align-items: center;
            border-radius: 24px;
            overflow: hidden;
            font-family: 'Inter', system-ui, sans-serif;
        }

        /* Dark overlay for better text readability */
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
            z-index: 2;
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
    </style>
@endsection

@section('content')
    <section class="hero-banner">

        <!-- Left Content -->
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

    </section>

    <section class="why-chat">
        <div class="container">

            <h2>Why Chat on AffirmSpace?</h2>

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
