<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Reset cached roles and permissions
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    // Create Permissions
    $permissions = [
      // User Management
      'view_users',
      'create_users',
      'edit_users',
      'delete_users',

      // Family Member Management
      'view_family_members',
      'create_family_members',
      'edit_family_members',
      'delete_family_members',
      'approve_family_members',

      // Family Branch Management
      'view_family_branches',
      'create_family_branches',
      'edit_family_branches',
      'delete_family_branches',
      'manage_own_branch',

      // Gallery & Stories
      'view_galleries',
      'create_galleries',
      'edit_galleries',
      'delete_galleries',
      'manage_own_gallery',

      // System Settings
      'access_system_settings',
      'backup_database',
      'restore_database',
      'view_activity_logs',

      // Reports
      'view_reports',
      'export_reports',
    ];

    foreach ($permissions as $permission) {
      Permission::create(['name' => $permission]);
    }

    // Create Roles and Assign Permissions

    // Super Admin - Full Access
    $superAdmin = Role::create(['name' => 'Super Admin']);
    $superAdmin->givePermissionTo(Permission::all());

    // Admin Keluarga - Limited Access
    $adminKeluarga = Role::create(['name' => 'Admin Keluarga']);
    $adminKeluarga->givePermissionTo([
      'view_family_members',
      'create_family_members',
      'edit_family_members',
      'manage_own_branch',
      'view_galleries',
      'create_galleries',
      'edit_galleries',
      'manage_own_gallery',
      'view_reports',
    ]);

    // Public/Pengunjung - View Only (optional, untuk future)
    $pengunjung = Role::create(['name' => 'Pengunjung']);
    $pengunjung->givePermissionTo([
      'view_family_members',
      'view_galleries',
    ]);
  }
}
