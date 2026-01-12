{{-- <x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot Password</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Inter", sans-serif;
        }

        body {
            height: 100vh;
            background: linear-gradient(135deg, #f0f7ff, #e0e7ff);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            width: 95%;
            max-width: 430px;
            background: #ffffff;
            padding: 40px 35px;
            border-radius: 22px;
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
            background: #0ea5e9;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 42px;
            box-shadow: 0 10px 18px rgba(14, 165, 233, 0.4);
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
            text-align: center;
            font-size: 24px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 10px;
        }

        p {
            text-align: center;
            font-size: 15px;
            color: #4b5563;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        input[type="email"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 8px;
            transition: 0.3s ease;
        }

        input[type="email"]:focus {
            border-color: #0ea5e9;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.25);
            outline: none;
        }

        .error {
            color: #dc2626;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .status-message {
            background: #e0fbe6;
            color: #065f46;
            padding: 10px 12px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 13px;
            border-left: 4px solid #10b981;
            text-align: center;
        }

        button {
            width: 100%;
            padding: 14px;
            background: #0ea5e9;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s ease;
            margin-top: 5px;
        }

        button:hover {
            background: #0284c7;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <div class="card">

        <div class="badge">🔑</div>

        <h2>Forgot Password</h2>

        <p>Enter your email below and we’ll send you a secure link to reset your password.</p>

        @if (session('status'))
            <div class="status-message">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <label for="email">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

            <button type="submit">Send Reset Link</button>
        </form>

    </div>

</body>

</html>
