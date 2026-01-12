<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About Us – AffirmSpace</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #ff512f, #dd2476);
            color: #ffffff;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 80px 24px;
        }

        .hero {
            text-align: center;
            margin-bottom: 100px;
        }

        .hero h1 {
            color: white;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
        }

        .hero p {
            max-width: 760px;
            margin: 24px auto 0;
            font-size: 1.2rem;
            color: #ffe6ee;
        }

        .glass {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(14px);
            border-radius: 24px;
            padding: 48px;
            margin-bottom: 48px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
        }

        .section-title {
            font-size: 2rem;
            margin-bottom: 16px;
            font-weight: 700;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 32px;
            margin-top: 32px;
        }

        .card {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.12), rgba(255, 255, 255, 0.04));
            border-radius: 20px;
            padding: 32px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 24px 50px rgba(0, 0, 0, 0.35);
        }

        .card h3 {
            margin-bottom: 12px;
            font-size: 1.3rem;
        }

        .card p {
            color: #ffe1ec;
            font-size: 0.95rem;
        }

        .cta {
            text-align: center;
            padding: 80px 24px;
            background: linear-gradient(135deg, #ff512f, #dd2476);
            border-radius: 32px;
            margin-top: 80px;
        }

        .cta h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 16px;
        }

        .cta p {
            font-size: 1.1rem;
            margin-bottom: 32px;
        }

        .cta a {
            display: inline-block;
            padding: 14px 36px;
            border-radius: 999px;
            background: #0f0f1a;
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .cta a:hover {
            background: #000000;
            transform: scale(1.05);
        }

        footer {
            text-align: center;
            margin-top: 80px;
            font-size: 0.85rem;
            color: #ffd1e0;
        }

        .top-header {
            position: fixed;
            top: 35px;
            left: 35px;
            z-index: 100;
        }

        .logo-link img {
            height: 88px;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .logo-link:hover img {
            transform: scale(1.08);
            opacity: 0.9;
        }
    </style>
</head>

<body>
    <header class="top-header">
        <a href="{{ route('login') }}" class="logo-link">
            <img src="images/welcomepage.png" alt="AffirmSpace Logo">
        </a>
    </header>

    <div class="container">
        <section class="hero">
            <h1>We’re Building a Safer Digital Home</h1>
            <p>
                AffirmSpace is a next-generation social and mental wellness platform designed
                for the LGBTQ+ community — where identity is respected, voices are protected,
                and support is always within reach.
            </p>
        </section>

        <section class="glass">
            <h2 class="section-title">Why AffirmSpace Exists</h2>
            <p>
                The internet wasn’t built with queer safety in mind. Harassment, misgendering,
                discrimination, and isolation are everyday realities for millions. AffirmSpace
                was created to change that.
                <br><br>
                We believe everyone deserves a space where they can express themselves freely,
                connect authentically, and access real mental health support — without fear.
            </p>
        </section>

        <section class="glass">
            <h2 class="section-title">What Makes Us Different</h2>
            <div class="grid">
                <div class="card">
                    <h3>Identity-First Design</h3>
                    <p>Pronouns, gender identity, and self-expression are core — not optional.</p>
                </div>
                <div class="card">
                    <h3>Built-In Counseling</h3>
                    <p>Access verified counselors and trained interns in a safe, private space.</p>
                </div>
                <div class="card">
                    <h3>Safety Over Virality</h3>
                    <p>Paid access and moderation-first systems to reduce trolling and abuse.</p>
                </div>
                <div class="card">
                    <h3>Community Without Fear</h3>
                    <p>No hate speech. No harassment. Just real people and real connections.</p>
                </div>
            </div>
        </section>

        <section class="glass">
            <h2 class="section-title">Our Mission</h2>
            <p>
                To empower LGBTQ+ individuals globally by providing a digital ecosystem
                that combines community, creativity, and mental health — all rooted in dignity,
                privacy, and respect.
            </p>
        </section>

        {{-- <section class="cta">
            <h2>You Belong Here 🌈</h2>
            <p>Join a platform where your identity is affirmed — always.</p>
            <a href="#">Join AffirmSpace</a>
        </section> --}}

        <footer>
            © 2025 AffirmSpace. Built with pride, safety, and purpose. 🌈
        </footer>
    </div>
</body>

</html>
