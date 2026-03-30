@extends('layouts.seo')

@section('meta')
    <meta name="description"
        content="Discover LGBTQ+ events, meetups, and community gatherings. Connect with people, share experiences, and join safe, inclusive events near you or online.">
    <title>LGBTQ+ Events & Meetups Near You | AffirmSpace</title>
    <meta name="author" content="AffirmSpace">

    <meta name="keywords"
        content="LGBTQ+ events, find LGBTQ+ events near you, online LGBTQ+ events platform, LGBTQ+ meetups, LGBTQ+ community events">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('css')
    <style>
        .container {
            max-width: 1200px;
            margin: auto;
            /* padding: 60px 20px; */
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

        /* BUTTONS */

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


        /* TAGS */

        .hero-tags {
            margin-top: 20px;
            display: flex;
            gap: 20px;
            font-size: 14px;
            color: #777;
        }


        /* IMAGE */

        .hero-image img {
            width: 100%;
            max-width: 575px;
        }

        /* WAVE */

        .hero-wave {
            position: absolute;
            bottom: -1px;
            width: 100%;
            height: 120px;
            background: white;
            border-top-left-radius: 60% 100%;
            border-top-right-radius: 60% 100%;
        }


        /* CENTER SECTION */

        .events-empty {
            background: #f6f0ff;
            text-align: center;
            padding: 80px 0;
        }

        .events-empty h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .subtitle {
            max-width: 650px;
            margin: auto;
            margin-bottom: 40px;
        }


        /* CARDS (IMPORTANT PART — matches your image) */

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .event-card {
            background: white;
            padding: 25px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            text-align: center;
            transition: 0.3s;
        }

        .event-card:hover {
            transform: translateY(-6px);
        }

        .event-card img {
            width: 100px;
            margin-bottom: 15px;
        }

        .event-card h3 {
            margin-bottom: 10px;
        }

        .event-card p {
            font-size: 14px;
            margin-bottom: 15px;
        }


        /* BUTTON COLORS LIKE IMAGE */

        .btn-orange {
            background: linear-gradient(90deg, #ff7a18, #ffb347);
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            text-decoration: none;
            display: inline-block;
        }

        .cards-grid .event-card:nth-child(1) a {
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: white;
        }

        .btn-purple {
            background: linear-gradient(90deg, #a18cd1, #fbc2eb);
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            text-decoration: none;
            display: inline-block;
        }


        /* NOTE TEXT */

        .note {
            margin-top: 30px;
            font-size: 14px;
            color: #666;
        }


        /* CTA SECTION (BOTTOM BANNER STYLE) */

        .events-cta {
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: white;
            /* padding:10px 0; */
            margin: 60px 20px;
            border-radius: 20px;
        }

        .cta-flex {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            /* NOT center */
            gap: 80px;
            height: 350px;
            padding-left: 60px;
            /* pushes slightly right */
        }

        .cta-text {
            max-width: 520px;
        }

        .cta-text h2 {
            font-size: 30px;
            margin-bottom: 10px;
        }

        .cta-text p {
            margin-bottom: 15px;
        }

        .cta-text ul {
            list-style: none;
            padding: 0;
            margin: 15px 0;
        }

        .cta-text li {
            margin-bottom: 8px;
        }


        /* RESPONSIVE */

        @media(max-width:900px) {

            .hero-flex,
            .cta-flex {
                flex-direction: column;
                text-align: center;
            }

            .cards-grid {
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
                    <h1>LGBTQ+ Community Events <br> <span>& Online Meetups</span></h1>

                    <p>
                        Join LGBTQ+ events, meetups, workshops, and community gatherings to connect,
                        learn, and celebrate your identity.
                    </p>

                    <div class="hero-buttons">
                        <a href="{{ 'register' }}?role=0" class="btn-primary">Explore Events</a>
                        <a href="{{ 'login' }}" class="btn-outline">Host an Event</a>
                    </div>

                    <div class="hero-tags">
                        <span>✔ Safe & Inclusive</span>
                        <span>✔ Community Driven</span>
                        <span>✔ Online & Offline</span>
                    </div>
                </div>

                <div class="hero-image">
                    <img src="{{ asset('images/events/eventop.png') }}"
                        alt="LGBTQ community celebrating pride with rainbow flag at festival.">
                </div>

            </div>
        </div>
    </section>

    <section class="events-empty">
        <div class="container">

            <h2>No Events Yet, But There's More to Explore!</h2>

            <p class="subtitle">
                While events are being added, you can still connect with the LGBTQ+ community,
                read helpful resources, and find support through AffirmSpace.
            </p>


            <div class="cards-grid">

                <div class="event-card">
                    <img src="{{ asset('images/events/e1.png') }}"
                        alt="People inside heart icon showing community gathering and support.">
                    <h3>Read Helpful Articles</h3>
                    <p>
                        Learn more about mental health, relationships, identity, and personal growth.
                    </p>
                    <a href="{{ route('blogs') }}" class="btn-orange">Browse Articles →</a>
                </div>


                <div class="event-card">
                    <img src="{{ asset('images/events/e2.png') }}"
                        alt="Woman using laptop reading content with notes and light bulb.">
                    <h3>Connect in the Community</h3>
                    <p>
                        Engage in LGBTQ+ discussions and meet amazing people.
                    </p>
                    <a href="{{ route('chat') }}" class="btn-orange">Join Chat →</a>
                </div>


                <div class="event-card">
                    <img src="{{ asset('images/events/e3.png') }}"
                        alt="Two people talking during support session with conversation bubble.">
                    <h3>Find Support Resources</h3>
                    <p>
                        Get guidance from LGBTQ+ friendly professionals.
                    </p>
                    <a href="{{ route('counselling') }}" class="btn-purple">Find Support →</a>
                </div>

            </div>

            <p class="note">
                No events happening right now. Your voice matters — together we will build amazing LGBTQ+ community
                experiences.
            </p>

        </div>
    </section>

    <section class="events-cta">
        <div class="container cta-flex">

            <div class="cta-text">
                <h2>Be Part of the Community</h2>

                <p>
                    Discover experiences that inspire, connect, and empower the LGBTQ+ community.
                </p>

                <ul>
                    <li>✔ Meet New People</li>
                    <li>✔ Build Friendships</li>
                    <li>✔ Celebrate Diversity</li>
                </ul>
                <div>
                    <a href="{{ 'register' }}?role=0" class="btn-primary">Explore Events Now →</a>
                </div>
            </div>

            <div class="cta-image">
                <img src="{{ asset('images/events/eventfooter.png') }}"
                    alt="Calendar with star icon and rocket launching beside it.">
            </div>

        </div>
    </section>
@endsection
