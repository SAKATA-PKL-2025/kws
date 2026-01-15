@extends('layouts.public')

@section('title', 'Galeri Foto - Silsilah Keluarga KWS')

@push('styles')
<style>
    .gallery-card {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        transition: transform 0.3s;
    }
    
    .gallery-card:hover {
        transform: translateY(-5px);
    }
    
    .gallery-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }
    
    .gallery-card:hover img {
        transform: scale(1.1);
    }
    
    .gallery-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        padding: 20px;
        transform: translateY(100%);
        transition: transform 0.3s;
    }
    
    .gallery-card:hover .gallery-overlay {
        transform: translateY(0);
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-pattern text-white py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">
            <i class="fas fa-images mr-3"></i>
            Galeri Foto Keluarga
        </h1>
        <p class="text-xl text-blue-100">
            Momen-momen berharga dan kenangan keluarga kami
        </p>
    </div>
</div>

<!-- Filter Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex items-center space-x-2">
                <i class="fas fa-filter text-gray-600"></i>
                <span class="font-semibold text-gray-900">Filter Cabang:</span>
            </div>
            <button class="px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition filter-btn active" data-filter="all">
                <i class="fas fa-images mr-2"></i>
                Semua ({{ $photos->count() }})
            </button>
            @foreach($branches as $branch)
                <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition filter-btn" 
                        data-filter="branch-{{ $branch->id }}"
                        style="border-left: 4px solid {{ $branch->color_code }};">
                    {{ $branch->name }} ({{ $photos->where('family_branch_id', $branch->id)->count() }})
                </button>
            @endforeach
        </div>
    </div>
</div>

<!-- Gallery Grid -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    @if($photos->isEmpty())
        <div class="text-center py-16 bg-white rounded-2xl shadow-lg">
            <i class="fas fa-images text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Foto</h3>
            <p class="text-gray-600">Album foto keluarga akan ditampilkan di sini setelah diupload oleh admin.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="gallery-container">
            @foreach($photos as $photo)
                <div class="gallery-card shadow-lg h-64 cursor-pointer" 
                     data-category="branch-{{ $photo->family_branch_id ?? 'none' }}"
                     onclick="openPhotoModal({{ json_encode($photo) }})">
                    <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="{{ $photo->title }}" class="h-full w-full object-cover">
                    <div class="gallery-overlay">
                        <h3 class="text-white font-bold text-lg mb-1">{{ $photo->title }}</h3>
                        <p class="text-gray-300 text-sm mb-2">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            {{ $photo->photo_date ? $photo->photo_date->format('d F Y') : 'Tanggal tidak diketahui' }}
                        </p>
                        @if($photo->location)
                            <p class="text-gray-300 text-sm">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                {{ $photo->location }}
                            </p>
                        @endif
                        @if($photo->branch)
                            <span class="inline-block mt-2 px-2 py-1 text-xs rounded-full" 
                                  style="background-color: {{ $photo->branch->color_code }}20; color: {{ $photo->branch->color_code }}; border: 1px solid {{ $photo->branch->color_code }};">
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
<div id="photoModal" class="hidden fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4" onclick="closePhotoModal()">
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
            </div>
        </div>

        <div class="gallery-card shadow-lg h-64" data-category="pernikahan">
            <div class="h-full bg-gradient-to-br from-pink-500 to-rose-600 flex items-center justify-center">
                <div class="text-center text-white">
                    <i class="fas fa-heart text-6xl mb-4 opacity-50"></i>
                    <p class="text-sm">Pernikahan 2023</p>
                </div>
            </div>
            <div class="gallery-overlay">
                <h3 class="text-white font-bold text-lg mb-1">Pernikahan Ahmad & Siti</h3>
                <p class="text-gray-300 text-sm">20 Juni 2023</p>
            </div>
        </div>

        <div class="gallery-card shadow-lg h-64" data-category="reuni">
            <div class="h-full bg-gradient-to-br from-green-500 to-teal-600 flex items-center justify-center">
                <div class="text-center text-white">
                    <i class="fas fa-users text-6xl mb-4 opacity-50"></i>
                    <p class="text-sm">Reuni Keluarga</p>
                </div>
            </div>
            <div class="gallery-overlay">
                <h3 class="text-white font-bold text-lg mb-1">Reuni Keluarga Besar</h3>
                <p class="text-gray-300 text-sm">10 Agustus 2023</p>
            </div>
        </div>

        <div class="gallery-card shadow-lg h-64" data-category="acara-keluarga">
            <div class="h-full bg-gradient-to-br from-orange-500 to-red-600 flex items-center justify-center">
                <div class="text-center text-white">
                    <i class="fas fa-birthday-cake text-6xl mb-4 opacity-50"></i>
                    <p class="text-sm">Ulang Tahun</p>
                </div>
            </div>
            <div class="gallery-overlay">
                <h3 class="text-white font-bold text-lg mb-1">Ulang Tahun Kakek</h3>
                <p class="text-gray-300 text-sm">5 Maret 2024</p>
            </div>
        </div>

        <div class="gallery-card shadow-lg h-64" data-category="lainnya">
            <div class="h-full bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center">
                <div class="text-center text-white">
                    <i class="fas fa-mosque text-6xl mb-4 opacity-50"></i>
                    <p class="text-sm">Kegiatan Keagamaan</p>
                </div>
            </div>
            <div class="gallery-overlay">
                <h3 class="text-white font-bold text-lg mb-1">Pengajian Keluarga</h3>
                <p class="text-gray-300 text-sm">12 Ramadan 1445H</p>
            </div>
        </div>

        <div class="gallery-card shadow-lg h-64" data-category="pernikahan">
            <div class="h-full bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center">
                <div class="text-center text-white">
                    <i class="fas fa-rings-wedding text-6xl mb-4 opacity-50"></i>
                    <p class="text-sm">Lamaran</p>
                </div>
            </div>
            <div class="gallery-overlay">
                <h3 class="text-white font-bold text-lg mb-1">Acara Lamaran</h3>
                <p class="text-gray-300 text-sm">3 April 2024</p>
            </div>
        </div>

        <div class="gallery-card shadow-lg h-64" data-category="reuni">
            <div class="h-full bg-gradient-to-br from-yellow-500 to-orange-600 flex items-center justify-center">
                <div class="text-center text-white">
                    <i class="fas fa-campground text-6xl mb-4 opacity-50"></i>
                    <p class="text-sm">Liburan Keluarga</p>
                </div>
            </div>
            <div class="gallery-overlay">
                <h3 class="text-white font-bold text-lg mb-1">Liburan ke Pantai</h3>
                <p class="text-gray-300 text-sm">25 Desember 2023</p>
            </div>
        </div>

        <div class="gallery-card shadow-lg h-64" data-category="lainnya">
            <div class="h-full bg-gradient-to-br from-teal-500 to-green-600 flex items-center justify-center">
                <div class="text-center text-white">
                    <i class="fas fa-graduation-cap text-6xl mb-4 opacity-50"></i>
                    <p class="text-sm">Wisuda</p>
                </div>
            </div>
            <div class="gallery-overlay">
                <h3 class="text-white font-bold text-lg mb-1">Wisuda Anak Keluarga</h3>
                <p class="text-gray-300 text-sm">1 September 2023</p>
            </div>
        </div>
    </div>

<!-- Info Box -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    <div class="mt-12 bg-blue-50 border-l-4 border-blue-700 p-6 rounded-lg">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-700 text-2xl mr-4 mt-1"></i>
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Informasi Galeri</h3>
                <p class="text-gray-700 mb-3">
                    Galeri foto ini menampilkan momen-momen penting dan kenangan berharga keluarga kami. 
                    Foto-foto ini dikelola oleh admin keluarga dan akan terus diperbarui dengan acara-acara terbaru.
                </p>
                <p class="text-gray-700">
                    <strong>Untuk Admin Keluarga:</strong> Login ke panel admin untuk menambahkan atau mengelola album foto. 
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
                    btn.classList.remove('active', 'bg-blue-700', 'text-white');
                    btn.classList.add('bg-gray-100', 'text-gray-700');
                });
                this.classList.add('active', 'bg-blue-700', 'text-white');
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
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }

    function closePhotoModal() {
        const modal = document.getElementById('photoModal');
        modal.classList.add('hidden');
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
