@extends('layouts.seo')

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us – AffirmSpace</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('css')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f9fafb;
            color: #222;
            line-height: 1.6;
        }

        header {
            background: #ffffff;
            padding: 20px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #222;
            font-size: 1.6rem;
            font-weight: 700;
        }

        .logo img {
            width: 42px;
            height: 42px;
            object-fit: contain;
        }

        .nav-btn {
            padding: 10px 24px;
            border-radius: 30px;
            text-decoration: none;
            color: white;
            font-weight: 600;
            background: linear-gradient(90deg, #ff512f, #dd2476);
        }

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

        .site-footer {
            background: #ffffff;
            padding: 35px 8%;
            border-top: 1px solid #eee;
            text-align: center;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .footer-links a {
            text-decoration: none;
            font-size: 0.95rem;
            color: #555;
            font-weight: 500;
        }

        .footer-links a:hover {
            color: #dd2476;
        }

        .footer-copy {
            font-size: 0.85rem;
            color: #777;
        }

        @media(max-width: 900px) {
            section {
                padding: 60px 6%;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section>
        <h2>More Than a Dating Platform 🌈</h2>
        <p>
            AffirmSpace is a global LGBTQ+ community, gay chat platform, and
            counselling ecosystem built for connection, safety, and genuine understanding.
            We are not just another gay dating website — we are a space where identity is respected
            and conversations go beyond surface-level attraction.
        </p>
    </section>

    <!-- About Content -->
    <section class="features">
        <div class="feature-grid">

            <div class="feature-card">
                <h3>1. A Safe LGBTQ+ Community</h3>
                <p>
                    AffirmSpace was created to provide a secure space for the LGBTQ+ community —
                    including gay, lesbian, bisexual, transgender, non-binary, and questioning individuals.
                    We prioritize safety, moderation, and respectful interaction.
                </p>
            </div>

            <div class="feature-card">
                <h3>2. Meaningful Gay Chat & Connections</h3>
                <p>
                    Whether you're looking for free gay chat, private conversations,
                    friendships, or long-term relationships, our platform helps you meet people
                    in a safe and inclusive environment.
                </p>
            </div>

            <div class="feature-card">
                <h3>3. Beyond Traditional Gay Dating Apps</h3>
                <p>
                    Unlike many gay dating apps focused only on swiping,
                    AffirmSpace encourages authentic conversations, comfort, and respect.
                    We believe connection should be built on understanding — not pressure.
                </p>
            </div>

            <div class="feature-card">
                <h3>4. Built-In Counselling Support</h3>
                <p>
                    AffirmSpace integrates professional and intern counselling support
                    directly into the platform. Users can access emotional guidance,
                    relationship advice, and safe discussions when needed.
                </p>
            </div>

            <div class="feature-card">
                <h3>5. Identity & Pronoun Respect</h3>
                <p>
                    We empower users to express their true identity through customizable
                    profiles, pronoun selection, and inclusive profile options.
                    Everyone deserves to feel seen and respected.
                </p>
            </div>

            <div class="feature-card">
                <h3>6. Our Vision</h3>
                <p>
                    Our mission is to build a trusted global LGBTQ+ social platform
                    that combines dating, community, and mental well-being —
                    creating a digital space where people can truly belong.
                </p>
            </div>

        </div>

        <p class="disclaimer">
            Come as you are — Stay because you feel understood 💜
        </p>
    </section>
@endsection
