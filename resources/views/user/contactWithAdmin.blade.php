@extends('layouts.seo')

@section('meta')
    <meta name="description"
        content="Contact AffirmSpace for help with our LGBTQ+ platform, community, dating, and mental health counselling support services.">
    <title>Contact AffirmSpace – LGBTQ+ Support & Help Center</title>
    <meta name="author" content="AffirmSpace">

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

        .contact-parallax {
            position: relative;
            padding: 120px 8%;
            text-align: center;
            color: white;
            overflow: hidden;
        }

        /* IMAGE */

        .contact-img {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            object-fit: cover;
            z-index: -2;
        }

        /* OVERLAY */

        .contact-parallax::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            z-index: -1;
        }

        /* TEXT */

        .contact-content {
            max-width: 850px;
            margin: auto;
        }

        .contact-content h2 {
            font-size: 2.2rem;
            margin-bottom: 15px;
        }

        .contact-content p {
            color: #f0f0f0;
            font-size: 1.05rem;
            line-height: 1.7;
        }

        /* MOBILE FIX */

        @media(max-width:1024px) {

            .contact-img {
                position: absolute;
                height: 100%;
            }

            .contact-parallax {
                padding: 100px 8%;
            }

        }
    </style>
@endsection

@section('content')
    <!-- Hero -->
    <section class="contact-parallax">

        <img src="images/coursel.png" class="contact-img"
            alt="LGBTQ community celebrating pride with rainbow flags and joy">

        <div class="contact-content">
            <h2>Contact Us</h2>

            <p>
                Have a question, feedback, or need support? Our team is here to help you.
                We aim to respond as quickly as possible.
            </p>
        </div>

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
@endsection
