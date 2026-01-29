<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Welcome Section -->
        <x-filament::section class="bg-primary-500 dark:bg-primary-600">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <x-heroicon-o-information-circle class="w-12 h-12 text-white" />
                </div>
                <div>
                    <h2 class="text-2xl font-bold mb-2 text-white">Selamat Datang di Panel Admin KWS</h2>
                    <p class="text-white/90">Panduan lengkap untuk mengelola sistem Silsilah Keluarga Kumpulan Wargi Sukapura</p>
                </div>
            </div>
        </x-filament::section>

        <!-- Quick Guide -->
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-check-circle class="w-6 h-6 text-primary-600" />
                    <span>Panduan Cepat</span>
                </div>
            </x-slot>
            
            <div class="grid md:grid-cols-2 gap-4">
                <div class="rounded-lg p-4 border-l-4 border-primary-500 bg-primary-50 dark:bg-gray-800">
                    <h4 class="font-semibold mb-2">1. Mengelola Anggota Keluarga</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Klik menu "Anggota Keluarga" untuk menambah, edit, atau hapus data anggota.</p>
                </div>
                <div class="rounded-lg p-4 border-l-4 border-success-500 bg-success-50 dark:bg-gray-800">
                    <h4 class="font-semibold mb-2">2. Mengelola Cabang Keluarga</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Atur cabang keluarga melalui menu "Cabang Keluarga" untuk organisasi yang lebih baik.</p>
                </div>
                <div class="rounded-lg p-4 border-l-4 border-danger-500 bg-danger-50 dark:bg-gray-800">
                    <h4 class="font-semibold mb-2">3. Upload Foto Galeri</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Tambahkan momen keluarga melalui menu "Foto Keluarga".</p>
                </div>
                <div class="rounded-lg p-4 border-l-4 border-warning-500 bg-warning-50 dark:bg-gray-800">
                    <h4 class="font-semibold mb-2">4. Kelola Pengguna</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Atur akses admin lain melalui menu "Pengguna".</p>
                </div>
            </div>
        </x-filament::section>

        <!-- FAQ Section -->
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-question-mark-circle class="w-6 h-6 text-primary-600" />
                    <span>Pertanyaan yang Sering Diajukan</span>
                </div>
            </x-slot>

            <div class="space-y-4">
                <!-- FAQ 1 -->
                <details class="group border dark:border-gray-700 rounded-lg overflow-hidden">
                    <summary class="flex items-center justify-between cursor-pointer p-4 font-semibold bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <span>Bagaimana cara menambahkan anggota keluarga baru?</span>
                        <x-heroicon-o-chevron-down class="w-5 h-5 transition group-open:rotate-180" />
                    </summary>
                    <div class="p-4 space-y-2 text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-900">
                        <p>1. Klik menu <strong>"Anggota Keluarga"</strong> di sidebar</p>
                        <p>2. Klik tombol <strong>"Tambah Anggota"</strong> di pojok kanan atas</p>
                        <p>3. Isi formulir dengan data lengkap (nama, tanggal lahir, gender, dll)</p>
                        <p>4. Pilih <strong>Ayah</strong> dan <strong>Ibu</strong> dari dropdown untuk menghubungkan dengan pohon keluarga</p>
                        <p>5. Pilih <strong>Cabang Keluarga</strong> yang sesuai</p>
                        <p>6. Klik tombol <strong>"Simpan"</strong></p>
                    </div>
                </details>

                <!-- FAQ 2 -->
                <details class="group border dark:border-gray-700 rounded-lg overflow-hidden">
                    <summary class="flex items-center justify-between cursor-pointer p-4 font-semibold bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <span>Bagaimana cara mengedit data anggota keluarga?</span>
                        <x-heroicon-o-chevron-down class="w-5 h-5 transition group-open:rotate-180" />
                    </summary>
                    <div class="p-4 space-y-2 text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-900">
                        <p>1. Buka menu <strong>"Anggota Keluarga"</strong></p>
                        <p>2. Cari anggota yang ingin diedit menggunakan pencarian atau filter</p>
                        <p>3. Klik ikon <strong>pensil (Edit)</strong> pada baris anggota tersebut</p>
                        <p>4. Ubah data yang diperlukan</p>
                        <p>5. Klik <strong>"Simpan"</strong> untuk menyimpan perubahan</p>
                    </div>
                </details>

                <!-- FAQ 3 -->
                <details class="group border dark:border-gray-700 rounded-lg overflow-hidden">
                    <summary class="flex items-center justify-between cursor-pointer p-4 font-semibold bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <span>Bagaimana cara membuat cabang keluarga baru?</span>
                        <x-heroicon-o-chevron-down class="w-5 h-5 transition group-open:rotate-180" />
                    </summary>
                    <div class="p-4 space-y-2 text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-900">
                        <p>1. Klik menu <strong>"Cabang Keluarga"</strong></p>
                        <p>2. Klik tombol <strong>"Tambah Cabang"</strong></p>
                        <p>3. Isi nama cabang (contoh: "Keturunan Anak Pertama")</p>
                        <p>4. Masukkan nama pendiri cabang</p>
                        <p>5. Pilih warna untuk identifikasi cabang di pohon keluarga</p>
                        <p>6. Klik <strong>"Simpan"</strong></p>
                    </div>
                </details>

                <!-- FAQ 4 -->
                <details class="group border dark:border-gray-700 rounded-lg overflow-hidden">
                    <summary class="flex items-center justify-between cursor-pointer p-4 font-semibold bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <span>Bagaimana cara upload foto ke galeri?</span>
                        <x-heroicon-o-chevron-down class="w-5 h-5 transition group-open:rotate-180" />
                    </summary>
                    <div class="p-4 space-y-2 text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-900">
                            <p>1. Klik menu <strong>"Foto Keluarga"</strong></p>
                            <p>2. Klik tombol <strong>"Tambah Foto"</strong></p>
                            <p>3. Isi judul foto (contoh: "Halal Bihalal Idul Fitri 2024")</p>
                            <p>4. Upload file gambar (JPG, PNG, max 2MB)</p>
                            <p>5. Isi tanggal foto diambil dan lokasi (opsional)</p>
                            <p>6. Pilih cabang keluarga yang terkait</p>
                            <p>7. Tambahkan deskripsi jika diperlukan</p>
                            <p>8. Klik <strong>"Simpan"</strong></p>
                    </div>
                </details>

                <!-- FAQ 5 -->
                <details class="group border dark:border-gray-700 rounded-lg overflow-hidden">
                    <summary class="flex items-center justify-between cursor-pointer p-4 font-semibold bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <span>Bagaimana cara menyetujui/menolak anggota baru?</span>
                        <x-heroicon-o-chevron-down class="w-5 h-5 transition group-open:rotate-180" />
                    </summary>
                    <div class="p-4 space-y-2 text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-900">
                            <p>1. Buka menu <strong>"Anggota Keluarga"</strong></p>
                            <p>2. Gunakan filter <strong>"Status"</strong> dan pilih <strong>"Pending"</strong></p>
                            <p>3. Review data anggota yang pending</p>
                            <p>4. Klik ikon <strong>Edit</strong> pada anggota tersebut</p>
                            <p>5. Ubah status menjadi <strong>"Disetujui"</strong> atau <strong>"Ditolak"</strong></p>
                            <p>6. Klik <strong>"Simpan"</strong></p>
                            <p class="text-xs italic mt-2">Note: Hanya anggota berstatus "Disetujui" yang muncul di pohon keluarga publik</p>
                    </div>
                </details>

                <!-- FAQ 6 -->
                <details class="group border dark:border-gray-700 rounded-lg overflow-hidden">
                    <summary class="flex items-center justify-between cursor-pointer p-4 font-semibold bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <span>Bagaimana cara menambahkan admin baru?</span>
                        <x-heroicon-o-chevron-down class="w-5 h-5 transition group-open:rotate-180" />
                    </summary>
                    <div class="p-4 space-y-2 text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-900">
                            <p>1. Klik menu <strong>"Pengguna"</strong> (hanya untuk Super Admin)</p>
                            <p>2. Klik tombol <strong>"Tambah Pengguna"</strong></p>
                            <p>3. Isi nama, email, dan password</p>
                            <p>4. Pilih role: <strong>Super Admin</strong> (akses penuh) atau <strong>Admin Keluarga</strong> (terbatas)</p>
                            <p>5. Klik <strong>"Simpan"</strong></p>
                            <p class="text-xs italic mt-2">Note: Super Admin bisa mengelola admin lain, Admin Keluarga hanya mengelola data anggota</p>
                    </div>
                </details>

                <!-- FAQ 7 -->
                <details class="group border dark:border-gray-700 rounded-lg overflow-hidden">
                    <summary class="flex items-center justify-between cursor-pointer p-4 font-semibold bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <span>Bagaimana cara mengatur privasi data anggota?</span>
                        <x-heroicon-o-chevron-down class="w-5 h-5 transition group-open:rotate-180" />
                    </summary>
                    <div class="p-4 space-y-2 text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-900">
                            <p>1. Edit data anggota keluarga yang ingin diatur privasinya</p>
                            <p>2. Ubah field <strong>"Visibility"</strong>:</p>
                            <ul class="list-disc list-inside ml-4">
                                <li><strong>Public:</strong> Tampil di website untuk semua orang</li>
                                <li><strong>Private:</strong> Hanya bisa dilihat oleh admin</li>
                            </ul>
                            <p>3. Klik <strong>"Simpan"</strong></p>
                            <p class="text-xs italic mt-2">Note: Data pribadi seperti email dan telepon tidak pernah ditampilkan di halaman publik</p>
                    </div>
                </details>
            </div>
        </x-filament::section>

        <!-- Tips Section -->
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center">
                    <x-heroicon-o-light-bulb class="w-6 h-6 mr-2 text-success-600" />
                    Tips & Best Practices
                </div>
            </x-slot>

            <ul class="space-y-3">
                <li class="flex items-start">
                    <x-heroicon-o-check-circle class="w-5 h-5 mr-3 text-success-600 flex-shrink-0 mt-0.5" />
                    <span>Selalu verifikasi data sebelum menyetujui anggota baru untuk menjaga akurasi silsilah</span>
                </li>
                <li class="flex items-start">
                    <x-heroicon-o-check-circle class="w-5 h-5 mr-3 text-success-600 flex-shrink-0 mt-0.5" />
                    <span>Backup data secara berkala untuk mencegah kehilangan data penting</span>
                </li>
                <li class="flex items-start">
                    <x-heroicon-o-check-circle class="w-5 h-5 mr-3 text-success-600 flex-shrink-0 mt-0.5" />
                    <span>Gunakan foto berkualitas baik (min 800x600px) untuk galeri agar terlihat profesional</span>
                </li>
                <li class="flex items-start">
                    <x-heroicon-o-check-circle class="w-5 h-5 mr-3 text-success-600 flex-shrink-0 mt-0.5" />
                    <span>Perbarui pohon keluarga secara rutin ketika ada kelahiran atau pernikahan baru</span>
                </li>
                <li class="flex items-start">
                    <x-heroicon-o-check-circle class="w-5 h-5 mr-3 text-success-600 flex-shrink-0 mt-0.5" />
                    <span>Jangan bagikan kredensial login admin kepada orang yang tidak berwenang</span>
                </li>
            </ul>
        </x-filament::section>

        <!-- Contact Support -->
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center">
                    <x-heroicon-o-envelope class="w-6 h-6 mr-2 text-primary-600" />
                    Butuh Bantuan Lebih Lanjut?
                </div>
            </x-slot>

            <p class="text-gray-600 dark:text-gray-400 mb-6">Jika Anda mengalami kendala atau memiliki pertanyaan yang tidak terjawab di FAQ ini, silakan hubungi Developer:</p>
            
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-4 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center">
                        <x-heroicon-o-envelope class="w-5 h-5 text-primary-600 dark:text-primary-400" />
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Email Developer</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">fikrihaikal170308@gmail.com</p>
                    </div>
                </div>
                
                <x-filament::button 
                    href="mailto:fikrihaikal170308@gmail.com" 
                    tag="a"
                    icon="heroicon-o-paper-airplane"
                    color="primary"
                    class="flex-shrink-0"
                >
                    Kirim Email
                </x-filament::button>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
