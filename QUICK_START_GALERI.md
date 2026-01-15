# 🚀 Quick Start Guide - Fitur Galeri Foto

## 📸 Cara Upload Foto di Admin Panel

### Langkah 1: Login ke Admin

1. Buka browser dan akses: `http://localhost/admin` atau `http://kws.test/admin`
2. Login dengan akun admin:
    - **Super Admin**: email yang ada di database
    - **Admin Keluarga**: email admin keluarga

### Langkah 2: Akses Menu Foto Keluarga

1. Di sidebar admin, cari menu **"Foto Keluarga"**
2. Klik menu tersebut
3. Anda akan melihat list foto yang sudah ada (12 sample photos)

### Langkah 3: Upload Foto Baru

1. Klik tombol **"Buat Foto Keluarga"** di kanan atas
2. Isi form upload:

    **📷 Informasi Foto:**

    - **Upload Foto**: Drag & drop atau klik untuk pilih file
        - Format: JPG, JPEG, PNG
        - Max size: 5MB
        - Gunakan **Image Editor** untuk crop (16:9, 4:3, atau 1:1)
    - **Judul**: Tulis judul foto (contoh: "Acara Keluarga 2024")
    - **Deskripsi**: Tulis deskripsi detail (optional)

    **📍 Detail Foto:**

    - **Cabang Keluarga**: Pilih cabang (auto-filled jika Admin Keluarga)
    - **Tanggal Foto**: Pilih tanggal saat foto diambil
    - **Lokasi**: Tulis lokasi (contoh: "Jakarta")

    **⚙️ Pengaturan Publikasi (Super Admin only):**

    - **Publik?**: Toggle ON agar muncul di galeri publik

3. Klik tombol **"Buat"**
4. ✅ Foto berhasil diupload dan langsung approved!

### Langkah 4: Verifikasi Upload

1. Kembali ke list foto
2. Cari foto yang baru saja diupload
3. Pastikan status = **"Approved"** (badge hijau)
4. Pastikan **"Publik"** = ✓ (checkmark)

---

## 🖼️ Cara Melihat Galeri Publik

### Akses Galeri:

1. Buka browser
2. Akses: `http://localhost/galeri` atau `http://kws.test/galeri`
3. Anda akan melihat galeri foto dengan layout grid yang menarik

### Filter Foto:

1. Di bagian atas galeri, ada tombol filter
2. Klik **"Semua"** untuk lihat semua foto
3. Klik nama cabang (contoh: **"Cabang A"**) untuk filter by cabang
4. Jumlah foto setiap cabang ditampilkan di button

### Lihat Detail Foto:

1. **Hover** mouse di atas foto → muncul overlay dengan info
2. **Klik** foto → modal detail terbuka dengan:
    - Gambar ukuran besar
    - Judul dan deskripsi lengkap
    - Tanggal dan lokasi
    - Badge cabang keluarga
3. **Klik "Tutup"** atau tekan **ESC** untuk menutup modal

---

## 🎯 Testing Checklist

### ✅ Test Upload

-   [ ] Login ke admin panel
-   [ ] Akses menu "Foto Keluarga"
-   [ ] Klik "Buat Foto Keluarga"
-   [ ] Upload foto dengan image editor
-   [ ] Isi semua field (title, description, date, location)
-   [ ] Submit form
-   [ ] Verifikasi foto muncul di list dengan status "Approved"

### ✅ Test Gallery Public

-   [ ] Buka `/galeri` di browser
-   [ ] Verifikasi ada 12+ foto ditampilkan
-   [ ] Test filter by cabang keluarga
-   [ ] Hover foto untuk lihat overlay
-   [ ] Klik foto untuk buka modal detail
-   [ ] Test close modal (button & ESC key)
-   [ ] Test responsive di mobile view

### ✅ Test Edit & Delete

-   [ ] Di admin, klik titik 3 (⋮) di foto
-   [ ] Klik "Ubah" → edit informasi → save
-   [ ] Verifikasi perubahan tersimpan
-   [ ] Test "Lihat" untuk view only mode
-   [ ] Test "Hapus" (hati-hati, permanent delete!)

### ✅ Test Approval (Super Admin only)

-   [ ] Login sebagai Super Admin
-   [ ] Upload foto ke cabang lain
-   [ ] Verifikasi badge warning dengan counter pending
-   [ ] Klik titik 3 (⋮) pada foto pending
-   [ ] Test "Setujui" → status jadi "Approved"
-   [ ] Test "Tolak" → status jadi "Rejected"
-   [ ] Verifikasi hanya foto "Approved" yang muncul di galeri publik

---

## 📊 Status Database Saat Ini

```
✅ Total Foto: 12
✅ Approved: 12
✅ Public: 12
✅ Storage Symlink: Connected
✅ Sample Data: Ready
```

### Sample Photos:

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
    11-12. (Additional photos)

---

## 🔧 Troubleshooting

### Foto tidak muncul di galeri:

```bash
# 1. Pastikan storage link sudah dibuat
php artisan storage:link

# 2. Cek permission folder (Linux/Mac)
chmod -R 775 storage
chmod -R 775 public/storage

# 3. Clear cache
php artisan cache:clear
php artisan view:clear
```

### Upload foto gagal:

1. ✅ Cek ukuran file (max 5MB)
2. ✅ Cek format file (JPG/PNG only)
3. ✅ Cek folder permission
4. ✅ Cek disk space server

### Modal tidak buka:

1. ✅ Check browser console (F12)
2. ✅ Clear browser cache (Ctrl+Shift+Del)
3. ✅ Test di browser lain (Chrome/Firefox)

---

## 🎨 Tips & Best Practices

### Upload Foto Berkualitas:

-   ✅ Gunakan foto HD (minimal 1920x1080)
-   ✅ Avoid foto blur atau gelap
-   ✅ Crop dengan aspect ratio yang sesuai:
    -   **16:9** → Landscape photo (wide)
    -   **4:3** → Standard photo
    -   **1:1** → Square (Instagram style)

### Penamaan & Deskripsi:

-   ✅ Judul jelas dan deskriptif
-   ✅ Tambahkan tanggal untuk dokumentasi
-   ✅ Tulis lokasi lengkap (kota/tempat)
-   ✅ Deskripsi detail tentang acara

### Organisasi:

-   ✅ Assign foto ke cabang yang tepat
-   ✅ Group foto by event/tanggal
-   ✅ Set private untuk foto internal family only
-   ✅ Archive foto lama yang tidak relevan

---

## 📱 Akses Cepat (Bookmarks)

### Admin Panel:

-   **Login**: http://localhost/admin
-   **Foto List**: http://localhost/admin/family/family-photos
-   **Upload Foto**: http://localhost/admin/family/family-photos/create

### Public Site:

-   **Home**: http://localhost
-   **Galeri**: http://localhost/galeri
-   **Privacy**: http://localhost/privacy

---

## 📞 Butuh Bantuan?

Jika ada masalah atau pertanyaan:

1. Cek dokumentasi lengkap: `FITUR_GALERI_FOTO.md`
2. Cek Laravel logs: `storage/logs/laravel.log`
3. Cek browser console: F12 → Console tab

**Selamat menggunakan fitur Galeri Foto Keluarga! 🎉**
