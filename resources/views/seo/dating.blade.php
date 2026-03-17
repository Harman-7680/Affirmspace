@extends('layouts.seo')

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dating – AffirmSpace</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('css')
    <style>
        /* GLOBAL */

        /* CONTAINER */

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 60px 20px;
        }


        /* HERO (MATCH CHAT PAGE) */

        .chat-hero {
            background: #f8f9ff;
        }


        /* GRID */

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 40px;
        }


        /* TEXT */

        .hero-text h1 {
            font-size: 48px;
            font-weight: 700;
            color: #222;
            line-height: 1.2;
        }

        .hero-text span {
            color: #ff4d7e;
        }

        .hero-text p {
            margin-top: 20px;
            font-size: 18px;
            color: #555;
            line-height: 1.6;
            max-width: 520px;
        }


        /* BUTTONS */

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


        /* IMAGE */

        .hero-image img {
            width: 100%;
            max-width: 450px;
        }



        /* WHY DATING */

        .why-dating {
            background: #f8f9ff;
            text-align: center;
        }

        .why-dating h2 {
            font-size: 34px;
            margin-bottom: 20px;
        }

        .features-grid {
            margin-top: 40px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .feature-card {
            background: white;
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
        }

        .icon {
            font-size: 32px;
            margin-bottom: 10px;
        }



        /* HOW IT WORKS */

        .how-works {
            text-align: center;
            background: white;
        }

        .how-works h2 {
            font-size: 34px;
        }

        .steps {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-top: 40px;
        }

        .step {
            background: #f8f9ff;
            padding: 30px;
            border-radius: 14px;
            transition: 0.3s;
        }

        .step:hover {
            transform: translateY(-5px);
        }

        .step-number {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #dd2476;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
            margin-bottom: 15px;
            font-weight: 600;
        }



        /* COMMUNITY SECTION */

        .community-section {
            background: #f4f5ff;
            text-align: center;
        }

        .community-box {
            max-width: 800px;
            margin: auto;
        }

        .community-section h2 {
            font-size: 32px;
        }

        .community-section p {
            margin-top: 20px;
            line-height: 1.7;
            font-size: 17px;
        }



        /* CTA SECTION */

        .dating-cta {
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: white;
            text-align: center;
            padding: 0px 0;
        }

        .cta-box h2 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .cta-box p {
            font-size: 18px;
            opacity: 0.95;
        }


        /* BUTTON MARGIN FIX */

        .dating-cta .btn-primary {
            margin-top: 35px;
        }



        /* RESPONSIVE */

        @media(max-width:900px) {

            .hero-grid {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-text p {
                margin-left: auto;
                margin-right: auto;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .steps {
                grid-template-columns: 1fr;
            }

            .hero-text h1 {
                font-size: 40px;
            }

            .hero-text h2 {
                font-size: 22px;
            }

        }
    </style>
@endsection

@section('content')
    <section class="chat-hero">
        <div class="container">

            <div class="hero-grid">

                <div class="hero-text">
                    <h1>Find Meaningful LGBTQ+ <br><span>Connections</span></h1>

                    <p>
                        Discover people who understand you. AffirmSpace helps the LGBTQ+ community connect,
                        build relationships, and explore dating in a safe and respectful environment.
                    </p>

                    <div class="hero-buttons">
                        <a href="#" class="btn-primary">Start Exploring</a>
                        <a href="#" class="btn-outline">Create Your Profile</a>
                    </div>
                </div>

                <div class="hero-image">
                    <img src="images/dating.png" alt="AffirmSpace Dating">
                </div>

            </div>

        </div>
    </section>



    <section class="why-dating">
        <div class="container">

            <h2>Why Choose AffirmSpace for Dating</h2>

            <div class="features-grid">

                <div class="feature-card">
                    <div class="icon">🏳️‍🌈</div>
                    <h3>Safe LGBTQ+ Dating Space</h3>
                    <p>
                        Meet people who respect your identity and values in a safe and inclusive environment.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="icon">✔️</div>
                    <h3>Authentic Profiles</h3>
                    <p>
                        Find genuine connections with real people from the LGBTQ+ community.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="icon">❤️</div>
                    <h3>Meaningful Connections</h3>
                    <p>
                        Whether you're looking for friendship, dating, or a relationship,
                        AffirmSpace helps you connect with like-minded people.
                    </p>
                </div>

            </div>

        </div>
    </section>



    <section class="how-works">
        <div class="container">

            <h2>How It Works</h2>

            <div class="steps">

                <div class="step">
                    <div class="step-number">1</div>
                    <h3>Create Your Profile</h3>
                    <p>
                        Share your interests, identity, and what you're looking for.
                    </p>
                </div>

                <div class="step">
                    <div class="step-number">2</div>
                    <h3>Discover People</h3>
                    <p>
                        Browse profiles and find people who share your values.
                    </p>
                </div>

                <div class="step">
                    <div class="step-number">3</div>
                    <h3>Start a Conversation</h3>
                    <p>
                        Match and begin meaningful conversations in a safe space.
                    </p>
                </div>

            </div>

        </div>
    </section>



    <section class="community-section">
        <div class="container community-box">

            <h2>Built for the LGBTQ+ Community</h2>

            <p>
                AffirmSpace is designed to be more than just a dating platform.
                It’s a community where LGBTQ+ individuals can connect freely,
                express themselves openly, and build meaningful relationships
                without fear of judgment.
            </p>

        </div>
    </section>



    <section class="dating-cta">
        <div class="container cta-box">

            <h2>Start Your Journey Today</h2>

            <p>
                Join AffirmSpace and meet people who truly understand you.
            </p>

            <a href="#" class="btn-primary">Create Your Profile</a>

        </div>
    </section>
@endsection
