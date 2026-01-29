@extends('layouts.public')

@section('title', 'Tentang Kami - Silsilah Keluarga KWS')

@section('content')
<!-- Hero Section -->
<div class="hero-pattern text-white py-32 pt-40 relative">
    <!-- Floating Icons Background -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="floating-icon absolute top-20 left-10 opacity-20">
            <i class="fas fa-heart text-6xl"></i>
        </div>
        <div class="floating-icon absolute top-40 right-20 opacity-20" style="animation-delay: 1s">
            <i class="fas fa-hands-helping text-5xl"></i>
        </div>
        <div class="floating-icon absolute bottom-20 left-1/4 opacity-20" style="animation-delay: 2s">
            <i class="fas fa-book-open text-4xl"></i>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                Tentang Keluarga Kami
            </h1>
            <p class="text-lg text-blue-100 mb-8 leading-relaxed max-w-3xl mx-auto">
                Menjaga dan melestarikan warisan keluarga untuk generasi mendatang.<br>
                Mengenal lebih dalam tentang visi, misi, dan nilai-nilai Kumpulan Wargi Sukapura.
            </p>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <!-- Vision & Mission -->
    <div class="grid md:grid-cols-2 gap-6 mb-16">
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-transparent hover:border-blue-500 group">
            <div class="p-8">
                <div class="flex items-center mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center mr-4 shadow-lg group-hover:scale-110 transition-transform">
                        <i class="fas fa-eye text-white text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Visi Kami</h2>
                </div>
                <p class="text-gray-600 leading-relaxed">
                    Menjadi pusat dokumentasi keluarga yang komprehensif dan akurat, membantu setiap anggota keluarga 
                    memahami akar dan sejarah keluarga mereka dengan mudah dan modern.
                </p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-transparent hover:border-green-500 group">
            <div class="p-8">
                <div class="flex items-center mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-600 to-green-700 rounded-xl flex items-center justify-center mr-4 shadow-lg group-hover:scale-110 transition-transform">
                        <i class="fas fa-bullseye text-white text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Misi Kami</h2>
                </div>
                <ul class="text-gray-600 space-y-3">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-3 mt-1 flex-shrink-0"></i>
                        <span>Mendokumentasikan sejarah dan silsilah keluarga secara digital</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-3 mt-1 flex-shrink-0"></i>
                        <span>Memudahkan akses informasi keluarga untuk semua generasi</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-3 mt-1 flex-shrink-0"></i>
                        <span>Menjaga dan melestarikan nilai-nilai keluarga</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 rounded-2xl p-8 md:p-12 mb-16 shadow-lg border border-blue-100">
        <div class="flex items-center justify-center mb-6">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                <i class="fas fa-book-open text-white text-xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">Sejarah Keluarga KWS</h2>
        </div>
        <div class="prose prose-lg max-w-none text-gray-700">
            <p class="mb-4">
                <strong>KWS</strong> merupakan singkatan dari <strong>"Kumpulan Wargi Sukapura"</strong>, yang berarti 
                kumpulan keluarga besar dari Sukapura. Keluarga KWS memiliki sejarah panjang yang dimulai dari generasi 
                pertama yang menjadi leluhur kami. Dengan semangat kebersamaan dan gotong royong, keluarga ini terus 
                berkembang dan menjaga tradisi serta nilai-nilai luhur yang diwariskan dari generasi ke generasi.
            </p>
            <p class="mb-4">
                Website Silsilah Keluarga KWS dibuat untuk mendokumentasikan dan melestarikan sejarah keluarga kami. 
                Melalui platform ini, setiap anggota keluarga dapat melihat hubungan kekeluargaan, mengetahui leluhur, 
                dan memahami posisi mereka dalam pohon keluarga.
            </p>
            <p>
                Kami percaya bahwa dengan mengetahui akar dan sejarah keluarga, akan tercipta ikatan yang lebih kuat 
                antar generasi dan rasa bangga terhadap identitas keluarga kita sebagai Wargi Sukapura.
            </p>
        </div>
    </div>

    <!-- Values -->
    <div class="mb-16">
        <div class="flex items-center justify-center mb-8">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-purple-700 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                <i class="fas fa-star text-white text-xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">Nilai-Nilai Keluarga</h2>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-yellow-400">
                <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-md">
                    <i class="fas fa-hands-helping text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Kebersamaan</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Menjaga hubungan erat antar anggota keluarga dengan saling mendukung dan membantu
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 text-center hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-blue-400">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-md">
                    <i class="fas fa-book-open text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Pendidikan</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Mengutamakan pendidikan sebagai kunci kesuksesan dan kemajuan keluarga
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 text-center hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-purple-400">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-md">
                    <i class="fas fa-praying-hands text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Spiritualitas</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Menjunjung tinggi nilai-nilai agama dan spiritual dalam kehidupan sehari-hari
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 text-center hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-red-400">
                <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-md">
                    <i class="fas fa-heart text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Kasih Sayang</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Menumbuhkan rasa cinta dan kasih sayang dalam setiap interaksi keluarga
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 text-center hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-green-400">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-md">
                    <i class="fas fa-balance-scale text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Integritas</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Menjaga kejujuran dan integritas dalam setiap aspek kehidupan
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 text-center hover:shadow-xl transition-all duration-300 border-2 border-transparent hover:border-indigo-400">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-md">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Kekeluargaan</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Mempertahankan tradisi dan budaya keluarga untuk generasi mendatang
                </p>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700 rounded-2xl p-8 md:p-12 text-white shadow-2xl">
        <div class="flex items-center justify-center mb-8">
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3">
                <i class="fas fa-chart-bar text-white text-xl"></i>
            </div>
            <h2 class="text-3xl font-bold">Keluarga Kami dalam Angka</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-6 hover:bg-opacity-20 transition">
                <div class="text-5xl font-bold mb-2">100+</div>
                <div class="text-blue-100 text-sm">Anggota Keluarga</div>
            </div>
            <div class="text-center bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-6 hover:bg-opacity-20 transition">
                <div class="text-5xl font-bold mb-2">5+</div>
                <div class="text-blue-100 text-sm">Generasi</div>
            </div>
            <div class="text-center bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-6 hover:bg-opacity-20 transition">
                <div class="text-5xl font-bold mb-2">10+</div>
                <div class="text-blue-100 text-sm">Cabang Keluarga</div>
            </div>
            <div class="text-center bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-6 hover:bg-opacity-20 transition">
                <div class="text-5xl font-bold mb-2">50+</div>
                <div class="text-blue-100 text-sm">Tahun Sejarah</div>
            </div>
        </div>
    </div>

    <!-- Contact -->
    <div class="mt-16 bg-white rounded-2xl shadow-2xl p-8 md:p-12 border-2 border-gray-100">
        <div class="max-w-3xl mx-auto text-center">
            <div class="flex items-center justify-center mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                    <i class="fas fa-envelope text-white text-xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">Hubungi Kami</h2>
            </div>
            <p class="text-gray-600 mb-8">
                Ada pertanyaan atau ingin berkontribusi dalam dokumentasi keluarga? 
                Jangan ragu untuk menghubungi kami.
            </p>
            <div class="grid md:grid-cols-3 gap-6 text-left">
                <div class="bg-gray-50 rounded-xl p-6 hover:bg-gray-100 transition">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center shadow-md">
                                <i class="fas fa-envelope text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900 mb-1">Email</div>
                            <div class="text-gray-600 text-sm">info@silsilahkws.com</div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-6 hover:bg-gray-100 transition">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-600 to-green-700 rounded-xl flex items-center justify-center shadow-md">
                                <i class="fas fa-phone text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900 mb-1">Telepon</div>
                            <div class="text-gray-600 text-sm">+62 xxx xxxx xxxx</div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-6 hover:bg-gray-100 transition">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-purple-700 rounded-xl flex items-center justify-center shadow-md">
                                <i class="fas fa-map-marker-alt text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900 mb-1">Alamat</div>
                            <div class="text-gray-600 text-sm">Sukapura, Indonesia</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
