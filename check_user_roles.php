<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Users and Their Roles ===\n\n";

$users = DB::table('users')
    ->select('id', 'name', 'email')
    ->get();

foreach ($users as $user) {
    echo "User: {$user->name} ({$user->email})\n";
    echo "ID: {$user->id}\n";
    
    // Get roles
    $roles = DB::table('model_has_roles')
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->where('model_has_roles.model_id', $user->id)
        ->select('roles.name')
        ->get();
    
    foreach ($roles as $role) {
        echo "  Role: {$role->name}\n";
    }
    
    // Check if admin of any branch
    $branches = DB::table('family_branches')
        ->where('admin_id', $user->id)
        ->select('id', 'name')
        ->get();
    
    if ($branches->count() > 0) {
        foreach ($branches as $branch) {
            echo "  Admin of Branch: {$branch->name}\n";
        }
    } else {
        echo "  NOT admin of any branch\n";
    }
    
    echo "\n";
}

echo "\n=== Family Branches ===\n\n";
$branches = DB::table('family_branches')
    ->select('id', 'name', 'admin_id')
    ->get();

foreach ($branches as $branch) {
    $adminName = 'Not assigned';
    if ($branch->admin_id) {
        $admin = DB::table('users')->where('id', $branch->admin_id)->first();
        $adminName = $admin ? $admin->name : 'Unknown';
    }
    echo "Branch: {$branch->name}\n";
    echo "  Admin: {$adminName}\n\n";
}

echo "\n=== Family Photos ===\n\n";
$photos = DB::table('family_photos')
    ->select('id', 'title', 'family_branch_id', 'uploaded_by', 'status')
    ->get();

foreach ($photos as $photo) {
    $uploader = DB::table('users')->where('id', $photo->uploaded_by)->first();
    $uploaderName = $uploader ? $uploader->name : 'Unknown';
    
    echo "Photo: {$photo->title}\n";
    echo "  Uploaded by: {$uploaderName}\n";
    echo "  Branch ID: {$photo->family_branch_id}\n";
    echo "  Status: {$photo->status}\n\n";
}
