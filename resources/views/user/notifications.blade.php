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
    <div class="max-w-4xl mx-auto mt-6 space-y-6">
        {{-- Header --}}
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Create New Event</h1>
            <p class="text-gray-500 text-sm">Fill out the form below to generate a bill</p>
        </div>

        {{-- Event Form --}}
        <div class="bg-white p-6 rounded-2xl shadow-lg max-w-3xl mx-auto">
            <form action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data"
                class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf

                {{-- Event Name --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Event Name</label>
                    <input type="text" name="name" placeholder="Enter event name" value="{{ old('name') }}"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('name')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- City --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">City</label>
                    <input type="text" name="city" placeholder="Enter city" value="{{ old('city') }}"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('city')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Event Date --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Event Date</label>
                    <input type="date" name="event_date"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('event_date')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Timing --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Time Slot</label>
                    <select name="timing_slot"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select Timing</option>
                        <option value="morning">Morning (9am – 12pm)</option>
                        <option value="afternoon">Afternoon (12pm – 4pm)</option>
                        <option value="evening">Evening (4pm – 8pm)</option>
                        <option value="night">Night (8pm – 12am)</option>
                    </select>
                    @error('timing_slot')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Area / Distance --}}
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-1">Event Area / Distance</label>
                    <select name="area_price_id" id="areaSelect"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select Area</option>
                    </select>
                    @error('area_price_id')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Image --}}
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2">Event Image</label>

                    <div class="flex items-center gap-6">
                        <label for="fileInput"
                            class="flex items-center justify-center px-6 py-3 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4 3a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V3z"
                                    clip-rule="evenodd" />
                            </svg>
                            Choose Image
                        </label>

                        <input type="file" name="image" accept="image/*" id="fileInput" class="hidden"
                            onchange="previewImage(event)">

                        <img id="imagePreview" class="w-24 h-24 rounded-lg object-cover border hidden">
                    </div>
                    @error('image')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <div class="md:col-span-2">
                    <button class="create_room_button w-full" type="submit">
                        Generate Bill
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

@section('script')
    {{-- Image Preview Script --}}
    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '';
                preview.classList.add('hidden');
            }
        }
    </script>

    <script>
        fetch("{{ url('/area-prices') }}")
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    const select = document.getElementById('areaSelect');

                    response.data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id; // IMPORTANT (DB ID)
                        option.textContent = `${item.area_range} (₹${item.amount})`;
                        select.appendChild(option);
                    });
                }
            });
    </script>
@endsection
