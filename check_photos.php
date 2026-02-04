<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Family Photos Status ===\n\n";
echo "Total photos: " . DB::table('family_photos')->count() . "\n\n";

$photos = DB::table('family_photos')
    ->select('id', 'title', 'status', 'is_public', 'photo_path', 'family_branch_id')
    ->get();

foreach ($photos as $photo) {
    echo sprintf(
        "ID: %s | Title: %s | Status: %s | Public: %s | Path: %s | Branch: %s\n",
        $photo->id,
        $photo->title,
        $photo->status,
        $photo->is_public ? 'Yes' : 'No',
        $photo->photo_path ?? 'NULL',
        $photo->family_branch_id ?? 'NULL'
    );
}

echo "\n=== Photos for public display ===\n";
$publicPhotos = DB::table('family_photos')
    ->where('is_public', true)
    ->where('status', 'approved')
    ->count();
echo "Public approved photos: $publicPhotos\n";

echo "\n=== Photos pending approval ===\n";
$pendingPhotos = DB::table('family_photos')
    ->where('status', 'pending')
    ->count();
echo "Pending photos: $pendingPhotos\n";
