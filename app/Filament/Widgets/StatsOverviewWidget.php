<?php

namespace App\Filament\Widgets;

use App\Models\FamilyMember;
use App\Models\FamilyPhoto;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $isSuperAdmin = $user->hasRole('Super Admin');

        $totalMembers = FamilyMember::count();
        $pendingMembers = FamilyMember::where('status', 'pending')->count();
        $pendingPhotos = FamilyPhoto::where('status', 'pending')->count();
        $totalPhotos = FamilyPhoto::where('status', 'approved')->count();

        $stats = [
            Stat::make('Total Anggota Keluarga', $totalMembers)
                ->description('Seluruh anggota terdaftar')
                ->color('primary'),

            Stat::make('Generasi Tercatat', FamilyMember::max('generation') ?? 0)
                ->description('Dari leluhur hingga sekarang')
                ->color('success'),

            Stat::make('Foto Album', $totalPhotos)
                ->description('Foto yang sudah disetujui')
                ->color('info'),
        ];

        if ($isSuperAdmin) {
            $stats[] = Stat::make('Menunggu Persetujuan', $pendingMembers + $pendingPhotos)
                ->description($pendingMembers . ' anggota, ' . $pendingPhotos . ' foto')
                ->color($pendingMembers + $pendingPhotos > 0 ? 'warning' : 'success');
        }

        return $stats;
    }
}
