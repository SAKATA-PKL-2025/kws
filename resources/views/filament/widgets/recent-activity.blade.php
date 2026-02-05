<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Aktivitas Terbaru
        </x-slot>

        <div class="space-y-3">
            @forelse($activities as $activity)
                @php
                    $link = $activity['type'] === 'photo'
                        ? route('filament.admin.resources.family.family-photos.view', ['record' => $activity['id']])
                        : route('filament.admin.resources.family.family-members.view', ['record' => $activity['id']]);
                    $initial = mb_substr($activity['title'], 0, 1);
                    $fallbackUrl = 'https://ui-avatars.com/api/?name=' . urlencode($initial) . '&color=FFFFFF&background=' . ($activity['type'] === 'photo' ? '9CA3AF' : 'D97706') . '&bold=true&size=48';
                    $imgUrl = !empty($activity['image']) ? Storage::url($activity['image']) : $fallbackUrl;
                @endphp
                <div style="display:flex;align-items:center;gap:1rem;padding:1rem;" class="bg-gray-50 dark:bg-gray-800/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    {{-- Avatar - single img tag, guaranteed 48x48 --}}
                    <img src="{{ $imgUrl }}"
                         style="width:48px;height:48px;min-width:48px;min-height:48px;object-fit:cover;"
                         class="{{ $activity['type'] === 'photo' ? 'rounded-lg' : 'rounded-full' }}"
                         alt="" loading="lazy"
                         onerror="this.onerror=null;this.src='{{ $fallbackUrl }}';">

                    {{-- Content --}}
                    <div style="flex:1;min-width:0;">
                        <h4 class="font-semibold text-gray-900 dark:text-white truncate">{{ $activity['title'] }}</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $activity['subtitle'] }}</p>
                        <div class="flex flex-wrap items-center gap-3 mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                            <span class="inline-flex items-center gap-1">
                                @if($activity['type'] === 'photo')
                                    <x-heroicon-s-photo class="w-3 h-3" /> Foto
                                @else
                                    <x-heroicon-s-user class="w-3 h-3" /> Anggota
                                @endif
                            </span>
                            <span class="inline-flex items-center gap-1">
                                <x-heroicon-s-calendar class="w-3 h-3" />
                                {{ $activity['created_at']->diffForHumans() }}
                            </span>
                            @if($activity['status'] === 'approved' && $activity['approved_by'])
                                <span class="inline-flex items-center gap-1">
                                    <x-heroicon-s-check-badge class="w-3 h-3 text-green-500" />
                                    oleh {{ $activity['approved_by'] }}
                                </span>
                            @endif
                            @if($activity['type'] === 'photo' && isset($activity['uploader']))
                                <span class="inline-flex items-center gap-1">
                                    <x-heroicon-s-arrow-up-tray class="w-3 h-3" />
                                    upload: {{ $activity['uploader'] }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Status + Arrow --}}
                    <div style="flex-shrink:0;display:flex;align-items:center;gap:0.75rem;">
                        @if($activity['status'] === 'pending')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 whitespace-nowrap">
                                <x-heroicon-s-clock class="w-3 h-3" /> Menunggu
                            </span>
                        @elseif($activity['status'] === 'approved')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 whitespace-nowrap">
                                <x-heroicon-s-check-circle class="w-3 h-3" /> Disetujui
                            </span>
                        @elseif($activity['status'] === 'rejected')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 whitespace-nowrap">
                                <x-heroicon-s-x-circle class="w-3 h-3" /> Ditolak
                            </span>
                        @endif
                        <a href="{{ $link }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 text-gray-400 hover:text-primary-600 transition-colors">
                            <x-heroicon-s-arrow-right class="w-4 h-4" />
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <x-heroicon-o-clock class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3" />
                    <p class="text-gray-500 dark:text-gray-400">Belum ada aktivitas</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($activities->total() > 0)
            <div class="fi-ta-pagination flex items-center justify-between gap-4 px-1 pt-3 border-t border-gray-200 dark:border-white/10 mt-3">
                {{-- Per Page Selector --}}
                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Per halaman
                    </label>
                    <select wire:model.live="perPage" class="h-8 rounded-lg border-gray-300 bg-white text-sm shadow-sm transition duration-75 focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 dark:border-white/10 dark:bg-white/5 dark:text-white dark:focus:border-primary-500 [&_option]:dark:bg-gray-900">
                        @foreach($this->perPageOptions as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Page Info + Navigation --}}
                <div class="flex items-center gap-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ ($activities->currentPage() - 1) * $activities->perPage() + 1 }}–{{ min($activities->currentPage() * $activities->perPage(), $activities->total()) }} dari {{ $activities->total() }}
                    </p>

                    <div class="flex items-center gap-1">
                        {{-- Previous --}}
                        <button
                            wire:click="previousPage"
                            @if($activities->onFirstPage()) disabled @endif
                            class="fi-pagination-previous-btn relative inline-flex items-center justify-center rounded-lg h-8 w-8 text-sm outline-none transition duration-75 focus-visible:ring-2 focus-visible:ring-primary-500 {{ $activities->onFirstPage() ? 'text-gray-300 dark:text-gray-600 cursor-not-allowed' : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-white/5' }}"
                        >
                            <x-heroicon-m-chevron-left class="w-5 h-5" />
                        </button>

                        {{-- Page Numbers --}}
                        @php
                            $currentPage = $activities->currentPage();
                            $lastPage = $activities->lastPage();
                            $pages = [];

                            if ($lastPage <= 7) {
                                $pages = range(1, $lastPage);
                            } else {
                                $pages[] = 1;
                                if ($currentPage > 3) $pages[] = '...';
                                for ($i = max(2, $currentPage - 1); $i <= min($lastPage - 1, $currentPage + 1); $i++) {
                                    $pages[] = $i;
                                }
                                if ($currentPage < $lastPage - 2) $pages[] = '...';
                                $pages[] = $lastPage;
                            }
                        @endphp

                        @foreach($pages as $p)
                            @if($p === '...')
                                <span class="inline-flex items-center justify-center h-8 w-8 text-sm text-gray-400 dark:text-gray-500">…</span>
                            @elseif($p == $currentPage)
                                <button class="fi-pagination-item relative inline-flex items-center justify-center rounded-lg h-8 min-w-[2rem] px-1.5 text-sm font-medium outline-none transition duration-75 bg-primary-50 text-primary-600 ring-1 ring-primary-600/10 dark:bg-primary-400/10 dark:text-primary-400 dark:ring-primary-400/30 focus-visible:ring-2 focus-visible:ring-primary-500">
                                    {{ $p }}
                                </button>
                            @else
                                <button wire:click="gotoPage({{ $p }})" class="fi-pagination-item relative inline-flex items-center justify-center rounded-lg h-8 min-w-[2rem] px-1.5 text-sm font-medium outline-none transition duration-75 text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-white/5 focus-visible:ring-2 focus-visible:ring-primary-500">
                                    {{ $p }}
                                </button>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        <button
                            wire:click="nextPage"
                            @if(!$activities->hasMorePages()) disabled @endif
                            class="fi-pagination-next-btn relative inline-flex items-center justify-center rounded-lg h-8 w-8 text-sm outline-none transition duration-75 focus-visible:ring-2 focus-visible:ring-primary-500 {{ !$activities->hasMorePages() ? 'text-gray-300 dark:text-gray-600 cursor-not-allowed' : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-white/5' }}"
                        >
                            <x-heroicon-m-chevron-right class="w-5 h-5" />
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
