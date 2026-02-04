<x-filament-widgets::widget>
    @php
        $data = $this->getData();
    @endphp

    @if($data['show'])
        <div class="bg-warning-50 dark:bg-warning-900/20 border-2 border-warning-400 dark:border-warning-600 rounded-xl p-4">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-warning-400 dark:bg-warning-600">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-base font-semibold text-warning-900 dark:text-warning-100">
                        Foto Menunggu Verifikasi
                    </h3>
                    <p class="mt-1 text-sm text-warning-700 dark:text-warning-300">
                        Anda memiliki <strong>{{ $data['pendingCount'] }}</strong> foto yang sedang menunggu verifikasi dari Super Admin. 
                        Foto akan ditampilkan di website publik setelah disetujui.
                    </p>
                    <div class="mt-3 flex items-center gap-2 text-xs text-warning-600 dark:text-warning-400">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                        <span>Foto dengan status "Menunggu Verifikasi" hanya dapat dilihat oleh Anda dan Super Admin</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-filament-widgets::widget>
