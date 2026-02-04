<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Setting some photos to pending status for testing ===\n\n";

// Get first photo and set to pending
$updated = DB::table('family_photos')
    ->where('id', 1)
    ->update([
        'status' => 'pending',
        'approved_by' => null,
        'approved_at' => null,
    ]);

echo "Updated photo ID 1 to pending status\n";

// Check all photos status
echo "\n=== Current Photos Status ===\n";
$photos = DB::table('family_photos')
    ->select('id', 'title', 'status')
    ->get();

foreach ($photos as $photo) {
    echo sprintf(
        "ID: %s | Title: %s | Status: %s\n",
        $photo->id,
        $photo->title,
        $photo->status
    );
}
