<?php

namespace App\Filament\Resources\Family\FamilyPhotoResource\Widgets;

use App\Models\FamilyPhoto;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class PendingPhotosInfoWidget extends Widget
{
    protected static string $view = 'filament.widgets.pending-photos-info';

    protected int | string | array $columnSpan = 'full';

    public function getData(): array
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->hasRole('Super Admin')) {
            return [
                'show' => false,
                'pendingCount' => 0,
            ];
        }

        return [
            'show' => false,
            'pendingCount' => 0,
        ];

        $pendingCount = FamilyPhoto::where('family_branch_id', $adminBranch->id)
            ->where('status', 'pending')
            ->count();

        return [
            'show' => $pendingCount > 0,
            'pendingCount' => $pendingCount,
        ];
    }
}
