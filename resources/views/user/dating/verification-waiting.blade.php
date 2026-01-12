@extends('layouts.app1')

@section('content')
    <div class="global-hearts" aria-hidden="true">
        <span class="heart">💖</span>
        <span class="heart">💜</span>
        <span class="heart">💙</span>
        <span class="heart">💗</span>
        <span class="heart">💞</span>
        <span class="heart">💘</span>
        <span class="heart">💖</span>
        <span class="heart">💜</span>
        <span class="heart">💙</span>
    </div>

    <div class="verify-wait-wrapper">

        <div class="verify-wait-card">

            <div class="icon-box">
                <img src="https://cdn-icons-png.flaticon.com/512/189/189792.png" class="wait-icon">
            </div>

            <h3 class="title">Your Profile Is Under Review</h3>

            <p class="subtitle">
                Thank you for submitting your photos!
                Our team is manually reviewing your profile.
            </p>

            <p class="description">
                Please wait while we verify your identity.
            </p>

            <p class="notify"><strong>You will receive an email once approved!</strong></p>
        </div>
    </div>
@endsection

@section('css')
    <style>
        /* Center everything perfectly */
        .verify-wait-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            padding: 20px;
        }

        .verify-wait-card {
            max-width: 500px;
            background: #ffffff;
            padding: 40px 35px;
            border-radius: 18px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            animation: fadeIn 0.5s ease-in-out;
        }

        .icon-box {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }

        .wait-icon {
            width: 110px;
            opacity: 0.85;
            animation: float 3s ease-in-out infinite;
        }

        .title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #6f6f6f;
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 15px;
        }

        .description {
            color: #555;
            font-size: 0.95rem;
        }

        .notify {
            margin-top: 20px;
            color: #0056d6;
            font-size: 1rem;
            font-weight: 600;
        }

        /* Smooth fade animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Floating animation for icon */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }
    </style>

    <style>
        .user-status-icon {
            position: absolute;
            left: 50%;
            bottom: -10px;
            transform: translateX(-50%);
            font-size: 16px;
        }

        /* ===== HEARTS FULL SCREEN BACKGROUND ===== */
        .global-hearts {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100vh;
            overflow: hidden;
            z-index: -1;
            pointer-events: none;
        }

        .global-hearts .heart {
            position: absolute;
            bottom: -60px;
            font-size: 40px;
            /* Increased heart size */
            opacity: 0.9;
            animation: floatUp 7s linear infinite;
        }

        /* Random positions & different speeds */
        .global-hearts .heart:nth-child(1) {
            left: 5%;
            animation-duration: 7s;
        }

        .global-hearts .heart:nth-child(2) {
            left: 18%;
            animation-duration: 8.5s;
            font-size: 45px;
            /* ↑ bigger */
        }

        .global-hearts .heart:nth-child(3) {
            left: 32%;
            animation-duration: 6.2s;
        }

        .global-hearts .heart:nth-child(4) {
            left: 48%;
            animation-duration: 7.8s;
        }

        .global-hearts .heart:nth-child(5) {
            left: 63%;
            animation-duration: 9s;
            font-size: 48px;
            /* ↑ bigger */
        }

        .global-hearts .heart:nth-child(6) {
            left: 77%;
            animation-duration: 6.4s;
        }

        .global-hearts .heart:nth-child(7) {
            left: 88%;
            animation-duration: 8s;
        }

        .global-hearts .heart:nth-child(8) {
            left: 25%;
            animation-duration: 7.3s;
            font-size: 44px;
            /* ↑ bigger */
        }

        .global-hearts .heart:nth-child(9) {
            left: 55%;
            animation-duration: 9.2s;
            font-size: 46px;
            /* ↑ bigger */
        }

        /* Floating animation */
        @keyframes floatUp {
            0% {
                transform: translateY(0) rotate(0deg) scale(1);
                opacity: 1;
            }

            50% {
                opacity: .9;
            }

            100% {
                transform: translateY(-120vh) rotate(10deg) scale(1.8);
                opacity: 0;
            }
        }
    </style>
@endsection
