@extends('layouts.seo')

@section('meta')
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AffirmSpace</title>
    <meta name="description"
        content="AffirmSpace is a safe LGBTQ+ platform for dating, community, anonymous chats, local events, and discovering trusted gender-affirming healthcare providers." />

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
@endsection

@section('css')
    <style>
        .parallax-hero {
            position: relative;
            height: 85vh;
            min-height: 620px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }

        .fixed-bg-layer {
            position: absolute;
            inset: 0;
            background-attachment: fixed;
            background-position: center;
            background-size: cover;
            pointer-events: none;
            transition: opacity 2s ease-in-out;
        }

        .parallax-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.48);
            z-index: 1;
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 900px;
            padding: 0 5%;
        }

        .hero-text h1 {
            font-size: 2.8rem;
            margin-bottom: 20px;
            text-shadow: 0 3px 12px rgba(0, 0, 0, 0.7);
        }

        .hero-text p {
            font-size: 1.1rem;
            margin-bottom: 35px;
            max-width: 720px;
            margin-left: auto;
            margin-right: auto;
            color: #f0f0f0;
            text-shadow: 0 1px 6px rgba(0, 0, 0, 0.6);
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .primary-btn,
        .secondary-btn {
            padding: 14px 34px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
        }

        .primary-btn {
            color: white;
            background: linear-gradient(90deg, #ff512f, #dd2476);
        }

        .secondary-btn {
            color: #dd2476;
            border: 2px solid #dd2476;
        }

        .identity {
            position: relative;
            padding: 80px 8%;
            text-align: center;
            color: white;
            overflow: hidden;
        }

        .identity-bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            z-index: 0;
        }

        /* dark overlay for readability */

        .identity::after {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            z-index: 1;
        }

        .identity-content {
            position: relative;
            z-index: 2;
            max-width: 900px;
            margin: auto;
        }

        .identity p {
            color: #f0f0f0;
        }

        .identity-points {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            font-weight: 500;
        }

        .identity-points div {
            background: rgba(255, 255, 255, 0.15);
            padding: 10px 18px;
            border-radius: 30px;
        }

        /* mobile fix */

        @media(max-width:1024px) {
            .identity-bg {
                background-attachment: scroll;
            }
        }

        /* Mobile – disable fixed background (required) */
        @media (max-width: 1024px) {
            .fixed-bg-layer {
                background-attachment: scroll !important;
            }

            .parallax-hero {
                height: 70vh;
                min-height: 900px;
            }

            .hero-text h1 {
                font-size: 2.2rem;
            }

            .hero-text p {
                font-size: 1rem;
            }
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
            max-width: 850px;
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
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;
        }

        .feature-card {
            background: #f9fafb;
            padding: 28px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .feature-card h3 {
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .disclaimer {
            margin-top: 35px;
            font-size: 0.85rem;
            text-align: center;
            color: #666;
        }

        .trust {
            background: #f9fafb;
            text-align: center;
        }

        .trust ul {
            list-style: none;
            margin-top: 25px;
        }

        .trust li {
            margin: 10px 0;
            font-weight: 500;
        }

        .how-it-works {
            padding: 80px 8%;
            background: #f9fafb;
        }

        .section-desc {
            max-width: 850px;
            margin: auto;
            text-align: center;
            color: #555;
            margin-bottom: 50px;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;
        }

        .step-card {
            background: #ffffff;
            padding: 28px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .step-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.08);
        }

        .faq-section {
            padding: 80px 8%;
            background: #f9fafb;
        }

        .faq-description {
            max-width: 820px;
            margin: auto;
            text-align: center;
            color: #555;
            margin-bottom: 50px;
        }

        .faq-container {
            max-width: 900px;
            margin: auto;
        }

        .faq-item {
            background: #ffffff;
            border-radius: 16px;
            margin-bottom: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all .25s ease;
        }

        .faq-item:hover {
            border-left: 4px solid #ff512f;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        }

        /* QUESTION BUTTON */

        .faq-question {
            width: 100%;
            text-align: left;
            padding: 20px 24px;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            background: none;
            cursor: pointer;
            transition: all .25s ease;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* + icon */

        .faq-question::after {
            content: "+";
            font-size: 24px;
            font-weight: 700;
            color: #dd2476;
            transition: transform .25s ease;
        }

        /* when open */

        .faq-question.active::after {
            content: "−";
        }

        /* hover gradient */

        .faq-question:hover {
            background: linear-gradient(90deg, #ff512f, #dd2476);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* ANSWER */

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height .35s ease;
            padding: 0 24px;
        }

        .faq-answer p {
            padding-bottom: 20px;
            color: #555;
            font-size: .95rem;
            line-height: 1.6;
        }

        .cta {
            text-align: center;
            background: #ffffff;
        }

        .cta p {
            margin-bottom: 30px;
        }

        #splash-screen {
            position: fixed;
            inset: 0;
            background-color: #dafaf8ff;
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: white;
            font-size: 2rem;
            z-index: 9999;
            opacity: 1;
            transition: opacity 0.5s ease;
        }

        #splash-screen img {
            width: 150px;
            margin-bottom: 20px;
            animation: pulse 1s infinite;
        }

        @keyframes pulse {

            0%,
            50%,
            100% {
                transform: scale(1);
            }

            25%,
            75% {
                transform: scale(1.3);
            }
        }
    </style>
@endsection

@section('content')
    <!-- Splash screen -->
    <div id="splash-screen">
        <img src="images/welcomepage.png" alt="AffirmSpace">
    </div>

    <!-- HERO SECTION – images stay fixed on desktop, smooth fade -->
    <section class="parallax-hero">
        <div class="fixed-bg-layer" id="bgLayer1" style="background-image: url('images/header1.png'); opacity: 1;">
        </div>
        <div class="fixed-bg-layer" id="bgLayer2" style="background-image: url('images/Consultant.png'); opacity: 0;">
        </div>
        <div class="parallax-overlay"></div>

        <div class="hero-content">
            <div class="hero-text">
                <h1>AffirmSpace – A Safe LGBTQ+ Social Network for Dating, Community, Events & Gender-Affirming
                    Healthcare</h1>
                <p>
                    AffirmSpace is an all-in-one LGBTQ+ social network designed to help people connect, date, share
                    experiences, join anonymous support groups, discover LGBTQ+ events, and access trusted
                    gender-affirming healthcare providers in a safe and inclusive digital community.
                </p>
                <div class="hero-buttons">
                    <a href="{{ 'register' }}?role=0" class="primary-btn">User</a>
                    <a href="{{ 'register' }}?role=1" class="secondary-btn">Doctor</a>
                </div>
            </div>
        </div>
    </section>

    <section>
        <h2>What is AffirmSpace?</h2>
        <p>
            AffirmSpace is an LGBTQ+ social networking and community platform where people can connect, build
            relationships, join support groups, discover LGBTQ+ events, and access gender-affirming healthcare resources
            in a safe and inclusive space.
        </p>
    </section>

    <section class="features">
        <h2>Everything You Need in One Safe LGBTQ+ Community Platform </h2>
        <div class="feature-grid">
            <div class="feature-card">
                <h3>💖 LGBTQ+ Dating</h3>
                <p>Find meaningful LGBTQ+ relationships in a safe and respectful environment. AffirmSpace helps
                    individuals explore LGBTQ+ dating, queer friendships, and authentic connections without fear,
                    discrimination, or judgment.</p>
            </div>
            <div class="feature-card">
                <h3>🌈 LGBTQ+ Community & Social Sharing</h3>
                <p>Join an active LGBTQ+ online community where you can share stories, post updates, and interact with
                    people who understand your experiences. Build connections through inclusive social networking for
                    LGBTQ+ individuals.</p>
            </div>
            <div class="feature-card">
                <h3>👥 Anonymous LGBTQ+ Chat Groups</h3>
                <p>Participate in anonymous LGBTQ+ support chats where you can talk freely, ask questions, and share
                    experiences without revealing your identity. A safe place for open discussions, advice, and peer
                    support.</p>
            </div>
            <div class="feature-card">
                <h3>📍 LGBTQ+ Events Near You</h3>
                <p>Discover LGBTQ+ events, pride parades, meetups, workshops, and queer safe spaces happening around
                    you. Stay connected with the global and local LGBTQ+ community through curated events.</p>
            </div>
            <div class="feature-card">
                <h3>🧠 LGBTQ+ Mental & Emotional Wellbeing</h3>
                <p>Access LGBTQ+ friendly counselors, mental health resources, and emotional support services designed
                    to help individuals navigate identity, relationships, and personal wellbeing.</p>
            </div>
            <div class="feature-card">
                <h3>🧬 Hormone Therapy & HRT Discovery</h3>
                <p>Find verified professionals offering hormone replacement therapy (HRT) for transgender individuals,
                    including endocrinologists and gender-affirming healthcare providers.</p>
            </div>
            <div class="feature-card">
                <h3>🩺 Gender-Affirming Care Specialists</h3>
                <p>Discover doctors experienced in gender-affirming healthcare, transgender support, and
                    transition-related medical care.</p>
            </div>
            <div class="feature-card">
                <h3>✨ Gender-Affirming Surgeries</h3>
                <p>Explore trusted surgeons offering gender-affirming surgeries, facial feminization surgery (FFS), and
                    other transgender medical procedures.</p>
            </div>
        </div>
        <p class="disclaimer">
            AffirmSpace does not provide medical advice. Our platform helps users discover verified LGBTQ+ friendly
            professionals, mental health support resources, and trusted gender-affirming healthcare providers.
        </p>
    </section>


    <section class="identity">

        <div class="identity-bg" style="background-image:url('images/beyou.jpg');"></div>

        <div class="identity-content">
            <h2>Be Yourself — On Your Terms</h2>
            <p>
                Whether you choose to be visible or anonymous, AffirmSpace gives LGBTQ+ individuals complete control
                over
                their identity, privacy, and self-expression. Our platform is designed to create a safe LGBTQ+ online
                community where everyone can connect, share experiences, and feel respected.
            </p>

            <div class="identity-points">
                <div>✔ Optional anonymity</div>
                <div>✔ Pronoun & identity controls</div>
                <div>✔ No forced labels</div>
                <div>✔ Zero tolerance for harassment</div>
            </div>
        </div>

    </section>

    <section class="trust">
        <h2>Built on Safety, Privacy & Trust</h2>
        <ul>
            <li>✔ Moderated LGBTQ+ inclusive community platform </li>
            <li>✔ Privacy-first design to protect user identity </li>
            <li>✔ Verified gender-affirming healthcare discovery</li>
            <li>✔ A culture built on respect, consent, and dignity</li>
        </ul>
    </section>

    <section class="how-it-works"
        style="background: url(images/how_it_work.jpeg) 
      no-repeat center center;
      background-size: cover;
      min-height: 100vh;">
        <h2>How AffirmSpace Works</h2>

        <p class="section-desc">
            AffirmSpace is a safe LGBTQ+ social networking platform designed to help people connect, build
            relationships, and discover supportive resources. Follow these simple steps to start exploring the LGBTQ+
            community, dating, events, and gender-affirming support.
        </p>

        <div class="steps-grid">

            <div class="step-card">
                <h3>1️⃣ Create Your LGBTQ+ Profile</h3>
                <p>
                    Sign up and build your profile with pronouns, identity options, and privacy controls designed
                    specifically for the LGBTQ+ community.
                </p>
            </div>

            <div class="step-card">
                <h3>2️⃣ Connect With the LGBTQ+ Community</h3>
                <p>
                    Meet like-minded people, explore LGBTQ+ dating, and engage with a supportive online queer community
                    through posts, discussions, and interactions.
                </p>
            </div>

            <div class="step-card">
                <h3>3️⃣ Join Chat Groups & Community Discussions</h3>
                <p>
                    Participate in anonymous LGBTQ+ chat groups and support communities where users can share
                    experiences, ask questions, and find peer support.
                </p>
            </div>

            <div class="step-card">
                <h3>4️⃣ Access Professional LGBTQ+ Consultancy</h3>
                <p>
                    Connect with trained LGBTQ+ counselors, consultants, and support professionals who can provide
                    guidance on identity, relationships, mental wellbeing, and gender-affirming care.
                </p>
            </div>

            <div class="step-card">
                <h3>5️⃣ Discover Events & Trusted Resources</h3>
                <p>
                    Explore LGBTQ+ events, pride meetups, support groups, and verified gender-affirming healthcare
                    providers recommended within the community.
                </p>
            </div>

            <div class="step-card">
                <h3>6️⃣ Safe & Private Platform </h3>
                <p>
                    AffirmSpace prioritizes user safety with privacy controls, respectful community guidelines, and
                    secure communication features designed for the LGBTQ+ community.
                </p>
            </div>

        </div>
    </section>

    <section class="faq-section">

        <h2>Frequently Asked Questions About AffirmSpace</h2>

        <p class="faq-description">
            Learn more about AffirmSpace, the LGBTQ+ social network designed for connection, safety, and community
            support.
        </p>

        <div class="faq-container">

            <div class="faq-item">
                <button class="faq-question">
                    Is AffirmSpace a dating platform?
                </button>
                <div class="faq-answer">
                    <p>
                        AffirmSpace is an LGBTQ+ social networking and dating platform where users can connect, build
                        relationships, join discussions, and interact with a supportive LGBTQ+ community.
                    </p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    Is AffirmSpace safe for LGBTQ+ users?
                </button>
                <div class="faq-answer">
                    <p>
                        Yes. AffirmSpace is built as a safe LGBTQ+ online space with moderation tools, privacy-first
                        features, and clear community guidelines to ensure respectful interactions.
                    </p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    Can I stay anonymous on AffirmSpace?
                </button>
                <div class="faq-answer">
                    <p>
                        Yes. AffirmSpace allows optional anonymity, giving users control over their identity and privacy
                        while participating in anonymous chat groups and LGBTQ+ discussions.
                    </p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    Does AffirmSpace provide healthcare services?
                </button>
                <div class="faq-answer">
                    <p>
                        No. AffirmSpace does not provide medical advice. The platform helps users discover verified
                        gender-affirming healthcare providers, hormone therapy specialists, and LGBTQ+ friendly
                        counselors.
                    </p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    Who can join AffirmSpace?
                </button>
                <div class="faq-answer">
                    <p>
                        AffirmSpace welcomes LGBTQ+ individuals and allies looking for a safe space to connect, build
                        relationships, find support, and participate in community events.
                    </p>
                </div>
            </div>

        </div>

    </section>

    <section class="cta">
        <h2>Join a Safe LGBTQ+ Social Network Where You Truly Belong</h2>
        <p>
            Connect with the LGBTQ+ community, build meaningful relationships, explore your identity, and attend
            inclusive events in a safe and supportive space.
        </p>

        <a href="{{ 'login' }}" class="primary-btn">Join the LGBTQ+ Community</a>
    </section>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const splash = document.getElementById('splash-screen');
            if (!sessionStorage.getItem('flashShown')) {
                splash.style.display = 'flex';
                setTimeout(() => {
                    splash.style.opacity = '0';
                    setTimeout(() => {
                        splash.style.display = 'none';
                    }, 500);
                }, 1000);
                sessionStorage.setItem('flashShown', 'true');
            }
        });

        document.addEventListener('DOMContentLoaded', () => {

            // Smooth image crossfade
            const layer1 = document.getElementById('bgLayer1');
            const layer2 = document.getElementById('bgLayer2');
            let showLayer1 = true;

            setInterval(() => {
                if (showLayer1) {
                    layer1.style.opacity = '0';
                    layer2.style.opacity = '1';
                } else {
                    layer1.style.opacity = '1';
                    layer2.style.opacity = '0';
                }
                showLayer1 = !showLayer1;
            }, 7000); // change every 7 seconds – fade takes 2 seconds
        });
    </script>

    <script>
        document.querySelectorAll(".faq-question").forEach((question) => {

            question.addEventListener("click", () => {

                const answer = question.nextElementSibling;

                /* toggle + / - icon */

                question.classList.toggle("active");

                /* open / close answer */

                if (answer.style.maxHeight) {
                    answer.style.maxHeight = null;
                } else {
                    answer.style.maxHeight = answer.scrollHeight + "px";
                }

            });

        });
    </script>
@endsection
