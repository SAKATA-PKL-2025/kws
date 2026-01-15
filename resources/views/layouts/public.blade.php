<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Silsilah Keluarga KWS - Warisan Keluarga Kami">
    <title>@yield('title', 'Silsilah Keluarga KWS')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .floating-navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
            max-width: 1200px;
        }
        
        .search-box {
            position: relative;
        }
        
        .search-box input {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 8px 40px 8px 14px;
            width: 100%;
            transition: all 0.3s;
            font-size: 14px;
        }
        
        .search-box input:focus {
            outline: none;
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .search-box button {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #64748b;
            cursor: pointer;
        }
        
        .hero-pattern {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 50%, #1e3a8a 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            position: relative;
            overflow: hidden;
        }
        
        .hero-pattern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.4;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .floating-icon {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-50">
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 px-8 pt-4 pb-2">
        <div class="floating-navbar">
            <div class="max-w-6xl mx-auto px-4 lg:px-6">
                <div class="flex justify-between items-center h-14">
                    <!-- Logo & Brand -->
                    <div class="flex items-center flex-shrink-0">
                        <a href="{{ route('home') }}" class="flex items-center space-x-2">
                            <div class="bg-gradient-to-br from-blue-600 to-blue-700 p-2 rounded-lg shadow-lg">
                                <i class="fas fa-sitemap text-white text-base"></i>
                            </div>
                            <div>
                                <div class="text-lg font-bold text-gray-900 leading-tight">KWS</div>
                            </div>
                        </a>
                    </div>

                    <!-- Search Bar (Desktop) -->
                    <div class="hidden lg:block flex-1 max-w-sm mx-6">
                        <div class="search-box">
                            <input type="text" placeholder="Cari anggota keluarga..." class="w-full">
                            <button type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center space-x-6 flex-shrink-0">
                        <a href="{{ route('home') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600 transition {{ request()->routeIs('home') ? 'text-blue-600' : '' }}">
                            Beranda
                        </a>
                        <a href="{{ route('about') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600 transition {{ request()->routeIs('about') ? 'text-blue-600' : '' }}">
                            Tentang
                        </a>
                        <a href="{{ route('gallery') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600 transition {{ request()->routeIs('gallery') ? 'text-blue-600' : '' }}">
                            Galeri
                        </a>
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="md:hidden flex items-center">
                        <button id="mobile-menu-button" class="text-gray-700 hover:text-blue-600 focus:outline-none p-2">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Mobile Search -->
                <div class="lg:hidden pb-2 px-2">
                    <div class="search-box">
                        <input type="text" placeholder="Cari anggota keluarga..." class="w-full">
                        <button type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden mt-2">
            <div class="floating-navbar">
                <div class="px-4 py-2 space-y-1">
                    <a href="{{ route('home') }}" class="flex items-center px-4 py-2.5 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-600' : '' }}">
                        <i class="fas fa-home mr-3 text-sm"></i>
                        <span class="font-medium">Beranda</span>
                    </a>
                    <a href="{{ route('about') }}" class="flex items-center px-4 py-2.5 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('about') ? 'bg-blue-50 text-blue-600' : '' }}">
                        <i class="fas fa-info-circle mr-3 text-sm"></i>
                        <span class="font-medium">Tentang</span>
                    </a>
                    <a href="{{ route('gallery') }}" class="flex items-center px-4 py-2.5 rounded-xl text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('gallery') ? 'bg-blue-50 text-blue-600' : '' }}">
                        <i class="fas fa-images mr-3 text-sm"></i>
                        <span class="font-medium">Galeri</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-slate-900 via-slate-800 to-gray-900 text-white mt-16 relative overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute top-0 left-0 w-full h-full opacity-5">
            <div class="absolute top-10 left-10 w-32 h-32 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-40 h-40 bg-slate-600 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-slate-700 rounded-full blur-3xl"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                <!-- Brand Section -->
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-5">
                        <div class="bg-gradient-to-br from-blue-600 to-blue-700 p-3 rounded-xl shadow-lg">
                            <i class="fas fa-sitemap text-white text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-white">KWS</div>
                            <div class="text-sm text-gray-300">Silsilah Keluarga</div>
                        </div>
                    </div>
                    <p class="text-gray-300 leading-relaxed mb-6 text-sm">
                        Dokumentasi lengkap silsilah keluarga untuk generasi sekarang dan yang akan datang. 
                        Menjaga warisan keluarga dengan teknologi modern.
                    </p>
                    <div class="flex space-x-3">
                        <a href="#" class="bg-gray-700 hover:bg-gray-600 transition w-10 h-10 rounded-lg flex items-center justify-center">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="bg-gray-700 hover:bg-gray-600 transition w-10 h-10 rounded-lg flex items-center justify-center">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="bg-gray-700 hover:bg-gray-600 transition w-10 h-10 rounded-lg flex items-center justify-center">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="bg-gray-700 hover:bg-gray-600 transition w-10 h-10 rounded-lg flex items-center justify-center">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-bold mb-5 text-white">Menu Cepat</h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('home') }}" class="text-gray-300 hover:text-white hover:translate-x-1 transition-all inline-flex items-center group">
                                <span class="bg-gray-700 group-hover:bg-gray-600 w-6 h-6 rounded flex items-center justify-center mr-3 transition">
                                    <i class="fas fa-home text-xs"></i>
                                </span>
                                Beranda
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('home') }}#family-tree" class="text-gray-300 hover:text-white hover:translate-x-1 transition-all inline-flex items-center group">
                                <span class="bg-gray-700 group-hover:bg-gray-600 w-6 h-6 rounded flex items-center justify-center mr-3 transition">
                                    <i class="fas fa-tree text-xs"></i>
                                </span>
                                Pohon Keluarga
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}" class="text-gray-300 hover:text-white hover:translate-x-1 transition-all inline-flex items-center group">
                                <span class="bg-gray-700 group-hover:bg-gray-600 w-6 h-6 rounded flex items-center justify-center mr-3 transition">
                                    <i class="fas fa-info-circle text-xs"></i>
                                </span>
                                Tentang Kami
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('gallery') }}" class="text-gray-300 hover:text-white hover:translate-x-1 transition-all inline-flex items-center group">
                                <span class="bg-gray-700 group-hover:bg-gray-600 w-6 h-6 rounded flex items-center justify-center mr-3 transition">
                                    <i class="fas fa-images text-xs"></i>
                                </span>
                                Galeri Foto
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg font-bold mb-5 text-white">Hubungi Kami</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <div class="bg-gray-700 w-8 h-8 rounded-lg flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                <i class="fas fa-envelope text-sm"></i>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400 mb-1">Email</div>
                                <a href="mailto:info@silsilahkws.com" class="text-gray-300 hover:text-white transition text-sm">
                                    info@silsilahkws.com
                                </a>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="bg-gray-700 w-8 h-8 rounded-lg flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                <i class="fas fa-phone text-sm"></i>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400 mb-1">Telepon</div>
                                <a href="tel:+62" class="text-gray-300 hover:text-white transition text-sm">
                                    +62 xxx xxxx xxxx
                                </a>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="bg-gray-700 w-8 h-8 rounded-lg flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-sm"></i>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400 mb-1">Lokasi</div>
                                <span class="text-gray-300 text-sm">Indonesia</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-700 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="text-gray-400 text-sm">
                        <p>&copy; {{ date('Y') }} <span class="font-semibold text-white">Silsilah Keluarga KWS</span>. Hak Cipta Dilindungi.</p>
                    </div>
                    <div class="flex items-center gap-6 text-sm">
                        <a href="{{ route('privacy') }}" class="text-gray-300 hover:text-white transition">Kebijakan Privasi</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!mobileMenuButton.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
