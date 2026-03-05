<!DOCTYPE html>
<html lang="en">
{{-- htdocs --}}

<head>

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GK7P3JDQN0"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-GK7P3JDQN0');
    </script>

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-TT8733ZM');
    </script>
    <!-- End Google Tag Manager -->

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link href="{{ asset('images/new_logo.png') }}" rel="icon" type="image/png">

    <!-- title and description-->
    <title>AffirmSpace | Register</title>
    <meta name="description" content="Socialite - Social sharing network HTML Template">

    <!-- css files -->
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">

    <!-- google font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700;800&display=swap"
        rel="stylesheet">
</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TT8733ZM" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div class="sm:flex">
        <div
            class="relative lg:w-[580px] md:w-96 w-full p-10 min-h-screen bg-white shadow-xl flex items-center pt-10 dark:bg-slate-900 z-10">
            <div class="w-full lg:max-w-sm mx-auto space-y-10"
                uk-scrollspy="target: > *; cls: uk-animation-scale-up; delay: 100 ;repeat: true">

                <!-- logo image-->
                <a href="{{ route('/') }}"> <img src="{{ asset('images/new_logo.png') }}"
                        class="w-16 absolute top-10 left-10 dark:hidden" alt=""></a>
                <a href="#"> <img src="{{ asset('images/logo-light.png') }}"
                        class="w-28 absolute top-10 left-10 hidden dark:!block" alt=""></a>

                <!-- logo icon optional -->
                <div class="hidden">
                    <img class="w-12" src="{{ asset('images/logo-icon.png') }}" alt="Socialite html template">
                </div>

                <!-- title -->
                <div>
                    <h2 class="text-2xl font-semibold mb-1.5"> Sign up to get started </h2>
                    <p class="text-sm text-gray-700 font-normal">If you already have an account, <a
                            href="{{ route('login') }}" class="text-blue-700">Login here!</a></p>
                </div>

                <!-- form -->
                <form method="POST" action="{{ route('register') }}"
                    class="space-y-7 text-sm text-black font-medium dark:text-white"
                    uk-scrollspy="target: > *; cls: uk-animation-scale-up; delay: 100 ;repeat: true">
                    @csrf
                    <div class="grid grid-cols-2 gap-4 gap-y-7">

                        <!-- first name -->
                        <div>
                            <label for="first_name" class="">First name</label>
                            <div class="mt-2.5">
                                <input id="first_name" name="first_name" type="text" placeholder="First name"
                                    value="{{ old('first_name') }}"
                                    oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                                    class="!w-full !rounded-lg !bg-transparent !shadow-sm !border-slate-200 dark:!border-slate-800 dark:!bg-white/5">
                                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Last name -->
                        <div>
                            <label for="last_name" class="">Last name</label>
                            <div class="mt-2.5">
                                <input id="last_name" name="last_name" type="text" placeholder="Last name"
                                    value="{{ old('last_name') }}"
                                    oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                                    class="!w-full !rounded-lg !bg-transparent !shadow-sm !border-slate-200 dark:!border-slate-800 dark:!bg-white/5">
                                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                            </div>
                        </div>

                        <!-- email -->
                        <div class="col-span-2">
                            <label for="email" class="">Email address</label>
                            <div class="mt-2.5">
                                <input id="email" name="email" type="email" placeholder="Email"
                                    :value="old('email')"
                                    class="!w-full !rounded-lg !bg-transparent !shadow-sm !border-slate-200 dark:!border-slate-800 dark:!bg-white/5">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password">Password</label>
                            <div class="mt-2.5 relative">
                                <input id="password" name="password" type="password" placeholder="Passowrd"
                                    class="w-full rounded-lg bg-transparent shadow-sm border border-slate-200 dark:border-slate-800 dark:bg-white/5 pr-12">

                                <!-- Eye toggle button -->
                                <button type="button" onclick="togglePassword('password', 'eyeOpen', 'eyeClosed')"
                                    class="absolute right-3 top-3 text-gray-500">

                                    <!-- Eye Open -->
                                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0
                    8.268 2.943 9.542 7-1.274 4.057-5.065
                    7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <!-- Eye Closed -->
                                    <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477
                    0-8.268-2.943-9.542-7a9.956 9.956 0
                    012.223-3.592m3.892-2.44A9.956
                    9.956 0 0112 5c4.477 0 8.268 2.943
                    9.542 7a9.969 9.969 0 01-4.043
                    5.409M15 12a3 3 0 11-6 0 3 3
                    0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3l18 18" />
                                    </svg>
                                </button>

                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 min-h-[18px]" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation">Confirm Password</label>
                            <div class="mt-2.5 relative">
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                    placeholder="Confirm Password"
                                    class="w-full rounded-lg bg-transparent shadow-sm border border-slate-200 dark:border-slate-800 dark:bg-white/5 pr-12">

                                <!-- Eye toggle button -->
                                <button type="button"
                                    onclick="togglePassword('password_confirmation', 'eyeOpenConfirm', 'eyeClosedConfirm')"
                                    class="absolute right-3 top-3 text-gray-500">

                                    <!-- Eye Open -->
                                    <svg id="eyeOpenConfirm" xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0
                    8.268 2.943 9.542 7-1.274 4.057-5.065
                    7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <!-- Eye Closed -->
                                    <svg id="eyeClosedConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477
                    0-8.268-2.943-9.542-7a9.956 9.956 0
                    012.223-3.592m3.892-2.44A9.956
                    9.956 0 0112 5c4.477 0 8.268 2.943
                    9.542 7a9.969 9.969 0 01-4.043
                    5.409M15 12a3 3 0 11-6 0 3 3
                    0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3l18 18" />
                                    </svg>
                                </button>

                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 min-h-[18px]" />
                            </div>
                        </div>

                        <script>
                            function togglePassword(inputId, eyeOpenId, eyeClosedId) {
                                const input = document.getElementById(inputId);
                                const eyeOpen = document.getElementById(eyeOpenId);
                                const eyeClosed = document.getElementById(eyeClosedId);

                                if (input.type === "password") {
                                    input.type = "text";
                                    eyeOpen.classList.remove("hidden");
                                    eyeClosed.classList.add("hidden");
                                } else {
                                    input.type = "password";
                                    eyeOpen.classList.add("hidden");
                                    eyeClosed.classList.remove("hidden");
                                }
                            }
                        </script>

                        <div>
                            <label for="role" class="block">Select User Type</label>
                            <div class="mt-2.5">
                                <select id="role" name="role"
                                    class="!w-full !rounded-lg !bg-transparent !shadow-sm !border-slate-200 dark:!border-slate-800 dark:!bg-white/5">
                                    <option value="">Select User Type</option>
                                    <option value="0" {{ old('role') == '0' ? 'selected' : '' }}>Counselee
                                    </option>
                                    <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>Counselor
                                    </option>
                                </select>
                                <x-input-error :messages="$errors->get('role')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Select Gender -->
                        <div>
                            <label for="gender" class="block">Select Gender</label>
                            <div class="mt-2.5">
                                <select id="gender" name="gender"
                                    class="!w-full !rounded-lg !bg-transparent !shadow-sm !border-slate-200 dark:!border-slate-800 dark:!bg-white/5">
                                    <option value="">Select Gender</option>
                                    <option value="Man" {{ old('gender') == 'Man' ? 'selected' : '' }}>Man</option>
                                    <option value="Woman" {{ old('gender') == 'Woman' ? 'selected' : '' }}>Woman
                                    </option>
                                    <option value="Trans Woman"
                                        {{ old('gender') == 'Trans Woman' ? 'selected' : '' }}>Trans Woman</option>
                                    <option value="Trans Man" {{ old('gender') == 'Trans Man' ? 'selected' : '' }}>
                                        Trans Man</option>
                                    <option value="Non-binary" {{ old('gender') == 'Non-binary' ? 'selected' : '' }}>
                                        Non-binary</option>
                                    <option value="Genderqueer"
                                        {{ old('gender') == 'Genderqueer' ? 'selected' : '' }}>Genderqueer</option>
                                    <option value="Agender" {{ old('gender') == 'Agender' ? 'selected' : '' }}>Agender
                                    </option>
                                    <option value="Bigender" {{ old('gender') == 'Bigender' ? 'selected' : '' }}>
                                        Bigender</option>
                                    <option value="Genderfluid"
                                        {{ old('gender') == 'Genderfluid' ? 'selected' : '' }}>Genderfluid</option>
                                    <option value="Two-Spirit" {{ old('gender') == 'Two-Spirit' ? 'selected' : '' }}>
                                        Two-Spirit</option>
                                    <option value="Intersex" {{ old('gender') == 'Intersex' ? 'selected' : '' }}>
                                        Intersex</option>
                                    <option value="Questioning"
                                        {{ old('gender') == 'Questioning' ? 'selected' : '' }}>Questioning</option>
                                    <option value="Prefer not to say"
                                        {{ old('gender') == 'Prefer not to say' ? 'selected' : '' }}>Prefer not to say
                                    </option>
                                    <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other
                                    </option>
                                </select>
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <label for="address">Address</label>
                            <div class="mt-2.5">
                                <input id="address" name="address" type="text" placeholder="Enter Address"
                                    value="{{ old('address') }}"
                                    class="!w-full !rounded-lg !bg-transparent !shadow-sm !border-slate-200 dark:!border-slate-800 dark:!bg-white/5"
                                    style="cursor: pointer;">
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <label for="refer_code">Referral Code (optional)</label>
                            <div class="mt-2.5">
                                <input id="refer_code" name="refer_code" type="text"
                                    placeholder="Enter referral code" value="{{ old('refer_code', request('ref')) }}"
                                    class="!w-full !rounded-lg !bg-transparent !shadow-sm !border-slate-200 dark:!border-slate-800 dark:!bg-white/5"
                                    style="cursor: pointer;">
                                <x-input-error :messages="$errors->get('refer_code')" class="mt-2" />
                            </div>
                        </div>

                        <div id="specialization-container" class="col-span-2" style="display: none;">
                            <label for="specialization" class="">Select Specialization</label>
                            <div class="mt-2.5">
                                <select id="specialization" name="specialization"
                                    class="!w-full !rounded-lg !bg-transparent !shadow-sm !border-slate-200 
                   dark:!border-slate-800 dark:!bg-white/5">
                                    <option value="">Loading specializations...</option>
                                </select>
                                <x-input-error :messages="$errors->get('specialization')" class="mt-2" />
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const roleSelect = document.getElementById('role');
                                const specializationContainer = document.getElementById('specialization-container');
                                const specializationSelect = document.getElementById('specialization');

                                // Fetch active specializations from backend
                                function loadSpecializations() {
                                    specializationSelect.innerHTML = '<option value="">Loading...</option>';

                                    fetch('{{ route('specializations.fetch') }}')
                                        .then(response => response.json())
                                        .then(data => {
                                            specializationSelect.innerHTML = '<option value="">Select Specialization</option>';
                                            if (data.length === 0) {
                                                specializationSelect.innerHTML =
                                                    '<option value="">No active specializations</option>';
                                            } else {
                                                data.forEach(spec => {
                                                    const opt = document.createElement('option');
                                                    opt.value = spec.id;
                                                    opt.textContent = spec.name;
                                                    specializationSelect.appendChild(opt);
                                                });
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error fetching specializations:', error);
                                            specializationSelect.innerHTML = '<option value="">Error loading data</option>';
                                        });
                                }

                                // Show/Hide dropdown dynamically
                                function toggleSpecialization() {
                                    if (roleSelect.value === '1') { // Counselor
                                        specializationContainer.style.display = 'block';
                                        loadSpecializations();
                                    } else {
                                        specializationContainer.style.display = 'none';
                                        specializationSelect.value = '';
                                    }
                                }

                                // Initial check
                                toggleSpecialization();

                                // Listen for role changes
                                roleSelect.addEventListener('change', toggleSpecialization);
                            });
                        </script>

                        <div class="">
                            <label for="accept-terms" class="flex items-center space-x-2">
                                <input type="checkbox" id="accept-terms" name="terms"
                                    class="rounded-md accent-red-800" {{ old('terms') ? 'checked' : '' }} />
                                <span>
                                    Agree to our
                                    <a href="javascript:void(0)" onclick="openModal()"
                                        class="text-blue-700 hover:underline">
                                        terms?
                                    </a>
                                </span>
                            </label>
                            <x-input-error :messages="$errors->get('terms')" />
                        </div>

                        <div class="">
                            <label for="is_adult" class="flex items-center space-x-2">
                                <input type="checkbox" id="is_adult" name="is_adult"
                                    class="rounded-md accent-red-800" {{ old('is_adult') ? 'checked' : '' }} />
                                <span>Are you 18+?</span>
                            </label>
                            <x-input-error :messages="$errors->get('is_adult')" />
                        </div>

                        <!-- Terms Modal -->
                        <div id="termsModal"
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm hidden">
                            <div
                                class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-2xl max-w-2xl w-full relative border border-gray-200 dark:border-gray-700">

                                <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Terms of Use</h2>

                                <div
                                    class="overflow-y-auto max-h-96 text-sm text-gray-700 dark:text-gray-200 pr-2 leading-relaxed">
                                    @include('user.term')
                                </div>

                                <div class="mt-6 flex justify-end space-x-3">
                                    <button type="button" onclick="closeModal()" class="btn-close">
                                        Close
                                    </button>
                                    <button type="button" onclick="acceptTerms()" class="btn-accept">
                                        Accept
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- submit button -->
                        <div class="col-span-2">
                            <button type="submit" class="register-btn bg-primary text-white w-full">Register
                                Here</button>
                        </div>
                    </div>

                    <style>
                        .register-btn {
                            background: linear-gradient(90deg, #ff512f, #dd2476);
                            color: #fff;
                            font-weight: bold;
                            border: none;
                            border-radius: 8px;
                            padding: 12px;
                            text-align: center;
                            cursor: pointer;
                            transition: 0.3s ease;
                        }

                        .register-btn:hover {
                            opacity: 0.9;
                        }
                    </style>

                    <div class="text-center flex items-center gap-6">
                        <hr class="flex-1 border-slate-200 dark:border-slate-800">
                        Or continue with
                        <hr class="flex-1 border-slate-200 dark:border-slate-800">
                    </div>

                    <!-- social login -->
                    <div class="flex gap-2"
                        uk-scrollspy="target: > *; cls: uk-animation-scale-up; delay: 400 ;repeat: true">
                        <a href="{{ route('social.redirect', 'facebook') }}"
                            class="button flex-1 flex items-center gap-2 bg-primary text-white text-sm">
                            <ion-icon name="logo-facebook" class="text-lg"></ion-icon> facebook </a>
                        <a href="{{ route('social.redirect', 'google') }}"
                            class="button flex-1 flex items-center gap-2 bg-white text-gray-700 text-sm border rounded-md px-3 py-2">
                            <img src="https://www.svgrepo.com/show/355037/google.svg" alt="Google" class="w-4 h-4">
                            Google
                        </a>
                        {{-- <a href="#" class="button flex-1 flex items-center gap-2 bg-black text-white text-sm">
                            <ion-icon name="logo-github"></ion-icon> github </a> --}}
                    </div>
                </form>
            </div>
        </div>

        <!-- image slider -->
        <div class="flex-1 relative bg-primary max-md:hidden">
            <div class="relative w-full h-full" tabindex="-1" uk-slideshow="animation: slide; autoplay: true">
                <ul class="uk-slideshow-items w-full h-full">
                    <li class="w-full">
                        <img src="{{ asset('images/post/3.png') }}" alt=""
                            class="w-full h-full object-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                        <div class="absolute bottom-0 w-full uk-tr ansition-slide-bottom-small z-10">
                            <div class="max-w-xl w-full mx-auto pb-32 px-5 z-30 relative"
                                uk-scrollspy="target: > *; cls: uk-animation-scale-up; delay: 100 ;repeat: true">
                                <img class="w-12" src="{{ asset('images/new_logo.png') }}"
                                    alt="Socialite html template">
                                <h4 class="!text-white text-2xl font-semibold mt-7"
                                    uk-slideshow-parallax="y: 600,0,0"> Connect With Friends </h4>
                                <p class="!text-white text-lg mt-7 leading-8" uk-slideshow-parallax="y: 800,0,0;">
                                    This phrase is more casual and playful. It suggests that you are keeping your
                                    friends updated on what’s happening in your life.</p>
                            </div>
                        </div>
                        <div class="w-full h-96 bg-gradient-to-t from-black absolute bottom-0 left-0"></div>
                    </li>
                    <li class="w-full">
                        <img src="{{ asset('images/post/4.png') }}" alt=""
                            class="w-full h-full object-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                        <div class="absolute bottom-0 w-full uk-tr ansition-slide-bottom-small z-10">
                            <div class="max-w-xl w-full mx-auto pb-32 px-5 z-30 relative"
                                uk-scrollspy="target: > *; cls: uk-animation-scale-up; delay: 100 ;repeat: true">
                                <img class="w-12" src="{{ asset('images/new_logo.png') }}"
                                    alt="Socialite html template">
                                <h4 class="!text-white text-2xl font-semibold mt-7"
                                    uk-slideshow-parallax="y: 800,0,0"> Connect With Friends </h4>
                                <p class="!text-white text-lg mt-7 leading-8" uk-slideshow-parallax="y: 800,0,0;">
                                    This phrase is more casual and playful. It suggests that you are keeping your
                                    friends updated on what’s happening in your life.</p>
                            </div>
                        </div>
                        <div class="w-full h-96 bg-gradient-to-t from-black absolute bottom-0 left-0"></div>
                    </li>
                </ul>

                <!-- slide nav -->
                <div class="flex justify-center">
                    <ul
                        class="inline-flex flex-wrap justify-center  absolute bottom-8 gap-1.5 uk-dotnav uk-slideshow-nav">
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Uikit js you can use cdn  https://getuikit.com/docs/installation  or fine the latest  https://getuikit.com/docs/installation -->

    <script src="{{ asset('js/uikit.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/register.js') }}"></script>

    <!-- Ion icon -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <!-- Dark mode -->
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }

        // Whenever the user explicitly chooses light mode
        localStorage.theme = 'light'

        // Whenever the user explicitly chooses dark mode
        localStorage.theme = 'dark'

        // Whenever the user explicitly chooses to respect the OS preference
        localStorage.removeItem('theme')

        function openModal() {
            document.getElementById('termsModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('termsModal').classList.add('hidden');
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addressInput = document.getElementById('address');
            const locationIqKey = 'pk.87f3589246fc3afff3a79de3ebd2be86';

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(async function(position) {
                        const lat = position.coords.latitude;
                        const lon = position.coords.longitude;

                        try {
                            const response = await fetch(
                                `https://us1.locationiq.com/v1/reverse.php?key=${locationIqKey}&lat=${lat}&lon=${lon}&format=json`
                            );
                            const data = await response.json();

                            if (data && data.address) {
                                const city = data.address.city || data.address.town || data.address
                                    .village || '';
                                const state = data.address.state || '';
                                const country = data.address.country || '';

                                addressInput.value = `${city}, ${state}, ${country}`;
                            }
                        } catch (err) {
                            console.error('Failed to get address:', err);
                        }
                    },
                    function(error) {
                        console.warn('Geolocation permission denied or unavailable.');
                    });
            } else {
                console.warn('Geolocation is not supported by this browser.');
            }
        });
    </script>

    <script>
        // Disable right-click
        document.addEventListener("contextmenu", function(e) {
            e.preventDefault();
        }, false);

        // Disable Ctrl+U, Ctrl+Shift+I, Ctrl+Shift+C, Ctrl+Shift+J, F12
        document.addEventListener("keydown", function(e) {
            // Ctrl+U or Ctrl+Shift+I or Ctrl+Shift+C or Ctrl+Shift+J
            if (
                (e.ctrlKey && e.key === "u") || (e.ctrlKey && e.key === "U") ||
                (e.ctrlKey && e.shiftKey && ["I", "C", "J"].includes(e.key)) ||
                e.key === "F12"
            ) {
                e.preventDefault();
            }
        });
    </script>
</body>

</html>

{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- First Name -->
        <div>
            <x-input-label for="first_name" :value="__('Fisrt Name')" />
            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                :value="old('fname')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <!-- Last Name -->
        <div>
            <x-input-label for="last_name" :value="__('Last Name')" />
            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')"
                required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
