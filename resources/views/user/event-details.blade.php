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

    <div class="max-w-4xl mx-auto mt-6 px-4 space-y-6">

        {{-- HEADER --}}
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                Event Details
            </h1>

            <p class="text-gray-500 text-sm">
                View event information and connect with the event
            </p>
        </div>

        {{-- EVENT CARD --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg max-w-3xl mx-auto">

            {{-- EVENT IMAGE --}}
            @if ($event->image)
                <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}"
                    class="w-full h-72 object-cover rounded-2xl border">
            @else
                <img src="{{ asset('images/default-event.jpg') }}" alt="{{ $event->name }}"
                    class="w-full h-72 object-cover rounded-2xl border">
            @endif

            {{-- EVENT NAME --}}
            <div class="mt-5">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                    {{ $event->name }}
                </h2>
            </div>

            @php
                $city = json_decode($event->city, true);
            @endphp

            {{-- LOCATION --}}
            <div class="mt-4 flex items-start gap-3">
                <div class="text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 21a2 2 0 01-2.828 0l-4.243-4.343a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Location
                    </p>

                    <p class="font-medium text-gray-800 dark:text-white">
                        {{ $city['address'] ?? 'N/A' }}
                    </p>
                </div>
            </div>

            {{-- TIMING --}}
            <div class="mt-4 flex items-start gap-3">
                <div class="text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Date & Time
                    </p>

                    <p class="font-medium text-gray-800 dark:text-white">
                        {{ \Carbon\Carbon::parse($event->timing)->format('d M Y, h:i A') }}
                    </p>
                </div>
            </div>

            {{-- EVENT AREA --}}
            @if ($event->area_range)
                <div class="mt-4 flex items-start gap-3">
                    <div class="text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 21s8-4.438 8-10a8 8 0 10-16 0c0 5.562 8 10 8 10z" />
                            <circle cx="12" cy="11" r="3" />
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">
                            Event Area
                        </p>

                        <p class="font-medium text-gray-800 dark:text-white">
                            {{ $event->area_range }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- DIVIDER --}}
            <div class="border-t border-gray-200 dark:border-gray-700 my-6"></div>


            <div class="mt-6">

                <form action="{{ route('events.message.send', $event->id) }}" method="POST">
                    @csrf

                    <input type="text" name="message" placeholder="Write a message..." required maxlength="5000"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pink-400">

                    <button type="submit" class="event_message_button mt-3">
                        Send Message
                    </button>
                </form>

            </div>

        </div>

    </div>
@endsection

@section('css')
    <style>
        .event_message_button {
            display: block;
            width: 100%;
            border: none;
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: white;
            font-size: 18px;
            font-weight: 600;
            padding: 12px 0;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            cursor: pointer;
            transition: 0.3s;
        }

        .event_message_button:hover {
            transform: translateY(-1px);
        }
    </style>
@endsection
