<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Affirmspace</title>
    <style>
        :root {
            --bg-color: #f4f6f9;
            --text-color: #222;
            --subtext-color: #555;
            --btn-bg: linear-gradient(90deg, #ff512f, #dd2476);
            --btn-text: #fff;
            --link-color: #333;
        }

        body.dark {
            --bg-color: #000000;
            --text-color: #fff;
            --subtext-color: #ccc;
            --btn-bg: linear-gradient(90deg, #ff512f, #dd2476);
            --btn-text: #fff;
            --link-color: #fff;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: var(--bg-color);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: var(--text-color);
            transition: background 0.3s, color 0.3s;
        }

        /* Main content container */
        #main-welcome {
            text-align: center;
            width: 90%;
            max-width: 400px;
            padding: 0 15px;
            margin: auto;
            animation: fadeIn 1s ease-in-out;
        }

        #main-welcome .logo {
            width: 150px;
            height: 150px;
            object-fit: contain;
            margin-bottom: 20px;
        }

        #main-welcome h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--text-color);
        }

        #main-welcome p {
            font-size: 16px;
            color: var(--subtext-color);
            margin-bottom: 30px;
            line-height: 1.5;
        }

        .btn {
            display: block;
            width: 100%;
            max-width: 320px;
            /* keeps button nicely sized */
            margin: 10px auto;
            /* centers button */
            padding: 12px 16px;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 10px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
            box-sizing: border-box;
        }

        /* Mobile-specific adjustment */
        @media (max-width: 400px) {
            .btn {
                max-width: 100%;
                /* allow full width only on very small screens */
                font-size: 0.9rem;
                padding: 10px 14px;
            }
        }

        .btn-primary {
            background: var(--btn-bg);
            color: var(--btn-text);
            border: none;
        }

        .btn-primary:hover {
            opacity: 0.9;
        }

        .toggle-btn {
            background: #444;
            color: #fff;
        }

        .toggle-btn:hover {
            background: #666;
        }

        .link a {
            text-decoration: none;
            font-weight: bold;
            color: var(--link-color);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Splash screen overlay */
        #splash-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #dafaf8ff;
            /* background matches logo theme */
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: white;
            font-size: 2rem;
            z-index: 9999;
            opacity: 1;
            transition: opacity 0.5s ease;
        }

        /* Heart pulse animation */
        #splash-screen img {
            width: 150px;
            margin-bottom: 20px;
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            25% {
                transform: scale(1.3);
            }

            50% {
                transform: scale(1);
            }

            75% {
                transform: scale(1.3);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
</head>

<body>

    <!-- Splash screen -->
    <div id="splash-screen">
        <img src="images/welcomepage.png" alt="AffirmSpace">
    </div>

    <div id="main-welcome">
        <img src="images/welcomepage.png" alt="AffirmSpace" class="logo">
        <h1>AffirmSpace</h1>
        <p>A Safe Space to connect, share and heal</p>
        <a href="/register" class="btn btn-primary">Create an Account</a>
        <p class="link">Already have an account? <a href="/login">Log in</a></p>
        <a href="#" class="btn toggle-btn" onclick="toggleTheme(event)">Switch Theme</a>
    </div>

    <script>
        function toggleTheme(event) {
            event.preventDefault();
            document.body.classList.toggle("dark");
        }

        // Splash screen logic
        window.addEventListener('load', () => {
            const splash = document.getElementById('splash-screen');
            if (!sessionStorage.getItem('flashShown')) {
                setTimeout(() => {
                    splash.style.opacity = 0;
                    setTimeout(() => {
                        splash.style.display = 'none';
                    }, 500);
                }, 1000);
                sessionStorage.setItem('flashShown', 'true');
            } else {
                splash.style.display = 'none';
            }
        });
    </script>
</body>

</html>
