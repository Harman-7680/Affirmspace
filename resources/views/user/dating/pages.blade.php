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

    <div class="page-wrapper flex justify-center items-center px-4 py-10">
        <div class="card w-full max-w-xl p-8 rounded-2xl shadow-xl bg-white/95 backdrop-blur-xl border border-gray-200">

            <div class="welcome-block active text-center">

                <h1 class="text-4xl font-extrabold text-pink-600 mb-4 drop-shadow-sm">
                    ❤️ Welcome to AffirmSpace Dating
                </h1>

                <p class="text-gray-600 text-lg leading-relaxed mb-6">
                    A safe, warm, and inclusive place where every identity is respected
                    and every connection is celebrated.
                    <br><br>
                    Let’s understand you better so we can help you find meaningful matches.
                </p>

                <button id="startBtn" class="start-btn mt-4">
                    Start Now →
                </button>
            </div>

            <form id="tinderForm" action="{{ route('user.save-details') }}" method="POST">
                @csrf

                {{-- QUESTION 1 --}}
                <div class="q-block hidden">
                    <h2 class="q-title">We fetch your identity..</h2>
                    <p class="sub-text">We proudly welcome all identities</p>

                    <div class="static-box">
                        {{ $user->gender }}
                    </div>

                    <input type="hidden" name="gender" value="{{ $user->gender }}">
                </div>

                {{-- QUESTION 2 --}}
                <div class="q-block hidden">
                    <h2 class="q-title">Who are you interested in connecting with?</h2>
                    <p class="sub-text">Choose the gender identity you naturally feel drawn to.</p>

                    <select name="preference" class="f-input" required>
                        <option value="" disabled selected>Select</option>
                        @foreach (['Man', 'Woman', 'Trans Woman', 'Trans Man', 'Non-binary', 'Genderqueer', 'Agender', 'Bigender', 'Genderfluid', 'Two-Spirit', 'Intersex', 'Questioning', 'Prefer not to say'] as $item)
                            <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                    <p class="text-red-600 text-xs mt-1 hidden">This field is required.</p>
                </div>

                {{-- QUESTION 3 --}}
                <div class="q-block hidden">
                    <h2 class="q-title">What type of vibe are you looking for?</h2>
                    <p class="sub-text">Choose the connection that feels right today.</p>

                    <select name="relationship_type" class="f-input" required>
                        <option value="" disabled selected>Select</option>
                        @foreach (['Long Term', 'Short Term', 'One Day Meetup', 'Friendship', 'Marriage', 'Soul Connection'] as $item)
                            <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                    <p class="text-red-600 text-xs mt-1 hidden">This field is required.</p>
                </div>

                {{-- QUESTION 4 --}}
                <div class="q-block hidden">
                    <h2 class="q-title">What kind of energy do you enjoy?</h2>
                    <p class="sub-text">Let people know what makes you feel alive.</p>

                    <select name="interest" class="f-input" required>
                        <option value="" disabled selected>Select</option>
                        @foreach (['Romantic', 'Fun & Playful', 'Emotional Support', 'Deep Conversations', 'Travel Partner', 'Movie Nights', 'Caring Nature', 'Serious & Mature', 'Open Minded', 'Respectful & Kind'] as $item)
                            <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                    <p class="text-red-600 text-xs mt-1 hidden">This field is required.</p>
                </div>

                {{-- QUESTION 5 : BIO --}}
                <div class="q-block hidden">
                    <h2 class="q-title">Tell us something about yourself</h2>
                    <p class="sub-text">
                        A short bio helps others connect with you better ❤️
                    </p>

                    <textarea name="bio" class="f-input" rows="4"
                        placeholder="Example: I love deep conversations, late-night walks, and good music..."></textarea>

                    <p class="text-red-600 text-xs mt-1 hidden">
                        Please write a short bio.
                    </p>
                </div>

                {{-- BUTTON AREA --}}
                <div class="flex justify-between mt-8">
                    <button type="button" id="prevBtn" class="nav-btn hidden">
                        ⬅ Previous
                    </button>

                    <button type="button" id="nextBtn" class="nav-btn hidden">
                        Next ➜
                    </button>

                    <button type="submit" id="submitBtn" class="submit-btn hidden">
                        Submit ❤️
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('css')
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

    <style>
        .page-wrapper {
            min-height: 100vh;
        }

        .card {
            animation: fadeIn 0.45s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.97);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Welcome Screen */

        .welcome-block {
            background: transparent !important;
            box-shadow: none !important;
            animation: fadeStep 0.5s ease-in-out;
        }

        .start-btn {
            padding: 14px 32px;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 14px;
            background: #ff4d8b;
            color: white;
            border: none;
            transition: .3s;
        }

        .start-btn:hover {
            background: #e63972;
            transform: scale(1.03);
        }

        /* Existing Styles */
        .q-title {
            font-size: 1.55rem;
            font-weight: 800;
            color: #333;
            margin-bottom: 6px;
        }

        .sub-text {
            font-size: 0.95rem;
            color: #666;
            margin-bottom: 14px;
        }

        .static-box {
            background: #f6f6f6;
            padding: 14px;
            border-radius: 14px;
            border: 1px solid #ddd;
            font-size: 1.1rem;
            margin-bottom: 6px;
        }

        .f-input {
            width: 100%;
            padding: 16px;
            font-size: 1.1rem;
            border-radius: 12px;
            border: 1px solid #ccc;
            background: #fff;
            transition: .25s;
        }

        .f-input:focus {
            border-color: #ff6b9e;
            box-shadow: 0 0 0 3px #ffb6d9;
        }

        .q-block {
            display: none;
            animation: fadeStep 0.4s ease-in-out;
        }

        .q-block.active {
            display: block;
            background: linear-gradient(135deg, #ffe4ef, #fff);
            padding: 18px;
            border-radius: 16px;
            border: 1px solid #ffd0e1;
        }

        @keyframes fadeStep {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .nav-btn,
        .submit-btn {
            padding: 12px 26px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 1rem;
            transition: .2s;
        }

        .nav-btn {
            background: #efefef;
            border: 1px solid #ccc;
        }

        .submit-btn {
            background: #ff4d8b;
            color: white;
        }
    </style>
@endsection



@section('script')
    <script>
        let current = -1; // start at welcome (-1)
        const welcome = document.querySelector(".welcome-block");
        const blocks = document.querySelectorAll(".q-block");
        const prevBtn = document.getElementById("prevBtn");
        const nextBtn = document.getElementById("nextBtn");
        const submitBtn = document.getElementById("submitBtn");
        const startBtn = document.getElementById("startBtn");

        function updateView() {
            // Hide all questions and welcome
            welcome.classList.add("hidden");
            blocks.forEach(b => b.classList.remove("active"));

            // If welcome screen
            if (current === -1) {
                welcome.classList.remove("hidden");
                prevBtn.classList.add("hidden");
                nextBtn.classList.add("hidden");
                submitBtn.classList.add("hidden");
                return;
            }

            // Show question
            blocks[current].classList.add("active");

            prevBtn.classList.toggle("hidden", current <= 0);
            nextBtn.classList.toggle("hidden", current === blocks.length - 1);
            submitBtn.classList.toggle("hidden", current !== blocks.length - 1);
        }

        function validateStep(step) {
            if (step === -1) return true;

            let block = blocks[step];
            let input = block.querySelector("select");
            let error = block.querySelector("p.text-red-600");

            if (!input) return true;

            if (input.value === "") {
                if (error) error.classList.remove("hidden");
                return false;
            } else {
                if (error) error.classList.add("hidden");
                return true;
            }
        }

        startBtn.addEventListener("click", () => {
            current = 0;
            updateView();
        });

        nextBtn.addEventListener("click", () => {
            if (!validateStep(current)) {
                // alert("Please choose an option before continuing ❤️");
                return;
            }
            current++;
            updateView();
        });

        prevBtn.addEventListener("click", () => {
            current--;
            updateView();
        });

        updateView();
    </script>
@endsection
