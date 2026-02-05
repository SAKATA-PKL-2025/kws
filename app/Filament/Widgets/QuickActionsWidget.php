<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Family\FamilyMemberResource;
use App\Filament\Resources\Family\FamilyPhotoResource;
use App\Filament\Resources\Admin\UserResource;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class QuickActionsWidget extends Widget
{
    protected static string $view = 'filament.widgets.quick-actions';

    protected static ?int $sort = 0;

    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $isSuperAdmin = $user->hasRole('Super Admin');

        $actions = [
            [
                'label' => 'Tambah Anggota',
                'description' => 'Daftarkan anggota keluarga baru',
                'icon' => 'heroicon-o-user-plus',
                'url' => FamilyMemberResource::getUrl('create'),
                'color' => 'primary',
            ],
            [
                'label' => 'Upload Foto',
                'description' => 'Tambah foto ke album keluarga',
                'icon' => 'heroicon-o-photo',
                'url' => FamilyPhotoResource::getUrl('create'),
                'color' => 'success',
            ],
            [
                'label' => 'Lihat Pohon Keluarga',
                'description' => 'Buka halaman silsilah publik',
                'icon' => 'heroicon-o-presentation-chart-line',
                'url' => route('home'),
                'color' => 'info',
                'external' => true,
            ],
        ];

        if ($isSuperAdmin) {
            $actions[] = [
                'label' => 'Kelola Pengguna',
                'description' => 'Atur akses admin',
                'icon' => 'heroicon-o-users',
                'url' => UserResource::getUrl('index'),
                'color' => 'warning',
            ];
        }

        return [
            'actions' => $actions,
            'userName' => $user->name,
            'greeting' => $this->getGreeting(),
        ];
    }

    private function getGreeting(): string
    {
        $hour = now()->hour;

        if ($hour < 12) {
            return 'Selamat Pagi';
        } elseif ($hour < 15) {
            return 'Selamat Siang';
        } elseif ($hour < 18) {
            return 'Selamat Sore';
        } else {
            return 'Selamat Malam';
        }
    }
}
