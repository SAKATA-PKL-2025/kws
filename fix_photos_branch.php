<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Family Branches ===\n\n";

$branches = DB::table('family_branches')
    ->select('id', 'name', 'is_active')
    ->get();

foreach ($branches as $branch) {
    echo sprintf(
        "ID: %s | Name: %s | Active: %s\n",
        $branch->id,
        $branch->name,
        $branch->is_active ? 'Yes' : 'No'
    );
}

echo "\n=== Updating photos without branch ===\n";

$firstBranch = $branches->first();
if ($firstBranch) {
    $updated = DB::table('family_photos')
        ->whereNull('family_branch_id')
        ->update(['family_branch_id' => $firstBranch->id]);
    
    echo "Updated $updated photos to branch: {$firstBranch->name}\n";
} else {
    echo "No branches found!\n";
}
