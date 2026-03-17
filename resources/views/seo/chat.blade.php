@extends('layouts.seo')

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat – AffirmSpace</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('css')
    <style>
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 60px 20px;
        }

        .chat-hero {
            background: #f8f9ff;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 40px;
        }

        .hero-text h1 {
            font-size: 48px;
            font-weight: 700;
            color: #222;
        }

        .hero-text span {
            color: #ff4d7e;
        }

        .hero-text p {
            margin-top: 20px;
            font-size: 18px;
            color: #555;
            line-height: 1.6;
        }

        .hero-buttons {
            margin-top: 30px;
            display: flex;
            gap: 15px;
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
@endsection

@section('content')
    <section class="chat-hero">
        <div class="container">

            <div class="hero-grid">

                <div class="hero-text">
                    <h1>Start Conversations <br> <span>That Matter</span></h1>

                    <p>
                        Connect with people in a safe and supportive LGBTQ+ community.
                        Chat freely, share your experiences, and build meaningful friendships
                        with people who truly understand you.
                    </p>

                    <div class="hero-buttons">
                        <a href="#" class="btn-primary">Start Chatting</a>
                        <a href="#" class="btn-outline">Open Messages</a>
                    </div>
                </div>

                <div class="hero-image">
                    <img src="{{ asset('images/chat/Chat_Header_Banner.png') }}" alt="AffirmSpace Chat">
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
                            alt=""></div>
                    <h3>Private & Secure</h3>
                    <p>Encrypted messaging for your privacy.</p>
                </div>

                <div class="feature-card">
                    <div class="icon"><img height="70" src="{{ asset('images/chat/Lgbt_Friendly.png') }}"
                            alt=""></div>
                    <h3>LGBTQ+ Friendly</h3>
                    <p>A safe space to be yourself.</p>
                </div>

                <div class="feature-card">
                    <div class="icon"><img height="80" src="{{ asset('images/chat/Group_Chat.png') }}" alt="">
                    </div>
                    <h3>Group Chats</h3>
                    <p>Join communities and discussions.</p>
                </div>

                <div class="feature-card">
                    <div class="icon"><img height="80" src="{{ asset('images/chat/Real_Connections.png') }}"
                            alt=""></div>
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
                    <div class="step-number"><img height="90" src="{{ asset('images/chat/Logo1.png') }}" alt="">
                    </div>
                    <h3>Browse & Connect</h3>
                    <p>Find people to chat with.</p>
                </div>

                <div class="step">
                    <div class="step-number"><img height="90" src="{{ asset('images/chat/logo2.png') }}" alt="">
                    </div>
                    <h3>Start Messaging</h3>
                    <p>Send text, emojis and media.</p>
                </div>

                <div class="step">
                    <div class="step-number"><img height="90" src="{{ asset('images/chat/logo3.png') }}" alt="">
                    </div>
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

            <a href="#" class="btn-light">Open Messages</a>

        </div>
    </section>
@endsection
