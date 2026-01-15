@extends('layouts.public')

@section('title', 'Tentang Kami - Silsilah Keluarga KWS')

@section('content')
<!-- Hero Section -->
<div class="hero-pattern text-white py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">
            <i class="fas fa-heart mr-3"></i>
            Tentang Keluarga Kami
        </h1>
        <p class="text-xl text-blue-100">
            Menjaga dan melestarikan warisan keluarga untuk generasi mendatang
        </p>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <!-- Vision & Mission -->
    <div class="grid md:grid-cols-2 gap-8 mb-16">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                <i class="fas fa-eye text-blue-700 text-2xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Visi Kami</h2>
            <p class="text-gray-600 leading-relaxed">
                Menjadi pusat dokumentasi keluarga yang komprehensif dan akurat, membantu setiap anggota keluarga 
                memahami akar dan sejarah keluarga mereka dengan mudah dan modern.
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-6">
                <i class="fas fa-bullseye text-green-700 text-2xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Misi Kami</h2>
            <ul class="text-gray-600 space-y-2">
                <li class="flex items-start">
                    <i class="fas fa-check text-green-600 mr-2 mt-1"></i>
                    <span>Mendokumentasikan sejarah dan silsilah keluarga secara digital</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check text-green-600 mr-2 mt-1"></i>
                    <span>Memudahkan akses informasi keluarga untuk semua generasi</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check text-green-600 mr-2 mt-1"></i>
                    <span>Menjaga dan melestarikan nilai-nilai keluarga</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- About Section -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-8 md:p-12 mb-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">Sejarah Keluarga KWS</h2>
        <div class="prose prose-lg max-w-none text-gray-700">
            <p class="mb-4">
                Keluarga KWS memiliki sejarah panjang yang dimulai dari generasi pertama yang menjadi leluhur kami. 
                Dengan semangat kebersamaan dan gotong royong, keluarga ini terus berkembang dan menjaga tradisi 
                serta nilai-nilai luhur yang diwariskan dari generasi ke generasi.
            </p>
            <p class="mb-4">
                Website Silsilah Keluarga KWS dibuat untuk mendokumentasikan dan melestarikan sejarah keluarga kami. 
                Melalui platform ini, setiap anggota keluarga dapat melihat hubungan kekeluargaan, mengetahui leluhur, 
                dan memahami posisi mereka dalam pohon keluarga.
            </p>
            <p>
                Kami percaya bahwa dengan mengetahui akar dan sejarah keluarga, akan tercipta ikatan yang lebih kuat 
                antar generasi dan rasa bangga terhadap identitas keluarga kita.
            </p>
        </div>
    </div>

    <!-- Values -->
    <div class="mb-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Nilai-Nilai Keluarga</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-hands-helping text-yellow-700 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Kebersamaan</h3>
                <p class="text-gray-600">
                    Menjaga hubungan erat antar anggota keluarga dengan saling mendukung dan membantu
                </p>
            </div>

            <div class="text-center">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-book-open text-blue-700 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Pendidikan</h3>
                <p class="text-gray-600">
                    Mengutamakan pendidikan sebagai kunci kesuksesan dan kemajuan keluarga
                </p>
            </div>

            <div class="text-center">
                <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-praying-hands text-purple-700 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Spiritualitas</h3>
                <p class="text-gray-600">
                    Menjunjung tinggi nilai-nilai agama dan spiritual dalam kehidupan sehari-hari
                </p>
            </div>

            <div class="text-center">
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-heart text-red-700 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Kasih Sayang</h3>
                <p class="text-gray-600">
                    Menumbuhkan rasa cinta dan kasih sayang dalam setiap interaksi keluarga
                </p>
            </div>

            <div class="text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-balance-scale text-green-700 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Integritas</h3>
                <p class="text-gray-600">
                    Menjaga kejujuran dan integritas dalam setiap aspek kehidupan
                </p>
            </div>

            <div class="text-center">
                <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-indigo-700 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Kekeluargaan</h3>
                <p class="text-gray-600">
                    Mempertahankan tradisi dan budaya keluarga untuk generasi mendatang
                </p>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="bg-gradient-to-r from-blue-700 to-indigo-700 rounded-lg p-8 md:p-12 text-white">
        <h2 class="text-3xl font-bold mb-8 text-center">Keluarga Kami dalam Angka</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-5xl font-bold mb-2">100+</div>
                <div class="text-blue-100">Anggota Keluarga</div>
            </div>
            <div class="text-center">
                <div class="text-5xl font-bold mb-2">5+</div>
                <div class="text-blue-100">Generasi</div>
            </div>
            <div class="text-center">
                <div class="text-5xl font-bold mb-2">10+</div>
                <div class="text-blue-100">Cabang Keluarga</div>
            </div>
            <div class="text-center">
                <div class="text-5xl font-bold mb-2">50+</div>
                <div class="text-blue-100">Tahun Sejarah</div>
            </div>
        </div>
    </div>

    <!-- Contact -->
    <div class="mt-16 bg-white rounded-lg shadow-lg p-8 md:p-12">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Hubungi Kami</h2>
            <p class="text-gray-600 mb-8">
                Ada pertanyaan atau ingin berkontribusi dalam dokumentasi keluarga? 
                Jangan ragu untuk menghubungi kami.
            </p>
            <div class="grid md:grid-cols-3 gap-6 text-left">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-envelope text-blue-700"></i>
                        </div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900">Email</div>
                        <div class="text-gray-600 text-sm">info@silsilahkws.com</div>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-phone text-green-700"></i>
                        </div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900">Telepon</div>
                        <div class="text-gray-600 text-sm">+62 xxx xxxx xxxx</div>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-purple-700"></i>
                        </div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900">Alamat</div>
                        <div class="text-gray-600 text-sm">Indonesia</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
