<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Current Login Session ===\n";
echo "You are logged in as: A1 (from screenshot)\n\n";

echo "=== All Users ===\n\n";
$users = DB::table('users')->get(['id', 'name', 'email']);
foreach ($users as $user) {
    echo "{$user->name} - {$user->email}\n";
    echo "  ID: {$user->id}\n\n";
}

echo "\n=== Family Branches ===\n\n";
$branches = DB::table('family_branches')->get(['id', 'name', 'admin_id']);
foreach ($branches as $branch) {
    echo "Branch: {$branch->name}\n";
    echo "  ID: {$branch->id}\n";
    echo "  Admin ID: " . ($branch->admin_id ?? 'NULL') . "\n\n";
}

echo "\n=== Family Photos ===\n\n";
$photos = DB::table('family_photos')->get(['id', 'title', 'family_branch_id', 'uploaded_by']);
foreach ($photos as $photo) {
    echo "Photo: {$photo->title}\n";
    echo "  ID: {$photo->id}\n";
    echo "  Branch ID: {$photo->family_branch_id}\n";
    echo "  Uploaded by: {$photo->uploaded_by}\n\n";
}
