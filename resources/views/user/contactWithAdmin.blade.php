<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
            background: linear-gradient(135deg, #ff512f, #dd2476);
            color: #ffffff;
            min-height: 100vh;
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

        /* CONTAINER */
        .container {
            max-width: 900px;
            margin: auto;
            padding: 120px 24px 80px;
        }

        .hero {
            text-align: center;
            margin-bottom: 60px;
        }

        .hero h1 {
            font-size: clamp(2.2rem, 5vw, 3.5rem);
            font-weight: 800;
        }

        .hero p {
            max-width: 600px;
            margin: 16px auto 0;
            font-size: 1.1rem;
            color: #ffe6ee;
        }

        /* GLASS CARD */
        .glass {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(14px);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
        }

        /* ALERTS */
        .alert {
            margin-bottom: 20px;
            padding: 14px;
            border-radius: 10px;
            text-align: center;
            font-weight: 600;
        }

        .alert.success {
            background: rgba(34, 197, 94, 0.2);
            border: 1px solid #22c55e;
            color: #d1fae5;
        }

        .alert.error {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid #ef4444;
            color: #fee2e2;
        }

        /* FORM */
        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            font-size: 14px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 14px;
            border-radius: 10px;
            border: none;
            outline: none;
            font-size: 14px;
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: #fbd5e1;
        }

        .form-group small {
            color: #ffd1d1;
            font-size: 12px;
        }

        /* BUTTON */
        .btn-submit {
            width: 100%;
            padding: 16px;
            border-radius: 999px;
            background: #0f0f1a;
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: transform 0.3s ease, background 0.3s ease;
        }

        .btn-submit:hover {
            background: #000;
            transform: scale(1.03);
        }

        footer {
            text-align: center;
            margin-top: 80px;
            font-size: 0.85rem;
            color: #ffd1e0;
        }

        @media (max-width: 600px) {
            .glass {
                padding: 28px;
            }

            .top-header {
                top: 20px;
                left: 20px;
            }

            .logo-link img {
                height: 60px;
            }
        }
    </style>
</head>

<body>

    <!-- LOGO -->
    <header class="top-header">
        <a href="{{ route('/') }}" class="logo-link">
            <img src="images/welcomepage.png" alt="AffirmSpace Logo">
        </a>
    </header>

    <div class="container">

        <section class="hero">
            <h1>Contact Us</h1>
            <p>Have a question or need help? We’re here for you.</p>
        </section>

        <section class="glass">

            <!-- FLASH -->
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
        </section>

        <footer>
            © 2026 AffirmSpace. Built with pride, safety, and purpose 🌈
        </footer>

    </div>

</body>

</html>
