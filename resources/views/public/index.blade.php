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
    
    .tree-children-wrap {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        margin-top: 60px;
        position: relative;
    }

    .tree-children {
        display: inline-flex;
        justify-content: center;
        align-items: flex-start;
        gap: 30px;
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

    .couple-row {
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .spouse-line {
        width: 24px;
        height: 2px;
        background-color: #93c5fd;
        flex-shrink: 0;
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
        display: inline-flex;
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
    .tree-children > .tree-child {
        position: relative;
        padding: 0 15px;
    }
    
    /* Garis vertikal dari garis horizontal ke child */
    .tree-children > .tree-child::before {
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
    .tree-children > .tree-child:not(:last-child)::after {
        content: '';
        position: absolute;
        top: -15px;
        left: 50%;
        width: calc(100% + 30px);
        height: 2px;
        background-color: #93c5fd;
    }
    
    /* Untuk single child - sembunyikan garis horizontal, perpanjang vertikal */
    .tree-children > .tree-child:only-child::before {
        top: -30px;
        height: 30px;
    }
    
    .tree-children > .tree-child:only-child::after {
        display: none;
    }
    
    /* Sembunyikan garis vertikal dari parent jika hanya 1 anak */
    .tree-children:has(> .tree-child:only-child)::before {
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
                <div class="text-4xl font-bold mb-2">{{ $members->count() }}+</div>
                <div class="text-sm text-blue-100">Anggota Keluarga</div>
            </div>
            <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-6 hover:bg-opacity-20 transition">
                <div class="text-4xl font-bold mb-2">{{ $members->max('generation') ?? 0 }}+</div>
                <div class="text-sm text-blue-100">Generasi</div>
            </div>
            <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-6 hover:bg-opacity-20 transition">
                <div class="text-4xl font-bold mb-2">{{ $members->where('marital_status', 'married')->count() }}+</div>
                <div class="text-sm text-blue-100">Pasangan Menikah</div>
            </div>
            <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-6 hover:bg-opacity-20 transition">
                @php
                    $oldestYear = $members->whereNotNull('birth_date')->min(function($member) {
                        return $member->birth_date ? \Carbon\Carbon::parse($member->birth_date)->year : null;
                    });
                    $yearsOfHistory = $oldestYear ? now()->year - $oldestYear : 0;
                @endphp
                <div class="text-4xl font-bold mb-2">{{ $yearsOfHistory }}+</div>
                <div class="text-sm text-blue-100">Tahun Sejarah</div>
            </div>
        </div>
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
                <div class="w-10 h-10 rounded-lg border border-blue-200 text-blue-700 flex items-center justify-center text-sm font-semibold mr-3">i</div>
                <h3 class="text-lg font-bold text-gray-900">Cara Membaca Pohon Keluarga</h3>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <div class="mb-2">
                        <span class="font-semibold text-gray-800">Arah Baca</span>
                    </div>
                    <p class="text-sm text-gray-600">Baca dari <strong>atas ke bawah</strong>. Generasi tertua di atas, generasi muda di bawah.</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <div class="mb-2">
                        <span class="font-semibold text-gray-800">Garis Penghubung</span>
                    </div>
                    <p class="text-sm text-gray-600">Garis menghubungkan <strong>orang tua</strong> dengan <strong>anak-anaknya</strong>.</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <div class="mb-2">
                        <span class="font-semibold text-gray-800">Generasi</span>
                    </div>
                    <p class="text-sm text-gray-600">Angka generasi menunjukkan <strong>tingkat keturunan</strong> dari pendiri keluarga.</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <div class="mb-2">
                        <span class="font-semibold text-gray-800">Detail Anggota</span>
                    </div>
                    <p class="text-sm text-gray-600">Klik pada <strong>kotak nama</strong> untuk melihat informasi lengkap anggota keluarga.</p>
                </div>
            </div>
            <div class="mt-4 p-3 bg-white/50 rounded-lg border border-blue-200">
                <p class="text-sm text-gray-600">
                    <strong>Tips:</strong> Klik pada kotak nama anggota untuk melihat informasi lengkap seperti tanggal lahir, tempat lahir, dan hubungan keluarga. Gunakan scroll horizontal jika pohon keluarga terlalu lebar.
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
                    Bagaimana cara membaca pohon keluarga?
                </span>
                <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" id="faq-icon-3"></i>
            </button>
            <div class="faq-answer max-h-0 overflow-hidden transition-all duration-500 ease-in-out px-6" id="faq-answer-3">
                <p class="text-gray-600 leading-relaxed py-5">
                    Pohon keluarga dibaca dari atas ke bawah. Generasi tertua (pendiri keluarga) berada di paling atas, dan keturunannya 
                    tersusun ke bawah. Garis penghubung menunjukkan hubungan orang tua dan anak. Anda bisa mengklik kotak nama untuk 
                    melihat informasi detail setiap anggota keluarga seperti tanggal lahir, tempat lahir, dan informasi lainnya.
                </p>
            </div>
        </div>

        <!-- FAQ 4 -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            <button class="faq-question w-full text-left px-6 py-5 flex justify-between items-center hover:bg-gray-50 transition" onclick="toggleFaq(4)">
                <span class="text-lg font-semibold text-gray-900 pr-4">
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
                    Bagaimana jika nama saya belum ada di pohon keluarga?
                </span>
                <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" id="faq-icon-5"></i>
            </button>
            <div class="faq-answer max-h-0 overflow-hidden transition-all duration-500 ease-in-out px-6" id="faq-answer-5">
                <p class="text-gray-600 leading-relaxed py-5">
                    Jika Anda adalah anggota keluarga tetapi nama Anda belum tercantum, silakan hubungi admin utama keluarga. 
                    Sertakan informasi lengkap seperti nama lengkap, tanggal lahir, dan nama orang tua Anda. Admin akan memverifikasi 
                    dan menambahkan data Anda ke dalam sistem dalam waktu singkat.
                </p>
            </div>
        </div>

        <!-- FAQ 6 -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            <button class="faq-question w-full text-left px-6 py-5 flex justify-between items-center hover:bg-gray-50 transition" onclick="toggleFaq(6)">
                <span class="text-lg font-semibold text-gray-900 pr-4">
                    Apakah data pribadi saya aman?
                </span>
                <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" id="faq-icon-6"></i>
            </button>
            <div class="faq-answer max-h-0 overflow-hidden transition-all duration-500 ease-in-out px-6" id="faq-answer-6">
                <p class="text-gray-600 leading-relaxed py-5">
                    Ya, keamanan dan privasi data adalah prioritas kami. Hanya informasi dasar yang ditampilkan di halaman publik 
                    (nama, tahun lahir, dan hubungan keluarga). Data sensitif seperti alamat lengkap, nomor telepon, dan email 
                    tidak ditampilkan kepada publik. Website ini juga dilindungi dengan enkripsi SSL untuk keamanan data.
                </p>
            </div>
        </div>

        <!-- FAQ 7 -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            <button class="faq-question w-full text-left px-6 py-5 flex justify-between items-center hover:bg-gray-50 transition" onclick="toggleFaq(7)">
                <span class="text-lg font-semibold text-gray-900 pr-4">
                    Bagaimana cara menambahkan foto keluarga?
                </span>
                <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" id="faq-icon-7"></i>
            </button>
            <div class="faq-answer max-h-0 overflow-hidden transition-all duration-500 ease-in-out px-6" id="faq-answer-7">
                <p class="text-gray-600 leading-relaxed py-5">
                    Foto keluarga dapat ditambahkan melalui panel admin oleh admin keluarga. Jika Anda memiliki foto acara keluarga 
                    atau momen penting yang ingin dibagikan, silakan hubungi admin utama dan kirimkan fotonya. Admin akan mengunggah 
                    foto tersebut ke galeri setelah mendapat persetujuan yang bersangkutan.
                </p>
            </div>
        </div>
    </div>

    <!-- CTA Box -->
    <div class="mt-12 bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl p-8 text-center text-white shadow-xl">
        <h3 class="text-2xl font-bold mb-3">Masih Ada Pertanyaan?</h3>
        <p class="mb-6 text-blue-100">Tim kami siap membantu Anda. Jangan ragu untuk menghubungi admin utama kami.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="https://wa.me/6281234567890" target="_blank" class="bg-white text-blue-700 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition inline-flex items-center justify-center">
                <i class="fab fa-whatsapp mr-2"></i>
                Chat Admin
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
    
    // Build tree structure - HIRARKI KELUARGA (berdasarkan pasangan)
    function buildTree() {
        const members = {};
        const nodes = {};
        const nodeByPersonId = {};
        const assignedChildIds = new Set();

        familyData.forEach(member => {
            members[member.id] = {
                ...member,
                children: []
            };
        });

        const getCoupleKey = (id1, id2) => [id1, id2].sort().join('_');

        familyData.forEach(member => {
            const spouse = member.spouse_id && members[member.spouse_id] ? members[member.spouse_id] : null;

            if (spouse) {
                const coupleKey = getCoupleKey(member.id, spouse.id);
                const nodeId = `couple_${coupleKey}`;

                if (!nodes[nodeId]) {
                    const firstPerson = member.gender === 'male' ? member : spouse;
                    const secondPerson = member.gender === 'male' ? spouse : member;

                    nodes[nodeId] = {
                        id: nodeId,
                        type: 'couple',
                        person1: members[firstPerson.id],
                        person2: members[secondPerson.id],
                        children: []
                    };
                }

                nodeByPersonId[member.id] = nodes[nodeId];
                nodeByPersonId[spouse.id] = nodes[nodeId];
            } else {
                const nodeId = `single_${member.id}`;
                if (!nodes[nodeId]) {
                    nodes[nodeId] = {
                        id: nodeId,
                        type: 'single',
                        person1: members[member.id],
                        person2: null,
                        children: []
                    };
                }
                nodeByPersonId[member.id] = nodes[nodeId];
            }
        });

        familyData.forEach(child => {
            const fatherNode = child.father_id ? nodeByPersonId[child.father_id] : null;
            const motherNode = child.mother_id ? nodeByPersonId[child.mother_id] : null;
            const parentNode = fatherNode || motherNode;
            const childNode = nodeByPersonId[child.id];

            if (!parentNode || !childNode || parentNode.id === childNode.id) {
                return;
            }

            if (!parentNode.children.some(c => c.id === childNode.id)) {
                parentNode.children.push(childNode);
                assignedChildIds.add(childNode.id);
            }
        });

        Object.values(nodes).forEach(node => {
            node.children.sort((a, b) => (a.person1.child_order || 0) - (b.person1.child_order || 0));
        });

        const roots = Object.values(nodes).filter(node => !assignedChildIds.has(node.id));

        return { nodes, roots };
    }
    
    // Render tree node
    function renderNode(node, level = 0) {
        const hasChildren = node.children && node.children.length > 0;
        const person1 = node.person1;
        const person2 = node.person2;

        const renderMemberCard = (person) => {
            const branchColor = person.branch?.color_code || '#3b82f6';
            return `
                <div class="member-card" data-member-id="${person.id}" onclick="showMemberDetail('${person.id}')" style="border-color: ${branchColor}">
                    <div class="text-base font-bold text-gray-900 leading-tight">${person.full_name}</div>
                    <div class="text-xs text-gray-500 mt-1">${person.nickname || ''}</div>
                    ${person.birth_date ? `<div class="text-xs text-gray-400">Lahir: ${person.birth_date.split('-')[0]}</div>` : ''}
                    ${person.branch ? `<div class="mt-2"><span class="branch-badge" style="background-color: ${branchColor}20; color: ${branchColor}; border: 1px solid ${branchColor}; font-size: 10px; padding: 2px 8px;">${person.branch.name}</span></div>` : ''}
                    <div class="text-xs text-gray-400 mt-1">Generasi ${person.generation}</div>
                </div>
            `;
        };

        let coupleHtml = '';
        if (person2) {
            coupleHtml = `
                <div class="couple-row">
                    ${renderMemberCard(person1)}
                    <div class="spouse-line"></div>
                    ${renderMemberCard(person2)}
                </div>
            `;
        } else {
            coupleHtml = renderMemberCard(person1);
        }

        let html = `
            <div class="tree-node">
                ${coupleHtml}
                ${hasChildren ? `
                    <div class="tree-children-wrap">
                        <div class="tree-children">
                            ${node.children.map(child => `<div class="tree-child">${renderNode(child, level + 1)}</div>`).join('')}
                        </div>
                    </div>
                ` : ''}
            </div>
        `;

        return html;
    }
    
    // Render tree - HIERARKI dari Pendiri
    function renderTree() {
        const { members, roots } = buildTree();
        const treeRoot = document.getElementById('tree-root');
        
        if (roots.length === 0) {
            treeRoot.innerHTML = '<div class="text-center text-gray-500">Tidak ada data pendiri keluarga yang ditemukan.</div>';
            return;
        }
        
        // Render hierarki dari pendiri (BUKAN dikelompokkan per generasi)
        let html = '<div class="inline-flex gap-20 px-10">';
        
        // Tampilkan setiap pendiri beserta keturunannya
        roots.forEach(root => {
            html += `
                <div class="flex flex-col items-center">
                    <span class="generation-label mb-6">Pendiri Keluarga</span>
                    ${renderNode(root)}
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
