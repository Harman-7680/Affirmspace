@extends('layouts.seo')

@section('meta')
    <meta name="description"
        content="Learn about AffirmSpace’s mission to build a safe LGBTQ+ community platform for connection, dating, and mental health support in an inclusive space.">
    <title>About AffirmSpace – LGBTQ+ Community Platform</title>
    <meta name="author" content="AffirmSpace">

    <meta name="keywords"
        content="LGBTQ+ community platform, safe LGBTQ+ community, gay chat platform, LGBTQ+ counselling platform, alternative to LGBTQ dating apps">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('css')
    <style>
        section {
            padding: 80px 8%;
        }

        section h2 {
            font-size: 2.1rem;
            margin-bottom: 15px;
            text-align: center;
        }

        section p {
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
            color: #555;
        }

        .features {
            background: #ffffff;
        }

        .feature-grid {
            margin-top: 50px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        .feature-card {
            background: #f9fafb;
            padding: 28px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .feature-card h3 {
            margin-bottom: 12px;
            font-size: 1.1rem;
        }

        .feature-card p {
            text-align: left;
            color: #555;
            margin-bottom: 10px;
        }

        .disclaimer {
            margin-top: 35px;
            font-size: 0.9rem;
            text-align: center;
            color: #666;
        }

        .about-parallax {
            position: relative;
            padding: 120px 8%;
            text-align: center;
            color: white;
            overflow: hidden;
        }

        /* IMAGE */

        .parallax-img {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            object-fit: cover;
            z-index: -2;
        }

        /* OVERLAY */

        .about-parallax::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            z-index: -1;
        }

        /* TEXT */

        .about-content {
            max-width: 850px;
            margin: auto;
        }

        .about-content h2 {
            font-size: 2.2rem;
            margin-bottom: 15px;
        }

        .about-content p {
            color: #f0f0f0;
            font-size: 1.05rem;
            line-height: 1.7;
        }

        /* MOBILE FIX */

        @media(max-width:1024px) {

            .parallax-img {
                position: absolute;
                height: 100%;
            }

            .about-parallax {
                padding: 100px 8%;
            }

        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="about-parallax">

        <img src="images/coursel.png" class="parallax-img" alt="AffirmSpace background">

        <div class="about-content">
            <h2>More Than a Dating Platform 🌈</h2>

            <p>
                AffirmSpace is a global LGBTQ+ community, gay chat platform, and
                counselling ecosystem built for connection, safety, and genuine understanding.
                We are not just another gay dating website — we are a space where identity is respected
                and conversations go beyond surface-level attraction.
            </p>
        </div>

    </section>

    <!-- About Content -->
    <section class="features">
        <div class="feature-grid">

            <div class="feature-card">
                <h3>🛡️ A Safe LGBTQ+ Community </h3>
                <p>
                    <a href="{{ route('/') }}" style="text-decoration:none; color:black;"> <b>AffirmSpace</b></a> was
                    created to provide a secure and inclusive environment where people can express their identity freely and
                    connect without fear of judgment.<a href="{{ route('community') }}"
                        style="text-decoration:none; color:black;"><b> As a safe LGBTQ+ community platform,</b></a> we
                    prioritize respectful interaction, privacy, and meaningful conversations for individuals across the
                    LGBTQ+ spectrum.
                </p>
            </div>

            <div class="feature-card">
                <h3>💬 Meaningful LGBTQ+ Chat & Real Connections</h3>
                <p>
                    Whether you're looking for casual conversations, friendships, or long-term relationships, AffirmSpace
                    helps people connect through inclusive <a href="{{ route('chat') }}"
                        style="text-decoration:none; color:black;"><b>LGBTQ+ chat and community</b></a> discussions in a
                    safe environment.
                </p>
            </div>

            <div class="feature-card">
                <h3>❤️ Beyond Traditional LGBTQ Dating Apps </h3>
                <p>
                    Unlike many <a href="{{ route('chatAndDating') }}" style="text-decoration:none; color:black;"><b>LGBTQ
                            dating apps</b></a> that focus only on swiping and quick matches, AffirmSpace promotes deeper
                    connections built on trust, shared experiences, and mutual understanding within the community.
                </p>
            </div>

            <div class="feature-card">
                <h3>🧠 Built-In Counselling Support </h3>
                <p>
                    AffirmSpace goes beyond social networking by integrating <a href="{{ route('counselling') }}"
                        style="text-decoration:none; color:black;"><b>LGBTQ-friendly counselling support</b></a> directly
                    into the platform. Users can access guidance for mental health, identity challenges, relationships, and
                    personal growth through trained counsellors and supervised interns.
                </p>
            </div>

            <div class="feature-card">
                <h3>🌈 Identity & Pronoun Respect </h3>
                <p>
                    We believe identity deserves recognition and respect. AffirmSpace allows members to express themselves
                    through customizable profiles, pronoun options, and inclusive identity choices that cr
                </p>
            </div>

            <div class="feature-card">
                <h3>🚀 Our Vision </h3>
                <p>
                    Our vision is to build a trusted global platform where LGBTQ+ individuals can connect, share
                    experiences, and find the understanding and support they deserve. AffirmSpace aims to create a space
                    where community, relationships, and mental well-being are supported together in one safe digital
                    environment.
                </p>
            </div>

        </div>

    </section>
@endsection
