# Fitur Galeri Foto Keluarga - Dokumentasi Lengkap

## 📸 Overview

Fitur galeri foto keluarga adalah sistem manajemen foto yang memungkinkan admin untuk mengupload, mengelola, dan mempublikasikan foto-foto acara keluarga. Fitur ini dilengkapi dengan sistem approval untuk Super Admin dan tampilan galeri publik yang menarik.

## ✨ Fitur Utama

### 1. Upload & Manajemen Foto (Admin)

-   ✅ Upload foto dengan editor gambar built-in
-   ✅ Pilihan aspect ratio (16:9, 4:3, 1:1)
-   ✅ Maksimal ukuran file 5MB
-   ✅ Auto-crop dan resize
-   ✅ Metadata lengkap (judul, deskripsi, tanggal, lokasi)
-   ✅ Assign ke cabang keluarga tertentu
-   ✅ Toggle publik/private

### 2. Sistem Approval

-   ✅ Auto-approve untuk Admin Keluarga
-   ✅ Manual approval untuk Super Admin
-   ✅ Status: Pending, Approved, Rejected
-   ✅ Badge notifikasi jumlah pending photos

### 3. Galeri Publik

-   ✅ Grid layout responsif (1-4 kolom tergantung screen)
-   ✅ Filter berdasarkan cabang keluarga
-   ✅ Hover effect dengan overlay informasi
-   ✅ Modal detail foto dengan informasi lengkap
-   ✅ Empty state jika belum ada foto

## 🗂️ Struktur Database

### Tabel: family_photos

| Field            | Type      | Description                                  |
| ---------------- | --------- | -------------------------------------------- |
| id               | UUID      | Primary key                                  |
| title            | string    | Judul foto (required)                        |
| description      | text      | Deskripsi foto (nullable)                    |
| photo_path       | string    | Path file foto di storage                    |
| family_branch_id | UUID      | Foreign key ke family_branches (nullable)    |
| photo_date       | date      | Tanggal foto diambil (nullable)              |
| location         | string    | Lokasi foto (nullable)                       |
| uploaded_by      | UUID      | Foreign key ke users (uploader)              |
| is_public        | boolean   | Status publikasi (default: true)             |
| status           | enum      | pending/approved/rejected (default: pending) |
| approved_by      | UUID      | Foreign key ke users (approver, nullable)    |
| approved_at      | timestamp | Waktu approval (nullable)                    |
| created_at       | timestamp | -                                            |
| updated_at       | timestamp | -                                            |

## 📁 File Structure

```
app/
├── Models/
│   └── FamilyPhoto.php              # Model dengan relasi
├── Http/
│   └── Controllers/
│       └── Public/
│           └── PublicController.php  # gallery() method
└── Filament/
    └── Resources/
        └── Family/
            ├── FamilyPhotoResource.php           # Resource utama
            └── FamilyPhotoResource/
                └── Pages/
                    ├── ListFamilyPhotos.php      # List page
                    ├── CreateFamilyPhoto.php     # Create + auto-approve
                    ├── EditFamilyPhoto.php       # Edit page
                    └── ViewFamilyPhoto.php       # View page

database/
├── migrations/
│   └── 2026_01_15_141411_create_family_photos_table.php
└── seeders/
    └── FamilyPhotoSeeder.php         # Sample data seeder

resources/
└── views/
    └── public/
        └── gallery.blade.php         # Halaman galeri publik

storage/
└── app/
    └── public/
        └── family-photos/            # Direktori penyimpanan foto
```

## 🚀 Cara Menggunakan

### Untuk Admin Keluarga:

1. **Login ke Admin Panel**

    - Buka `/admin`
    - Login dengan akun Admin Keluarga

2. **Upload Foto**

    - Klik menu "Foto Keluarga" di sidebar
    - Klik tombol "Buat Foto Keluarga"
    - Upload foto (drag & drop atau pilih file)
    - Gunakan image editor untuk crop/resize
    - Isi informasi:
        - Judul (required)
        - Deskripsi (optional)
        - Cabang Keluarga (auto-filled untuk Admin Keluarga)
        - Tanggal Foto (optional)
        - Lokasi (optional)
    - Klik "Buat"
    - ✅ Foto langsung approved dan muncul di galeri publik!

3. **Edit/Hapus Foto**
    - Di list foto, klik ikon titik 3 (⋮) pada foto
    - Pilih "Lihat", "Ubah", atau "Hapus"
    - Edit informasi foto sesuai kebutuhan

### Untuk Super Admin:

1. **Semua fitur Admin Keluarga +**
2. **Approve/Reject Foto**

    - Badge warning menampilkan jumlah foto pending
    - Klik ikon titik 3 (⋮) pada foto pending
    - Pilih "Setujui" atau "Tolak"
    - Hanya foto approved yang muncul di galeri publik

3. **Filter & Search**
    - Filter by cabang keluarga
    - Filter by status (pending/approved/rejected)
    - Filter by is_public (public/private)
    - Search by title

### Untuk Pengunjung (Public):

1. **Lihat Galeri**

    - Buka `/galeri`
    - Scroll untuk melihat semua foto

2. **Filter Foto**

    - Klik tombol "Semua" atau pilih cabang keluarga
    - Foto akan difilter sesuai cabang

3. **Lihat Detail Foto**
    - Klik pada foto untuk membuka modal
    - Modal menampilkan:
        - Gambar ukuran besar
        - Judul dan deskripsi
        - Tanggal dan lokasi
        - Badge cabang keluarga
    - Klik tombol "Tutup" atau tekan ESC untuk menutup modal

