@extends('layouts.public')

@section('title', 'Kebijakan Privasi - Silsilah Keluarga KWS')

@section('content')
<!-- Hero Section -->
<div class="hero-pattern py-32 pt-40">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-white/10 rounded-2xl mb-6 backdrop-blur-sm">
            <i class="fas fa-shield-alt text-white text-4xl"></i>
        </div>
        <h1 class="text-5xl font-bold text-white mb-4">Kebijakan Privasi</h1>
        <p class="text-xl text-blue-100">
            Komitmen kami untuk melindungi data dan privasi Anda
        </p>
    </div>
</div>

<!-- Content Section -->
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12">
        <!-- Last Updated -->
        <div class="bg-blue-50 border-l-4 border-blue-600 p-4 mb-8 rounded-r-lg">
            <p class="text-sm text-blue-800">
                <i class="fas fa-info-circle mr-2"></i>
                <strong>Terakhir diperbarui:</strong> {{ date('d F Y') }}
            </p>
        </div>

        <!-- Introduction -->
        <div class="mb-10">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                <span class="bg-blue-600 w-1.5 h-8 rounded-full mr-3"></span>
                Pendahuluan
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
                Selamat datang di Silsilah Keluarga KWS - website dokumentasi keluarga kami. Saya, sebagai pengelola 
                website keluarga ini, sangat menghargai kepercayaan yang anggota keluarga berikan dengan membagikan 
                informasi pribadi mereka. Kebijakan Privasi ini menjelaskan bagaimana saya mengumpulkan, menggunakan, 
                melindungi, dan membagikan informasi keluarga kita.
            </p>
            <p class="text-gray-700 leading-relaxed">
                Website ini dibuat khusus untuk keluarga kita sendiri, bertujuan mendokumentasikan dan menjaga warisan 
                keluarga. Dengan menggunakan website ini, Anda menyetujui pengumpulan dan penggunaan informasi sesuai 
                dengan kebijakan ini. Harap baca kebijakan ini dengan seksama.
            </p>
        </div>

        <!-- Data Collection -->
        <div class="mb-10">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                <span class="bg-blue-600 w-1.5 h-8 rounded-full mr-3"></span>
                Informasi yang Dikumpulkan
            </h2>
            <div class="space-y-4">
                <div class="bg-gray-50 p-5 rounded-xl">
                    <h3 class="font-semibold text-gray-900 mb-2 flex items-center">
                        <i class="fas fa-user text-blue-600 mr-2"></i>
                        Informasi Anggota Keluarga
                    </h3>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        Nama lengkap, nama panggilan, tanggal lahir, tempat lahir, jenis kelamin, alamat, nomor telepon, 
                        email, dan foto anggota keluarga yang diberikan saat pendaftaran atau pembaruan profil oleh admin keluarga.
                    </p>
                </div>
                <div class="bg-gray-50 p-5 rounded-xl">
                    <h3 class="font-semibold text-gray-900 mb-2 flex items-center">
                        <i class="fas fa-network-wired text-blue-600 mr-2"></i>
                        Informasi Hubungan Keluarga
                    </h3>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        Data tentang hubungan keluarga seperti informasi orang tua, pasangan, anak-anak, dan cabang keluarga 
                        yang membantu membangun pohon keluarga kita dengan akurat dan lengkap.
                    </p>
                </div>
                <div class="bg-gray-50 p-5 rounded-xl">
                    <h3 class="font-semibold text-gray-900 mb-2 flex items-center">
                        <i class="fas fa-chart-line text-blue-600 mr-2"></i>
                        Data Penggunaan Website
                    </h3>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        Informasi teknis tentang bagaimana anggota keluarga mengakses website ini, termasuk alamat IP, 
                        jenis browser, halaman yang dikunjungi, dan waktu akses untuk keperluan pemeliharaan dan keamanan.
                    </p>
                </div>
            </div>
        </div>

        <!-- Data Usage -->
        <div class="mb-10">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                <span class="bg-blue-600 w-1.5 h-8 rounded-full mr-3"></span>
                Bagaimana Informasi Digunakan
            </h2>
            <ul class="space-y-3">
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                    <span class="text-gray-700">Membuat dan memelihara dokumentasi pohon keluarga yang akurat untuk generasi sekarang dan mendatang</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                    <span class="text-gray-700">Menyediakan dan meningkatkan fitur website keluarga ini</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                    <span class="text-gray-700">Berkomunikasi dengan anggota keluarga tentang pembaruan dan informasi penting</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                    <span class="text-gray-700">Melindungi keamanan dan integritas data keluarga kita</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                    <span class="text-gray-700">Mematuhi kewajiban hukum dan peraturan yang berlaku</span>
                </li>
            </ul>
        </div>

        <!-- Data Security -->
        <div class="mb-10">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                <span class="bg-blue-600 w-1.5 h-8 rounded-full mr-3"></span>
                Keamanan Data Keluarga
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
                Sebagai pengelola website keluarga ini, saya berkomitmen penuh untuk melindungi data keluarga kita. 
                Berikut adalah langkah-langkah keamanan yang diterapkan:
            </p>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="border border-gray-200 rounded-lg p-4">
                    <i class="fas fa-lock text-blue-600 text-2xl mb-2"></i>
                    <h3 class="font-semibold text-gray-900 mb-1">Enkripsi SSL/TLS</h3>
                    <p class="text-sm text-gray-600">Data ditransfer dengan enkripsi yang aman</p>
                </div>
                <div class="border border-gray-200 rounded-lg p-4">
                    <i class="fas fa-database text-blue-600 text-2xl mb-2"></i>
                    <h3 class="font-semibold text-gray-900 mb-1">Database Terenkripsi</h3>
                    <p class="text-sm text-gray-600">Informasi disimpan dengan proteksi tingkat tinggi</p>
                </div>
                <div class="border border-gray-200 rounded-lg p-4">
                    <i class="fas fa-user-shield text-blue-600 text-2xl mb-2"></i>
                    <h3 class="font-semibold text-gray-900 mb-1">Kontrol Akses</h3>
                    <p class="text-sm text-gray-600">Hanya admin terverifikasi yang dapat mengakses</p>
                </div>
                <div class="border border-gray-200 rounded-lg p-4">
                    <i class="fas fa-history text-blue-600 text-2xl mb-2"></i>
                    <h3 class="font-semibold text-gray-900 mb-1">Audit Trail</h3>
                    <p class="text-sm text-gray-600">Semua perubahan data tercatat dan terlacak</p>
                </div>
            </div>
        </div>

        <!-- Data Sharing -->
        <div class="mb-10">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                <span class="bg-blue-600 w-1.5 h-8 rounded-full mr-3"></span>
                Pembagian Informasi Keluarga
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
                Website ini adalah untuk keluarga kita sendiri. Saya tidak akan menjual, menyewakan, atau membagikan 
                informasi keluarga kepada pihak ketiga manapun tanpa persetujuan dari anggota keluarga, kecuali dalam 
                kondisi berikut:
            </p>
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mr-2 mt-1"></i>
                        <span>Untuk mematuhi hukum, regulasi, atau proses hukum yang berlaku</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mr-2 mt-1"></i>
                        <span>Untuk melindungi hak, properti, atau keselamatan keluarga kita</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mr-2 mt-1"></i>
                        <span>Dengan persetujuan eksplisit dari anggota keluarga yang bersangkutan</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- User Rights -->
        <div class="mb-10">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                <span class="bg-blue-600 w-1.5 h-8 rounded-full mr-3"></span>
                Hak Anda
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
                Anda memiliki hak untuk:
            </p>
            <div class="grid gap-3">
                <div class="flex items-start bg-blue-50 p-4 rounded-lg">
                    <i class="fas fa-eye text-blue-600 mr-3 mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Akses Data</h3>
                        <p class="text-sm text-gray-700">Meminta salinan informasi pribadi yang kami simpan tentang Anda</p>
                    </div>
                </div>
                <div class="flex items-start bg-blue-50 p-4 rounded-lg">
                    <i class="fas fa-edit text-blue-600 mr-3 mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Koreksi Data</h3>
                        <p class="text-sm text-gray-700">Memperbarui atau memperbaiki informasi yang tidak akurat</p>
                    </div>
                </div>
                <div class="flex items-start bg-blue-50 p-4 rounded-lg">
                    <i class="fas fa-trash text-blue-600 mr-3 mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Penghapusan Data</h3>
                        <p class="text-sm text-gray-700">Meminta penghapusan informasi pribadi Anda dari sistem kami</p>
                    </div>
                </div>
                <div class="flex items-start bg-blue-50 p-4 rounded-lg">
                    <i class="fas fa-ban text-blue-600 mr-3 mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Pembatasan Pemrosesan</h3>
                        <p class="text-sm text-gray-700">Membatasi cara kami memproses data pribadi Anda</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cookies -->
        <div class="mb-10">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                <span class="bg-blue-600 w-1.5 h-8 rounded-full mr-3"></span>
                Cookies dan Teknologi Pelacakan
            </h2>
            <p class="text-gray-700 leading-relaxed mb-4">
                Kami menggunakan cookies dan teknologi serupa untuk meningkatkan pengalaman Anda di situs web kami. 
                Cookies membantu kami:
            </p>
            <ul class="space-y-2 text-gray-700">
                <li class="flex items-start">
                    <i class="fas fa-cookie-bite text-blue-600 mr-3 mt-1"></i>
                    <span>Mengingat preferensi dan pengaturan Anda</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-cookie-bite text-blue-600 mr-3 mt-1"></i>
                    <span>Memahami bagaimana Anda berinteraksi dengan layanan kami</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-cookie-bite text-blue-600 mr-3 mt-1"></i>
                    <span>Menyediakan fitur keamanan dan mencegah penipuan</span>
                </li>
            </ul>
            <p class="text-gray-700 leading-relaxed mt-4 text-sm">
                Anda dapat mengatur browser Anda untuk menolak cookies, namun ini mungkin mempengaruhi fungsionalitas situs.
            </p>
        </div>

        <!-- Children Privacy -->
        <div class="mb-10">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                <span class="bg-blue-600 w-1.5 h-8 rounded-full mr-3"></span>
                Privasi Anak-anak
            </h2>
            <p class="text-gray-700 leading-relaxed">
                Layanan kami tidak ditujukan untuk anak-anak di bawah usia 13 tahun tanpa persetujuan orang tua atau wali. 
                Kami tidak secara sengaja mengumpulkan informasi pribadi dari anak-anak di bawah 13 tahun. Jika Anda adalah 
                orang tua atau wali dan mengetahui bahwa anak Anda telah memberikan informasi pribadi kepada kami, 
                harap hubungi kami agar kami dapat mengambil tindakan yang diperlukan.
            </p>
        </div>

        <!-- Policy Changes -->
        <div class="mb-10">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                <span class="bg-blue-600 w-1.5 h-8 rounded-full mr-3"></span>
                Perubahan Kebijakan
            </h2>
            <p class="text-gray-700 leading-relaxed">
                Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu untuk mencerminkan perubahan dalam praktik 
                kami atau karena alasan operasional, hukum, atau regulasi lainnya. Kami akan memberitahu Anda tentang 
                perubahan signifikan dengan memposting pemberitahuan di situs web kami atau mengirimkan email kepada Anda. 
                Tanggal "Terakhir diperbarui" di bagian atas halaman ini menunjukkan kapan kebijakan ini terakhir direvisi.
            </p>
        </div>

        <!-- Contact -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl p-8 text-white">
            <h2 class="text-2xl font-bold mb-4 flex items-center">
                <i class="fas fa-envelope text-3xl mr-3"></i>
                Hubungi Saya
            </h2>
            <p class="mb-6 text-blue-100 leading-relaxed">
                Jika Anda memiliki pertanyaan, kekhawatiran, atau permintaan terkait Kebijakan Privasi ini atau 
                bagaimana data keluarga kita dikelola, silakan hubungi saya sebagai pengelola website keluarga:
            </p>
            <div class="space-y-3">
                <div class="flex items-center">
                    <i class="fas fa-envelope-open-text mr-3 text-blue-200"></i>
                    <span>Email: <a href="mailto:privacy@silsilahkws.com" class="font-semibold hover:underline">privacy@silsilahkws.com</a></span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-phone-alt mr-3 text-blue-200"></i>
                    <span>Telepon: +62 xxx xxxx xxxx</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-map-marker-alt mr-3 text-blue-200"></i>
                    <span>Indonesia</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Back to Home -->
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    <div class="text-center">
        <a href="{{ route('home') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
