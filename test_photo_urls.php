<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

echo "=== Testing Photo URLs ===\n\n";

$photos = DB::table('family_photos')->get();

foreach ($photos as $photo) {
    echo "Photo ID: {$photo->id}\n";
    echo "Title: {$photo->title}\n";
    echo "Path in DB: {$photo->photo_path}\n";
    
    // Check if file exists
    $exists = Storage::disk('public')->exists($photo->photo_path);
    echo "File exists in storage: " . ($exists ? 'YES' : 'NO') . "\n";
    
    // Get full path
    $fullPath = storage_path('app/public/' . $photo->photo_path);
    echo "Full path: {$fullPath}\n";
    echo "File exists on disk: " . (file_exists($fullPath) ? 'YES' : 'NO') . "\n";
    
    // Get URL
    $url = asset('storage/' . $photo->photo_path);
    echo "Public URL: {$url}\n";
    
    echo "\n";
}
