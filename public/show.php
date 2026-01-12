<?php

    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

    use Illuminate\Support\Facades\Config;

    function mask($value)
    {
        return $value ? str_repeat('*', strlen($value)) : '—';
    }

    function getLastLogLines($file, $lines = 30)
    {
        if (! file_exists($file)) {
            return ['Log file not found'];
        }
        $fp = fopen($file, 'r');
        fseek($fp, -1, SEEK_END);
        $buffer    = '';
        $lineCount = 0;
        while ($lineCount < $lines && ftell($fp) > 0) {
            $char   = fgetc($fp);
            $buffer = $char . $buffer;
            fseek($fp, -2, SEEK_CUR);
            if ($char === "\n") {
                $lineCount++;
            }

        }
        fclose($fp);
        return explode("\n", trim($buffer));
    }

    $laravelVersion = app()->version();
    $phpVersion     = phpversion();
    $appEnv         = env('APP_ENV');
    $appDebug       = env('APP_DEBUG') ? 'true' : 'false';
    $appUrl         = env('APP_URL');
    $timezone       = config('app.timezone');
    $cacheDriver    = config('cache.default');
    $sessionDriver  = config('session.driver');
    $queueDriver    = config('queue.default');
    $db             = config('database.connections.' . config('database.default'));
    $mail           = config('mail');

    $logFiles = glob(storage_path('logs/laravel*.log'));
    rsort($logFiles);
    $latestLogFile = $logFiles[0] ?? null;
    $latestLogs    = $latestLogFile ? getLastLogLines($latestLogFile, 30) : ['No log file found'];

    $composerLockFile = base_path('composer.lock');
    $packages         = $devPackages         = [];
    if (file_exists($composerLockFile)) {
        $lockData    = json_decode(file_get_contents($composerLockFile), true);
        $packages    = $lockData['packages'] ?? [];
        $devPackages = $lockData['packages-dev'] ?? [];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Laravel Maintenance Tool</title>
<style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap");

    body {
        font-family: "Poppins", sans-serif;
        background: linear-gradient(135deg, #141e30, #243b55);
        color: #e0e0e0;
        margin: 0;
        padding: 40px;
    }

    .container {
        max-width: 1100px;
        margin: auto;
        background: rgba(25, 25, 25, 0.9);
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.5);
        backdrop-filter: blur(10px);
        animation: fadeIn 0.7s ease-in-out;
    }

    h1 {
        text-align: center;
        color: #00e676;
        margin-bottom: 40px;
        font-weight: 600;
        letter-spacing: 1px;
    }

    h2 {
        color: #82b1ff;
        margin-top: 50px;
        border-bottom: 2px solid #00e676;
        padding-bottom: 6px;
        font-weight: 500;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: #0e0e0e;
        border-radius: 10px;
        overflow: hidden;
        margin-top: 15px;
        box-shadow: 0 0 10px rgba(0,0,0,0.2);
    }

    th, td {
        padding: 12px 16px;
        text-align: left;
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    th {
        background: rgba(0, 230, 118, 0.2);
        color: #00e676;
        font-weight: 600;
    }

    tr:hover td {
        background: rgba(255, 255, 255, 0.05);
    }

    pre {
        background: #0f0f0f;
        color: #f8f8f2;
        padding: 15px;
        border-radius: 10px;
        font-size: 14px;
        overflow-x: auto;
        max-height: 400px;
        line-height: 1.6;
        border: 1px solid rgba(255,255,255,0.1);
    }

    .small {
        color: #999;
        font-size: 13px;
        margin-top: 6px;
    }

    .center {
        text-align: center;
    }

    .footer {
        text-align: center;
        margin-top: 40px;
        color: #888;
        font-size: 14px;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(15px);}
        to {opacity: 1; transform: translateY(0);}
    }
</style>
</head>
<body>
<div class="container">

<h1>Laravel Maintenance Tool</h1>

<h2>Environment Details</h2>
<table>
    <tr><th>Laravel Version</th><td><?php echo $laravelVersion ?></td></tr>
    <tr><th>PHP Version</th><td><?php echo $phpVersion ?></td></tr>
    <tr><th>APP_ENV</th><td><?php echo $appEnv ?></td></tr>
    <tr><th>APP_DEBUG</th><td><?php echo $appDebug ?></td></tr>
    <tr><th>APP_URL</th><td><?php echo $appUrl ?></td></tr>
    <tr><th>Timezone</th><td><?php echo $timezone ?></td></tr>
    <tr><th>Cache Driver</th><td><?php echo $cacheDriver ?></td></tr>
    <tr><th>Session Driver</th><td><?php echo $sessionDriver ?></td></tr>
    <tr><th>Queue Driver</th><td><?php echo $queueDriver ?></td></tr>
</table>

<h2>Database Configuration</h2>
<table>
    <tr><th>Driver</th><td><?php echo $db['driver'] ?? '' ?></td></tr>
    <tr><th>Host</th><td><?php echo $db['host'] ?? '' ?></td></tr>
    <tr><th>Port</th><td><?php echo $db['port'] ?? '' ?></td></tr>
    <tr><th>Database</th><td><?php echo $db['database'] ?? '' ?></td></tr>
    <tr><th>Username</th><td><?php echo $db['username'] ?? '' ?></td></tr>
    <tr><th>Password</th><td><?php echo mask($db['password'] ?? '') ?></td></tr>
</table>

<h2>Email Configuration</h2>
<table>
    <tr><th>Driver</th><td><?php echo $mail['driver'] ?? '' ?></td></tr>
    <tr><th>Host</th><td><?php echo $mail['host'] ?? '' ?></td></tr>
    <tr><th>Port</th><td><?php echo $mail['port'] ?? '' ?></td></tr>
    <tr><th>From Email</th><td><?php echo $mail['from']['address'] ?? '' ?></td></tr>
    <tr><th>Encryption</th><td><?php echo $mail['encryption'] ?? '' ?></td></tr>
    <tr><th>Username</th><td><?php echo mask($mail['username'] ?? '') ?></td></tr>
</table>

<h2>Latest Laravel Log (last 30 lines)</h2>
<p class="small">File:                                                                   <?php echo basename($latestLogFile ?? 'None') ?></p>
<pre><?php echo htmlspecialchars(implode("\n", $latestLogs)) ?></pre>

<h2>Installed Composer Packages (<?php echo count($packages) ?>)</h2>
<table>
<tr><th>Name</th><th>Version</th><th>Description</th></tr>
<?php foreach (array_slice($packages, 0, 20) as $pkg): ?>
<tr>
    <td><?php echo $pkg['name'] ?></td>
    <td><?php echo $pkg['version'] ?></td>
    <td><?php echo $pkg['description'] ?? '' ?></td>
</tr>
<?php endforeach; ?>
</table>
<?php if (count($packages) > 20): ?>
<p class="small center">... and<?php echo count($packages) - 20 ?> more packages</p>
<?php endif; ?>

<h2>Dev Packages (<?php echo count($devPackages) ?>)</h2>
<table>
<tr><th>Name</th><th>Version</th><th>Description</th></tr>
<?php foreach (array_slice($devPackages, 0, 10) as $pkg): ?>
<tr>
    <td><?php echo $pkg['name'] ?></td>
    <td><?php echo $pkg['version'] ?></td>
    <td><?php echo $pkg['description'] ?? '' ?></td>
</tr>
<?php endforeach; ?>
</table>
<?php if (count($devPackages) > 10): ?>
<p class="small center">... and<?php echo count($devPackages) - 10 ?> more dev packages</p>
<?php endif; ?>

<div class="footer">AffirmSpace Utility • Laravel Project Inspector</div>

</div>
</body>
</html>
