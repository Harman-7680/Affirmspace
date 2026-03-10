<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us – AffirmSpace</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

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
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            color: #555;
        }

        .contact-wrapper {
            background: #ffffff;
        }

        .contact-card {
            max-width: 700px;
            margin: 50px auto 0;
            background: #f9fafb;
            padding: 40px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .alert {
            margin-bottom: 20px;
            padding: 14px;
            border-radius: 10px;
            text-align: center;
            font-weight: 600;
            font-size: 14px;
        }

        .alert.success {
            background: #e6fffa;
            color: #047857;
            border: 1px solid #10b981;
        }

        .alert.error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 14px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 14px;
            border-radius: 10px;
            border: 1px solid #ddd;
            font-size: 14px;
            outline: none;
            transition: border 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #dd2476;
        }

        .form-group small {
            color: #dc2626;
            font-size: 12px;
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            border-radius: 30px;
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: white;
            font-size: 16px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .btn-submit:hover {
            transform: scale(1.02);
            opacity: 0.9;
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

            .contact-card {
                padding: 28px;
            }
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header>
        <a href="/" class="logo">
            <img src="images/welcomepage.png" alt="AffirmSpace Logo">
            <span>AffirmSpace</span>
        </a>

        <a href="/register" class="nav-btn">Get Started</a>
    </header>

    <!-- Hero -->
    <section>
        <h2>Contact Us</h2>
        <p>
            Have a question, feedback, or need support? Our team is here to help you.
            We aim to respond as quickly as possible.
        </p>
    </section>

    <!-- Contact Form -->
    <section class="contact-wrapper">

        <div class="contact-card">

            @if (session('success'))
                <div class="alert success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert error">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('AdminSend') }}">
                @csrf

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}">
                    @error('name')
                        <small>{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}">
                    @error('email')
                        <small>{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" name="subject" value="{{ old('subject') }}">
                    @error('subject')
                        <small>{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Message</label>
                    <textarea name="message" rows="5">{{ old('message') }}</textarea>
                    @error('message')
                        <small>{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">
                    Send Message
                </button>

            </form>

        </div>

    </section>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-links">
            <a href="/aboutUs">About Us</a>
            <a href="/privacy">Privacy Policy</a>
            <a href="/refundPolicy">Refund</a>
            <a href="/terms">Terms & Conditions</a>
            <a href="/contactWithAdmin">Contact</a>
        </div>

        <p class="footer-copy">
            © 2026 AffirmSpace. All rights reserved.
        </p>
    </footer>

</body>

</html>