## 🎨 Fitur UI/UX

### Admin Panel:

-   ✅ Image editor dengan aspect ratio controls
-   ✅ Circular preview thumbnail (60px)
-   ✅ Badge status berwarna (pending/approved/rejected)
-   ✅ Action menu dengan ikon ellipsis (⋮)
-   ✅ Navigation badge dengan counter
-   ✅ Form sections terorganisir
-   ✅ Auto-complete untuk Admin Keluarga

### Galeri Publik:

-   ✅ Hero section dengan judul menarik
-   ✅ Filter buttons dengan counter
-   ✅ Responsive grid (1-4 kolom)
-   ✅ Hover effect dengan transform & overlay
-   ✅ Modal foto dengan 2-column layout
-   ✅ Info box untuk admin
-   ✅ Empty state yang informatif

## 🔒 Permission & Security

### Role-Based Access:

-   **Super Admin**: Full access (CRUD + approve/reject)
-   **Admin Keluarga**: CRUD untuk cabang sendiri (auto-approve)
-   **Public**: View approved & public photos only

### Auto-Approval Logic:

```php
// CreateFamilyPhoto.php
protected function mutateFormDataBeforeCreate(array $data): array
{
    $data['uploaded_by'] = Auth::id();
    $data['status'] = 'approved';      // Auto approve
    $data['approved_by'] = Auth::id();
    $data['approved_at'] = now();
    return $data;
}
```

### Storage Security:

-   Photos stored in `storage/app/public/family-photos/`
-   Symlink required: `php artisan storage:link`
-   File cleanup on delete: `Storage::disk('public')->delete($record->photo_path)`

## 🧪 Testing

### 1. Run Seeder untuk Data Dummy:

```bash
php artisan db:seed --class=FamilyPhotoSeeder
```

### 2. Upload Foto Real via Admin:

-   Login ke `/admin`
-   Upload foto asli untuk replace placeholder
-   Test image editor & aspect ratios
-   Verifikasi file tersimpan di storage

### 3. Test Galeri Publik:

-   Buka `/galeri`
-   Test filter by cabang
-   Klik foto untuk buka modal
-   Test responsive di berbagai screen size
-   Test keyboard navigation (ESC key)

### 4. Test Approval Workflow:

-   Login sebagai Admin Keluarga → upload foto → cek langsung approved
-   Login sebagai Super Admin → upload foto other branch → cek pending status
-   Test approve & reject actions

## 📊 Sample Data

Seeder membuat 10 foto contoh dengan data:

1. Acara Keluarga Tahunan 2024
2. Perayaan Ulang Tahun Kakek
3. Reuni Keluarga Besar
4. Pernikahan Ahmad & Siti
5. Liburan Keluarga ke Bali
6. Pengajian Keluarga Ramadan
7. Wisuda Anak Keluarga
8. Acara Syukuran Kelahiran Bayi
9. Kunjungan ke Makam Leluhur
10. Halal Bihalal Idul Fitri

Semua foto:

-   ✅ Status: Approved
-   ✅ Public: Yes
-   ✅ Assigned ke random branch
-   ✅ Complete metadata (title, description, date, location)

## 🔧 Troubleshooting

### Foto tidak muncul di galeri:

1. ✅ Cek status foto = 'approved'
2. ✅ Cek is_public = true
3. ✅ Jalankan `php artisan storage:link`
4. ✅ Cek file exists di `storage/app/public/family-photos/`

### Image upload error:

1. ✅ Cek max file size (5MB)
2. ✅ Cek format file (jpg/jpeg/png)
3. ✅ Cek permission folder storage
4. ✅ Cek disk space

### Filter tidak berfungsi:

1. ✅ Cek JavaScript console for errors
2. ✅ Pastikan data-category attribute set
3. ✅ Clear browser cache

## 🎯 Best Practices

### Untuk Admin:

-   ✅ Gunakan judul yang deskriptif
-   ✅ Isi tanggal dan lokasi untuk dokumentasi
-   ✅ Upload foto berkualitas baik (tidak blur)
-   ✅ Crop dengan aspect ratio yang sesuai
-   ✅ Assign ke cabang yang tepat

### Untuk Developer:

-   ✅ Selalu cleanup file saat delete record
-   ✅ Validate file size & format
-   ✅ Use eager loading untuk relations (`with(['branch'])`)
-   ✅ Implement proper error handling
-   ✅ Add logging untuk upload/delete actions

## 📈 Future Enhancements

Fitur yang bisa ditambahkan:

-   [ ] Bulk upload (multiple files)
-   [ ] Image compression otomatis
-   [ ] Watermark untuk foto
-   [ ] Download foto dalam ZIP
-   [ ] Social media sharing
-   [ ] Comments on photos
-   [ ] Tags/categories untuk foto
-   [ ] Search by keyword
-   [ ] Pagination untuk galeri
-   [ ] Lazy loading untuk performa

## 📝 Changelog

### Version 1.0.0 (2026-01-15)

-   ✅ Initial release
-   ✅ Upload & management system
-   ✅ Approval workflow
-   ✅ Public gallery with filters
-   ✅ Modal detail view
-   ✅ Responsive design
-   ✅ Sample data seeder

---

**Dokumentasi dibuat:** 15 Januari 2026  
**Last Updated:** 15 Januari 2026  
**Author:** Admin Website Keluarga
