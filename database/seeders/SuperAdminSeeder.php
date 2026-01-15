<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Cari user yang sudah dibuat dengan make:filament-user
    $user = User::where('email', 'fikrihaikal170308@gmail.com')->first();

    if ($user) {
      // Assign role Super Admin ke user yang sudah ada
      $user->assignRole('Super Admin');
      $this->command->info('Role Super Admin assigned to existing user: ' . $user->email);
    } else {
      // Jika belum ada, buat user baru
      $superAdmin = User::create([
        'name' => 'Super Admin',
        'email' => 'admin@kws.com',
        'password' => Hash::make('password'),
        'email_verified_at' => now(),
      ]);

      $superAdmin->assignRole('Super Admin');
      $this->command->info('Super Admin created: ' . $superAdmin->email);
    }

    // Buat beberapa contoh Admin Keluarga untuk testing
    $adminBranch1 = User::create([
      'name' => 'Admin Cabang 1',
      'email' => 'admin.cabang1@kws.com',
      'password' => Hash::make('password'),
      'email_verified_at' => now(),
    ]);
    $adminBranch1->assignRole('Admin Keluarga');

    $adminBranch2 = User::create([
      'name' => 'Admin Cabang 2',
      'email' => 'admin.cabang2@kws.com',
      'password' => Hash::make('password'),
      'email_verified_at' => now(),
    ]);
    $adminBranch2->assignRole('Admin Keluarga');

    $this->command->info('Sample Admin Keluarga users created');
  }
}
