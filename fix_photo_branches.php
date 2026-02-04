<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Fixing Photo Branch Assignments ===\n\n";

// Get Admin Cabang 1's branch
$adminId = 'a0fcecb7-f49f-4d8a-9baf-81a5fe806ce7';
$branch = DB::table('family_branches')
    ->where('admin_id', $adminId)
    ->first();

if ($branch) {
    echo "Admin Cabang 1 is admin of: {$branch->name}\n";
    echo "Branch ID: {$branch->id}\n\n";
    
    // Update all photos uploaded by this admin
    $updated = DB::table('family_photos')
        ->where('uploaded_by', $adminId)
        ->update(['family_branch_id' => $branch->id]);
    
    echo "Updated {$updated} photos to branch {$branch->name}\n";
}

echo "\n=== Verification ===\n";
$photos = DB::table('family_photos')
    ->where('uploaded_by', $adminId)
    ->get(['id', 'title', 'family_branch_id', 'status']);

foreach ($photos as $photo) {
    echo "Photo: {$photo->title}\n";
    echo "  Branch ID: {$photo->family_branch_id}\n";
    echo "  Status: {$photo->status}\n\n";
}
