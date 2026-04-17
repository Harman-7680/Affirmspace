<!DOCTYPE html>
<html lang="en">

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
    <meta name="robots" content="index, follow">
    
    <!-- Favicon -->
    <link href="{{ asset('images/new_logo.png') }}" rel="icon" type="image/png">

    <!-- title and description-->
    <title>AffirmSpace | Login</title>
    <meta name="description" content="Socialite - Social sharing network HTML Template">

    <!-- css files -->
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

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
                <a href="{{ route('/') }}"> <img src="{{ asset('images/new_logo.png') }}"
                        class="w-16 absolute top-10 left-10 hidden dark:!block" alt=""></a>
                <h1
                    style="font-family: 'Times New Roman', serif; font-weight: 900; font-size: 2.5rem; text-align: center; color: #ff512f;">
                    AffirmSpace
                </h1>
                <!-- logo icon optional -->
                <div class="hidden">
                    <img class="w-12" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&amp;shade=600"
                        alt="Socialite html template">
                </div>

                <!-- title -->
                <div>
                    <h2 class="text-2xl font-semibold mb-1.5">Log in to your account</h2>

                    <p class="text-sm text-gray-700 font-normal">
                        If you haven’t signed up yet.
                        Register as
                        <a href="{{ route('register', ['role' => 0]) }}" class="text-blue-700 no-underline">User</a>
                        or
                        <a href="{{ route('register', ['role' => 1]) }}" class="text-blue-700 no-underline">Doctor</a>.
                    </p>
                </div>

                <!-- form -->
                <form method="POST" action="{{ route('login') }}" onsubmit="return validateLoginForm()"
                    class="space-y-7 text-sm text-black font-medium dark:text-white"
                    uk-scrollspy="target: > *; cls: uk-animation-scale-up; delay: 100 ;repeat: true">
                    @csrf

                    <!-- email -->
                    <div>
                        <label for="email">Email address</label>
                        <div class="mt-2.5">
                            <input id="email" name="email" type="email" placeholder="Email"
                                style="border: 1px solid grey !important;" value="{{ old('email') }}"
                                class="!w-full !rounded-lg !bg-transparent !shadow-sm !border-slate-200 dark:!border-slate-800 dark:!bg-white/5">
                            <span id="emailError" class="text-red-500 text-xs block min-h-[22px]"></span>
                            <x-input-error :messages="$errors->get('email')" class="mt-2 min-h-[18px]" />
                            @if (session('error'))
                                <p class="text-danger" style="color:red;">{{ session('error') }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- password -->
                    {{-- <div>
                        <label for="password">Password</label>
                        <div class="mt-2.5 relative">
                            <input id="password" name="password" type="password" placeholder="***"
                                class="!w-full !rounded-lg !bg-transparent !shadow-sm !border-slate-200 dark:!border-slate-800 dark:!bg-white/5">
                            <span id="passwordError" class="text-red-500 text-xs block min-h-[18px]"></span>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 min-h-[18px]" />
                        </div>
                    </div> --}}

                    <div>
                        <label for="password">Password</label>
                        <div class="mt-2.5 relative">

                            <style>
                                .password-wrapper {
                                    position: relative;
                                    width: 100%;
                                    max-width: 350px;
                                }

                                .password-input {
                                    width: 100%;
                                    padding: 10px 40px 10px 12px;
                                    /* extra space on right for eye */
                                    border: 1px solid grey !important;
                                    border-radius: 8px;
                                    outline: none;
                                    transition: border-color 0.2s;
                                    background: transparent !important;
                                }

                                /* For laptop/desktop screens */
                                @media (min-width: 1024px) {
                                    .password-input {
                                        width: 109%;
                                    }
                                }

                                /* For phones (small screens) */
                                @media (max-width: 768px) {
                                    .password-input {
                                        width: 100%;
                                    }

                                    .password-toggle {
                                        right: 10px;
                                    }
                                }


                                .password-input:focus {
                                    border-color: #fa7f40;
                                    /* highlight border when focused */
                                }

                                .password-toggle {
                                    position: absolute;
                                    right: 0;
                                    top: 50%;
                                    transform: translateY(-50%);
                                    background: none;
                                    border: none;
                                    cursor: pointer;
                                    padding: 0;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                }
                            </style>

                            <div class="password-wrapper">
                                <input id="password" name="password" type="password" placeholder="Password"
                                    class="password-input">

                                <!-- Eye toggle button inside input -->
                                <button type="button" class="password-toggle ms-5" onclick="togglePassword()">
                                    <!-- Eye Open -->
                                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477
           0 8.268 2.943 9.542 7-1.274
           4.057-5.065 7-9.542 7-4.477
           0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <!-- Eye Closed -->
                                    <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477
           0-8.268-2.943-9.542-7a9.956
           9.956 0 012.223-3.592m3.892-2.44
           A9.956 9.956 0 0112 5c4.477 0
           8.268 2.943 9.542 7a9.969 9.969
           0 01-4.043 5.409M15 12a3 3
           0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>

                            <span id="passwordError" class="text-red-500 text-xs block min-h-[18px]"></span>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 min-h-[18px]" />
                        </div>
                    </div>

                    <script>
                        function togglePassword() {
                            const input = document.getElementById('password');
                            const eyeOpen = document.getElementById('eyeOpen');
                            const eyeClosed = document.getElementById('eyeClosed');

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

                    <div class="flex items-center justify-between">
                        {{-- <div class="flex items-center gap-2.5">
                            <input id="remember_me" name="rememberme" type="checkbox">
                            <label for="rememberme" class="font-semibold ">Remember me</label>
                        </div> --}}
                        <a href="{{ route('password.request') }}" class="text-blue-700">Forgot password </a>
                    </div>

                    <!-- submit button -->
                    <div>
                        <button type="submit"
                            style="background: linear-gradient(90deg, #ff512f, #dd2476); color: white; width: 100%; padding: 0.75rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                            Log in
                        </button>
                    </div>

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
                        <img src="{{ asset('images/post/1.jpg') }}" alt=""
                            class="w-full h-full object-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                        <div class="absolute bottom-0 w-full uk-tr ansition-slide-bottom-small z-10">
                            <div class="max-w-xl w-full mx-auto pb-32 px-5 z-30 relative"
                                uk-scrollspy="target: > *; cls: uk-animation-scale-up; delay: 100 ;repeat: true">
                                <img class="w-12" src="{{ asset('images/new_logo.png') }}"
                                    alt="Socialite html template">
                                <h4 class="!text-white text-2xl font-semibold mt-7"
                                    uk-slideshow-parallax="y: 600,0,0">
                                    Be Yourself, Find Your People </h4>
                                <p class="!text-white text-lg mt-7 leading-8" uk-slideshow-parallax="y: 800,0,0;">
                                    AffirmSpace is your safe and vibrant community to connect, share, and grow without
                                    fear — because you deserve a space that celebrates you.</p>
                            </div>
                        </div>
                        <div class="w-full h-96 bg-gradient-to-t from-black absolute bottom-0 left-0"></div>
                    </li>
                    <li class="w-full">
                        <img src="{{ asset('images/post/2.png') }}" alt=""
                            class="w-full h-full object-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                        <div class="absolute bottom-0 w-full uk-tr ansition-slide-bottom-small z-10">
                            <div class="max-w-xl w-full mx-auto pb-32 px-5 z-30 relative"
                                uk-scrollspy="target: > *; cls: uk-animation-scale-up; delay: 100 ;repeat: true">
                                <img class="w-12" src="{{ asset('images/new_logo.png') }}"
                                    alt="Socialite html template">
                                <h4 class="!text-white text-2xl font-semibold mt-7"
                                    uk-slideshow-parallax="y: 800,0,0"> Express Without Limits </h4>
                                <p class="!text-white text-lg mt-7 leading-8" uk-slideshow-parallax="y: 800,0,0;">
                                    Celebrate your true colors in a safe, supportive space where every voice is heard
                                    and every identity is affirmed.</p>
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
    {{-- <script src="{{ asset('css/script.css') }}"></script> --}}
    <script src="{{ asset('js/login.js') }}"></script>

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
    </script>

</body>

</html>

{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
