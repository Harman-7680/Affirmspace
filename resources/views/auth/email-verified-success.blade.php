<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Email Verified</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Inter", sans-serif;
        }

        body {
            height: 100vh;
            background: #f0f2f8;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #eef2ff, #e9d5ff);
        }

        .card {
            width: 95%;
            max-width: 450px;
            background: #ffffff;
            padding: 40px 35px;
            border-radius: 22px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
            animation: fadeIn 0.7s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(22px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .badge {
            height: 90px;
            width: 90px;
            background: #10b981;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 45px;
            box-shadow: 0 10px 18px rgba(16, 185, 129, 0.4);
            animation: pop 0.5s ease;
        }

        @keyframes pop {
            0% {
                transform: scale(0.5);
                opacity: 0.3;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        h1 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #111827;
        }

        p {
            font-size: 15px;
            color: #4b5563;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .btn {
            display: inline-block;
            padding: 13px 30px;
            border-radius: 10px;
            background: #4f46e5;
            color: white;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.25s;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3);
        }

        .btn:hover {
            background: #4338ca;
            transform: translateY(-2px);
        }

        .footer {
            margin-top: 20px;
            font-size: 13px;
            color: #6b7280;
        }

        .app-info {
            margin-top: 18px;
            padding: 12px 15px;
            font-size: 15px;
            font-weight: 600;
            color: #4f46e5;
            background: #eef2ff;
            border-radius: 12px;
            display: inline-block;
        }
    </style>
</head>

<body>

    <div class="card">
        <div class="badge">✓</div>

        <h1>Email Verified</h1>

        <p style="font-size:14px; margin-top:10px;">
            Using the app? Continue there.
            On the web? Use the button below.
        </p>

        <a href="{{ url('/login') }}" target="_blank" class="btn">Login</a>

        <div class="footer">If you need help, our support team is always here.</div>
    </div>

</body>


</html>
