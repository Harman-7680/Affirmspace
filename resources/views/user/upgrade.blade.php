@extends('layouts.app1')

@section('content')
    <br><br>
    <div class="max-w-4xl mx-auto mt-6 space-y-6">

        {{-- Header --}}
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Create Room</h1>
            <p class="text-gray-500 text-sm">Fill the details below to create a new room</p>
        </div>

        {{-- Room Form --}}
        <div class="bg-white p-6 rounded-2xl shadow-lg max-w-3xl mx-auto">

            <form action="{{ route('jitsi.store') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Room Name --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Room Name</label>
                    <input type="text" name="room_name" placeholder="Enter room name" value="{{ old('room_name') }}"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">

                    @error('room_name')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Duration --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Room Duration</label>
                    <select name="duration_minutes"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="" disabled selected>Select duration</option>
                        <option value="5">5 Minutes</option>
                        <option value="10">10 Minutes</option>
                        <option value="15">15 Minutes</option>
                        <option value="20">20 Minutes</option>
                        <option value="25">25 Minutes</option>
                        <option value="30">30 Minutes</option>
                    </select>

                    @error('duration_minutes')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Members --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Members Allowed</label>
                    <select name="max_users"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="" disabled selected>Select members</option>
                        <option value="5">5 Members</option>
                        <option value="10">10 Members</option>
                        <option value="15">15 Members</option>
                        <option value="20">20 Members</option>
                        <option value="25">25 Members</option>
                        <option value="30">30 Members</option>
                    </select>

                    @error('max_users')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Room Description</label>
                    <textarea name="description" rows="4" placeholder="Write a short description..."
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>

                {{-- Button --}}
                <button class="create_room_button w-full py-3 rounded-lg text-white text-lg font-semibold">
                    Create Room
                </button>
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
