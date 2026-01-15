<?php

namespace Database\Seeders;

use App\Models\FamilyBranch;
use App\Models\FamilyPhoto;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class FamilyPhotoSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Get all branches and users
    $branches = FamilyBranch::all();
    $users = User::all();

    if ($branches->isEmpty() || $users->isEmpty()) {
      $this->command->warn('Harap jalankan FamilyDummySeeder terlebih dahulu!');
      return;
    }

    $superAdmin = $users->whereIn('role', ['super_admin', 'Super Admin'])->first();
    if (!$superAdmin) {
      $superAdmin = $users->first();
    }

    // Ensure storage directory exists
    Storage::disk('public')->makeDirectory('family-photos');

    // Create sample photos for each branch
    $photoData = [
      [
        'title' => 'Acara Keluarga Tahunan 2024',
        'description' => 'Pertemuan tahunan keluarga besar yang diadakan di rumah kakek. Dihadiri oleh semua anggota keluarga dari berbagai cabang. Acara penuh kehangatan dan kebersamaan.',
        'location' => 'Rumah Kakek, Jakarta',
        'photo_date' => '2024-01-15',
      ],
      [
        'title' => 'Perayaan Ulang Tahun Kakek',
        'description' => 'Perayaan ulang tahun ke-75 kakek yang meriah. Seluruh keluarga berkumpul untuk merayakan momen spesial ini dengan penuh sukacita dan doa.',
        'location' => 'Jakarta',
        'photo_date' => '2024-03-05',
      ],
      [
        'title' => 'Reuni Keluarga Besar',
        'description' => 'Reuni keluarga yang diadakan setelah 5 tahun tidak bertemu. Momen yang sangat mengharukan dan penuh kenangan.',
        'location' => 'Bandung',
        'photo_date' => '2023-08-10',
      ],
      [
        'title' => 'Pernikahan Ahmad & Siti',
        'description' => 'Acara pernikahan yang megah dan penuh berkah. Pernikahan ini menyatukan dua keluarga besar dalam ikatan persaudaraan yang lebih erat.',
        'location' => 'Gedung Pernikahan Permata, Surabaya',
        'photo_date' => '2023-06-20',
      ],
      [
        'title' => 'Liburan Keluarga ke Bali',
        'description' => 'Liburan bersama seluruh keluarga ke Pulau Bali. Menikmati keindahan alam dan budaya Bali sambil mempererat tali persaudaraan.',
        'location' => 'Bali',
        'photo_date' => '2023-12-25',
      ],
      [
        'title' => 'Pengajian Keluarga Ramadan',
        'description' => 'Acara pengajian rutin keluarga yang diadakan setiap bulan Ramadan. Momen untuk berbagi ilmu agama dan mempererat silaturahmi.',
        'location' => 'Masjid Al-Ikhlas',
        'photo_date' => '2024-04-12',
      ],
      [
        'title' => 'Wisuda Anak Keluarga',
        'description' => 'Momen kebanggaan keluarga saat salah satu anggota keluarga meraih gelar sarjana. Pencapaian yang membanggakan untuk seluruh keluarga.',
        'location' => 'Universitas Indonesia',
        'photo_date' => '2023-09-01',
      ],
      [
        'title' => 'Acara Syukuran Kelahiran Bayi',
        'description' => 'Syukuran atas kelahiran anggota keluarga baru. Bayi yang sehat dan lucu membawa kebahagiaan untuk seluruh keluarga.',
        'location' => 'Rumah Keluarga',
        'photo_date' => '2024-02-28',
      ],
      [
        'title' => 'Kunjungan ke Makam Leluhur',
        'description' => 'Ziarah bersama ke makam para leluhur untuk mendoakan dan mengenang jasa-jasa mereka. Tradisi yang selalu dijaga oleh keluarga.',
        'location' => 'Pemakaman Keluarga Cianjur',
        'photo_date' => '2024-05-10',
      ],
      [
        'title' => 'Halal Bihalal Idul Fitri',
        'description' => 'Acara halal bihalal setelah Idul Fitri. Momen untuk saling memaafkan dan memulai lembaran baru dengan penuh kasih sayang.',
        'location' => 'Rumah Kakek',
        'photo_date' => '2024-04-25',
      ],
    ];

    // Create sample image files (placeholder)
    foreach ($photoData as $index => $data) {
      // Create a simple placeholder image file (you can replace with actual images)
      $imageName = 'photo_' . ($index + 1) . '.jpg';
      $imagePath = 'family-photos/' . $imageName;

      // Create a placeholder file (empty file for now)
      // In production, you would upload actual images
      Storage::disk('public')->put($imagePath, '');

      // Randomly assign to a branch
      $branch = $branches->random();

      FamilyPhoto::create([
        'title' => $data['title'],
        'description' => $data['description'],
        'photo_path' => $imagePath,
        'family_branch_id' => $branch->id,
        'photo_date' => $data['photo_date'],
        'location' => $data['location'],
        'uploaded_by' => $superAdmin->id,
        'is_public' => true,
        'status' => 'approved',
        'approved_by' => $superAdmin->id,
        'approved_at' => now(),
      ]);

      $this->command->info("Created photo: {$data['title']}");
    }

    $this->command->info('Family photos seeded successfully!');
    $this->command->warn('CATATAN: Placeholder images telah dibuat. Untuk testing yang lebih baik, upload foto asli melalui admin panel.');
  }
}
