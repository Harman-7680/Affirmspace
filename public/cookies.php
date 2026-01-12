<?php
echo '
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laravel Maintenance Tool</title>
<style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap");

    body {
        font-family: "Poppins", sans-serif;
        background: linear-gradient(135deg, #141e30, #243b55);
        color: #f1f1f1;
        padding: 40px;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        min-height: 100vh;
    }

    .container {
        width: 100%;
        max-width: 850px;
        background: rgba(25, 25, 25, 0.9);
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.5);
        backdrop-filter: blur(10px);
        animation: fadeIn 0.7s ease-in-out;
    }

    h1 {
        text-align: center;
        color: #00e676;
        margin-bottom: 30px;
        letter-spacing: 1px;
        font-weight: 600;
    }

    .log {
        background: #0e0e0e;
        padding: 20px;
        border-radius: 10px;
        overflow-y: auto;
        max-height: 500px;
        white-space: pre-wrap;
        line-height: 1.6;
        font-family: "Courier New", monospace;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .info {
        color: #82b1ff;
        display: block;
        margin: 5px 0;
    }

    .footer {
        text-align: center;
        margin-top: 20px;
        color: #aaa;
        font-size: 14px;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(20px);}
        to {opacity: 1; transform: translateY(0);}
    }
</style>
</head>
<body>
<div class="container">
<h1>Laravel Maintenance Tool</h1>
<div class="log">
';

if (! empty($_COOKIE)) {
    echo "<span class='info'>Cookies Detected:</span>\n\n";
    print_r($_COOKIE);
} else {
    echo "<span class='info'>No cookies found in your browser.</span>";
}

echo '
</div>
<div class="footer">AffirmSpace Utility • Laravel Project Inspector</div>
</div>
</body>
</html>';
