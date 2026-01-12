<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$logFile = __DIR__ . '/../storage/logs/laravel.log';

if (! file_exists($logFile)) {
    die("❌ Log file not found at: $logFile");
}

// Get last N lines (you can increase the limit if needed)
$lines = 200;
$tail  = tailCustom($logFile, $lines);

// Optional: HTML output with basic styling
echo "<pre style='background: #111; color: #0f0; padding: 20px; font-size: 14px;'>";
echo htmlentities($tail);
echo "</pre>";

// Helper function to get last N lines from a file
function tailCustom($filepath, $lines = 100)
{
    $f = fopen($filepath, "rb");
    if ($f === false) {
        return false;
    }

    $buffer    = '';
    $chunkSize = 4096;

    fseek($f, -1, SEEK_END);
    if (fgetc($f) !== "\n") {
        $lines--;
    }

    while (ftell($f) > 0 && $lines >= 0) {
        $seek = ftell($f) - $chunkSize;
        if ($seek < 0) {
            $chunkSize += $seek;
            $seek = 0;
        }
        fseek($f, $seek, SEEK_SET);
        $buffer = fread($f, $chunkSize) . $buffer;
        fseek($f, $seek, SEEK_SET);
        $lines -= substr_count($buffer, "\n");
    }

    fclose($f);

    $linesArray = explode("\n", $buffer);
    return implode("\n", array_slice($linesArray, -$lines));
}
