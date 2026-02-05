<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex-shrink-0">
                <h2 class="text-xl font-bold text-gray-950 dark:text-white">{{ $greeting }}, {{ $userName }}!</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Selamat datang di panel admin Silsilah Keluarga</p>
            </div>
            <div class="flex flex-wrap gap-3 ml-auto">
                @foreach($actions as $action)
                <a href="{{ $action['url'] }}" 
                   @if(isset($action['external']) && $action['external']) target="_blank" @endif
                   class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-sm">
                    {{ $action['label'] }}
                </a>
                @endforeach
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
