<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Setting one photo to rejected for testing ===\n\n";

// Get first pending photo and reject it
$photo = DB::table('family_photos')
    ->where('status', 'pending')
    ->first();

if ($photo) {
    DB::table('family_photos')
        ->where('id', $photo->id)
        ->update([
            'status' => 'rejected',
            'rejection_reason' => 'Foto kurang jelas dan resolusi rendah. Mohon upload ulang dengan kualitas yang lebih baik.',
            'approved_by' => 'a0fcecb7-7cbd-4ff8-990f-df3f4f58b531', // Super Admin ID
        ]);
    
    echo "Photo '{$photo->title}' has been rejected\n";
    echo "Rejection reason: Foto kurang jelas dan resolusi rendah. Mohon upload ulang dengan kualitas yang lebih baik.\n";
} else {
    echo "No pending photos found\n";
}

echo "\n=== Current Photos Status ===\n";
$photos = DB::table('family_photos')
    ->select('id', 'title', 'status', 'rejection_reason')
    ->get();

foreach ($photos as $photo) {
    echo sprintf(
        "ID: %s | Title: %s | Status: %s\n",
        $photo->id,
        $photo->title,
        $photo->status
    );
    if ($photo->status === 'rejected' && $photo->rejection_reason) {
        echo "  Rejection reason: {$photo->rejection_reason}\n";
    }
    echo "\n";
}
