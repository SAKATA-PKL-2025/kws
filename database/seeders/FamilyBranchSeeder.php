<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FamilyBranch;
use App\Models\User;

class FamilyBranchSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $superAdmin = User::role('Super Admin')->first();
    $adminCabang1 = User::where('email', 'admin.cabang1@kws.com')->first();
    $adminCabang2 = User::where('email', 'admin.cabang2@kws.com')->first();

    // Cabang Utama (Founder)
    FamilyBranch::create([
      'name' => 'Cabang Keturunan Anak Pertama',
      'founder_name' => 'H. Ahmad Suryanto (Anak Pertama Founder)',
      'description' => 'Cabang keluarga dari anak pertama pendiri KWS',
      'location' => 'Tasikmalaya, Jawa Barat',
      'generation' => 2,
      'color_code' => '#3B82F6',
      'admin_id' => $adminCabang1?->id,
      'is_active' => true,
      'created_by' => $superAdmin?->id,
    ]);

    FamilyBranch::create([
      'name' => 'Cabang Keturunan Anak Kedua',
      'founder_name' => 'Hj. Siti Nurhaliza (Anak Kedua Founder)',
      'description' => 'Cabang keluarga dari anak kedua pendiri KWS',
      'location' => 'Bandung, Jawa Barat',
      'generation' => 2,
      'color_code' => '#EF4444',
      'admin_id' => $adminCabang2?->id,
      'is_active' => true,
      'created_by' => $superAdmin?->id,
    ]);

    FamilyBranch::create([
      'name' => 'Cabang Keturunan Anak Ketiga',
      'founder_name' => 'H. Budi Santoso (Anak Ketiga Founder)',
      'description' => 'Cabang keluarga dari anak ketiga pendiri KWS',
      'location' => 'Jakarta',
      'generation' => 2,
      'color_code' => '#10B981',
      'is_active' => true,
      'created_by' => $superAdmin?->id,
    ]);

    $this->command->info('Sample family branches created successfully!');
  }
}
