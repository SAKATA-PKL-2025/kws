@extends('layouts.public')

@section('title', 'Galeri Foto - Silsilah Keluarga KWS')

@push('styles')
<style>
    .gallery-card {
        position: relative;
        overflow: hidden;
        border-radius: 16px;
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
        background: white;
        border: 2px solid transparent;
    }
    
    .gallery-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        border-color: #3b82f6;
    }
    
    .gallery-image-container {
        position: relative;
        width: 100%;
        padding-top: 75%; /* 4:3 aspect ratio (3/4 = 0.75 = 75%) */
        overflow: hidden;
        border-radius: 14px 14px 0 0;
    }
    
    .gallery-card img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }
    
    .gallery-card:hover img {
        transform: scale(1.05);
    }
    
    .gallery-overlay {
        padding: 16px;
        background: white;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .gallery-card:hover .gallery-overlay {
        background: #f9fafb;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-pattern text-white py-32 pt-40 relative">
    <!-- Floating Icons Background -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="floating-icon absolute top-20 left-10 opacity-20">
            <i class="fas fa-images text-6xl"></i>
        </div>
        <div class="floating-icon absolute top-40 right-20 opacity-20" style="animation-delay: 1s">
            <i class="fas fa-camera text-5xl"></i>
        </div>
        <div class="floating-icon absolute bottom-20 left-1/4 opacity-20" style="animation-delay: 2s">
            <i class="fas fa-photo-video text-4xl"></i>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                Galeri Foto Keluarga
            </h1>
            <p class="text-lg text-blue-100 mb-8 leading-relaxed max-w-3xl mx-auto">
                Momen-momen berharga dan kenangan keluarga kami.<br>
                Dokumentasi visual dari setiap perayaan dan kebersamaan Kumpulan Wargi Sukapura.
            </p>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <div class="mb-4">
            <div class="flex items-center space-x-2 mb-4">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center shadow-md">
                    <i class="fas fa-filter text-white"></i>
                </div>
                <span class="font-semibold text-gray-900 text-lg">Filter Cabang:</span>
            </div>
            <div class="flex flex-wrap gap-3">
                <button class="px-5 py-2.5 bg-gradient-to-br from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all shadow-md hover:shadow-lg filter-btn active font-medium" data-filter="all">
                    <i class="fas fa-images mr-2"></i>
                    Semua ({{ $photos->count() }})
                </button>
                @foreach($branches as $branch)
                    <button class="px-5 py-2.5 bg-white text-gray-700 rounded-xl hover:shadow-md transition-all filter-btn font-medium border-2 border-gray-200 hover:border-gray-300" 
                            data-filter="branch-{{ $branch->id }}">
                        <span class="inline-block w-3 h-3 rounded-full mr-2" style="background-color: {{ $branch->color_code }};"></span>
                        {{ $branch->name }} ({{ $photos->where('family_branch_id', $branch->id)->count() }})
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Gallery Grid -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
    @if($photos->isEmpty())
        <div class="text-center py-20 bg-white rounded-2xl shadow-xl border-2 border-gray-100">
            <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-images text-gray-400 text-5xl"></i>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-3">Belum Ada Foto</h3>
            <p class="text-gray-600 text-lg">Album foto keluarga akan ditampilkan di sini setelah diupload oleh admin.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="gallery-container">
            @foreach($photos as $photo)
                <div class="gallery-card shadow-lg cursor-pointer" 
                     data-category="branch-{{ $photo->family_branch_id ?? 'none' }}"
                     onclick="openPhotoModal({{ json_encode($photo) }})">
                    <div class="gallery-image-container">
                        <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="{{ $photo->title }}">
                    </div>
                    <div class="gallery-overlay">
                        <h3 class="text-gray-900 font-bold text-lg mb-2">{{ $photo->title }}</h3>
                        <p class="text-gray-600 text-sm mb-2">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            {{ $photo->photo_date ? $photo->photo_date->format('d F Y') : 'Tanggal tidak diketahui' }}
                        </p>
                        @if($photo->location)
                            <p class="text-gray-600 text-sm mb-2">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                {{ $photo->location }}
                            </p>
                        @endif
                        @if($photo->branch)
                            <span class="inline-block mt-auto px-3 py-1 text-xs rounded-full font-medium" 
                                  style="background-color: {{ $photo->branch->color_code }}; color: white;">
                                {{ $photo->branch->name }}
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Photo Modal -->
<div id="photoModal" class="hidden fixed inset-0 bg-black bg-opacity-90 z-50 items-center justify-center p-4" onclick="closePhotoModal()">
    <button class="absolute top-4 right-4 text-white text-4xl hover:text-gray-300 transition" onclick="closePhotoModal()">
        <i class="fas fa-times"></i>
    </button>
    
    <div class="max-w-5xl w-full bg-white rounded-2xl overflow-hidden" onclick="event.stopPropagation()">
        <div class="grid md:grid-cols-2 gap-0">
            <!-- Image Side -->
            <div class="bg-gray-100">
                <img id="modalImage" src="" alt="" class="w-full h-full object-contain max-h-[80vh]">
            </div>
            
            <!-- Details Side -->
            <div class="p-8">
                <h2 id="modalTitle" class="text-3xl font-bold text-gray-900 mb-4"></h2>
                
                <div class="space-y-4 mb-6">
                    <div class="flex items-start">
                        <i class="fas fa-calendar-alt text-blue-600 mt-1 mr-3"></i>
                        <div>
                            <div class="text-sm text-gray-500">Tanggal</div>
                            <div id="modalDate" class="font-semibold text-gray-900"></div>
                        </div>
                    </div>
                    
                    <div class="flex items-start" id="modalLocationContainer">
                        <i class="fas fa-map-marker-alt text-blue-600 mt-1 mr-3"></i>
                        <div>
                            <div class="text-sm text-gray-500">Lokasi</div>
                            <div id="modalLocation" class="font-semibold text-gray-900"></div>
                        </div>
                    </div>
                    
                    <div class="flex items-start" id="modalBranchContainer">
                        <i class="fas fa-sitemap text-blue-600 mt-1 mr-3"></i>
                        <div>
                            <div class="text-sm text-gray-500">Cabang Keluarga</div>
                            <div id="modalBranch"></div>
                        </div>
                    </div>
                </div>
                
                <div id="modalDescriptionContainer" class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Deskripsi</h3>
                    <p id="modalDescription" class="text-gray-700 leading-relaxed"></p>
                </div>
                
                <button onclick="closePhotoModal()" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition">
                    <i class="fas fa-times mr-2"></i>
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Info Box -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    <div class="mt-12 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 border-l-4 border-blue-700 p-8 rounded-2xl shadow-lg">
        <div class="flex items-start">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center mr-4 shadow-md flex-shrink-0">
                <i class="fas fa-info-circle text-white text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Informasi Galeri</h3>
                <p class="text-gray-700 mb-4 leading-relaxed">
                    Galeri foto ini menampilkan momen-momen penting dan kenangan berharga keluarga kami. 
                    Foto-foto ini dikelola oleh admin keluarga dan akan terus diperbarui dengan acara-acara terbaru.
                </p>
                <p class="text-gray-700 leading-relaxed">
                    <strong class="text-blue-700">Untuk Admin Keluarga:</strong> Login ke panel admin untuk menambahkan atau mengelola album foto. 
                    Pastikan foto yang diunggah sudah mendapat persetujuan dari keluarga yang bersangkutan.
                </p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const galleryItems = document.querySelectorAll('.gallery-card');

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                
                // Update active button
                filterButtons.forEach(btn => {
                    btn.classList.remove('active', 'bg-gradient-to-br', 'from-blue-600', 'to-blue-700', 'text-white');
                    btn.classList.add('bg-gray-100', 'text-gray-700');
                });
                this.classList.add('active', 'bg-gradient-to-br', 'from-blue-600', 'to-blue-700', 'text-white');
                this.classList.remove('bg-gray-100', 'text-gray-700');

                // Filter gallery items
                galleryItems.forEach(item => {
                    const category = item.getAttribute('data-category');
                    if (filter === 'all' || category === filter) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    });

    // Photo modal functions
    function openPhotoModal(photo) {
        const modal = document.getElementById('photoModal');
        const modalImage = document.getElementById('modalImage');
        const modalTitle = document.getElementById('modalTitle');
        const modalDate = document.getElementById('modalDate');
        const modalLocation = document.getElementById('modalLocation');
        const modalLocationContainer = document.getElementById('modalLocationContainer');
        const modalDescription = document.getElementById('modalDescription');
        const modalDescriptionContainer = document.getElementById('modalDescriptionContainer');
        const modalBranch = document.getElementById('modalBranch');
        const modalBranchContainer = document.getElementById('modalBranchContainer');

        // Set image and basic info
        modalImage.src = '/storage/' + photo.photo_path;
        modalImage.alt = photo.title;
        modalTitle.textContent = photo.title;
        
        // Format and set date
        if (photo.photo_date) {
            const date = new Date(photo.photo_date);
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            modalDate.textContent = date.toLocaleDateString('id-ID', options);
        } else {
            modalDate.textContent = 'Tanggal tidak diketahui';
        }

        // Set location or hide if empty
        if (photo.location) {
            modalLocation.textContent = photo.location;
            modalLocationContainer.style.display = 'flex';
        } else {
            modalLocationContainer.style.display = 'none';
        }

        // Set description or hide if empty
        if (photo.description) {
            modalDescription.textContent = photo.description;
            modalDescriptionContainer.style.display = 'block';
        } else {
            modalDescriptionContainer.style.display = 'none';
        }

        // Set branch badge or hide if empty
        if (photo.branch) {
            modalBranch.innerHTML = `<span class="inline-block px-3 py-1 text-sm rounded-full font-semibold" 
                style="background-color: ${photo.branch.color_code}20; color: ${photo.branch.color_code}; border: 1px solid ${photo.branch.color_code};">
                ${photo.branch.name}
            </span>`;
            modalBranchContainer.style.display = 'flex';
        } else {
            modalBranchContainer.style.display = 'none';
        }

        // Show modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }

    function closePhotoModal() {
        const modal = document.getElementById('photoModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = ''; // Restore scrolling
    }

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePhotoModal();
        }
    });
</script>
@endpush
