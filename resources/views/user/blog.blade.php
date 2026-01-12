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

    {{-- <main id="site__main" class="2xl:ml-[--w-side] xl:ml-[--w-side-sm] p-2.5 h-[calc(100vh-var(--m-top))] mt-[--m-top]"> --}}
    <main class="max-w-4xl mx-auto mt-[--m-top] p-4">

        <div class="my-counselling-page">
            {{-- Notification: only show if accepted appointment exists AND it is not past --}}
            @if (
                $acceptedAppointment &&
                    $acceptedAppointment->availability &&
                    $acceptedAppointment->availability->statusFlag !== 'past')
                <div class="notification-box">
                    <span class="icon">&#x1F514;</span>
                    <p>
                        <strong>Appointment Confirmed!</strong>
                        You have a session scheduled on
                        {{ $acceptedAppointment->availability->date ?? 'N/A' }}
                        from {{ $acceptedAppointment->availability->startTime ?? '' }}
                        to {{ $acceptedAppointment->availability->endTime ?? '' }}.
                    </p>
                </div>
            @endif

            {{-- Upcoming Sessions --}}
            <h2 class="section-title">Upcoming Sessions</h2>
            <div class="upcoming-sessions">
                @php
                    $upcoming = $appointments->filter(function ($a) {
                        return $a->status === 'accepted' &&
                            $a->availability &&
                            ($a->availability->statusFlag ?? '') === 'upcoming';
                    });
                @endphp

                @if ($upcoming->count())
                    @foreach ($upcoming as $appointment)
                        @php
                            $counselor =
                                $appointment->sender->role == 1 ? $appointment->sender : $appointment->receiver;
                        @endphp

                        <div class="upcoming-card">
                            <img src="{{ $counselor->image ? asset('storage/' . $counselor->image) : asset('images/avatars/avatar-1.jpg') }}"
                                alt="" class="avatar">

                            <div class="upcoming-card-content">
                                <div class="upcoming-details">
                                    <h4>{{ $counselor->first_name }} {{ $counselor->last_name }} : Upcoming Session</h4>
                                    <p>
                                        {{ $appointment->availability->date }}
                                        ({{ $appointment->availability->startTime }} -
                                        {{ $appointment->availability->endTime }})
                                    </p>
                                </div>
                                <div class="upcoming-actions">
                                    <div class="date-box">
                                        <div class="date">{{ $appointment->availability->date }}</div>
                                        <div class="time">{{ $appointment->availability->startTime }} -
                                            {{ $appointment->availability->endTime }}</div>
                                    </div>
                                    {{-- <button class="join-session-btn">Join Session</button> --}}
                                    <a href="{{ url('/messages/' . $counselor->id . '?type=counselor') }}"
                                        class="open-chat-btn">
                                        Open Chat
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No upcoming sessions scheduled.</p>
                @endif
            </div>

            <h2 class="section-title">Recent Activity</h2>
            <div class="recent-activity">
                @forelse($appointments as $appointment)
                    @php
                        $counselor = $appointment->sender->role == 1 ? $appointment->sender : $appointment->receiver;

                        $avatar = $counselor->image ?? null;
                        $name = $counselor->first_name . ' ' . $counselor->last_name;
                    @endphp

                    <div class="history-card">
                        <img src="{{ $avatar ? asset('storage/' . $avatar) : asset('images/avatars/avatar-1.jpg') }}"
                            class="avatar" alt="">

                        <div class="card-content border rounded-xl p-4 bg-white shadow-sm hover:shadow-md transition">

                            <!-- Header -->
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-semibold text-gray-800 text-sm md:text-base">
                                    {{ $name }}
                                    <span class="text-gray-500 font-normal">
                                        : {{ $appointment->subject ?? '(No Subject)' }}
                                    </span>
                                </h4>

                                <span
                                    class="px-3 py-1 text-xs font-semibold rounded-full
                        @if ($appointment->status === 'pending') bg-blue-100 text-blue-700
                        @elseif ($appointment->status === 'accepted') bg-green-100 text-green-700
                        @else bg-red-100 text-red-700 @endif">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </div>

                            <!-- Message -->
                            <p class="text-gray-600 text-sm mb-3 leading-relaxed">
                                {{ $appointment->message_body ?? 'No message' }}
                            </p>

                            @php
                                $existingRating = $ratings[$counselor->id] ?? null;
                            @endphp

                            @if (auth()->check() && auth()->id() !== $counselor->id && $appointment->status === 'accepted' && $counselor->role == 1)
                                {{-- IF ALREADY RATED --}}
                                @if ($existingRating)
                                    <div class="flex items-center gap-1 mt-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $existingRating->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.173c.969 0 1.371 1.24.588 1.81l-3.378 2.455a1 1 0 00-.364 1.118l1.287 3.971c.3.921-.755 1.688-1.54 1.118l-3.378-2.455a1 1 0 00-1.176 0l-3.378 2.455c-.784.57-1.838-.197-1.539-1.118l1.287-3.971a1 1 0 00-.364-1.118L2.174 9.397c-.783-.57-.38-1.81.588-1.81h4.173a1 1 0 00.95-.69l1.286-3.97z" />
                                            </svg>
                                        @endfor

                                        <span class="text-xs text-gray-500 ml-2">
                                            Your rating
                                        </span>
                                    </div>

                                    {{-- SHOW FORM ONLY IF NOT RATED --}}
                                @else
                                    <form action="{{ route('ratings.store') }}" method="POST" x-data="{ rating: 0, review: '' }"
                                        class="mt-2 space-y-2">

                                        @csrf

                                        <input type="hidden" name="counselor_id" value="{{ $counselor->id }}">
                                        <input type="hidden" name="rating" x-model="rating">

                                        <!-- ⭐ STAR SELECT -->
                                        <div class="flex gap-1 items-center">
                                            <template x-for="star in 5" :key="star">
                                                <svg @click="rating = star" class="w-5 h-5 cursor-pointer transition"
                                                    :class="rating >= star ? 'text-yellow-400' : 'text-gray-300'"
                                                    fill="currentColor" viewBox="0 0 20 20">

                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.173c.969 0 1.371 1.24.588 1.81l-3.378 2.455a1 1 0 00-.364 1.118l1.287 3.971c.3.921-.755 1.688-1.54 1.118l-3.378-2.455a1 1 0 00-1.176 0l-3.378 2.455c-.784.57-1.838-.197-1.539-1.118l1.287-3.971a1 1 0 00-.364-1.118L2.174 9.397c-.783-.57-.38-1.81.588-1.81h4.173a1 1 0 00.95-.69l1.286-3.97z" />
                                                </svg>
                                            </template>
                                        </div>

                                        <!-- ✍️ REVIEW TEXTAREA (OPENS AFTER STAR CLICK) -->
                                        <div x-show="rating > 0" x-transition x-cloak>
                                            <textarea name="review" x-model="review" rows="3" placeholder="Write your experience..."
                                                class="w-full mt-2 p-2 border rounded-lg text-sm
                   focus:ring-2 focus:ring-blue-500 focus:outline-none
                   dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                                            </textarea>

                                            <!-- SUBMIT -->
                                            <button type="submit"
                                                class="mt-2 bg-blue-600 text-white px-4 py-1.5 rounded-lg text-sm
                   hover:bg-blue-700 transition">
                                                Submit Review
                                            </button>
                                        </div>

                                    </form>
                                @endif
                            @endif

                            <!-- Footer -->
                            <div class="text-right mt-2">
                                <small class="text-gray-400 text-xs">
                                    {{ $appointment->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>No recent activity found.</p>
                @endforelse
            </div>

            {{-- <h2 class="section-title">Dummy Call History</h2>
            <div class="call-history">
                <div class="history-card">
                    <span class="icon">&#x260E;</span>
                    <div class="card-content">
                        <h4>Previous Calls</h4>
                        <p>Call records will appear here.</p>
                    </div>
                </div>
            </div> --}}

            {{-- Ongoing Sessions
            <h2 class="section-title">Ongoing Sessions</h2>
            <div class="ongoing-sessions">
                @php
                    $ongoing = $appointments->filter(function ($a) {
                        return $a->status === 'accepted' &&
                            $a->availability &&
                            ($a->availability->statusFlag ?? '') === 'ongoing';
                    });
                @endphp

                @if ($ongoing->count())
                    @foreach ($ongoing as $appointment)
                        @php
                            $counselor =
                                $appointment->sender->role == 1 ? $appointment->sender : $appointment->receiver;
                        @endphp

                        <div class="upcoming-card">
                            <img src="{{ $counselor->image ? asset('storage/' . $counselor->image) : asset('images/avatars/avatar-2.jpg') }}"
                                alt="" class="avatar">

                            <div class="upcoming-card-content">
                                <div class="upcoming-details">
                                    <h4>{{ $counselor->first_name }} {{ $counselor->last_name }} : Ongoing Session</h4>
                                    <p>
                                        {{ $appointment->availability->date }}
                                        ({{ $appointment->availability->startTime }} -
                                        {{ $appointment->availability->endTime }})
                                    </p>
                                </div>
                                <div class="upcoming-actions">
                                    <div class="date-box">
                                        <div class="date">{{ $appointment->availability->date }}</div>
                                        <div class="time">{{ $appointment->availability->startTime }} -
                                            {{ $appointment->availability->endTime }}</div>
                                    </div>
                                    <button class="join-session-btn">Join Session</button>
                                    <button class="open-chat-btn">Open Chat</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No ongoing sessions.</p>
                @endif
            </div> --}}

            {{-- Past Sessions
            <h2 class="section-title">Past Sessions</h2>
            <div class="past-sessions">
                @php
                    $past = $appointments->filter(function ($a) {
                        return $a->status === 'accepted' &&
                            $a->availability &&
                            ($a->availability->statusFlag ?? '') === 'past';
                    });
                @endphp

                @if ($past->count())
                    @foreach ($past as $appointment)
                        @php
                            $counselor =
                                $appointment->sender->role == 1 ? $appointment->sender : $appointment->receiver;
                        @endphp

                        <div class="history-card">
                            <img src="{{ $counselor->image ? asset('storage/' . $counselor->image) : asset('images/avatars/avatar-2.jpg') }}"
                                alt="" class="avatar">

                            <div class="card-content">
                                <h4>{{ $counselor->first_name }} {{ $counselor->last_name }} : Past Session</h4>
                                <p>
                                    {{ $appointment->availability->date }}
                                    ({{ $appointment->availability->startTime }} -
                                    {{ $appointment->availability->endTime }})
                                </p>
                                <small class="text-gray-500">Completed</small>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No past sessions.</p>
                @endif
            </div> --}}
        </div>
    </main>
@endsection

@section('css')
    <style>
        /* Main container styling for the content area */
        .my-counselling-page {
            padding: 2.5rem;
            max-width: 900px;
            margin: auto;
            font-family: Arial, sans-serif;
        }

        /* Section headings */
        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #ddd;
            padding-bottom: 0.5rem;
        }

        /* Notification box */
        .notification-box {
            background-color: #e6f7ff;
            border-left: 5px solid #1890ff;
            padding: 1.25rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .notification-box .icon {
            color: #1890ff;
            font-size: 2rem;
            margin-right: 1rem;
        }

        .notification-box p {
            flex-grow: 1;
            margin: 0;
            font-size: 1rem;
            color: #333;
        }

        /* History and upcoming sections */
        .history-card,
        .upcoming-card {
            background-color: #fff;
            border: 1px solid #e8e8e8;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }

        .history-card:hover,
        .upcoming-card:hover {
            transform: translateY(-5px);
        }

        .history-card .avatar,
        .upcoming-card .avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 1rem;
        }

        .card-content {
            flex-grow: 1;
        }

        .card-content h4 {
            margin: 0;
            font-size: 1.1rem;
            color: #555;
        }

        .card-content p {
            margin: 0.25rem 0 0;
            font-size: 0.9rem;
            color: #888;
        }

        /* Call history specific styling */
        .call-history .history-card {
            align-items: flex-start;
        }

        .call-history .history-card .icon {
            color: #52c41a;
            font-size: 1.5rem;
            margin-right: 1rem;
        }

        /* Upcoming sessions specific styling */
        .upcoming-card-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .upcoming-details {
            flex-grow: 1;
        }

        .upcoming-actions {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .upcoming-actions .date-box {
            background-color: #f0f2f5;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .upcoming-actions .date-box .date {
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
        }

        .upcoming-actions .date-box .time {
            font-size: 1rem;
            color: #555;
        }

        .upcoming-actions button {
            background-color: #1890ff;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            margin-top: 0.5rem;
            transition: background-color 0.2s;
        }

        .upcoming-actions button:hover {
            background-color: #40a9ff;
        }

        .upcoming-actions .open-chat-btn {
            background-color: #f0f2f5;
            color: #333;
        }

        .upcoming-actions .open-chat-btn:hover {
            background-color: #e8e8e8;
        }

        .open-chat-btn {
            padding: 8px 14px;
            background: #3b82f6;
            color: white;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .open-chat-btn:hover {
            background: #2563eb;
        }
    </style>
@endsection
