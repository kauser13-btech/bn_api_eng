<?php

// Define the path to your Laravel project's root
// Adjust this if your script is not in the project root
define('LARAVEL_START', microtime(true));
$projectRoot = __DIR__ . '/..'; // If script is in a 'scripts' subdirectory

// Bootstrap Laravel
require $projectRoot . '/vendor/autoload.php';
$app = require_once $projectRoot . '/bootstrap/app.php';

// Make the Illuminate\Contracts\Http\Kernel available
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class); // Or Http\Kernel if you need HTTP context, but ConsoleKernel is usually enough
$kernel->bootstrap();

// Now you can use Laravel Facades, Models, and Helpers
use App\Helpers\clearCacheHelpers;
use Illuminate\Support\Facades\Artisan;

$start_time = microtime(true);

echo "Cache Clearing...\n";

Artisan::call('cache:clear');
Artisan::call('optimize:clear');
clearCacheHelpers::autoQuickCache();

$end_time = microtime(true);
echo "Time taken: " . round(($end_time - $start_time), 4) . " seconds\n";
