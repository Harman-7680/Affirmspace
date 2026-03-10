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

    {{-- main contents --}}
    {{-- <main id="site__main" class="2xl:ml-[--w-side]  xl:ml-[--w-side-sm] p-2.5 h-[calc(100vh-var(--m-top))] mt-[--m-top]"> --}}
    <main class="max-w-8xl mx-auto mt-[--m-top] p-4">
        <div class="max-w-6xl mx-auto">
            <div class="box relative rounded-lg shadow-md">
                <div class="flex md:gap-8 gap-4 items-center md:p-8 p-6 md:pb-4">
                    <div class="relative md:w-20 md:h-20 w-12 h-12 shrink-0">
                        <label for="file" class="cursor-pointer">
                            <div class="mb-4 w-16 h-16 mx-auto">
                                <img id="img"
                                    src="{{ $user->image && $user->image !== '0' ? asset('storage/' . $user->image) : asset('images/avatars/avatar-1.jpg') }}"
                                    class="object-cover w-16 h-16 rounded-full border-2 border-gray-300 dark:border-gray-600 shadow-md"
                                    alt="" />
                            </div>
                        </label>
                    </div>

                    <div class="flex-1">
                        <h3 class="md:text-xl text-base font-semibold text-black dark:text-white">
                            {{ $user->first_name }} {{ $user->last_name }}
                        </h3>
                        <p class="text-sm text-blue-600 mt-1 font-normal">
                            <?php // echo '@';
                            ?>Counselee</p>
                    </div>
                </div>

                <!-- nav tabs -->
                <div class="relative border-b" tabindex="-1" uk-slider="finite: true">
                    {{-- <nav class="uk-slider-container overflow-hidden nav__underline px-6 p-0 border-transparent -mb-px"> --}}
                    {{-- <ul class="uk-slider-items w-[calc(100%+10px)] !overflow-hidden"
                            uk-switcher="connect: #setting_tab ; animation: uk-animation-slide-right-medium, uk-animation-slide-left-medium"> --}}

                    <nav class="uk-slider-container overflow-x-auto px-6 p-0 border-transparent -mb-px">
                        <ul class="uk-slider-items w-auto"
                            uk-switcher="connect: #setting_tab ; animation: uk-animation-slide-right-medium, uk-animation-slide-left-mediumm">
                            <li class="w-auto pl-4"> <a href="#"> Description </a> </li>
                            <li class="w-auto pl-4"> <a href="#"> Appointments </a> </li>
                            <li class="w-auto pl-4"> <a href="#"> Password </a> </li>
                            <li class="w-auto pl-4"> <a href="#"> Upload Post </a> </li>
                            <li class="w-auto pl-4"> <a href="#"> Update Posts </a> </li>
                            <li class="w-auto pl-4"> <a href="#"> Friends </a> </li>
                            <li class="w-auto pl-4"> <a href="#"> Blocked </a> </li>
                            <li class="w-auto pl-4"> <a href="#"> Muted </a> </li>
                            <li class="w-auto pl-4"> <a href="#"> Bookmark </a> </li>
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

                <div id="setting_tab" class="uk-switcher md:py-6 md:px-20 p-6 overflow-hidden text-black text-sm">

                    <!-- tab user basic info -->
                    <div>
                        <div>
                            <div class="mt-4">
                                <label class="flex items-center space-x-2">
                                    <span>Private Account</span>
                                    <input type="checkbox" id="privateAccount" class="rounded"
                                        {{ auth()->user()->is_private ? 'checked' : '' }}>
                                </label>
                            </div>

                            <div class="mt-4">
                                <label>Your referral link</label>
                                <input type="text" readonly
                                    value="{{ url('/register?ref=' . auth()->user()->refer_code) }}"
                                    class="w-full border rounded-md p-2"
                                    onclick="this.select(); document.execCommand('copy'); alert('Referral link copied!')">
                            </div>
                            <br>

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
                                            <input type="text" name="last_name"
                                                value="{{ old('last_name', $user->last_name) }}"
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
                                            <textarea name="bio" class="w-full border rounded-md p-2" rows="5">{{ old('bio', $user->bio ?? '') }}</textarea>
                                            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                                        </div>
                                    </div>

                                    {{-- Address --}}
                                    <div class="md:flex items-center gap-10 mt-4">
                                        <label class="md:w-32 text-right">Address</label>
                                        <div class="flex-1 max-md:mt-4">
                                            <input type="text" name="address"
                                                value="{{ old('address', $user->address) }}"
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
                                                    {{ old('gender', $user->gender) == 'Woman' ? 'selected' : '' }}>Woman
                                                </option>
                                                <option value="Man"
                                                    {{ old('gender', $user->gender) == 'Man' ? 'selected' : '' }}>Man
                                                </option>
                                                <option value="Trans Woman"
                                                    {{ old('gender', $user->gender) == 'Trans Woman' ? 'selected' : '' }}>
                                                    Trans
                                                    Woman</option>
                                                <option value="Trans Man"
                                                    {{ old('gender', $user->gender) == 'Trans Man' ? 'selected' : '' }}>
                                                    Trans Man
                                                </option>
                                                <option value="Non-binary"
                                                    {{ old('gender', $user->gender) == 'Non-binary' ? 'selected' : '' }}>
                                                    Non-binary
                                                </option>
                                                <option value="Genderqueer"
                                                    {{ old('gender', $user->gender) == 'Genderqueer' ? 'selected' : '' }}>
                                                    Genderqueer</option>
                                                <option value="Agender"
                                                    {{ old('gender', $user->gender) == 'Agender' ? 'selected' : '' }}>
                                                    Agender
                                                </option>
                                                <option value="Bigender"
                                                    {{ old('gender', $user->gender) == 'Bigender' ? 'selected' : '' }}>
                                                    Bigender
                                                </option>
                                                <option value="Genderfluid"
                                                    {{ old('gender', $user->gender) == 'Genderfluid' ? 'selected' : '' }}>
                                                    Genderfluid</option>
                                                <option value="Two-Spirit"
                                                    {{ old('gender', $user->gender) == 'Two-Spirit' ? 'selected' : '' }}>
                                                    Two-Spirit
                                                </option>
                                                <option value="Intersex"
                                                    {{ old('gender', $user->gender) == 'Intersex' ? 'selected' : '' }}>
                                                    Intersex
                                                </option>
                                                <option value="Questioning"
                                                    {{ old('gender', $user->gender) == 'Questioning' ? 'selected' : '' }}>
                                                    Questioning</option>
                                                <option value="Prefer not to say"
                                                    {{ old('gender', $user->gender) == 'Prefer not to say' ? 'selected' : '' }}>
                                                    Prefer not to say</option>
                                                {{-- <option value="Other"
                                                    {{ old('gender', $user->gender) == 'Other' ? 'selected' : '' }}>Other
                                                </option> --}}
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
                                                    {{ old('relationship', $user->relationship) == 'None' ? 'selected' : '' }}>
                                                    None
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
                                                    {{ old('pronouns', $user->pronouns) == '' ? 'selected' : '' }}>Select
                                                    Pronouns
                                                </option>
                                                <option value="He/Him"
                                                    {{ old('pronouns', $user->pronouns) == 'He/Him' ? 'selected' : '' }}>
                                                    He/Him
                                                </option>
                                                <option value="She/Her"
                                                    {{ old('pronouns', $user->pronouns) == 'She/Her' ? 'selected' : '' }}>
                                                    She/Her
                                                </option>
                                                <option value="They/Them"
                                                    {{ old('pronouns', $user->pronouns) == 'They/Them' ? 'selected' : '' }}>
                                                    They/Them</option>
                                                <option value="Other"
                                                    {{ old('pronouns', $user->pronouns) == 'Other' ? 'selected' : '' }}>
                                                    Other
                                                </option>
                                                <option value="Prefer not to say"
                                                    {{ old('pronouns', $user->pronouns) == 'Prefer not to say' ? 'selected' : '' }}>
                                                    Prefer not to say</option>
                                            </select>
                                            <x-input-error class="mt-2" :messages="$errors->get('pronouns')" />
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
                                    <button type="submit" class="button lg:px-10 bg-primary text-white max-md:flex-1">
                                        Save <span class="ripple-overlay"></span>
                                    </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- tab socialinks -->
                {{-- <div>
                    <div class="max-w-md mx-auto">
                        <div class="font-normal text-gray-400">
                            <div>
                                <h4 class="text-xl font-medium text-black dark:text-white"> Social Links </h4>
                                <p class="mt-3 font-normal text-gray-600 dark:text-white">We may still send you
                                    important notifications about your account and content outside of you
                                    preferred notivications settings</p>
                            </div>

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

                                <div class="flex items-center justify-center mt-4">
                                    @if (session('status') === 'social-links-updated')
                                        <p class="text-green-600">Social links updated successfully.</p>
                                    @endif
                                </div>

                                <div class="flex items-center justify-center gap-4 mt-16">
                                    // if uncomment comment reset button
                                    <button type="reset"
                                            class="button lg:px-6 bg-secondery max-md:flex-1">Cancel</button>
                                    <button type="submit"
                                        class="button lg:px-10 bg-primary text-white max-md:flex-1">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> --}}

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
                                style="border:1px solid #ccc; border-radius:6px; padding:8px 12px; margin-bottom:8px; background:#fafafa; {{ $index >= 2 ? 'display:none;' : '' }}">
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
                                <p style="margin:0; font-size:11px; color:#777;">
                                    {{ $appointment->created_at->format('M d, Y h:i A') }}
                                </p>
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

                                @if (auth()->user()->social_id)
                                    <p class="text-sm text-blue-500 mt-1">
                                        Logged in with Google/Facebook? Setting a password for the first time — use <span
                                            class="font-semibold">Forgot Password</span>.
                                    </p>
                                @endif
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
                        <button type="submit" class="button lg:px-10 bg-primary text-white max-md:flex-1">Save</button>
                    </div>
                </form>

                {{-- upload post --}}
                <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-6 w-full mx-auto">
                        <!-- Caption -->
                        <div>
                            <label for="caption" class="block text-sm font-medium text-gray-700">Caption</label>
                            <input type="text" name="caption" id="caption" class="w-full border rounded px-3 py-3"
                                placeholder="Write something..." value="{{ old('caption') }}">
                            @error('caption')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Media Upload -->
                        <div class="mt-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Upload Image or Video
                            </label>

                            <!-- Custom Upload Box -->
                            <div onclick="document.getElementById('media').click()"
                                class="relative flex flex-col items-center justify-center w-full h-44 border-2 border-dashed border-gray-300 rounded-2xl 
               bg-gradient-to-br from-gray-50 to-gray-100 hover:from-blue-50 hover:to-blue-100 
               transition-all duration-300 cursor-pointer">
                                <input type="file" name="media" id="media" accept="image/*,video/*"
                                    class="hidden" onchange="previewSingleMedia(event)">

                                <div id="upload_placeholder" class="flex flex-col items-center text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mb-2 text-blue-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 0115.9 6H16a5 5 0 011 9.9V17H7z" />
                                    </svg>
                                    <p class="text-sm text-gray-600 font-medium">Click to upload or drag & drop</p>
                                    <p class="text-xs text-gray-400 mt-1">Supports one image or video (max 20MB)</p>
                                </div>

                                <!-- Preview (hidden until file selected) -->
                                <div id="preview_box" class="absolute inset-0 hidden items-center justify-center">
                                    <img id="preview_image" class="w-full h-full object-cover rounded-2xl"
                                        alt="Preview">
                                    <video id="preview_video" controls
                                        class="w-full h-full object-cover rounded-2xl hidden"></video>
                                </div>
                            </div>

                            @error('media')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <script>
                            function previewSingleMedia(event) {
                                const file = event.target.files[0];
                                const uploadPlaceholder = document.getElementById('upload_placeholder');
                                const previewBox = document.getElementById('preview_box');
                                const previewImage = document.getElementById('preview_image');
                                const previewVideo = document.getElementById('preview_video');

                                if (!file) {
                                    previewBox.classList.add('hidden');
                                    uploadPlaceholder.classList.remove('hidden');
                                    return;
                                }

                                const fileType = file.type;
                                const reader = new FileReader();

                                reader.onload = function(e) {
                                    uploadPlaceholder.classList.add('hidden');
                                    previewBox.classList.remove('hidden');
                                    if (fileType.startsWith('image/')) {
                                        previewImage.src = e.target.result;
                                        previewImage.classList.remove('hidden');
                                        previewVideo.classList.add('hidden');
                                    } else if (fileType.startsWith('video/')) {
                                        previewVideo.src = e.target.result;
                                        previewVideo.classList.remove('hidden');
                                        previewImage.classList.add('hidden');
                                    }
                                };

                                reader.readAsDataURL(file);
                            }
                        </script>

                        {{-- @if (session('success'))
                            <p class="text-green-500 text-sm">{{ session('success') }}</p>
                        @endif --}}

                        <div class="flex justify-center mt-6">
                            <button type="submit" class="button lg:px-10 bg-primary text-white">Upload</button>
                        </div>
                    </div>
                </form>

                {{-- update post --}}

                {{-- its js on bottom of this file --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($uploaded_post as $post)
                        <form method="POST" action="{{ route('posts.update', $post->id) }}"
                            enctype="multipart/form-data"
                            class="bg-white shadow-md rounded-lg p-4 border border-gray-200 space-y-4">
                            @csrf
                            @method('PUT')

                            <!-- Post Media -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Current Media</label>
                                @php
                                    $file = $post->post_image;
                                    $isVideo = \Illuminate\Support\Str::endsWith($file, [
                                        '.mp4',
                                        '.mov',
                                        '.avi',
                                        '.webm',
                                    ]);
                                @endphp

                                @if ($isVideo)
                                    <video autoplay muted loop playsinline
                                        class="w-full h-48 object-cover rounded-md border">
                                        <source src="{{ asset('storage/' . $file) }}"
                                            type="video/{{ pathinfo($file, PATHINFO_EXTENSION) }}">
                                        Your browser does not support the video tag.
                                    </video>
                                @else
                                    <img src="{{ asset('storage/' . $file) }}" alt="Post Media"
                                        class="w-full h-48 object-cover rounded-md border">
                                @endif
                            </div>

                            <!-- Caption Input -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Caption</label>
                                <input type="text" name="caption" value="{{ old('caption', $post->caption) }}"
                                    class="w-full px-3 py-2 border @error('caption') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('caption')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Upload New Image -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Upload New Image</label>
                                <input type="file" name="image"
                                    class="w-full px-3 py-2 border @error('image') border-red-500 @else border-gray-300 @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('image')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="text-right">
                                <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                    Update Post
                                </button>
                            </div>
                        </form>

                        <!-- Delete Form -->
                        {{-- <form method="POST" action="{{ route('posts.destroy', $post->id) }}" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this post?')"
                                class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition w-full">
                                Delete Post
                            </button>
                        </form> --}}
                    @endforeach
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse ($followers as $follower)
                        <div class="bg-white shadow-sm rounded-xl p-3 border border-gray-200 w-full max-w-sm mx-auto">

                            <!-- Small Rounded Profile Image -->
                            <div class="flex justify-center mb-2">
                                <img src="{{ $follower->image ? asset('storage/' . $follower->image) : asset('images/avatars/avatar-1.jpg') }}"
                                    alt="" class="w-14 h-14 object-cover rounded-full border shadow-sm">
                            </div>

                            <!-- Follower Info -->
                            <div class="text-center">
                                <h3 class="text-base font-semibold text-gray-800 truncate">{{ $follower->first_name }}
                                </h3>
                                <p class="text-xs text-gray-500 truncate">{{ $follower->email }}</p>
                            </div>

                            <!-- Unfriend Button -->
                            <div class="text-center mt-2">
                                <form action="{{ route('unfriend', $follower->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to unfriend this user?');"
                                        class="mt-2 px-4 py-2 bg-red-600 text-white text-sm rounded-md hover:bg-red-700 shadow-md">
                                        Unfriend
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">No followers yet.</p>
                    @endforelse
                </div>

                <!-- Blocked Users Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse ($blockedUsers as $blocked)
                        <div class="bg-white shadow-sm rounded-xl p-3 border border-gray-200 w-full max-w-sm mx-auto">
                            <!-- Profile Image -->
                            <div class="flex justify-center mb-2">
                                <img src="{{ $blocked->image ? asset('storage/' . $blocked->image) : asset('images/avatars/avatar-1.jpg') }}"
                                    alt="" class="w-14 h-14 object-cover rounded-full border shadow-sm">
                            </div>

                            <!-- Blocked User Info -->
                            <div class="text-center">
                                <h3 class="text-base font-semibold text-gray-800 truncate">{{ $blocked->first_name }}</h3>
                                <p class="text-xs text-gray-500 truncate">{{ $blocked->email }}</p>
                            </div>

                            <!-- Unblock Button -->
                            <div class="text-center mt-2">
                                <button type="button" onclick="unblockUser({{ $blocked->id }})"
                                    class="mt-2 px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 shadow-md">
                                    Unblock
                                </button>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">No blocked users.</p>
                    @endforelse
                </div>

                <!-- Muted Users Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse ($mutedUsers as $muted)
                        <div class="bg-white shadow-sm rounded-xl p-3 border border-gray-200 w-full max-w-sm mx-auto">
                            <!-- Profile Image -->
                            <div class="flex justify-center mb-2">
                                <img src="{{ $muted->image ? asset('storage/' . $muted->image) : asset('images/avatars/avatar-1.jpg') }}"
                                    alt="" class="w-14 h-14 object-cover rounded-full border shadow-sm">
                            </div>

                            <!-- Muted User Info -->
                            <div class="text-center">
                                <h3 class="text-base font-semibold text-gray-800 truncate">{{ $muted->first_name }}</h3>
                                <p class="text-xs text-gray-500 truncate">{{ $muted->email }}</p>
                            </div>

                            <!-- Unmute Button -->
                            <div class="text-center mt-2">
                                <button type="button" onclick="unmuteUser({{ $muted->id }})"
                                    class="mt-2 px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 shadow-md">
                                    Unmute
                                </button>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">No muted users.</p>
                    @endforelse
                </div>

                <!-- Bookmarked Posts Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse ($bookmarkedPosts as $post)
                        <div class="bg-white shadow-sm rounded-xl p-4 border border-gray-200 w-full max-w-sm mx-auto">
                            <div class="flex items-center mb-2">
                                <img src="{{ $post->user && $post->user->image ? asset('storage/' . $post->user->image) : asset('images/avatars/avatar-1.jpg') }}"
                                    class="w-10 h-10 rounded-full mr-3 object-cover">
                                <h3 class="text-sm font-semibold text-gray-800">
                                    {{ $post->user->first_name ?? 'Unknown' }}</h3>
                            </div>

                            <p class="text-sm text-gray-700 mb-3">
                                {{ Str::limit($post->content ?? 'No Caption', 100) }}
                            </p>

                            {{-- POST IMAGE --}}
                            @if (!empty($post->post_image))
                                <img src="{{ asset('storage/' . $post->post_image) }}"
                                    class="w-full h-40 object-cover rounded-md mb-3" loading="lazy">
                            @endif

                            <div class="text-center">
                                <button type="button"
                                    class="remove-bookmark px-4 py-2 bg-red-600 text-white text-sm rounded-md hover:bg-red-700 shadow-md"
                                    data-post-id="{{ $post->id }}">
                                    Remove Bookmark
                                </button>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">No bookmarked posts.</p>
                    @endforelse
                </div>

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
                        <a href="{{ route('contactUs') }}" class="text-pink-600 hover:text-pink-700 underline transition"
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
                                onclick="return confirm('Are you Sure you Want to Delete Your Account ?');"
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
    @include('layouts.chatbot')
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('video').forEach(video => {
                video.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    this.paused ? this.play() : this.pause();
                });
            });
        });
    </script>

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

    <!-- JS for unmute/unblock -->
    <script>
        async function unblockUser(userId) {
            if (!confirm("Are you sure you want to unblock this user?")) return;

            try {
                const response = await fetch(`unblock/${userId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                if (response.ok) {
                    alert("User unblocked successfully");
                    location.reload();
                } else {
                    alert("Something went wrong while unblocking.");
                }
            } catch (error) {
                console.error(error);
                alert("Error unblocking user.");
            }
        }

        async function unmuteUser(userId) {
            if (!confirm("Are you sure you want to unmute this user?")) return;

            try {
                const response = await fetch(`unmute/${userId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                if (response.ok) {
                    alert("User unmuted successfully");
                    location.reload();
                } else {
                    alert("Something went wrong while unmuting.");
                }
            } catch (error) {
                console.error(error);
                alert("Error unmuting user.");
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('privateAccount');

            checkbox.addEventListener('change', function() {
                fetch('{{ route('settings.privacy') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            is_private: checkbox.checked
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Privacy updated!');
                        } else {
                            alert('Failed to update privacy.');
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        alert('An error occurred.');
                    });
            });
        });
    </script>

    <script>
        $(document).on('click', '.remove-bookmark', function() {
            const postId = $(this).data('post-id');
            const button = $(this);

            $.ajax({
                url: "{{ route('bookmark') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    post_id: postId
                },
                success: function(response) {
                    if (response.status === 'removed') {
                        button.closest('div.bg-white').fadeOut(400, function() {
                            $(this).remove();
                            // Slight reload to update page
                            // setTimeout(() => location.reload(), 300);
                        });
                    }
                },
                error: function() {
                    alert('Something went wrong while removing the bookmark.');
                }
            });
        });
    </script>
@endsection
