<!-- TERMS CONTENT -->
<title>Terms – AffirmSpace</title>

<div class="terms-container">

    <!-- LOGO -->
    <header class="top-header">
        <a href="{{ route('/') }}" class="logo-link">
            <img src="images/welcomepage.png" alt="AffirmSpace Logo">
        </a>
    </header>

    <div class="terms-glass">

        <h1 class="terms-title">📄 Terms & Conditions</h1>

        <p class="terms-text">
            Welcome to <strong>AffirmSpace</strong> — a safe, inclusive social and counselling
            platform created especially for LGBTQ+ individuals.
            By accessing or using AffirmSpace, you agree to these Terms and Conditions.
            If you do not agree, please do not use the platform.
        </p>

        <h2>1. Eligibility</h2>
        <ul>
            <li>You must be at least <strong>18 years old</strong> to register and use AffirmSpace.</li>
        </ul>

        <h2>2. Account & Identity</h2>
        <ul>
            <li>You are responsible for maintaining the confidentiality of your login credentials.</li>
            <li>You may not impersonate others or create accounts on behalf of anyone else.</li>
        </ul>

        <h2>3. Safe Space Policy</h2>
        <ul>
            <li>
                AffirmSpace is built for LGBTQ+ safety and expression.
                Any form of harassment, hate speech, discrimination, or abuse
                will result in <strong>immediate account suspension or removal</strong>.
            </li>
        </ul>

        <h2>Acceptance</h2>
        <p class="terms-text">
            By using the platform, you confirm that you understand and accept these
            Terms & Conditions.
        </p>

    </div>
</div>

<style>
    body {
        margin: 0;
        min-height: 100vh;
        background: linear-gradient(135deg, #ff512f, #dd2476);
        font-family: 'Inter', sans-serif;
    }

    .terms-container {
        max-width: 900px;
        margin: 60px auto;
        padding: 0 20px;
    }

    /* LOGO HEADER */
    .top-header {
        position: fixed;
        top: 35px;
        left: 35px;
        z-index: 100;
    }

    .logo-link img {
        height: 80px;
        transition: transform 0.3s ease, opacity 0.3s ease;
    }

    .logo-link:hover img {
        transform: scale(1.08);
        opacity: 0.9;
    }

    /* GLASS CARD */
    .terms-glass {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(14px);
        border-radius: 24px;
        padding: 45px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
        color: #ffffff;
    }

    .terms-title {
        font-size: 2.4rem;
        font-weight: 800;
        margin-bottom: 20px;
    }

    .terms-text {
        font-size: 1rem;
        color: #ffe6ee;
        margin-bottom: 20px;
        line-height: 1.7;
    }

    .terms-glass h2 {
        margin-top: 30px;
        margin-bottom: 12px;
        font-size: 1.25rem;
        font-weight: 700;
    }

    .terms-glass ul {
        margin-left: 18px;
        margin-bottom: 15px;
    }

    .terms-glass li {
        margin-bottom: 8px;
        color: #ffd1e0;
    }

    @media (max-width: 600px) {
        .terms-glass {
            padding: 30px;
        }

        .terms-title {
            font-size: 2rem;
        }
    }
</style>
