@extends('layouts.app1')

@section('content')
    <div class="global-hearts" aria-hidden="true">
        <span class="heart">💖</span>
        <span class="heart">💜</span>
        <span class="heart">💙</span>
        <span class="heart">💗</span>
        <span class="heart">💞</span>
        <span class="heart">💘</span>
        <span class="heart">💖</span>
        <span class="heart">💜</span>
        <span class="heart">💙</span>
    </div>

    <div class="page-wrapper flex justify-center items-center px-4 py-10">
        <div
            class="card w-full max-w-3xl p-6 sm:p-12 rounded-2xl shadow-xl bg-white/95 backdrop-blur-xl border border-gray-200">

            {{-- HEADER: Progress Bar & Step Counter --}}
            <div id="onboardingHeader" class="mb-6 hidden">
                <div class="flex justify-between items-center mb-2">
                    <span id="stepIndicator"
                        class="text-xs font-bold uppercase tracking-wider text-pink-600 bg-pink-50 px-3 py-1 rounded-full border border-pink-100">
                        Step 1 of 12
                    </span>
                </div>
                <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                    <div id="progressBar"
                        class="bg-gradient-to-r from-pink-500 to-purple-600 h-full w-0 transition-all duration-300"></div>
                </div>
            </div>

            <form id="tinderForm" novalidate>
                @csrf

                <input type="hidden" id="currentStepInput" value="1">

                {{-- STEP 1: WELCOME SCREEN --}}
                <div class="q-block welcome-block active text-center">
                    <div
                        class="w-20 h-20 mx-auto mb-4 bg-gradient-to-tr from-pink-100 to-purple-100 rounded-full flex items-center justify-center text-4xl shadow-inner border border-pink-200">
                        💖
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-pink-600 mb-4 drop-shadow-sm">
                        Welcome to AffirmSpace Dating
                    </h1>
                    <p class="text-gray-700 text-base sm:text-lg leading-relaxed mb-6">
                        A safe, warm, and inclusive place where every identity is respected and every connection is
                        celebrated.
                        <br><br>
                        Let’s understand you better so we can help you find meaningful matches.
                    </p>

                    <div class="grid grid-cols-3 gap-2 mb-6 text-xs font-medium text-gray-800">
                        <div class="bg-pink-50/80 p-2.5 rounded-xl border border-pink-100">🛡️ Verified</div>
                        <div class="bg-purple-50/80 p-2.5 rounded-xl border border-purple-100">🔒 Privacy First</div>
                        <div class="bg-pink-50/80 p-2.5 rounded-xl border border-pink-100">🏳️‍🌈 Inclusive</div>
                    </div>

                    <button type="button" id="startBtn" class="start-btn mt-2 w-full sm:w-auto">
                        Start Now →
                    </button>
                </div>

                {{-- STEP 2: IDENTITY VERIFICATION --}}
                <div class="q-block hidden">
                    <h2 class="q-title">Verify Your Identity</h2>
                    <p class="sub-text">Enhance security, authenticity, and prevent fake profiles while keeping total
                        privacy.</p>
                    <div class="static-box text-center py-6">
                        <span class="text-4xl mb-2 block">📸✨</span>
                        <p class="text-sm font-semibold text-gray-800">Quick Verification (Optional)</p>
                        <p class="text-xs text-gray-600 mt-1">Verified profiles get up to 3x more meaningful connections!
                        </p>
                    </div>
                </div>

                {{-- STEP 3: WHO ARE YOU INTERESTED IN & GOAL --}}
                <div class="q-block hidden space-y-3">
                    <div>
                        <h2 class="text-xs font-extrabold text-gray-900 mb-0.5">Your Identity</h2>
                        <p class="text-[9px] text-gray-500 mb-1.5">Select how you identify yourself.</p>
                        <select name="identity" class="f-input text-[10px] py-1 px-1.5" required>
                            <option value="" disabled selected>Select identity</option>
                            <option value="Man">Man</option>
                            <option value="Woman">Woman</option>
                            <option value="Non-binary">Non-binary</option>
                            <option value="Transgender">Transgender</option>
                        </select>
                        <p class="error-msg text-red-500 text-[9px] mt-0.5 hidden"></p>
                    </div>

                    <div>
                        <h2 class="text-xs font-extrabold text-gray-900 mb-0.5">Who are you interested in?</h2>
                        <p class="text-[9px] text-gray-500 mb-1.5">Choose who you naturally feel drawn to connect with.</p>
                        <select name="preference" class="f-input text-[10px] py-1 px-1.5" required>
                            <option value="" disabled selected>Select preference</option>
                            @foreach (['Woman', 'Man', 'Non-binary', 'Everyone'] as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                        <p class="error-msg text-red-500 text-[9px] mt-0.5 hidden"></p>
                    </div>

                    <div>
                        <h2 class="text-xs font-extrabold text-gray-900 mb-0.5">What type of vibe are you looking for?</h2>
                        <p class="text-[9px] text-gray-500 mb-1.5">Choose the connection that feels right today.</p>
                        <select name="relationship_type" class="f-input text-[10px] py-1 px-1.5" required>
                            <option value="" disabled selected>Select vibe</option>
                            @foreach (['Long Term', 'Short Term', 'Friendship', 'Marriage', 'Soul Connection', 'Casual'] as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                        <p class="error-msg text-red-500 text-[9px] mt-0.5 hidden"></p>
                    </div>
                </div>

                {{-- STEP 4: BASIC PROFILE INFO --}}
                <div class="q-block hidden space-y-2">
                    <div>
                        <h2 class="text-xs font-extrabold text-gray-900 mb-0.5">Basic Information</h2>
                        <p class="text-[9px] text-gray-500 mb-2">Tell us a bit about yourself.</p>
                    </div>

                    <div class="space-y-2 max-h-[260px] overflow-y-auto pr-1">
                        <div>
                            <label class="block text-[9px] font-bold text-gray-600 uppercase tracking-wider mb-0.5">Display
                                Name</label>
                            <input type="text" name="dating_display_name" class="f-input text-[10px] py-2 px-2.5"
                                placeholder="Dating Display Name (e.g. Alex)" data-type="string" required>
                            <p class="error-msg text-red-500 text-[9px] mt-0.5 hidden"></p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-1.5">
                            <div>
                                <label class="block text-[9px] font-bold text-gray-600 uppercase tracking-wider mb-0.5">Date
                                    Of Birth</label>
                                <input type="date" name="dob" class="f-input text-[10px] py-2 px-2.5"
                                    data-type="date" required>
                                <p class="error-msg text-red-500 text-[9px] mt-0.5 hidden"></p>
                            </div>
                            <div>
                                <label
                                    class="block text-[9px] font-bold text-gray-600 uppercase tracking-wider mb-0.5">Height</label>
                                <input type="text" name="height" class="f-input text-[10px] py-2 px-2.5"
                                    placeholder="Height (e.g. 5'10'')" data-type="height" required>
                                <p class="error-msg text-red-500 text-[9px] mt-0.5 hidden"></p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-1.5">

                            <input type="hidden" name="lat" id="lat">
                            <input type="hidden" name="lng" id="lng">

                            <!-- Location -->
                            <div>
                                <label class="block text-[9px] font-bold text-gray-600 uppercase tracking-wider mb-1">
                                    Location
                                </label>

                                <!-- Option -->
                                <div class="flex items-center gap-3 mb-2 text-[10px]">
                                    <label class="flex items-center gap-1 cursor-pointer">
                                        <input type="radio" name="location_type" value="current" checked>
                                        <span>Current</span>
                                    </label>

                                    <label class="flex items-center gap-1 cursor-pointer">
                                        <input type="radio" name="location_type" value="manual">
                                        <span>Manual</span>
                                    </label>
                                </div>

                                <!-- Current Location -->
                                <div id="currentLocationBox">
                                    <button type="button" id="detectLocation"
                                        class="w-full py-2 rounded-lg bg-blue-600 text-white text-[10px] hover:bg-blue-700">
                                        📍 Use Current Location
                                    </button>
                                </div>

                                <!-- Manual -->
                                <div id="manualLocationBox" class="hidden">
                                    <input type="text" name="city" id="city"
                                        class="f-input text-[10px] py-2 px-2.5" placeholder="Search your city">
                                </div>

                                <!-- Hidden -->
                                <input type="hidden" name="latitude" id="latitude">
                                <input type="hidden" name="longitude" id="longitude">

                                <p class="error-msg text-red-500 text-[9px] mt-0.5 hidden"></p>
                            </div>

                            <!-- Job Title -->
                            <div>
                                <label class="block text-[9px] font-bold text-gray-600 uppercase tracking-wider mb-0.5">
                                    Job Title
                                </label>

                                <input type="text" name="job_title" class="f-input text-[10px] py-2 px-2.5"
                                    placeholder="job_title" data-type="string" required>

                                <p class="error-msg text-red-500 text-[9px] mt-0.5 hidden"></p>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- STEP 5: GENDER & PRONOUNS --}}
                <div class="q-block hidden">
                    <h2 class="q-title">Gender & Pronouns</h2>
                    <p class="sub-text">We proudly welcome all identities. Confirm your gender details.</p>

                    <div class="space-y-3">
                        <div>
                            <label class="text-xs font-bold text-gray-700 mb-1 block">Your Registered Gender</label>
                            <div class="static-box py-3 px-4 font-semibold text-gray-900 bg-white">
                                {{ $user->gender ?? 'Not Specified' }}
                            </div>
                            <input type="hidden" name="gender" value="{{ $user->gender ?? '' }}">
                        </div>

                        <div>
                            <label class="text-xs font-bold text-gray-700 mb-1 block">Pronouns (Optional)</label>
                            <input type="text" name="pronouns" class="f-input text-sm py-3"
                                placeholder="e.g. She/Her, They/Them, He/Him">
                        </div>
                    </div>
                </div>

                {{-- STEP 6: PHOTOS UPLOAD WITH PREVIEW --}}
                <div class="q-block hidden space-y-2">
                    <div>
                        <h2 class="text-xs font-extrabold text-gray-900 mb-0.5">Upload Dating Photos</h2>
                        <p class="text-[9px] text-gray-500 mb-2">Add your best moments! (Preview shows instantly)</p>
                    </div>
                    <div class="field-group" data-name="photos">
                        <div class="grid grid-cols-3 sm:grid-cols-6 gap-1.5">
                            @for ($i = 1; $i <= 6; $i++)
                                <label
                                    class="photo-upload-box relative w-full h-14 bg-gray-50 border border-dashed border-gray-300 rounded-lg flex flex-col items-center justify-center cursor-pointer hover:border-pink-500 hover:bg-pink-50/20 overflow-hidden group shadow-xs transition">
                                    <div class="placeholder-content flex flex-col items-center">
                                        <span
                                            class="text-sm group-hover:scale-110 transition-transform text-pink-500 font-bold">+</span>
                                        <span class="text-[8px] font-semibold text-gray-500">Photo
                                            {{ $i }}</span>
                                    </div>
                                    <img src="" alt="Preview"
                                        class="preview-img hidden absolute inset-0 w-full h-full object-cover">
                                    <input type="file" name="photos[]" accept="image/*"
                                        class="photo-input absolute inset-0 opacity-0 cursor-pointer">
                                </label>
                            @endfor
                        </div>
                        <p class="error-msg text-red-500 text-xs mt-2 hidden"></p>
                    </div>
                </div>

                {{-- STEP 7: ABOUT ME (BIO) --}}
                <div class="q-block hidden">
                    <h2 class="q-title">Tell us something about yourself</h2>
                    <p class="sub-text">A short bio helps others connect with you better ❤️</p>
                    <textarea name="bio" class="f-input text-sm" rows="4" maxlength="250"
                        placeholder="Example: I love deep conversations, late-night walks, and good music..." data-type="string" required></textarea>
                    <p class="error-msg text-red-500 text-xs mt-1 hidden"></p>
                </div>

                {{-- STEP 8: INTERESTS --}}
                <div class="q-block hidden space-y-2">
                    <div>
                        <h2 class="text-xs font-extrabold text-gray-900 mb-0.5">💖 Select Your Interests</h2>
                        <p class="text-[9px] text-gray-500 mb-2">Pick the things you love doing (Select at least one)</p>
                    </div>

                    <div class="flex flex-wrap gap-1.5 max-h-[240px] overflow-y-auto pr-1">
                        @php
                            $interests = [
                                'Travel' => '✈️',
                                'Music' => '🎵',
                                'Movies' => '🎬',
                                'Coffee' => '☕',
                                'Fitness' => '💪',
                                'Hiking' => '🥾',
                                'Yoga' => '🧘‍♀️',
                                'Reading' => '📚',
                                'Gaming' => '🎮',
                                'Photography' => '📸',
                                'Cooking' => '🍳',
                                'Pets' => '🐾',
                                'Art' => '🎨',
                                'Nature' => '🌿',
                                'Technology' => '💻',
                                'Food' => '🍕',
                                'Sports' => '⚽',
                            ];
                        @endphp

                        @foreach ($interests as $item => $emoji)
                            <label
                                class="px-2.5 py-1.5 rounded-lg border border-gray-200 text-[10px] font-semibold cursor-pointer transition-all bg-gray-50 hover:bg-pink-50/30 hover:border-pink-400 select-none flex items-center gap-1.5 shadow-2xs group">
                                <input type="checkbox" name="interests[]" value="{{ $item }}"
                                    class="accent-pink-600 w-3 h-3 rounded interest-checkbox">
                                <span class="text-black group-hover:text-pink-600 transition font-bold">{{ $emoji }}
                                    {{ $item }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p class="error-msg text-red-500 text-[9px] mt-1 hidden"></p>
                </div>

                {{-- STEP 9: LIFESTYLE --}}
                <div class="q-block hidden">
                    <h2 class="q-title">Lifestyle & Vibe</h2>
                    <p class="sub-text">Share your daily habits.</p>
                    <div class="space-y-3 max-h-[280px] overflow-y-auto pr-1">
                        <div>
                            <select name="lifestyle_smoking" class="f-input text-sm py-2.5" required>
                                <option value="" disabled selected>Smoking Habit</option>
                                <option value="Non-smoker">Non-smoker</option>
                                <option value="Social smoker">Social smoker</option>
                            </select>
                            <p class="error-msg text-red-500 text-[9px] mt-1 hidden"></p>
                        </div>
                        <div>
                            <select name="lifestyle_drinking" class="f-input text-sm py-2.5" required>
                                <option value="" disabled selected>Drinking Habit</option>
                                <option value="Non-drinker">Non-drinker</option>
                                <option value="Social drinker">Social drinker</option>
                            </select>
                            <p class="error-msg text-red-500 text-[9px] mt-1 hidden"></p>
                        </div>
                        <div>
                            <select name="lifestyle_pets" class="f-input text-sm py-2.5" required>
                                <option value="" disabled selected>Pet Lover?</option>
                                <option value="Dog person">Dog person 🐶</option>
                                <option value="Cat person">Cat person 🐱</option>
                            </select>
                            <p class="error-msg text-red-500 text-[9px] mt-1 hidden"></p>
                        </div>
                    </div>
                </div>

                {{-- STEP 10: PRIVACY CONTROLS --}}
                <div class="q-block hidden">
                    <h2 class="q-title">Privacy Controls</h2>
                    <p class="sub-text">Your safety and comfort come first.</p>
                    <div class="space-y-3.5">
                        <div>
                            <label class="text-xs font-bold text-gray-700 mb-1 block">Who can see your profile?</label>
                            <select name="privacy_profile_view" class="f-input text-sm py-3 text-gray-900 bg-white"
                                required>
                                <option value="" disabled selected>Select option</option>
                                <option value="everyone">Everyone on AffirmSpace</option>
                                <option value="verified_only">Verified Members Only</option>
                            </select>
                            <p class="error-msg text-red-500 text-[9px] mt-1 hidden"></p>
                        </div>

                        <div>
                            <label class="text-xs font-bold text-gray-700 mb-1 block">
                                Who can message you?
                            </label>
                            <select name="who_can_message" class="f-input text-sm py-3 text-gray-900 bg-white" required>
                                <option value="" disabled selected>Select option</option>
                                <option value="everyone">Everyone</option>
                                <option value="matches_only">Verified Members Only</option>
                            </select>
                            <p class="error-msg text-red-500 text-[9px] mt-1 hidden"></p>
                        </div>
                        <label
                            class="flex items-center justify-between p-4 bg-white rounded-xl border border-gray-300 cursor-pointer hover:border-pink-500 shadow-sm">
                            <span class="text-sm font-bold text-gray-900">Hide my Distance</span>
                            <input type="checkbox" name="hide_distance" value="1"
                                class="w-5 h-5 accent-pink-600 rounded">
                        </label>
                        <label
                            class="flex items-center justify-between p-4 bg-white rounded-xl border border-gray-300 cursor-pointer hover:border-pink-500 shadow-sm">
                            <span class="text-sm font-bold text-gray-900">Hide my Online Status</span>
                            <input type="checkbox" name="hide_online" value="1"
                                class="w-5 h-5 accent-pink-600 rounded">
                        </label>
                    </div>
                </div>

                {{-- STEP 11: MATCH PREFERENCES --}}
                <div class="q-block hidden">
                    <h2 class="q-title">Match Preferences</h2>
                    <p class="sub-text">Customize your discovery feed.</p>
                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-bold text-gray-700 mb-1 block">Preferred Age Range</label>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <input type="number" name="min_age" value="18" min="18"
                                        class="f-input text-sm py-2" data-type="number" required>
                                    <p class="error-msg text-red-500 text-[9px] mt-1 hidden"></p>
                                </div>
                                <div>
                                    <input type="number" name="max_age" value="50" min="18"
                                        class="f-input text-sm py-2" data-type="number" required>
                                    <p class="error-msg text-red-500 text-[9px] mt-1 hidden"></p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-700 mb-1 block">Max Distance (km)</label>
                            <input type="range" name="max_distance" min="5" max="200" value="50"
                                class="w-full accent-pink-600">
                        </div>
                    </div>
                </div>

                {{-- STEP 12: REVIEW & PUBLISH --}}
                <div class="q-block hidden text-center">
                    <div
                        class="w-16 h-16 mx-auto mb-3 bg-gradient-to-tr from-pink-500 to-purple-600 text-white rounded-full flex items-center justify-center text-2xl shadow-md">
                        ✨
                    </div>
                    <h2 class="text-2xl font-extrabold text-gray-900 mb-1">You're All Set!</h2>
                    <p class="text-gray-700 text-sm mb-4">Your dating profile is ready. Start discovering meaningful
                        connections now.</p>
                    <div
                        class="bg-white p-3 rounded-xl border border-pink-100 text-xs text-gray-800 mb-4 font-semibold shadow-sm">
                        ✓ All requirements completed successfully. Click submit to finish.
                    </div>
                </div>

                {{-- BUTTON AREA --}}
                <div class="flex justify-between mt-8 pt-4 border-t border-gray-100">
                    <button type="button" id="prevBtn" class="nav-btn hidden">
                        ⬅ Previous
                    </button>

                    <button type="button" id="nextBtn" class="nav-btn hidden ml-auto">
                        Next ➜
                    </button>

                    <button type="submit" id="submitBtn" class="submit-btn hidden ml-auto">
                        Submit ❤️
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .user-status-icon {
            position: absolute;
            left: 50%;
            bottom: -10px;
            transform: translateX(-50%);
            font-size: 16px;
        }

        /* ===== HEARTS FULL SCREEN BACKGROUND ===== */
        .global-hearts {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100vh;
            overflow: hidden;
            z-index: -1;
            pointer-events: none;
        }

        .global-hearts .heart {
            position: absolute;
            bottom: -60px;
            font-size: 40px;
            opacity: 0.9;
            animation: floatUp 7s linear infinite;
        }

        .global-hearts .heart:nth-child(1) {
            left: 5%;
            animation-duration: 7s;
        }

        .global-hearts .heart:nth-child(2) {
            left: 18%;
            animation-duration: 8.5s;
            font-size: 45px;
        }

        .global-hearts .heart:nth-child(3) {
            left: 32%;
            animation-duration: 6.2s;
        }

        .global-hearts .heart:nth-child(4) {
            left: 48%;
            animation-duration: 7.8s;
        }

        .global-hearts .heart:nth-child(5) {
            left: 63%;
            animation-duration: 9s;
            font-size: 48px;
        }

        .global-hearts .heart:nth-child(6) {
            left: 77%;
            animation-duration: 6.4s;
        }

        .global-hearts .heart:nth-child(7) {
            left: 88%;
            animation-duration: 8s;
        }

        .global-hearts .heart:nth-child(8) {
            left: 25%;
            animation-duration: 7.3s;
            font-size: 44px;
        }

        .global-hearts .heart:nth-child(9) {
            left: 55%;
            animation-duration: 9.2s;
            font-size: 46px;
        }

        @keyframes floatUp {
            0% {
                transform: translateY(0) rotate(0deg) scale(1);
                opacity: 1;
            }

            50% {
                opacity: .9;
            }

            100% {
                transform: translateY(-120vh) rotate(10deg) scale(1.8);
                opacity: 0;
            }
        }

        .page-wrapper {
            min-height: 85vh;
        }

        .card {
            animation: fadeIn 0.45s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.97);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .welcome-block {
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
        }

        .start-btn {
            padding: 14px 32px;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 14px;
            background: #ff4d8b;
            color: white;
            border: none;
            transition: .3s;
            cursor: pointer;
        }

        .start-btn:hover {
            background: #e63972;
            transform: scale(1.03);
        }

        .q-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 6px;
        }

        .sub-text {
            font-size: 1rem;
            color: #4b5563;
            margin-bottom: 16px;
        }

        .static-box {
            background: #ffffff;
            padding: 14px;
            border-radius: 14px;
            border: 1px solid #d1d5db;
            font-size: 1.1rem;
            margin-bottom: 6px;
        }

        .f-input {
            width: 100%;
            padding: 14px 16px;
            font-size: 1rem;
            border-radius: 12px;
            border: 1px solid #d1d5db;
            background: #fff;
            color: #1f2937;
            transition: .25s;
            outline: none;
        }

        .f-input:focus {
            border-color: #ff6b9e;
            box-shadow: 0 0 0 3px #ffb6d9;
        }

        .q-block {
            display: none;
            animation: fadeStep 0.4s ease-in-out;
        }

        .q-block.active {
            display: block;
            background: linear-gradient(135deg, #ffe4ef, #fff);
            padding: 24px;
            border-radius: 16px;
            border: 1px solid #ffd0e1;
        }

        @keyframes fadeStep {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .nav-btn,
        .submit-btn {
            padding: 12px 26px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 1rem;
            transition: .2s;
            cursor: pointer;
        }

        .nav-btn {
            background: #f3f4f6;
            border: 1px solid #d1d5db;
            color: #1f2937;
        }

        .submit-btn {
            background: #ff4d8b;
            color: white;
            border: none;
        }
    </style>
@endsection

@section('script')
    <script>
        const form = document.getElementById("tinderForm");
        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let savedStep = {{ $details->onboarding_step ?? 1 }};
        let current = savedStep <= 1 ? -1 : savedStep - 2;
        const welcomeBlock = document.querySelector(".welcome-block");
        const blocks = document.querySelectorAll(".q-block:not(.welcome-block)");
        const onboardingHeader = document.getElementById("onboardingHeader");
        const progressBar = document.getElementById("progressBar");
        const stepIndicator = document.getElementById("stepIndicator");
        const prevBtn = document.getElementById("prevBtn");
        const nextBtn = document.getElementById("nextBtn");
        const submitBtn = document.getElementById("submitBtn");
        const startBtn = document.getElementById("startBtn");
        const cityInput = document.querySelector('input[name="city"]');

        const totalQuestions = blocks.length;

        function updateView() {
            welcomeBlock.classList.remove("active");
            welcomeBlock.classList.add("hidden");
            blocks.forEach(b => {
                b.classList.remove("active");
                b.classList.add("hidden");
            });

            if (current === -1) {
                welcomeBlock.classList.remove("hidden");
                welcomeBlock.classList.add("active");
                onboardingHeader.classList.add("hidden");
                prevBtn.classList.add("hidden");
                nextBtn.classList.add("hidden");
                submitBtn.classList.add("hidden");
                return;
            }

            onboardingHeader.classList.remove("hidden");
            blocks[current].classList.remove("hidden");
            blocks[current].classList.add("active");

            // console.log("Current =", current);
            // console.log(
            //     blocks[current].querySelector("h2")?.innerText ||
            //     blocks[current].querySelector(".q-title")?.innerText
            // );

            prevBtn.classList.toggle("hidden", current <= 0);
            nextBtn.classList.toggle("hidden", current === totalQuestions - 1);
            submitBtn.classList.toggle("hidden", current !== totalQuestions - 1);

            let progressPercentage = ((current + 1) / totalQuestions) * 100;
            progressBar.style.width = `${progressPercentage}%`;
            stepIndicator.textContent = `Step ${current + 2} of 12`;
        }

        // Inline Field-Level Error & Datatype Validation Function
        function validateCurrentStep() {
            if (current === -1) return true;

            const activeBlock = blocks[current];

            // console.log("Current Step =", current);
            // console.log(activeBlock);

            let isValid = true;

            // Clear previous error messages in current block
            activeBlock.querySelectorAll('.error-msg').forEach(msg => {
                msg.textContent = "";
                msg.classList.add('hidden');
            });

            // Special check for Step 8 (Interests checkboxes)
            if (current === 6) {

                // console.log("===== INTEREST STEP =====");

                const allCheckboxes = activeBlock.querySelectorAll(".interest-checkbox");
                const checkedCheckboxes = activeBlock.querySelectorAll(".interest-checkbox:checked");

                // console.log("All =", allCheckboxes.length);
                // console.log("Checked =", checkedCheckboxes.length);

                allCheckboxes.forEach(c => {
                    // console.log(c.value, c.checked);
                });

                if (checkedCheckboxes.length === 0) {
                    // console.log("NO INTEREST SELECTED");
                    return false;
                }

                // console.log("INTEREST VALID");
                return true;
            }

            // Check standard required inputs/selects/textareas inside the active step block
            const requiredFields = activeBlock.querySelectorAll('[required]');
            for (let field of requiredFields) {

                // console.log(
                //     field.name,
                //     "=>",
                //     field.value,
                //     "required:",
                //     field.required
                // );

                let val = field.value ? field.value.trim() : "";
                if (val === "") {
                    // console.log("FAILED FIELD =>", field.name);
                }
                let errorContainer = field.parentElement.querySelector('.error-msg');

                if (val === "") {
                    isValid = false;
                    if (errorContainer) {
                        errorContainer.textContent = "This field is required.";
                        errorContainer.classList.remove('hidden');
                    }
                    continue;
                }

                // Datatype validation based on data-type attribute
                let dataType = field.getAttribute('data-type');
                if (dataType) {
                    if (dataType === 'number') {
                        // Check if it's purely numbers
                        if (isNaN(val) || !/^\d+$/.test(val)) {
                            isValid = false;
                            if (errorContainer) {
                                errorContainer.textContent = "Please enter valid numbers only.";
                                errorContainer.classList.remove('hidden');
                            }
                        }
                    } else if (dataType === 'string') {
                        // Check if string contains only numbers (e.g. 123 instead of text)
                        if (/^\d+$/.test(val)) {
                            isValid = false;
                            if (errorContainer) {
                                errorContainer.textContent = "Please enter valid text (numbers not allowed).";
                                errorContainer.classList.remove('hidden');
                            }
                        }
                    } else if (dataType === 'height') {
                        // Height pattern check (e.g., 5'10" or numbers/feet format)
                        let heightRegex = /^(\d+['"]\s*\d*['"]?|\d+\s*(cm|ft|in)?)$/i;
                        if (!heightRegex.test(val) && isNaN(val)) {
                            isValid = false;
                            if (errorContainer) {
                                errorContainer.textContent = "Please enter a valid height format (e.g. 5'10'').";
                                errorContainer.classList.remove('hidden');
                            }
                        }
                    } else if (dataType === 'date') {
                        // Simple date check
                        if (isNaN(Date.parse(val))) {
                            isValid = false;
                            if (errorContainer) {
                                errorContainer.textContent = "Please enter a valid date.";
                                errorContainer.classList.remove('hidden');
                            }
                        }
                    }
                }
            }

            return isValid;
        }

        startBtn.addEventListener("click", () => {
            current = 0;
            updateView();
        });

        nextBtn.addEventListener("click", async () => {
            // console.log("Current =", current);

            // if (current === 8) {
            //     console.log("Lifestyle values:");
            //     console.log(document.querySelector('[name="lifestyle_smoking"]').value);
            //     console.log(document.querySelector('[name="lifestyle_drinking"]').value);
            //     console.log(document.querySelector('[name="lifestyle_pets"]').value);
            // }

            if (!validateCurrentStep()) {
                // console.log("Validation Failed");
                return;
            }

            // console.log("Validation Passed");
            let result = await saveStep(current + 2);

            if (result.success) {
                if (current < totalQuestions - 1) {
                    current++;
                    updateView();
                    window.scrollTo({
                        top: 0,
                        behavior: "smooth"
                    });
                }
            }
        });

        prevBtn.addEventListener("click", () => {
            if (current > 0) {
                current--;
                updateView();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            } else if (current === 0) {
                current = -1;
                updateView();
            }
        });

        // Photo Preview Script for Step 6
        document.querySelectorAll('.photo-input').forEach(input => {
            input.addEventListener('change', function(e) {
                const box = this.closest('.photo-upload-box');
                const placeholder = box.querySelector('.placeholder-content');
                const previewImg = box.querySelector('.preview-img');

                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        previewImg.classList.remove('hidden');
                        placeholder.classList.add('hidden');
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });

        document.querySelectorAll('input[name="location_type"]').forEach(radio => {

            radio.addEventListener('change', function() {

                if (this.value === 'current') {

                    document.getElementById('currentLocationBox').classList.remove('hidden');
                    document.getElementById('manualLocationBox').classList.add('hidden');

                } else {

                    document.getElementById('currentLocationBox').classList.add('hidden');
                    document.getElementById('manualLocationBox').classList.remove('hidden');

                }

            });

        });

        document.getElementById('detectLocation').addEventListener('click', function() {

            if (!navigator.geolocation) {
                alert('Geolocation is not supported by your browser.');
                return;
            }

            this.disabled = true;
            this.innerText = 'Detecting...';

            navigator.geolocation.getCurrentPosition(
                async (position) => {

                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        document.getElementById('latitude').value = lat;
                        document.getElementById('longitude').value = lng;


                        try {

                            const response = await fetch(
                                `https://us1.locationiq.com/v1/reverse?key={{ config('services.locationiq.key') }}&lat=${lat}&lon=${lng}&format=json`
                            );

                            const data = await response.json();

                            if (data.display_name) {

                                document.querySelector('input[name="city"]').value = data.display_name;

                            }

                        } catch (e) {

                            console.error("Reverse geocoding failed", e);

                        }

                        this.innerText = 'Location Detected';

                    },
                    (error) => {

                        alert('Unable to fetch your location.');

                        console.error(error);

                        this.disabled = false;
                        this.innerText = '📍 Use Current Location';

                    }, {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
            );

        });

        cityInput.addEventListener('change', async function() {

            if (document.querySelector('input[name="location_type"]:checked').value !== 'manual') {
                return;
            }

            const address = this.value.trim();

            if (!address) return;

            try {

                const response = await fetch("{{ route('dating.geocode') }}", {

                    method: "POST",

                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrf,
                        "Accept": "application/json"
                    },

                    body: JSON.stringify({
                        address: address
                    })

                });

                const data = await response.json();

                if (data.success) {

                    document.getElementById("latitude").value = data.lat;
                    document.getElementById("longitude").value = data.lng;

                    console.log(data);

                } else {

                    alert("Location not found");

                }

            } catch (e) {

                console.error(e);

            }

        });

        async function saveStep(step) {

            clearLaravelErrors();

            let formData = new FormData(form);
            formData.append("step", step);

            const response = await fetch("{{ route('dating.save.step') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrf,
                    "Accept": "application/json"
                },
                body: formData
            });

            const data = await response.json();

            if (response.status === 422) {
                showLaravelErrors(data.errors);
                return {
                    success: false
                };
            }

            return data;
        }

        function clearLaravelErrors() {

            document.querySelectorAll(".error-msg").forEach(error => {
                error.innerHTML = "";
                error.classList.add("hidden");
            });

            document.querySelectorAll(".f-input").forEach(input => {
                input.classList.remove("border-red-500");
            });

        }

        function showLaravelErrors(errors) {

            Object.keys(errors).forEach(function(fieldName) {

                // photos.0 -> photos
                let groupName = fieldName.split('.')[0];

                let group = document.querySelector(`[data-name="${groupName}"]`);

                if (group) {

                    let error = group.querySelector(".error-msg");

                    error.textContent = errors[fieldName][0];
                    error.classList.remove("hidden");
                    return;
                }

                let field =
                    document.querySelector(`[name="${fieldName}"]`) ||
                    document.querySelector(`[name="${fieldName}[]"]`);

                if (!field) return;

                let error = field.parentElement.querySelector(".error-msg");

                if (error) {
                    error.textContent = errors[fieldName][0];
                    error.classList.remove("hidden");
                }

            });

        }

        form.addEventListener("submit", async function(e) {
            e.preventDefault();

            if (!validateCurrentStep()) {
                return;
            }

            let result = await saveStep(12);

            if (result.success) {
                alert("Profile completed successfully");
                window.location.href = "{{ route('pages') }}";
            }
        });

        updateView();
    </script>
@endsection
