@extends('layouts.app1')

@section('title')
    Dashboard
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

    <!-- main contents -->
    <main class="p-4 mt-16 max-w-8xl mx-auto">

        <div class="max-w-6xl mx-auto">
            <div class="box relative rounded-lg shadow-md">
                <div class="flex md:gap-8 gap-4 items-center md:p-8 p-6 md:pb-4">
                    <div class="relative md:w-20 md:h-20 w-12 h-12 shrink-0">
                        <label for="file" class="cursor-pointer">
                            <div class="mb-4 w-16 h-16 mx-auto">
                                <img id="img"
                                    src="{{ $user->image && $user->image !== '0' ? asset('storage/' . $user->image) : asset('images/avatars/avatar-1.jpg') }}"
                                    class="object-cover w-16 h-16 rounded-full border-2 border-gray-300 dark:border-gray-600 shadow-md"
                                    alt="User Image" />
                            </div>
                            {{-- <input type="file" id="file" class="hidden" /> --}}
                        </label>

                        {{-- <label for="file"
                            class="md:p-1 p-0.5 rounded-full bg-slate-600 md:border-4 border-white absolute -bottom-2 -right-2 cursor-pointer dark:border-slate-700">

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="md:w-4 md:h-4 w-3 h-3 fill-white">
                                <path d="M12 9a3.75 3.75 0 100 7.5A3.75 3.75 0 0012 9z" />
                                <path fill-rule="evenodd"
                                    d="M9.344 3.071a49.52 49.52 0 015.312 0c.967.052 1.83.585 2.332 1.39l.821 1.317c.24.383.645.643 1.11.71.386.054.77.113 1.152.177 1.432.239 2.429 1.493 2.429 2.909V18a3 3 0 01-3 3h-15a3 3 0 01-3-3V9.574c0-1.416.997-2.67 2.429-2.909.382-.064.766-.123 1.151-.178a1.56 1.56 0 001.11-.71l.822-1.315a2.942 2.942 0 012.332-1.39zM6.75 12.75a5.25 5.25 0 1110.5 0 5.25 5.25 0 01-10.5 0zm12-1.5a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                    clip-rule="evenodd" />
                            </svg>
                            <input id="file" type="file" class="hidden" />
                        </label> --}}
                    </div>

                    <div class="flex-1">
                        <h3 class="md:text-xl text-base font-semibold text-black dark:text-white">
                            {{ $user->first_name }} {{ $user->last_name }}
                        </h3>

                        <p class="text-sm text-blue-600 mt-1 font-normal">
                            Counselor
                        </p>

                        @if ($user->specialization)
                            <p class="text-sm text-gray-600 mt-0.5">
                                <span class="font-medium">{{ $user->specialization->name }}</span>
                            </p>
                        @endif
                    </div>
                </div>

                <!-- nav tabs -->
                <div class="relative border-b" tabindex="-1" uk-slider="finite: true">
                    {{-- <nav class="uk-slider-container overflow-hidden nav__underline px-6 p-0 border-transparent -mb-px">
                        <ul class="uk-slider-items w-[calc(100%+10px)] !overflow-hidden"
                            uk-switcher="connect: #setting_tab ; animation: uk-animation-slide-right-medium, uk-animation-slide-left-medium"> --}}

                    <nav class="uk-slider-container overflow-x-auto px-6 p-0 border-transparent -mb-px">
                        <ul class="uk-slider-items w-auto"
                            uk-switcher="connect: #setting_tab ; animation: uk-animation-slide-right-medium, uk-animation-slide-left-mediumm">

                            <li class="w-auto pl-4"> <a href="#"> Description </a> </li>
                            <li class="w-auto pl-4"> <a href="#"> Links </a> </li>
                            <li class="w-auto pl-4"> <a href="#"> Appointments </a> </li>
                            <li class="w-auto pl-4"> <a href="#"> Set Availibility </a> </li>
                            <li class="w-auto pl-4"> <a href="#"> Update Password </a> </li>
                            <li class="w-auto pl-4"> <a href="#"> Policy </a> </li>
                            <li class="w-auto pl-4"> <a href="#"> Other </a> </li>
                        </ul>
                    </nav>

                    <a class="absolute -translate-y-1/2 top-1/2 left-0 flex items-center w-20 h-full p-2 py-1 justify-start bg-gradient-to-r from-white via-white dark:from-slate-800 dark:via-slate-800"
                        href="#" uk-slider-item="previous"> <ion-icon name="chevron-back"
                            class="text-2xl ml-1"></ion-icon> </a>
                    <a class="absolute right-0 -translate-y-1/2 top-1/2 flex items-center w-20 h-full p-2 py-1 justify-end bg-gradient-to-l from-white via-white dark:from-slate-800 dark:via-slate-800"
                        href="#" uk-slider-item="next"> <ion-icon name="chevron-forward"
                            class="text-2xl mr-1"></ion-icon> </a>
                </div>
                <div id="setting_tab" class="uk-switcher md:py-12 md:px-20 p-6 overflow-hidden text-black text-sm">

                    <!-- tab user basic info -->
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="space-y-6">
                            <div class="md:flex items-center gap-10">
                                <label class="md:w-32 text-right">First Name</label>
                                <div class="flex-1 max-md:mt-4">
                                    <input type="text" name="first_name"
                                        value="{{ old('first_name', $user->first_name) }}"
                                        class="w-full border rounded-md p-2" required>
                                    <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                                </div>
                            </div>

                            {{-- Last Name --}}
                            <div class="md:flex items-center gap-10">
                                <label class="md:w-32 text-right">Last Name</label>
                                <div class="flex-1 max-md:mt-4">
                                    <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                                        class="w-full border rounded-md p-2" required>
                                    <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="md:flex items-center gap-10">
                                <label class="md:w-32 text-right">Email</label>
                                <div class="flex-1 max-md:mt-4">
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                        class="w-full border rounded-md p-2" required>
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                </div>
                            </div>

                            {{-- Bio --}}
                            <div class="md:flex items-start gap-10">
                                <label class="md:w-32 text-right">Bio</label>
                                <div class="flex-1 max-md:mt-4">
                                    {{-- <textarea name="bio" class="lg:w-1/2 w-full border rounded-md p-2" rows="5">{{ old('bio', $user->bio ?? '') }}</textarea> --}}
                                    <textarea name="bio" class="w-full border rounded-md p-2" rows="5">{{ old('bio', $user->bio ?? '') }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                                </div>
                            </div>

                            {{-- Address --}}
                            <div class="md:flex items-center gap-10 mt-4">
                                <label class="md:w-32 text-right">Address</label>
                                <div class="flex-1 max-md:mt-4">
                                    <input type="text" name="address" value="{{ old('address', $user->address) }}"
                                        placeholder="Enter your address" class="w-full border rounded-md p-2">
                                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                                </div>
                            </div>

                            {{-- Gender --}}
                            <div class="md:flex items-center gap-10">
                                <label class="md:w-32 text-right">Gender</label>
                                <div class="flex-1 max-md:mt-4">
                                    <select name="gender" class="border rounded-md w-full p-2">
                                        <option value="Woman"
                                            {{ old('gender', $user->gender) == 'Woman' ? 'selected' : '' }}>Woman</option>
                                        <option value="Man"
                                            {{ old('gender', $user->gender) == 'Man' ? 'selected' : '' }}>Man</option>
                                        <option value="Trans Woman"
                                            {{ old('gender', $user->gender) == 'Trans Woman' ? 'selected' : '' }}>Trans
                                            Woman</option>
                                        <option value="Trans Man"
                                            {{ old('gender', $user->gender) == 'Trans Man' ? 'selected' : '' }}>Trans Man
                                        </option>
                                        <option value="Non-binary"
                                            {{ old('gender', $user->gender) == 'Non-binary' ? 'selected' : '' }}>Non-binary
                                        </option>
                                        <option value="Genderqueer"
                                            {{ old('gender', $user->gender) == 'Genderqueer' ? 'selected' : '' }}>
                                            Genderqueer</option>
                                        <option value="Agender"
                                            {{ old('gender', $user->gender) == 'Agender' ? 'selected' : '' }}>Agender
                                        </option>
                                        <option value="Bigender"
                                            {{ old('gender', $user->gender) == 'Bigender' ? 'selected' : '' }}>Bigender
                                        </option>
                                        <option value="Genderfluid"
                                            {{ old('gender', $user->gender) == 'Genderfluid' ? 'selected' : '' }}>
                                            Genderfluid</option>
                                        <option value="Two-Spirit"
                                            {{ old('gender', $user->gender) == 'Two-Spirit' ? 'selected' : '' }}>Two-Spirit
                                        </option>
                                        <option value="Intersex"
                                            {{ old('gender', $user->gender) == 'Intersex' ? 'selected' : '' }}>Intersex
                                        </option>
                                        <option value="Questioning"
                                            {{ old('gender', $user->gender) == 'Questioning' ? 'selected' : '' }}>
                                            Questioning</option>
                                        <option value="Prefer not to say"
                                            {{ old('gender', $user->gender) == 'Prefer not to say' ? 'selected' : '' }}>
                                            Prefer not to say</option>
                                        {{-- <option value="Other"
                                            {{ old('gender', $user->gender) == 'Other' ? 'selected' : '' }}>Other</option> --}}
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                                </div>
                            </div>

                            {{-- Relationship --}}
                            <div class="md:flex items-center gap-10">
                                <label class="md:w-32 text-right">Relationship</label>
                                <div class="flex-1 max-md:mt-4">
                                    <select name="relationship" class="border rounded-md w-full p-2">
                                        <option value="None"
                                            {{ old('relationship', $user->relationship) == 'None' ? 'selected' : '' }}>None
                                        </option>
                                        <option value="Single"
                                            {{ old('relationship', $user->relationship) == 'Single' ? 'selected' : '' }}>
                                            Single</option>
                                        <option value="In a relationship"
                                            {{ old('relationship', $user->relationship) == 'In a relationship' ? 'selected' : '' }}>
                                            In a relationship</option>
                                        <option value="Married"
                                            {{ old('relationship', $user->relationship) == 'Married' ? 'selected' : '' }}>
                                            Married</option>
                                        <option value="Engaged"
                                            {{ old('relationship', $user->relationship) == 'Engaged' ? 'selected' : '' }}>
                                            Engaged</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('relationship')" />
                                </div>
                            </div>

                            {{-- Pronouns --}}
                            <div class="md:flex items-center gap-10 mt-4">
                                <label class="md:w-32 text-right">Pronouns</label>
                                <div class="flex-1 max-md:mt-4">
                                    <select name="pronouns" class="border rounded-md w-full p-2">
                                        <option value=""
                                            {{ old('pronouns', $user->pronouns) == '' ? 'selected' : '' }}>Select Pronouns
                                        </option>
                                        <option value="He/Him"
                                            {{ old('pronouns', $user->pronouns) == 'He/Him' ? 'selected' : '' }}>He/Him
                                        </option>
                                        <option value="She/Her"
                                            {{ old('pronouns', $user->pronouns) == 'She/Her' ? 'selected' : '' }}>She/Her
                                        </option>
                                        <option value="They/Them"
                                            {{ old('pronouns', $user->pronouns) == 'They/Them' ? 'selected' : '' }}>
                                            They/Them</option>
                                        <option value="Other"
                                            {{ old('pronouns', $user->pronouns) == 'Other' ? 'selected' : '' }}>Other
                                        </option>
                                        <option value="Prefer not to say"
                                            {{ old('pronouns', $user->pronouns) == 'Prefer not to say' ? 'selected' : '' }}>
                                            Prefer not to say</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('pronouns')" />
                                </div>
                            </div>


                            {{-- Price --}}
                            <div class="md:flex items-center gap-10">
                                <label class="md:w-32 text-right">Price</label>
                                <div class="flex-1 max-md:mt-4">
                                    <input type="text" name="price" value="{{ old('price', $user->price) }}"
                                        class="w-full border rounded-md p-2">
                                    <x-input-error class="mt-2" :messages="$errors->get('price')" />
                                </div>
                            </div>

                            {{-- Image --}}
                            <div class="md:flex items-center gap-10 mt-4">
                                <label class="md:w-32 text-right font-medium">Image</label>
                                <div class="flex-1 max-md:mt-4">
                                    <input type="file" name="image" accept="image/*"
                                        class="w-full border rounded-md p-2 cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100">
                                    <x-input-error class="mt-2" :messages="$errors->get('image')" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-center gap-4 mt-4">
                            {{-- <button type="submit1" class="button lg:px-6 bg-secondery max-md:flex-1">
                                            Cancle</button> --}}
                            <button type="submit" class="button lg:px-10 bg-primary text-white max-md:flex-1">
                                Save <span class="ripple-overlay"></span>
                            </button>
                    </form>
                </div>

                <!-- tab socialinks -->
                <div class="w-full mx-auto">
                    <div class="font-normal text-gray-400">
                        <div>
                            <h4 class="text-xl font-medium text-black dark:text-white"> Social Links </h4>
                            <p class="mt-3 font-normal text-gray-600 dark:text-white">We may still send you
                                important notifications about your account and content outside of you
                                preferred notivications settings</p>
                        </div>

                        {{-- here php fetching the social links from db of logged in user --}}
                        @php
                            $socialLinks = \App\Models\Sociallinks::where('user_id', auth()->id())->first();

                        @endphp

                        <form action="{{ route('profile.links') }}" method="POST">
                            @csrf
                            <div class="space-y-6 mt-8">

                                <div class="flex items-center gap-3">
                                    <div class="bg-blue-50 rounded-full p-2 flex">
                                        <ion-icon name="logo-facebook" class="text-2xl text-blue-600"></ion-icon>
                                    </div>
                                    <div class="flex-1">
                                        <input type="text" name="facebook" class="w-full"
                                            value="{{ old('facebook', $socialLinks->facebook ?? '') }}"
                                            placeholder="http://www.facebook.com/">
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div class="bg-pink-50 rounded-full p-2 flex">
                                        <ion-icon name="logo-instagram" class="text-2xl text-pink-600"></ion-icon>
                                    </div>
                                    <div class="flex-1">
                                        <input type="text" name="instagram" class="w-full"
                                            value="{{ old('instagram', $socialLinks->instagram ?? '') }}"
                                            placeholder="http://www.instagram.com/">
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div class="bg-sky-50 rounded-full p-2 flex">
                                        <ion-icon name="logo-twitter" class="text-2xl text-sky-600"></ion-icon>
                                    </div>
                                    <div class="flex-1">
                                        <input type="text" name="twitter" class="w-full"
                                            value="{{ old('twitter', $socialLinks->twitter ?? '') }}"
                                            placeholder="http://www.twitter.com/">
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div class="bg-red-50 rounded-full p-2 flex">
                                        <ion-icon name="logo-youtube" class="text-2xl text-red-600"></ion-icon>
                                    </div>
                                    <div class="flex-1">
                                        <input type="text" name="youtube" class="w-full"
                                            value="{{ old('youtube', $socialLinks->youtube ?? '') }}"
                                            placeholder="http://www.youtube.com/">
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div class="bg-slate-50 rounded-full p-2 flex">
                                        <ion-icon name="logo-github" class="text-2xl text-black"></ion-icon>
                                    </div>
                                    <div class="flex-1">
                                        <input type="text" name="github" class="w-full"
                                            value="{{ old('github', $socialLinks->github ?? '') }}"
                                            placeholder="http://www.github.com/">
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-center gap-4 mt-16">
                                {{-- <button type="reset"
                                            class="button lg:px-6 bg-secondery max-md:flex-1">Cancel</button> --}}
                                <button type="submit"
                                    class="button lg:px-10 bg-primary text-white max-md:flex-1">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="mt-6" style="margin-top:20px;">
                    <h4 style="font-size:16px; font-weight:bold; color:#111; margin-bottom:10px;">
                        My Appointments
                    </h4>

                    @php
                        $totalAppointments = count($appointments);
                    @endphp

                    <div id="appointments-container">
                        @forelse ($appointments as $index => $appointment)
                            <div class="appointment-card"
                                style="border:1px solid #ccc; border-radius:6px; padding:12px; margin-bottom:8px; background:#fafafa; display:flex; justify-content:space-between; align-items:flex-start; {{ $index >= 2 ? 'display:none;' : '' }}">
                                <div style="width:70%;">

                                    <p style="margin:2px 0; font-size:13px;">
                                        <strong>Name:</strong>
                                        {{ $appointment->sender_id == auth()->id()
                                            ? $appointment->receiver->first_name . ' ' . $appointment->receiver->last_name
                                            : $appointment->sender->first_name . ' ' . $appointment->sender->last_name }}
                                    </p>
                                    <p style="margin:2px 0; font-size:13px;">
                                        <strong>Subject:</strong> {{ $appointment->subject }}
                                    </p>
                                    <p style="margin:2px 0; font-size:13px; color:#444;">
                                        <strong>Message:</strong> {{ $appointment->message_body }}
                                    </p>
                                    <p style="margin:2px 0; font-size:13px;">
                                        <strong>Status:</strong>
                                        <span
                                            style="font-weight:600; 
                                    color:{{ $appointment->status === 'accepted' ? '#16a34a' : ($appointment->status === 'rejected' ? '#dc2626' : '#ca8a04') }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </p>
                                    @if ($appointment->status == 'pending')
                                        <div class="m-2 flex gap-2">
                                            <form
                                                action="{{ route('messages.updateStatus', [$appointment->id, 'accepted']) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded">
                                                    Accept
                                                </button>
                                            </form>

                                            <form
                                                action="{{ route('messages.updateStatus', [$appointment->id, 'rejected']) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded"
                                                    style="background:red; color:white; padding:4px 8px;">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    @endif

                                    <p style="margin:0; font-size:11px; color:#777;">
                                        {{ $appointment->created_at->format('M d, Y h:i A') }}
                                    </p>
                                </div>
                                @if ($appointment->status === 'accepted' && $appointment->base_paid > 0)
                                    <div
                                        style="width:28%; background:#fff; padding:8px; border-radius:6px; border:1px solid #e5e5e5;">

                                        <p style="margin:2px 0; font-size:13px;">
                                            <strong>Paid:</strong> ₹{{ number_format($appointment->base_paid, 2) }}
                                        </p>

                                        <p style="margin:2px 0; font-size:13px; color:#16a34a;">
                                            <strong>You Get (80%):</strong>
                                            ₹{{ number_format($appointment->payable_amount, 2) }}
                                        </p>

                                        <p style="margin:2px 0; font-size:12px; color:#dc2626;">
                                            Platform Fee (20%): ₹{{ number_format($appointment->platform_fee, 2) }}
                                        </p>

                                        <p style="margin-top:6px; font-size:12px;">
                                            <strong>Release:</strong>
                                            <span
                                                style="font-weight:600; color:{{ $appointment->release_status == 1 ? '#16a34a' : '#ca8a04' }}">
                                                {{ $appointment->release_status == 1 ? 'Payment Released' : 'Not Released' }}
                                            </span>
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p style="color:#666; font-size:13px;">No appointments found.</p>
                        @endforelse
                    </div>

                    {{-- its js i apply on this file bottom --}}

                    @if ($totalAppointments > 2)
                        <div style="text-align:center; margin-top:10px;">
                            <button id="load-more-btn"
                                style="background:#007bff; color:white; border:none; padding:6px 12px; border-radius:4px; cursor:pointer;">
                                Load More
                            </button>
                        </div>
                    @endif
                </div>

                <div class="w-full mx-auto p-3 bg-white shadow rounded">
                    <div class="mt-6 p-2 bg-gray-100 rounded">
                        <h3 class="text-lg font-bold mb-3">Available Dates & Times</h3>
                        @forelse($availabilities as $slot)
                            <div class="flex justify-between items-center border-b py-2">
                                <p class="text-sm">
                                    {{ \Carbon\Carbon::parse($slot->available_date)->format('d M Y') }}
                                    - {{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }}
                                    to {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}
                                </p>
                                <form action="{{ route('counselor.availability.destroy', $slot->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded shadow-sm"
                                        style="background:red; color:white; padding:4px 8px;">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No availability set.</p>
                        @endforelse
                    </div>
                    <br>

                    <h2 class="text-lg font-bold mb-4">Set Your Availability</h2>
                    @php
                        use Carbon\Carbon;

                        $today = now()->toDateString();
                        $maxDate = now()->addDays(7)->toDateString();

                        // Generate time slots (30 min intervals, 24-hour values but show 12-hour format)
                        $timeSlots = [];
                        for ($hour = 0; $hour < 24; $hour++) {
                            for ($min = 0; $min < 60; $min += 30) {
                                $time24 = sprintf('%02d:%02d', $hour, $min);
                                $time12 = Carbon::createFromFormat('H:i', $time24)->format('g:i A');
                                $timeSlots[] = ['value' => $time24, 'label' => $time12];
                            }
                        }
                    @endphp

                    <form method="POST" action="{{ route('counselor.availability.store') }}">
                        @csrf

                        <!-- DATE -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Available Date</label>
                            <input type="date" name="available_date" value="{{ old('available_date') }}"
                                min="{{ $today }}" max="{{ $maxDate }}"
                                class="w-full border rounded px-3 py-2">
                            @error('available_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- START TIME -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Start Time</label>
                            <select name="start_time" class="w-full border rounded px-3 py-2">
                                <option value="">Select Start Time</option>
                                @foreach ($timeSlots as $time)
                                    <option value="{{ $time['value'] }}"
                                        {{ old('start_time') == $time['value'] ? 'selected' : '' }}>
                                        {{ $time['label'] }}
                                    </option>
                                @endforeach
                            </select>
                            @error('start_time')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- END TIME -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">End Time</label>
                            <select name="end_time" class="w-full border rounded px-3 py-2">
                                <option value="">Select End Time</option>
                                @foreach ($timeSlots as $time)
                                    <option value="{{ $time['value'] }}"
                                        {{ old('end_time') == $time['value'] ? 'selected' : '' }}>
                                        {{ $time['label'] }}
                                    </option>
                                @endforeach
                            </select>
                            @error('end_time')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        @if (auth()->user()->bank_status === 'verified' && auth()->user()->razorpay_account_id)
                            {{-- Bank verified --}}
                            <button type="submit" class="button lg:px-10 bg-primary text-white max-md:flex-1">
                                Save Availability
                            </button>
                        @elseif (auth()->user()->bank_status === 'pending')
                            <p class="text-yellow-600 text-sm font-medium">
                                Your bank details are under verification. Please wait for approval.
                            </p>
                        @elseif (auth()->user()->bank_status === 'rejected')
                            <p class="text-red-600 text-sm font-medium">
                                Bank verification rejected:
                                {{ auth()->user()->bank_rejection_reason ?? 'Please update bank details.' }}
                            </p>
                        @else
                            <p class="text-red-600 text-sm font-medium">
                                Please add and verify your bank details to set availability.
                            </p>
                        @endif

                    </form>
                </div>

                <!-- tab password-->
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="space-y-6 w-full mx-auto">
                        <div class="md:flex items-center gap-16 justify-between max-md:space-y-3">
                            <label class="md:w-40 text-right" for="current_password">Current Password</label>
                            <div class="flex-1 max-md:mt-4">
                                <input id="current_password" name="current_password" type="password"
                                    placeholder="******" class="w-full border rounded px-3 py-2"
                                    autocomplete="current-password">
                                @error('current_password', 'updatePassword')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="md:flex items-center gap-16 justify-between max-md:space-y-3">
                            <label class="md:w-40 text-right" for="password">New Password</label>
                            <div class="flex-1 max-md:mt-4">
                                <input id="password" name="password" type="password" placeholder="******"
                                    class="w-full border rounded px-3 py-2" autocomplete="new-password">
                                @error('password', 'updatePassword')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="md:flex items-center gap-16 justify-between max-md:space-y-3">
                            <label class="md:w-40 text-right" for="password_confirmation">Repeat Password</label>
                            <div class="flex-1 max-md:mt-4">
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                    placeholder="******" class="w-full border rounded px-3 py-2"
                                    autocomplete="new-password">
                                @error('password_confirmation', 'updatePassword')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-center gap-4 mt-16">
                        {{-- <button type="reset" class="button lg:px-6 bg-gray-300 max-md:flex-1">Cancel</button> --}}
                        <button type="submit" class="button lg:px-10 bg-primary text-white max-md:flex-1">Save</button>
                    </div>
                </form>

                <div class="max-w-lg mx-auto mb-6 text-center">
                    <p class="text-sm text-gray-600 mb-3">
                        AffirmSpace Privacy Policy
                    </p>
                    <div class="flex justify-center gap-4 text-sm font-medium">
                        <a href="{{ route('aboutUs') }}" target="_blank"
                            class="text-pink-600 hover:text-pink-700 underline transition" style="text-decoration:none;">
                            About Us
                        </a>
                        <span class="text-gray-400">•</span>
                        <a href="{{ route('contactus') }}" class="text-pink-600 hover:text-pink-700 underline transition"
                            style="text-decoration:none;">
                            Contact Us
                        </a>
                        <span class="text-gray-400">•</span>
                        <a href="{{ route('privacy') }}" target="_blank"
                            class="text-pink-600 hover:text-pink-700 underline transition" style="text-decoration:none;">
                            Privacy Policy
                        </a>
                        <span class="text-gray-400">•</span>
                        <a href="{{ route('refundPolicy') }}" target="_blank"
                            class="text-pink-600 hover:text-pink-700 underline transition" style="text-decoration:none;">
                            Refund Policy
                        </a>
                    </div>
                    <div class="mt-4 text-xs text-gray-400">
                        Your data safety and transparency matter to us 💖
                    </div>
                </div>

                <form method="POST" action="{{ route('profile.destroy') }}" class="max-w-lg mx-auto">
                    @csrf
                    @method('DELETE')

                    <div class="space-y-6">
                        <div class="flex justify-center">
                            <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded">
                                Delete Account
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </main>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let shown = 2;
            const total = {{ $totalAppointments }};
            const cards = document.querySelectorAll('.appointment-card');
            const loadMoreBtn = document.getElementById('load-more-btn');

            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function() {
                    let nextShow = shown + 2; // Show 2 more at a time
                    for (let i = shown; i < nextShow && i < total; i++) {
                        cards[i].style.display = 'block';
                    }
                    shown = nextShow;
                    if (shown >= total) {
                        loadMoreBtn.style.display = 'none';
                    }
                });
            }
        });
    </script>
@endsection
