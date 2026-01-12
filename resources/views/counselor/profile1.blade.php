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

    <br>
    <div class="max-w-5xl mx-auto mt-16 mb-16 p-6 bg-gray-50 rounded-lg shadow-lg">
        <!-- Profile Header -->
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
            <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('images/avatars/avatar-1.jpg') }}"
                class="w-28 h-28 rounded-full object-cover border-4 border-blue-500" alt="">

            <div class="flex-1">
                <h2 class="text-3xl font-bold text-gray-800">{{ $user->first_name }} {{ $user->last_name }}</h2>
                <p class="text-blue-600 text-lg mt-1">{{ $user->pronouns }}</p>

                @if (isset($user->price))
                    <p class="text-gray-700 mt-2 font-medium">Consultation Fee: ₹{{ $user->price }}</p>
                @endif

                @if (isset($averageRating))
                    <p class="mt-2 text-gray-600">
                        <span class="font-semibold">{{ number_format($averageRating, 1) }}</span> ⭐ ({{ $totalReviews }}
                        reviews)
                    </p>
                @else
                    <p class="mt-2 text-gray-600">No ratings yet.</p>
                @endif
            </div>
        </div>

        <!-- Bio -->
        @if ($user->bio)
            <div class="mt-8 bg-white p-4 rounded shadow-sm">
                <h3 class="font-semibold text-xl text-gray-800 mb-2">Bio</h3>
                <p class="text-gray-700">{{ $user->bio }}</p>
            </div>
        @endif

        <!-- Stats -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white p-4 rounded shadow-sm">
                <h4 class="font-semibold text-gray-700 mb-1">Email</h4>
                <p class="text-gray-600">{{ $user->email }}</p>
            </div>

            <div class="bg-white p-4 rounded shadow-sm">
                <h4 class="font-semibold text-gray-700 mb-1">Status</h4>
                <p class="text-gray-600">{{ $user->status ? 'Active' : 'Deactivated' }}</p>
            </div>

            <div class="bg-white p-4 rounded shadow-sm">
                <h4 class="font-semibold text-gray-700 mb-1">Joined At</h4>
                <p class="text-gray-600">{{ $user->created_at->format('d M Y') }}</p>
            </div>

            <div class="bg-white p-4 rounded shadow-sm">
                <h4 class="font-semibold text-gray-700 mb-1">Gender</h4>
                <p class="text-gray-600">{{ $user->gender }}</p>
            </div>
            <div class="bg-white p-4 rounded shadow-sm">
                <h4 class="font-semibold text-gray-700 mb-1">Address</h4>
                <p class="text-gray-600">{{ $user->address }}</p>
            </div>
            <div class="bg-white p-4 rounded shadow-sm">
                <h4 class="font-semibold text-gray-700 mb-1">Relationship</h4>
                <p class="text-gray-600">{{ $user->relationship }}</p>
            </div>
        </div>

    </div>
@endsection
