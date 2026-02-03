<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Email Verification</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Inter", sans-serif;
        }

        body {
            height: 100vh;
            background: linear-gradient(135deg, #eef2ff, #e9d5ff);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            width: 95%;
            max-width: 450px;
            background: #ffffff;
            padding: 40px 35px;
            border-radius: 22px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
            animation: fadeIn 0.7s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(22px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Badge Icon */
        .badge {
            height: 90px;
            width: 90px;
            background: #4f46e5;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 42px;
            box-shadow: 0 10px 18px rgba(79, 70, 229, 0.4);
            animation: pop 0.5s ease;
        }

        @keyframes pop {
            0% {
                transform: scale(0.5);
                opacity: 0.3;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        h2 {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 12px;
        }

        p {
            font-size: 15px;
            color: #4b5563;
            line-height: 1.6;
            margin-bottom: 22px;
        }

        .status-message {
            background: #e0fbe6;
            color: #065f46;
            padding: 10px 12px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 13px;
            border-left: 4px solid #10b981;
        }

        button {
            width: 100%;
            padding: 14px;
            background: #4f46e5;
            color: #ffffff;
            font-size: 15px;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s ease;
            margin-bottom: 10px;
        }

        button:hover {
            background: #4338ca;
            transform: translateY(-2px);
        }

        .logout-btn {
            background: none;
            color: #374151;
            text-decoration: underline;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            padding: 10px 0;
        }

        .logout-btn:hover {
            color: #111827;
        }

        .feed-btn {
            background: #10b981;
        }

        .feed-btn:hover {
            background: #059669;
        }
    </style>
</head>

<body>

    @php
        $isApp = request()->has('app');
    @endphp

    <div class="card">

        <div class="badge">📧</div>

        <h2>Email Verification Required</h2>

        <p>
            Thanks for signing up! We’ve sent a verification link to your email.
            If you didn't receive it, you can request another below.
        </p>

        @if (session('status'))
            <div class="status-message">
                @if (session('status') == 'verification-link-sent')
                    A new verification link has been sent to your email address.
                @elseif(session('status') == 'Email already verified!')
                    Email is already verified!
                @else
                    {{ session('status') }}
                @endif
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') ?? request('email') }}">
            <button type="submit">Resend Verification Email</button>
        </form>

        @php
            $user = auth()->user();
        @endphp

        @if ($user && $user->role == 0)
            <a href="{{ route('feed') }}">
                <button type="button" class="feed-btn">
                    Go to home page →
                </button>
            </a>
        @elseif($user && $user->role == 1)
            <a href="{{ route('profile') }}">
                <button type="button" class="feed-btn">
                    Go to profile →
                </button>
            </a>
        @endif

        {{-- @if (!$isApp)
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        @endif --}}
    </div>
</body>

</html>
