@extends('layouts.app1')

@section('content')
    {{-- SUCCESS ALERT --}}
    @if (session('success'))
        <div id="flash-success"
            style="
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #dcfce7;
            border: 1px solid #22c55e;
            color: #166534;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            z-index: 9999;
            box-shadow: 0 10px 25px rgba(0,0,0,.15);
            text-align: center;
            min-width: 260px;
        ">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(() => {
                const el = document.getElementById('flash-success');
                if (el) el.style.display = 'none';
            }, 5000);
        </script>
    @endif

    {{-- ERROR ALERT --}}
    @if (session('error'))
        <div id="flash-error"
            style="
            position: fixed;
            top: 70px;
            left: 50%;
            transform: translateX(-50%);
            background: #fee2e2;
            border: 1px solid #ef4444;
            color: #7f1d1d;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            z-index: 9999;
            box-shadow: 0 10px 25px rgba(0,0,0,.15);
            text-align: center;
            min-width: 260px;
        ">
            {{ session('error') }}
        </div>

        <script>
            setTimeout(() => {
                const el = document.getElementById('flash-error');
                if (el) el.style.display = 'none';
            }, 5000);
        </script>
    @endif

    <br><br>
    <div class="max-w-4xl mx-auto mt-10 space-y-6">

        {{-- Header --}}
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Contact Us</h1>
            <p class="text-gray-500 text-sm">Have a question or need help? We’d love to hear from you.</p>
        </div>

        {{-- Contact Form --}}
        <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-lg max-w-3xl mx-auto">
            <form method="POST" action="{{ route('contact.send') }}" class="space-y-5">
                @csrf

                {{-- Name --}}
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Full Name</label>
                    <input type="text" name="name" value="{{ $user->first_name }} {{ $user->last_name }}"
                        class="w-full border border-gray-300 dark:border-gray-700 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="">

                    @error('name')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Email Address</label>
                    <input type="email" name="email" value="{{ $user->email }}"
                        class="w-full border border-gray-300 dark:border-gray-700 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="">

                    @error('email')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Subject --}}
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Subject</label>
                    <input type="text" name="subject" value="{{ old('subject') }}"
                        class="w-full border border-gray-300 dark:border-gray-700 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="">

                    @error('subject')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Message --}}
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Message</label>
                    <textarea name="message" rows="5"
                        class="w-full border border-gray-300 dark:border-gray-700 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="">{{ old('message') }}</textarea>

                    @error('message')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <div>
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition create_room_button">
                        Send Message
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .create_room_button {
            background: linear-gradient(90deg, #ff512f, #dd2476) !important;
            border-radius: 15px !important;
            color: white !important;
            font-size: 20px;
            padding: 12px 0;
            font-weight: 600;
            letter-spacing: .5px;
            box-shadow: 0 4px 10px rgba(221, 36, 118, 0.3);
            transition: 0.3s ease;
        }

        .create_room_button:hover {
            opacity: .9;
            transform: translateY(-1px);
        }
    </style>
@endsection
