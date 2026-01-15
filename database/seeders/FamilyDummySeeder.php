<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FamilyBranch;
use App\Models\FamilyMember;

class FamilyDummySeeder extends Seeder
{
  public function run(): void
  {
    // Ambil atau buat cabang keluarga
    $branch = FamilyBranch::first();

    if (!$branch) {
      $branch = FamilyBranch::create([
        'name' => 'Cabang Keturunan Anak Pertama',
        'founder_name' => 'Bapak Wirawan',
        'color_code' => '#3b82f6',
        'is_active' => true,
      ]);
    }

    // GENERASI 1 - Leluhur (Kakek-Nenek)
    $kakek = FamilyMember::create([
      'family_branch_id' => $branch->id,
      'full_name' => 'Bapak Wirawan Kusuma',
      'nickname' => 'Pak Wir',
      'gender' => 'male',
      'birth_date' => '1940-05-15',
      'birth_place' => 'Yogyakarta',
      'is_alive' => false,
      'death_date' => '2015-08-20',
      'death_place' => 'Jakarta',
      'generation' => 1,
      'marital_status' => 'widowed',
      'is_public' => true,
      'status' => 'approved',
    ]);

    $nenek = FamilyMember::create([
      'family_branch_id' => $branch->id,
      'full_name' => 'Ibu Siti Rahayu',
      'nickname' => 'Bu Siti',
      'gender' => 'female',
      'birth_date' => '1942-03-10',
      'birth_place' => 'Solo',
      'is_alive' => true,
      'generation' => 1,
      'marital_status' => 'widowed',
      'is_public' => true,
      'status' => 'approved',
    ]);

    // Update spouse relationship
    $kakek->update(['spouse_id' => $nenek->id]);
    $nenek->update(['spouse_id' => $kakek->id, 'marriage_date' => '1960-06-12']);

    // GENERASI 2 - Orang Tua (Anak dari Kakek-Nenek)
    $bapak = FamilyMember::create([
      'family_branch_id' => $branch->id,
      'full_name' => 'Ahmad Wirawan',
      'nickname' => 'Pak Ahmad',
      'gender' => 'male',
      'father_id' => $kakek->id,
      'mother_id' => $nenek->id,
      'birth_date' => '1965-11-20',
      'birth_place' => 'Jakarta',
      'is_alive' => true,
      'generation' => 2,
      'child_order' => 1,
      'marital_status' => 'married',
      'occupation' => 'Pengusaha',
      'is_public' => true,
      'status' => 'approved',
    ]);

    $ibu = FamilyMember::create([
      'family_branch_id' => $branch->id,
      'full_name' => 'Dewi Lestari',
      'nickname' => 'Bu Dewi',
      'gender' => 'female',
      'birth_date' => '1968-07-15',
      'birth_place' => 'Bandung',
      'is_alive' => true,
      'generation' => 2,
      'marital_status' => 'married',
      'occupation' => 'Guru',
      'is_public' => true,
      'status' => 'approved',
    ]);

    // Update spouse relationship
    $bapak->update(['spouse_id' => $ibu->id, 'marriage_date' => '1990-05-18']);
    $ibu->update(['spouse_id' => $bapak->id, 'marriage_date' => '1990-05-18']);

    // Saudara kandung dari Bapak (Paman/Bibi)
    $paman = FamilyMember::create([
      'family_branch_id' => $branch->id,
      'full_name' => 'Budi Wirawan',
      'nickname' => 'Pak Budi',
      'gender' => 'male',
      'father_id' => $kakek->id,
      'mother_id' => $nenek->id,
      'birth_date' => '1970-03-08',
      'birth_place' => 'Jakarta',
      'is_alive' => true,
      'generation' => 2,
      'child_order' => 2,
      'marital_status' => 'married',
      'occupation' => 'Dokter',
      'is_public' => true,
      'status' => 'approved',
    ]);

    $tante = FamilyMember::create([
      'family_branch_id' => $branch->id,
      'full_name' => 'Maya Kusuma',
      'nickname' => 'Bu Maya',
      'gender' => 'female',
      'father_id' => $kakek->id,
      'mother_id' => $nenek->id,
      'birth_date' => '1972-09-25',
      'birth_place' => 'Jakarta',
      'is_alive' => true,
      'generation' => 2,
      'child_order' => 3,
      'marital_status' => 'married',
      'occupation' => 'Arsitek',
      'is_public' => true,
      'status' => 'approved',
    ]);

    // GENERASI 3 - Cucu (Anak dari Ahmad & Dewi)
    $anak1 = FamilyMember::create([
      'family_branch_id' => $branch->id,
      'full_name' => 'Rizki Ahmad Wirawan',
      'nickname' => 'Rizki',
      'gender' => 'male',
      'father_id' => $bapak->id,
      'mother_id' => $ibu->id,
      'birth_date' => '1992-04-10',
      'birth_place' => 'Jakarta',
      'is_alive' => true,
      'generation' => 3,
      'child_order' => 1,
      'marital_status' => 'married',
      'occupation' => 'Software Engineer',
      'phone' => '081234567890',
      'email' => 'rizki@example.com',
      'is_public' => true,
      'status' => 'approved',
    ]);

    $anak2 = FamilyMember::create([
      'family_branch_id' => $branch->id,
      'full_name' => 'Sari Dewi Wirawan',
      'nickname' => 'Sari',
      'gender' => 'female',
      'father_id' => $bapak->id,
      'mother_id' => $ibu->id,
      'birth_date' => '1995-08-22',
      'birth_place' => 'Jakarta',
      'is_alive' => true,
      'generation' => 3,
      'child_order' => 2,
      'marital_status' => 'single',
      'occupation' => 'Designer',
      'phone' => '081234567891',
      'email' => 'sari@example.com',
      'is_public' => true,
      'status' => 'approved',
    ]);

    $anak3 = FamilyMember::create([
      'family_branch_id' => $branch->id,
      'full_name' => 'Andi Ahmad Wirawan',
      'nickname' => 'Andi',
      'gender' => 'male',
      'father_id' => $bapak->id,
      'mother_id' => $ibu->id,
      'birth_date' => '1998-12-05',
      'birth_place' => 'Jakarta',
      'is_alive' => true,
      'generation' => 3,
      'child_order' => 3,
      'marital_status' => 'single',
      'occupation' => 'Mahasiswa',
      'phone' => '081234567892',
      'email' => 'andi@example.com',
      'is_public' => true,
      'status' => 'approved',
    ]);

    // Istri dari Rizki
    $istriRizki = FamilyMember::create([
      'family_branch_id' => $branch->id,
      'full_name' => 'Linda Permata Sari',
      'nickname' => 'Linda',
      'gender' => 'female',
      'birth_date' => '1994-02-14',
      'birth_place' => 'Surabaya',
      'is_alive' => true,
      'generation' => 3,
      'marital_status' => 'married',
      'occupation' => 'Accountant',
      'phone' => '081234567893',
      'email' => 'linda@example.com',
      'is_public' => true,
      'status' => 'approved',
    ]);

    // Update spouse relationship
    $anak1->update(['spouse_id' => $istriRizki->id, 'marriage_date' => '2018-07-15']);
    $istriRizki->update(['spouse_id' => $anak1->id, 'marriage_date' => '2018-07-15']);

    // GENERASI 4 - Cicit (Anak dari Rizki & Linda)
    $cucu1 = FamilyMember::create([
      'family_branch_id' => $branch->id,
      'full_name' => 'Alya Rizki Wirawan',
      'nickname' => 'Alya',
      'gender' => 'female',
      'father_id' => $anak1->id,
      'mother_id' => $istriRizki->id,
      'birth_date' => '2020-03-20',
      'birth_place' => 'Jakarta',
      'is_alive' => true,
      'generation' => 4,
      'child_order' => 1,
      'marital_status' => 'single',
      'is_public' => true,
      'status' => 'approved',
    ]);

    $cucu2 = FamilyMember::create([
      'family_branch_id' => $branch->id,
      'full_name' => 'Aryan Rizki Wirawan',
      'nickname' => 'Aryan',
      'gender' => 'male',
      'father_id' => $anak1->id,
      'mother_id' => $istriRizki->id,
      'birth_date' => '2023-11-10',
      'birth_place' => 'Jakarta',
      'is_alive' => true,
      'generation' => 4,
      'child_order' => 2,
      'marital_status' => 'single',
      'is_public' => true,
      'status' => 'approved',
    ]);

    $this->command->info('✅ Data dummy keluarga berhasil dibuat!');
    $this->command->info('📊 Total: ' . FamilyMember::count() . ' anggota keluarga');
    $this->command->info('🌳 Struktur:');
    $this->command->info('   Generasi 1: Kakek Wirawan + Nenek Siti');
    $this->command->info('   Generasi 2: 3 anak (Ahmad, Budi, Maya)');
    $this->command->info('   Generasi 3: 4 orang (3 anak Ahmad + istri Rizki)');
    $this->command->info('   Generasi 4: 2 cicit (anak Rizki & Linda)');
  }
}
