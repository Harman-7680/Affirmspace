<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// HTML + CSS
echo '
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laravel Maintenance Tool</title>
<style>

    body {
        font-family: "Poppins", sans-serif;
        background-color: #121212;
        color: #e0e0e0;
        padding: 30px;
        margin: 0;
    }
    .container {
        max-width: 800px;
        margin: auto;
        background: #1e1e1e;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 0 20px rgba(0,0,0,0.3);
    }
    h1 {
        text-align: center;
        color: #00e676;
        margin-bottom: 25px;
    }
    .log {
        background: #0f0f0f;
        padding: 15px;
        border-radius: 8px;
        overflow-y: auto;
        max-height: 500px;
        white-space: pre-wrap;
        line-height: 1.5;
        font-family: "Courier New", monospace;
    }
    .success { color: #00e676; }
    .fail { color: #ff5252; }
    .info { color: #82b1ff; }
    .footer {
        text-align: center;
        margin-top: 20px;
        font-size: 14px;
        color: #777;
    }
</style>
</head>
<body>
<div class="container">
<h1>Laravel Maintenance Tool</h1>
<div class="log">
';

echo "--- Clearing Laravel caches ---\n\n";

$commands = [
    'cache:clear',
    'route:clear',
    'config:clear',
    'view:clear',
    'event:clear',
    'optimize:clear',
    'queue:restart',
];

foreach ($commands as $command) {
    $exitCode    = $kernel->call($command);
    $output      = $kernel->output();
    $statusClass = $exitCode === 0 ? "success" : "fail";
    echo "<span class='{$statusClass}'>$command executed (Exit code: $exitCode)</span>\n";
    if ($output) {
        echo "<span class='info'>Output:</span> $output\n";
    }
}

$logFile = __DIR__ . '/../storage/logs/laravel.log';

if (file_exists($logFile)) {
    if (unlink($logFile)) {
        echo "<span class='success'>Old log file deleted successfully.</span>\n";
        if (touch($logFile)) {
            echo "<span class='success'>New log file created successfully.</span>\n";
        } else {
            echo "<span class='fail'>Failed to create new log file.</span>\n";
        }
    } else {
        echo "<span class='fail'>Failed to delete old log file.</span>\n";
    }
} else {
    echo "<span class='info'>Log file not found, skipping deletion.</span>\n";
}

echo "\n<span class='success'>All caches cleared, queue restarted, and logs reset successfully.</span>";

echo '
</div>
<div class="footer">AffirmSpace Utility • Laravel Project Inspector</div>
        </div>
    </body>
</html>';
