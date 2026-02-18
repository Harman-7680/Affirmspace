@extends('layouts.app_admin')

@section('css')
    <style>
        .profile-container {
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .profile-header img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-header h2 {
            font-size: 22px;
            font-weight: 600;
            margin: 0;
            color: #333;
        }

        .profile-header p {
            margin: 3px 0;
            color: #555;
            font-size: 14px;
        }

        .bio-section {
            margin-top: 25px;
        }

        .bio-section h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }

        .bio-section p {
            color: #666;
            line-height: 1.6;
            font-size: 14px;
        }

        .appointment-container {
            max-width: 1000px;
            margin: 25px auto;
            background: #fff;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .appointment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .appointment-header h3 {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin: 0;
        }

        .back-btn {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }

        .back-btn:hover {
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
            font-weight: 600;
        }

        td {
            background-color: #fff;
        }

        .status-accepted {
            color: #28a745;
            font-weight: bold;
        }

        .status-rejected {
            color: #dc3545;
            font-weight: bold;
        }

        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }

        .no-appointments {
            text-align: center;
            color: #777;
            padding: 15px;
        }
    </style>
@endsection

@section('content')
    <br><br>
    <div class="profile-container">
        <div class="profile-header">
            <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('images/avatars/avatar-1.jpg') }}"
                alt="Profile Image">
            <div>
                <h2>{{ $user->first_name }} {{ $user->last_name }}</h2>
                <p class="text-sm text-gray-600 mt-0.5">
                    <span class="font-medium">{{ $user->specialization->name }}</span>
                </p>
                @if (isset($user->price))
                    <p>₹{{ $user->price }}</p>
                @endif
                @if (isset($averageRating))
                    <p>{{ number_format($averageRating, 1) }} ⭐ ({{ $totalReviews }} reviews)</p>
                @else
                    <p>No ratings yet.</p>
                @endif
            </div>
        </div>

        <div class="bio-section">
            <h3>Bio</h3>
            <p>{{ $user->bio }}</p>
        </div>
    </div>

    <div class="appointment-container">
        <div class="appointment-header">
            <h3>Appointments</h3>
            <a href="javascript:history.back()" class="back-btn">← Back</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Client Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appointment)
                    <tr>
                        <td>{{ optional($appointment->availability)->available_date ?? 'N/A' }}</td>
                        <td>
                            {{ optional($appointment->availability)->start_time ?? '' }} -
                            {{ optional($appointment->availability)->end_time ?? '' }}
                        </td>
                        <td>{{ $appointment->email }}</td>
                        <td>{{ $appointment->subject }}</td>
                        <td>{{ $appointment->message_body }}</td>
                        <td
                            class="
                        {{ $appointment->status === 'accepted'
                            ? 'status-accepted'
                            : ($appointment->status === 'rejected'
                                ? 'status-rejected'
                                : 'status-pending') }}">
                            {{ ucfirst($appointment->status) }}
                        </td>

                        <td>
                            @if ($appointment->payment_status === 'paid')
                                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">
                                    Paid
                                </span>

                                <div class="text-xs text-gray-500 mt-1">
                                    Payment ID: {{ $appointment->razorpay_payment_id ?? 'N/A' }}
                                </div>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded-full">
                                    Unpaid
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="no-appointments">No appointments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

{{-- <div class="max-w-4xl mx-auto mt-6 p-6 bg-white rounded shadow">
        <h3 class="text-xl font-semibold mb-4">Contact Counselor</h3>
        <form action="{{ route('contact.counselor', $user->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="subject" class="block font-medium mb-1">Email</label>
                <input type="email" name="subject" id="subject" placeholder="Enter email address"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
            </div>
            <div class="mb-4">
                <label for="message" class="block font-medium mb-1">Message</label>
                <textarea name="message" id="message" rows="5" placeholder="Type Something......"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required></textarea>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Send Message</button>
        </form>
    </div> --}}

{{-- <div class="max-w-4xl mx-auto mt-6 p-6 bg-white rounded shadow">
    @if (auth()->check() && auth()->id() !== $user->id)
        <form action="{{ route('ratings.store') }}" method="POST" class="mt-4">
            @csrf
            <div class="mb-4">
                <label for="rating" class="block font-medium mb-1">Rate this counselor:</label>
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

            @if (session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <button type="submit" class="mt-2 bg-blue-600 text-white px-4 py-1 rounded">Submit</button>
        </form>
    @endif
</div> --}}
