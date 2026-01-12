@extends('layouts.app1')

@section('title')
    Counselor Profile
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

    {{-- <main
        class="2xl:ml-[--w-side] xl:ml-[--w-side-sm] py-6 p-4 h-[calc(100vh-var(--m-top))] mt-[--m-top] bg-gray-50 dark:bg-gray-900"> --}}
    <main class="max-w-5xl mx-auto mt-[--m-top] p-4">
        <div class="2xl:max-w-[1220px] max-w-[1065px] mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Profile Section --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm text-center mb-8">
                <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('images/avatars/avatar-1.jpg') }}"
                    alt="Counselor Profile"
                    class="w-32 h-32 rounded-full mx-auto shadow-lg object-cover border-4 border-white dark:border-gray-700">

                <h1 class="text-3xl sm:text-4xl font-bold mt-4 text-gray-900 dark:text-white">
                    {{ $user->first_name }} {{ $user->last_name }}
                </h1>
                <p class="text-lg sm:text-xl text-gray-600 dark:text-gray-400 mt-1">{{ $user->pronouns }}</p>

                <div class="flex items-center justify-center mt-3 text-yellow-500">
                    <span class="text-xl sm:text-2xl mr-1">★</span>
                    <span class="font-bold text-xl sm:text-2xl">
                        {{ isset($averageRating) ? number_format($averageRating, 1) : '0.0' }}
                    </span>
                    <span class="text-gray-500 dark:text-gray-400 ml-2">
                        ({{ $totalReviews ?? 0 }} reviews)
                    </span>
                </div>
                <p class="text-sm text-gray-600 mt-0.5">
                    <span class="font-medium">{{ $user->specialization->name }}</span>
                </p>
            </div>

            <div class="space-y-6">
                {{-- About Section --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                    <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Bio</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-base sm:text-lg">
                        {{ $user->bio }}
                    </p>
                </div>

                {{-- Client Feedback Section --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                    <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Client Feedback</h2>

                    @if (isset($reviews) && count($reviews) > 0)
                        <div class="space-y-5">
                            @foreach ($reviews as $review)
                                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                                    {{-- Stars --}}
                                    <div class="flex items-center mb-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span
                                                class="text-base {{ $i <= $review->rating ? 'text-yellow-500' : 'text-gray-300 dark:text-gray-600' }}">
                                                ★
                                            </span>
                                        @endfor
                                    </div>

                                    {{-- Review Text --}}
                                    <p class="text-gray-700 dark:text-gray-300 italic text-base">
                                        "{{ $review->review ?? 'No written feedback provided.' }}"
                                    </p>

                                    {{-- Reviewer Name --}}
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                        –
                                        {{ trim(($review->user->first_name ?? 'Anonymous') . ' ' . ($review->user->last_name ?? '')) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600 dark:text-gray-400 italic">No reviews yet.</p>
                    @endif
                </div>

                {{-- Availability Section --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                    <button type="button" id="openModal"
                        class="create_room_button text-white px-6 py-3 rounded-full text-lg font-semibold mt-6 w-full shadow-lg transition-transform transform hover:scale-105 active:scale-95 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Book Appointment
                    </button>
                </div>
            </div>
        </div>
    </main>

    {{-- Popup Modal --}}
    <div id="bookingModal" class="fixed inset-0 bg-black/40 backdrop-blur-md hidden flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-lg p-6 relative">
            <button id="closeModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">✖</button>

            <h3 class="text-xl font-semibold mb-2">Contact {{ $user->first_name }}</h3>

            @if (isset($user->price))
                <span class="inline-block bg-green-100 text-green-700 text-sm font-medium px-3 py-1 mb-2 rounded-full">
                    Price ₹{{ number_format($user->price, 2) }}
                </span>
            @endif

            <form action="{{ route('contact.counselor', $user->id) }}" method="POST">
                @csrf

                @php $auth = Auth::user(); @endphp

                <div class="mb-4">
                    <label class="block font-medium mb-1">Email</label>
                    <input type="email" name="email" placeholder="Enter email address"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required
                        value="{{ $auth->email }}">
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Select Available Date & Time</label>
                    <select name="availability_id"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
                        <option value="">-- Select a slot --</option>
                        @forelse($user->availabilities as $slot)
                            <option value="{{ $slot->id }}">
                                {{ \Carbon\Carbon::parse($slot->available_date)->format('d M Y') }}
                                - {{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }}
                                to {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}
                            </option>
                        @empty
                            <option disabled>No availability found</option>
                        @endforelse
                    </select>

                    @error('availability_id')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Subject</label>
                    <input type="text" name="subject" placeholder="Enter Subject here"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>

                    @error('subject')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Message</label>
                    <textarea name="message" rows="5" placeholder="Type Something......"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required></textarea>

                    @error('message')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="create_room_button text-white px-6 py-3 rounded-full text-lg font-semibold mt-6 w-full shadow-lg transition-transform transform hover:scale-105 active:scale-95 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Send
                    Message</button>
            </form>
        </div>
    </div>

    {{-- <div class="max-w-4xl mx-auto mt-6 p-6 bg-white rounded shadow">
        @if (auth()->check() && auth()->id() !== $user->id)
            <form action="{{ route('ratings.store') }}" method="POST" class="mt-4">
                @csrf
                <div class="mb-4">
                    <label for="rating" class="block font-medium mb-1">Rate this counselor:</label>
                    @if (session('error'))
                        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                            {{ session('error') }}
                        </div>
                    @endif
                    <select name="rating" id="rating"
                        class="w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
                        <option value="">Select rating</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }} Star</option>
                        @endfor
                    </select>
                </div>
                <textarea name="review" placeholder="Write a review (optional)" class="w-full mt-2"></textarea>
                <input type="hidden" name="counselor_id" value="{{ $user->id }}">
                <button type="submit" class="mt-2 bg-blue-600 text-white px-4 py-1 rounded">Submit</button>
            </form>
        @endif
    </div> --}}

@endsection

@section('script')
    <script>
        const modal = document.getElementById('bookingModal');
        const openModal = document.getElementById('openModal');
        const closeModal = document.getElementById('closeModal');

        openModal.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        closeModal.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        // Close when clicking outside modal
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });

        @if ($errors->any())
            modal.classList.remove('hidden');
        @endif
    </script>
@endsection
