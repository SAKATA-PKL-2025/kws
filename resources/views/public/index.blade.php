@extends('layouts.public')

@section('title', 'Pohon Keluarga - Silsilah Keluarga KWS')

@push('styles')
<style>
    .tree-container {
        min-height: 600px;
        background: white;
        border-radius: 12px;
        padding: 40px 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow-x: auto;
        overflow-y: visible;
    }
    
    .tree-node {
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        position: relative;
    }
    
    .tree-children {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        gap: 30px;
        margin-top: 60px;
        position: relative;
    }
    
    /* Connection lines */
    .tree-children::before {
        content: '';
        position: absolute;
        top: -30px;
        left: 50%;
        width: 2px;
        height: 30px;
        background: #93c5fd;
        transform: translateX(-50%);
    }
    
    .tree-children::after {
        content: '';
        position: absolute;
        top: -30px;
        height: 2px;
        background: #93c5fd;
        left: 0;
        right: 0;
    }
    
    /* Hide horizontal line for single child */
    .tree-children:has(> *:only-child)::after {
        display: none;
    }
    
    .branch-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin: 2px;
    }
    
    .member-card {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 12px;
        text-align: center;
        width: 160px;
        min-height: 90px;
        transition: all 0.3s;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        justify-content: center;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    
    .member-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        border-color: #3b82f6;
    }
    
    .member-card.highlighted {
        animation: pulse-highlight 0.6s ease-in-out 5;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.5), 0 8px 20px rgba(59, 130, 246, 0.3);
        border-color: #3b82f6 !important;
        transform: scale(1.05);
    }
    
    @keyframes pulse-highlight {
        0%, 100% {
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.5), 0 8px 20px rgba(59, 130, 246, 0.3);
        }
        50% {
            box-shadow: 0 0 0 8px rgba(59, 130, 246, 0.3), 0 8px 25px rgba(59, 130, 246, 0.4);
        }
    }

    .tree-node {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    .tree-children {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding-top: 30px;
        position: relative;
    }
    
    /* Garis vertikal dari parent ke garis horizontal */
    .tree-children::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        width: 2px;
        height: 15px;
        background-color: #93c5fd;
    }
    
    /* Setiap child node */
    .tree-children > .tree-node {
        position: relative;
        padding: 0 15px;
    }
    
    /* Garis vertikal dari garis horizontal ke child */
    .tree-children > .tree-node::before {
        content: '';
        position: absolute;
        top: -15px;
        left: 50%;
        width: 2px;
        height: 15px;
        background-color: #93c5fd;
        transform: translateX(-50%);
    }
    
    /* Garis horizontal ke kanan (untuk semua kecuali child terakhir) */
    .tree-children > .tree-node:not(:last-child)::after {
        content: '';
        position: absolute;
        top: -15px;
        left: 50%;
        width: calc(100% + 30px);
        height: 2px;
        background-color: #93c5fd;
    }
    
    /* Untuk single child - sembunyikan garis horizontal, perpanjang vertikal */
    .tree-children > .tree-node:only-child::before {
        top: -30px;
        height: 30px;
    }
    
    .tree-children > .tree-node:only-child::after {
        display: none;
    }
    
    /* Sembunyikan garis vertikal dari parent jika hanya 1 anak */
    .tree-children:has(> .tree-node:only-child)::before {
        display: none;
    }
    
    .generation-label {
        background: #3b82f6;
        color: white;
        padding: 8px 20px;
        border-radius: 20px;
        font-weight: 700;
        display: inline-block;
        margin-bottom: 24px;
        font-size: 14px;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-pattern text-white py-32 pt-40 relative">
    <!-- Floating Icons Background -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="floating-icon absolute top-20 left-10 opacity-20">
            <i class="fas fa-users text-6xl"></i>
        </div>
        <div class="floating-icon absolute top-40 right-20 opacity-20" style="animation-delay: 1s">
            <i class="fas fa-heart text-5xl"></i>
        </div>
        <div class="floating-icon absolute bottom-20 left-1/4 opacity-20" style="animation-delay: 2s">
            <i class="fas fa-book text-4xl"></i>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="text-left">
                <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                    Jelajahi Silsilah,<br>
                    <span class="text-blue-200">Kenali Akar</span>
                </h1>
                <p class="text-lg text-blue-100 mb-8 leading-relaxed">
                    Selamat datang di Silsilah Keluarga KWS. Temukan sejarah, warisan, dan ikatan keluarga yang menghubungkan generasi. 
                    Setiap cabang menceritakan kisah, setiap anggota memiliki tempat dalam pohon keluarga kita.
                </p>
                
                <div class="flex flex-wrap gap-4 mb-8">
                    <a href="#family-tree" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 px-8 py-4 rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl transition-all duration-300 flex items-center">
                        <i class="fas fa-arrow-down mr-2"></i>
                        Lihat Pohon Keluarga
                    </a>
                </div>
                
                <div class="flex items-start space-x-6 text-sm">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-400 mr-2"></i>
                        <span>{{ $members->count() }}+ Anggota Keluarga</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-400 mr-2"></i>
                        <span>Diperbarui Berkala</span>
                    </div>
                </div>
            </div>

            <!-- Right Content - Decorative -->
            <div class="hidden md:flex justify-center items-center">
                <div class="relative">
                    <div class="w-80 h-80 bg-white bg-opacity-10 backdrop-blur-sm rounded-3xl flex items-center justify-center transform rotate-6 hover:rotate-0 transition-transform duration-500">
                        <i class="fas fa-sitemap text-white text-9xl opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Statistics Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-16">
            <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-6 hover:bg-opacity-20 transition">
                <div class="text-4xl font-bold mb-2">{{ $members->count() }}</div>
                <div class="text-sm text-blue-100">Anggota Keluarga</div>
            </div>
            <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-6 hover:bg-opacity-20 transition">
                <div class="text-4xl font-bold mb-2">{{ $members->max('generation') ?? 0 }}</div>
                <div class="text-sm text-blue-100">Generasi</div>
            </div>
            <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-6 hover:bg-opacity-20 transition">
                <div class="text-4xl font-bold mb-2">{{ $branches->count() }}</div>
                <div class="text-sm text-blue-100">Cabang Keluarga</div>
            </div>
            <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-6 hover:bg-opacity-20 transition">
                <div class="text-4xl font-bold mb-2">{{ $branches->sum('members_count') }}</div>
                <div class="text-sm text-blue-100">Total Anggota</div>
            </div>
        </div>
    </div>
</div>

<!-- Branches Section -->
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2 flex items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                <i class="fas fa-code-branch text-white text-xl"></i>
            </div>
            Cabang Keluarga
        </h2>
        <p class="text-gray-600 ml-15">Jelajahi setiap cabang keluarga dan lihat anggota di dalamnya</p>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($branches as $branch)
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-transparent hover:border-blue-500 group flex flex-col h-full">
                <!-- Content -->
                <div class="p-4 flex flex-col flex-grow">
                    <!-- Branch Icon & Name -->
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-3 group-hover:scale-110 transition-transform" 
                                 style="background-color: {{ $branch->color_code }}20;">
                                <i class="fas fa-sitemap text-xl" style="color: {{ $branch->color_code }};"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-base text-gray-900 leading-tight">{{ $branch->name }}</h3>
                                <p class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-user-circle mr-1"></i>{{ $branch->founder_name ?? 'Pendiri' }}
                                </p>
                            </div>
                        </div>
                        <span class="px-2 py-1 rounded-full text-xs font-semibold" 
                              style="background-color: {{ $branch->color_code }}20; color: {{ $branch->color_code }};">
                            Aktif
                        </span>
                    </div>

                    <!-- Statistics -->
                    <div class="grid grid-cols-3 gap-2 mb-3">
                        <div class="bg-gray-50 rounded-lg p-2 text-center">
                            <div class="text-xl font-bold text-gray-900">{{ $branch->members_count }}</div>
                            <div class="text-xs text-gray-600 mt-1">Anggota</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-2 text-center">
                            <div class="text-xl font-bold text-gray-900">
                                {{ $members->where('family_branch_id', $branch->id)->max('generation') ?? 0 }}
                            </div>
                            <div class="text-xs text-gray-600 mt-1">Generasi</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-2 text-center">
                            <div class="text-xl font-bold text-gray-900">
                                {{ $members->where('family_branch_id', $branch->id)->where('is_alive', true)->count() }}
                            </div>
                            <div class="text-xs text-gray-600 mt-1">Hidup</div>
                        </div>
                    </div>

                    <!-- Recent Members Preview -->
                    <div class="mb-4 flex-grow">
                        <div class="text-xs font-semibold text-gray-500 mb-2 flex items-center">
                            <i class="fas fa-users mr-1"></i>
                            Anggota Terbaru
                        </div>
                        <div class="flex -space-x-2 min-h-[2rem]">
                            @foreach($members->where('family_branch_id', $branch->id)->take(5) as $member)
                                <div class="w-8 h-8 rounded-full border-2 border-white bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white text-xs font-bold shadow-md"
                                     title="{{ $member->full_name }}">
                                    {{ strtoupper(substr($member->full_name, 0, 1)) }}
                                </div>
                            @endforeach
                            @if($branch->members_count > 5)
                                <div class="w-8 h-8 rounded-full border-2 border-white bg-gray-200 flex items-center justify-center text-gray-600 text-xs font-bold shadow-md">
                                    +{{ $branch->members_count - 5 }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Button -->
                    <button onclick="scrollToTree()" 
                            class="w-full py-2.5 rounded-lg font-semibold text-sm transition-all flex items-center justify-center group-hover:shadow-lg"
                            style="background-color: {{ $branch->color_code }}; color: white;">
                        <i class="fas fa-arrow-down mr-2"></i>
                        Lihat di Pohon Keluarga
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white rounded-2xl shadow-lg p-12 text-center">
                <i class="fas fa-code-branch text-gray-300 text-6xl mb-4"></i>
                <p class="text-gray-500 text-lg">Belum ada cabang keluarga yang aktif.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Family Tree Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16" id="family-tree">
    <div class="tree-container">
        <div class="text-center mb-8">
            <h2 class="text-4xl font-bold text-gray-900 mb-3">Pohon Silsilah Keluarga</h2>
            <p class="text-gray-600 text-lg">Klik pada anggota keluarga untuk melihat detail lengkap</p>
        </div>

        <!-- Cara Membaca Pohon Keluarga -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 mb-8 border border-blue-100">
            <div class="flex items-center mb-4">
                <div class="bg-blue-600 rounded-lg p-2 mr-3">
                    <i class="fas fa-book-open text-white"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Cara Membaca Pohon Keluarga</h3>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <div class="flex items-center mb-2">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-2">
                            <i class="fas fa-arrow-down text-blue-600 text-sm"></i>
                        </div>
                        <span class="font-semibold text-gray-800">Arah Baca</span>
                    </div>
                    <p class="text-sm text-gray-600">Baca dari <strong>atas ke bawah</strong>. Generasi tertua di atas, generasi muda di bawah.</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <div class="flex items-center mb-2">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-2">
                            <i class="fas fa-sitemap text-green-600 text-sm"></i>
                        </div>
                        <span class="font-semibold text-gray-800">Garis Penghubung</span>
                    </div>
                    <p class="text-sm text-gray-600">Garis menghubungkan <strong>orang tua</strong> dengan <strong>anak-anaknya</strong>.</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <div class="flex items-center mb-2">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-2">
                            <i class="fas fa-layer-group text-purple-600 text-sm"></i>
                        </div>
                        <span class="font-semibold text-gray-800">Generasi</span>
                    </div>
                    <p class="text-sm text-gray-600">Angka generasi menunjukkan <strong>tingkat keturunan</strong> dari pendiri keluarga.</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <div class="flex items-center mb-2">
                        <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-2">
                            <i class="fas fa-palette text-orange-600 text-sm"></i>
                        </div>
                        <span class="font-semibold text-gray-800">Warna Cabang</span>
                    </div>
                    <p class="text-sm text-gray-600">Setiap <strong>cabang keluarga</strong> memiliki warna berbeda untuk memudahkan identifikasi.</p>
                </div>
            </div>
            <div class="mt-4 p-3 bg-white/50 rounded-lg border border-blue-200">
                <p class="text-sm text-gray-600">
                    <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                    <strong>Tips:</strong> Klik pada kotak nama anggota untuk melihat informasi lengkap. Gunakan scroll horizontal jika pohon keluarga terlalu lebar.
                </p>
            </div>
        </div>

        <div id="family-tree-container" class="overflow-x-auto overflow-y-visible pb-4">
            @if($members->isEmpty())
                <div class="text-center py-16">
                    <i class="fas fa-users text-gray-300 text-6xl mb-4"></i>
                    <p class="text-gray-500 text-lg">Belum ada data anggota keluarga yang tersedia.</p>
                    <p class="text-gray-400 text-sm mt-2">Silahkan hubungi admin untuk menambahkan anggota keluarga.</p>
                </div>
            @else
                <!-- Tree will be rendered by JavaScript -->
                <div id="tree-root" class="inline-block min-w-full py-8">
                    <div class="text-center">
                        <i class="fas fa-spinner fa-spin text-blue-700 text-4xl"></i>
                        <p class="text-gray-600 mt-4">Memuat pohon keluarga...</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- FAQ Section -->
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-gray-900 mb-3">Pertanyaan yang Sering Diajukan</h2>
        <p class="text-gray-600 text-lg">Temukan jawaban untuk pertanyaan umum tentang Silsilah Keluarga KWS</p>
    </div>

    <div class="space-y-4">
        <!-- FAQ 1 -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            <button class="faq-question w-full text-left px-6 py-5 flex justify-between items-center hover:bg-gray-50 transition" onclick="toggleFaq(1)">
                <span class="text-lg font-semibold text-gray-900 pr-4">
                    <i class="fas fa-question-circle text-blue-600 mr-3"></i>
                    Apa itu Silsilah Keluarga KWS?
                </span>
                <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" id="faq-icon-1"></i>
            </button>
            <div class="faq-answer max-h-0 overflow-hidden transition-all duration-500 ease-in-out px-6" id="faq-answer-1">
                <p class="text-gray-600 leading-relaxed py-5">
                    <strong>KWS</strong> merupakan singkatan dari <strong>"Kumpulan Wargi Sukapura"</strong>, yang berarti 
                    kumpulan keluarga besar dari Sukapura. Website ini adalah platform digital yang dibuat untuk mendokumentasikan 
                    dan melestarikan sejarah keluarga besar kami. Website ini menampilkan pohon silsilah interaktif yang menghubungkan 
                    semua anggota keluarga dari berbagai generasi, sehingga setiap anggota keluarga dapat mengenal akar dan sejarah 
                    keluarganya dengan mudah.
                </p>
            </div>
        </div>

        <!-- FAQ 2 -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            <button class="faq-question w-full text-left px-6 py-5 flex justify-between items-center hover:bg-gray-50 transition" onclick="toggleFaq(2)">
                <span class="text-lg font-semibold text-gray-900 pr-4">
                    <i class="fas fa-bullseye text-blue-600 mr-3"></i>
                    Mengapa website ini dibuat?
                </span>
                <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" id="faq-icon-2"></i>
            </button>
            <div class="faq-answer max-h-0 overflow-hidden transition-all duration-500 ease-in-out px-6" id="faq-answer-2">
                <p class="text-gray-600 leading-relaxed py-5">
                    Website ini dibuat dengan tujuan untuk memperkuat ikatan antar anggota keluarga, melestarikan sejarah dan warisan keluarga 
                    untuk generasi mendatang, serta memudahkan anggota keluarga untuk saling mengenal meskipun terpisah jarak dan waktu. 
                    Dengan adanya dokumentasi digital ini, kisah dan silsilah keluarga tidak akan hilang seiring berjalannya waktu.
                </p>
            </div>
        </div>

        <!-- FAQ 3 -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            <button class="faq-question w-full text-left px-6 py-5 flex justify-between items-center hover:bg-gray-50 transition" onclick="toggleFaq(3)">
                <span class="text-lg font-semibold text-gray-900 pr-4">
                    <i class="fas fa-sitemap text-blue-600 mr-3"></i>
                    Bagaimana cara membaca pohon keluarga?
                </span>
                <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" id="faq-icon-3"></i>
            </button>
            <div class="faq-answer max-h-0 overflow-hidden transition-all duration-500 ease-in-out px-6" id="faq-answer-3">
                <p class="text-gray-600 leading-relaxed py-5">
                    Pohon keluarga dibaca dari atas ke bawah. Generasi tertua (pendiri keluarga) berada di paling atas, dan keturunannya 
                    tersusun ke bawah. Garis penghubung menunjukkan hubungan orang tua dan anak. Setiap cabang keluarga memiliki warna 
                    berbeda untuk memudahkan identifikasi. Anda bisa mengklik kotak nama untuk melihat informasi detail setiap anggota.
                </p>
            </div>
        </div>

        <!-- FAQ 4 -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            <button class="faq-question w-full text-left px-6 py-5 flex justify-between items-center hover:bg-gray-50 transition" onclick="toggleFaq(4)">
                <span class="text-lg font-semibold text-gray-900 pr-4">
                    <i class="fas fa-search text-blue-600 mr-3"></i>
                    Bagaimana cara mencari anggota keluarga?
                </span>
                <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" id="faq-icon-4"></i>
            </button>
            <div class="faq-answer max-h-0 overflow-hidden transition-all duration-500 ease-in-out px-6" id="faq-answer-4">
                <p class="text-gray-600 leading-relaxed py-5">
                    Gunakan kotak pencarian di bagian atas halaman (navbar). Ketik nama anggota keluarga yang ingin dicari, 
                    dan hasil pencarian akan muncul secara otomatis. Klik pada nama yang muncul untuk langsung menuju ke posisi 
                    anggota tersebut di pohon keluarga. Anda juga bisa mencari berdasarkan nama panggilan atau tempat lahir.
                </p>
            </div>
        </div>

        <!-- FAQ 5 -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            <button class="faq-question w-full text-left px-6 py-5 flex justify-between items-center hover:bg-gray-50 transition" onclick="toggleFaq(5)">
                <span class="text-lg font-semibold text-gray-900 pr-4">
                    <i class="fas fa-code-branch text-blue-600 mr-3"></i>
                    Apa yang dimaksud dengan cabang keluarga?
                </span>
                <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" id="faq-icon-5"></i>
            </button>
            <div class="faq-answer max-h-0 overflow-hidden transition-all duration-500 ease-in-out px-6" id="faq-answer-5">
                <p class="text-gray-600 leading-relaxed py-5">
                    Cabang keluarga adalah pembagian silsilah berdasarkan keturunan dari anak-anak pendiri keluarga. Misalnya, 
                    "Cabang Keturunan Anak Pertama" berisi semua keturunan dari anak pertama pendiri. Setiap cabang ditandai dengan 
                    warna berbeda agar mudah dibedakan di pohon keluarga. Pembagian ini membantu mengorganisir dan memahami struktur 
                    keluarga besar dengan lebih baik.
                </p>
            </div>
        </div>

        <!-- FAQ 6 -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            <button class="faq-question w-full text-left px-6 py-5 flex justify-between items-center hover:bg-gray-50 transition" onclick="toggleFaq(6)">
                <span class="text-lg font-semibold text-gray-900 pr-4">
                    <i class="fas fa-user-plus text-blue-600 mr-3"></i>
                    Bagaimana jika nama saya belum ada di pohon keluarga?
                </span>
                <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" id="faq-icon-6"></i>
            </button>
            <div class="faq-answer max-h-0 overflow-hidden transition-all duration-500 ease-in-out px-6" id="faq-answer-6">
                <p class="text-gray-600 leading-relaxed py-5">
                    Jika Anda adalah anggota keluarga tetapi nama Anda belum tercantum, silakan hubungi admin keluarga melalui 
                    email di info@silsilahkws.com. Sertakan informasi lengkap seperti nama lengkap, tanggal lahir, nama orang tua, 
                    dan cabang keluarga Anda. Admin akan memverifikasi dan menambahkan data Anda ke dalam sistem.
                </p>
            </div>
        </div>

        <!-- FAQ 7 -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            <button class="faq-question w-full text-left px-6 py-5 flex justify-between items-center hover:bg-gray-50 transition" onclick="toggleFaq(7)">
                <span class="text-lg font-semibold text-gray-900 pr-4">
                    <i class="fas fa-shield-alt text-blue-600 mr-3"></i>
                    Apakah data pribadi saya aman?
                </span>
                <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" id="faq-icon-7"></i>
            </button>
            <div class="faq-answer max-h-0 overflow-hidden transition-all duration-500 ease-in-out px-6" id="faq-answer-7">
                <p class="text-gray-600 leading-relaxed py-5">
                    Ya, keamanan dan privasi data adalah prioritas kami. Hanya informasi dasar yang ditampilkan di halaman publik 
                    (nama, tahun lahir, dan hubungan keluarga). Data sensitif seperti alamat lengkap, nomor telepon, dan email 
                    tidak ditampilkan kepada publik. Website ini juga dilindungi dengan enkripsi SSL untuk keamanan data.
                </p>
            </div>
        </div>
    </div>

    <!-- CTA Box -->
    <div class="mt-12 bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl p-8 text-center text-white shadow-xl">
        <h3 class="text-2xl font-bold mb-3">Masih Ada Pertanyaan?</h3>
        <p class="mb-6 text-blue-100">Tim kami siap membantu Anda. Jangan ragu untuk menghubungi kami.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="mailto:info@silsilahkws.com" class="bg-white text-blue-700 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition inline-flex items-center justify-center">
                <i class="fas fa-envelope mr-2"></i>
                Kirim Email
            </a>
            <a href="{{ route('about') }}" class="bg-blue-800 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-900 transition inline-flex items-center justify-center">
                <i class="fas fa-info-circle mr-2"></i>
                Pelajari Lebih Lanjut
            </a>
        </div>
    </div>
</div>

<!-- Member Detail Modal -->
<div id="member-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-2xl font-bold text-gray-900" id="modal-name"></h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <div id="modal-content" class="space-y-4">
                <!-- Content will be filled by JavaScript -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Family data from Laravel
    const familyData = @json($members);
    
    // Build tree structure
    function buildTree() {
        const members = {};
        const roots = [];
        
        // Create member lookup
        familyData.forEach(member => {
            members[member.id] = {
                ...member,
                children: []
            };
        });
        
        // Build parent-child relationships
        familyData.forEach(member => {
            if (member.father_id && members[member.father_id]) {
                members[member.father_id].children.push(members[member.id]);
            } else if (member.mother_id && members[member.mother_id]) {
                members[member.mother_id].children.push(members[member.id]);
            } else {
                roots.push(members[member.id]);
            }
        });
        
        // Sort children by child_order
        Object.values(members).forEach(member => {
            member.children.sort((a, b) => (a.child_order || 0) - (b.child_order || 0));
        });
        
        return { members, roots };
    }
    
    // Render tree node
    function renderNode(member, level = 0) {
        const branchColor = member.branch?.color_code || '#3b82f6';
        const hasChildren = member.children && member.children.length > 0;
        
        let html = `
            <div class="tree-node">
                <div class="member-card" data-member-id="${member.id}" onclick="showMemberDetail('${member.id}')" style="border-color: ${branchColor}">
                    <div class="text-base font-bold text-gray-900 leading-tight">${member.full_name}</div>
                    <div class="text-xs text-gray-500 mt-1">${member.nickname || ''}</div>
                    ${member.birth_date ? `<div class="text-xs text-gray-400">Lahir: ${member.birth_date.split('-')[0]}</div>` : ''}
                    ${member.branch ? `<div class="mt-2"><span class="branch-badge" style="background-color: ${branchColor}20; color: ${branchColor}; border: 1px solid ${branchColor}; font-size: 10px; padding: 2px 8px;">${member.branch.name}</span></div>` : ''}
                    <div class="text-xs text-gray-400 mt-1">Generasi ${member.generation}</div>
                </div>
                
                ${hasChildren ? `
                    <div class="tree-children">
                        ${member.children.map(child => renderNode(child, level + 1)).join('')}
                    </div>
                ` : ''}
            </div>
        `;
        
        return html;
    }
    
    // Render tree
    function renderTree() {
        const { members, roots } = buildTree();
        const treeRoot = document.getElementById('tree-root');
        
        if (roots.length === 0) {
            treeRoot.innerHTML = '<div class="text-center text-gray-500">Tidak ada data leluhur yang ditemukan.</div>';
            return;
        }
        
        // Render from roots with proper centered layout
        let html = '<div class="inline-flex flex-col items-center gap-8 px-10">';
        
        // Group roots by generation
        const genRoots = {};
        roots.forEach(root => {
            if (!genRoots[root.generation]) genRoots[root.generation] = [];
            genRoots[root.generation].push(root);
        });
        
        Object.keys(genRoots).sort().forEach(gen => {
            html += `
                <div class="flex flex-col items-center">
                    <span class="generation-label mb-4">Generasi ${gen}</span>
                    <div class="flex gap-10 justify-center items-start">
                        ${genRoots[gen].map(root => renderNode(root)).join('')}
                    </div>
                </div>
            `;
        });
        
        html += '</div>';
        treeRoot.innerHTML = html;
        
        // Scroll to center horizontally
        const container = document.getElementById('family-tree-container');
        if (container) {
            const scrollWidth = container.scrollWidth;
            const clientWidth = container.clientWidth;
            container.scrollLeft = (scrollWidth - clientWidth) / 2;
        }
    }
    
    // Format date function
    function formatDate(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                       'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const day = date.getDate();
        const month = months[date.getMonth()];
        const year = date.getFullYear();
        return `${day} ${month} ${year}`;
    }
    
    // Show member detail
    function showMemberDetail(memberId) {
        const member = familyData.find(m => m.id === memberId);
        if (!member) return;
        
        document.getElementById('modal-name').textContent = member.full_name;
        
        let content = `
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <div class="text-sm text-gray-500">Nama Lengkap</div>
                    <div class="font-semibold">${member.full_name}</div>
                </div>
                ${member.nickname ? `
                    <div>
                        <div class="text-sm text-gray-500">Nama Panggilan</div>
                        <div class="font-semibold">${member.nickname}</div>
                    </div>
                ` : ''}
                <div>
                    <div class="text-sm text-gray-500">Jenis Kelamin</div>
                    <div class="font-semibold">${member.gender === 'male' ? 'Laki-laki' : 'Perempuan'}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Generasi</div>
                    <div class="font-semibold">${member.generation}</div>
                </div>
                ${member.birth_date ? `
                    <div>
                        <div class="text-sm text-gray-500">Tanggal Lahir</div>
                        <div class="font-semibold">${formatDate(member.birth_date)}</div>
                    </div>
                ` : ''}
                ${member.birth_place ? `
                    <div>
                        <div class="text-sm text-gray-500">Tempat Lahir</div>
                        <div class="font-semibold">${member.birth_place}</div>
                    </div>
                ` : ''}
                ${member.branch ? `
                    <div>
                        <div class="text-sm text-gray-500">Cabang Keluarga</div>
                        <div>
                            <span class="branch-badge" style="background-color: ${member.branch.color_code}20; color: ${member.branch.color_code}; border: 1px solid ${member.branch.color_code};">
                                ${member.branch.name}
                            </span>
                        </div>
                    </div>
                ` : ''}
            </div>
            
            ${member.father || member.mother ? `
                <div class="mt-6 pt-6 border-t">
                    <h4 class="font-semibold mb-3">Orang Tua</h4>
                    <div class="grid grid-cols-2 gap-4">
                        ${member.father ? `
                            <div>
                                <div class="text-sm text-gray-500">Ayah</div>
                                <div class="font-semibold">${member.father.full_name}</div>
                            </div>
                        ` : ''}
                        ${member.mother ? `
                            <div>
                                <div class="text-sm text-gray-500">Ibu</div>
                                <div class="font-semibold">${member.mother.full_name}</div>
                            </div>
                        ` : ''}
                    </div>
                </div>
            ` : ''}
            
            ${member.children && member.children.length > 0 ? `
                <div class="mt-6 pt-6 border-t">
                    <h4 class="font-semibold mb-3">Anak (${member.children.length})</h4>
                    <div class="space-y-2">
                        ${member.children.map(child => `
                            <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                                <span>${child.full_name}</span>
                                <span class="text-sm text-gray-500">Generasi ${child.generation}</span>
                            </div>
                        `).join('')}
                    </div>
                </div>
            ` : ''}
        `;
        
        document.getElementById('modal-content').innerHTML = content;
        const modal = document.getElementById('member-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    
    // Close modal
    function closeModal() {
        const modal = document.getElementById('member-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    
    // Close modal when clicking outside
    document.getElementById('member-modal').addEventListener('click', (e) => {
        if (e.target.id === 'member-modal') {
            closeModal();
        }
    });
    
    // FAQ Toggle Function
    function toggleFaq(id) {
        const answer = document.getElementById(`faq-answer-${id}`);
        const icon = document.getElementById(`faq-icon-${id}`);
        
        // Close all other FAQs
        for (let i = 1; i <= 7; i++) {
            if (i !== id) {
                const otherAnswer = document.getElementById(`faq-answer-${i}`);
                const otherIcon = document.getElementById(`faq-icon-${i}`);
                otherAnswer.style.maxHeight = '0px';
                otherIcon.style.transform = 'rotate(0deg)';
            }
        }
        
        // Toggle current FAQ
        if (answer.style.maxHeight && answer.style.maxHeight !== '0px') {
            answer.style.maxHeight = '0px';
            icon.style.transform = 'rotate(0deg)';
        } else {
            answer.style.maxHeight = answer.scrollHeight + 'px';
            icon.style.transform = 'rotate(180deg)';
        }
    }
    
    // Make toggleFaq globally accessible
    window.toggleFaq = toggleFaq;
    
    // Scroll to tree function
    function scrollToTree() {
        const treeElement = document.getElementById('family-tree');
        if (treeElement) {
            treeElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
    
    // Make scrollToTree globally accessible
    window.scrollToTree = scrollToTree;
    
    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        renderTree();
    });
</script>
@endpush
