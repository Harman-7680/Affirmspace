@extends('layouts.seo')

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counselling – AffirmSpace</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('css')
    <style>
        /* CONTAINER */

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 60px 20px;
        }


        /* HERO */

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


        /* BUTTON */

        .hero-buttons {
            margin-top: 30px;
        }

        .btn-primary {
            background: linear-gradient(90deg, #ff4d7e, #ff7a5c);
            color: #fff;
            padding: 14px 28px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
        }


        /* IMAGE */

        .hero-image {
            display: flex;
            justify-content: end;
        }

        .hero-image img {
            width: 100%;
            max-width: 450px;
        }


        /* MIDDLE SECTION */

        .counsel-mid {
            background: #f6f0ff;
            padding: 80px 0;
            text-align: center;
        }

        .mid-grid {
            margin-top: 40px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        .mid-card {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            background: white;
            padding: 20px;
            border-radius: 14px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            text-align: left;
            transition: 0.3s;
        }

        .mid-card:hover {
            transform: translateY(-5px);
        }

        .mid-card img {
            width: 70px;
            height: 90px;
            border-radius: 12px;
            object-fit: cover;
        }

        .mid-card h3 {
            margin-bottom: 6px;
            color: #dd2476;
        }


        /* BENEFITS */

        .benefits {
            margin-top: 30px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            font-weight: 500;
        }


        /* CTA */

        .counsel-cta {
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: white;
            padding: 0px 0;
            margin: 0 20px;
            border-radius: 15px;
        }

        .cta-flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
        }

        .cta-text h2 {
            font-size: 34px;
            margin-bottom: 15px;
        }

        .cta-text p {
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .cta-image img {
            max-width: 350px;
        }


        /* BUTTON SPACING */

        .counsel-cta .btn-primary {
            margin-top: 20px;
        }


        /* RESPONSIVE */

        @media(max-width:900px) {

            .hero-flex,
            .cta-flex {
                flex-direction: column;
                text-align: center;
            }

            .mid-grid {
                grid-template-columns: 1fr;
            }

            .hero-text h1 {
                font-size: 34px;
            }

        }
    </style>
@endsection

@section('content')
    <section class="chat-hero">
        <div class="container">

            <div class="hero-grid">

                <div class="hero-text">
                    <h1>LGBTQ+ Counselling & <br><span>Mental Wellness</span></h1>

                    <p>
                        Welcome to AffirmSpace Counselling — a safe and supportive space where LGBTQ+ individuals
                        can connect with affirming counsellors.
                    </p>

                    <div class="hero-buttons">
                        <a href="#" class="btn-primary">Find a Counsellor</a>
                    </div>
                </div>

                <div class="hero-image">
                    <img src="images/counselling/Header_Image_Counselling.png" alt="Counselling">
                </div>

            </div>

        </div>
    </section>



    <section class="counsel-mid">
        <div class="container">

            <h2>Talk to Someone Who Truly Understands</h2>

            <div class="mid-grid">

                <div class="mid-card">
                    <img src="images/counselling/logo1.png">
                    <div>
                        <h3>Identity Counselling</h3>
                        <p>Explore gender identity, sexual orientation, and self-discovery with supportive guidance.</p>
                    </div>
                </div>

                <div class="mid-card">
                    <img src="images/counselling/logo2.png">
                    <div>
                        <h3>Relationship Guidance</h3>
                        <p>Discuss dating, communication, and emotional connections with LGBTQ+ affirming counsellors.</p>
                    </div>
                </div>

                <div class="mid-card">
                    <img src="images/counselling/logo3.png">
                    <div>
                        <h3>Mental Health Support</h3>
                        <p>Get help managing anxiety, stress, depression, and emotional wellbeing.</p>
                    </div>
                </div>

                <div class="mid-card">
                    <img src="images/counselling/logo4.png">
                    <div>
                        <h3>Coming Out Support</h3>
                        <p>Navigate coming out with confidence and guidance in a safe environment.</p>
                    </div>
                </div>

            </div>

            <div class="benefits">
                <span>✔ LGBTQ+ affirming professionals</span>
                <span>✔ Safe and inclusive environment</span>
                <span>✔ Completely confidential sessions</span>
            </div>

        </div>
    </section>



    <section class="counsel-cta">
        <div class="container cta-flex">

            <div class="cta-text">
                <h2>You Don’t Have to Face Things Alone</h2>
                <p>
                    Join AffirmSpace and access counselling support from professionals who understand your experiences.
                </p>

                <a href="#" class="btn-primary">Start Your Counselling Journey</a>
            </div>

            <div class="cta-image">
                <img src="images/counselling/counsellingfooter.png">
            </div>

        </div>
    </section>
@endsection
