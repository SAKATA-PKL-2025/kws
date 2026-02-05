<?php

namespace App\Filament\Resources\Family\FamilyMemberResource\Pages;

use App\Filament\Resources\Family\FamilyMemberResource;
use App\Models\FamilyMember;
use App\Models\FamilyBranch;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class CreateFamilyMember extends CreateRecord
{
    protected static string $resource = FamilyMemberResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Auto-set branch for non-super admins
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->hasRole('Super Admin')) {
            $adminBranch = FamilyBranch::where('admin_id', $user->id)->first();
            if ($adminBranch) {
                $data['family_branch_id'] = $adminBranch->id;
            }
        }

        return $data;
    }

    protected function beforeCreate(): void
    {
        // Validate if parent is married ONLY when parent is specified
        if (empty($this->data['father_id']) && empty($this->data['mother_id'])) {
            // No parents specified, no validation needed
            return;
        }

        // If parent is specified, validate they are married
        if (!empty($this->data['father_id'])) {
            $father = FamilyMember::find($this->data['father_id']);
            if ($father && !in_array($father->marital_status, ['married', 'widowed'])) {
                Notification::make()
                    ->danger()
                    ->title('Validasi Gagal')
                    ->body("Ayah yang dipilih ({$father->full_name}) belum menikah. Tidak dapat menambahkan anak untuk orang yang belum menikah.")
                    ->persistent()
                    ->send();

                $this->halt();
            }
        }

        if (!empty($this->data['mother_id'])) {
            $mother = FamilyMember::find($this->data['mother_id']);
            if ($mother && !in_array($mother->marital_status, ['married', 'widowed'])) {
                Notification::make()
                    ->danger()
                    ->title('Validasi Gagal')
                    ->body("Ibu yang dipilih ({$mother->full_name}) belum menikah. Tidak dapat menambahkan anak untuk orang yang belum menikah.")
                    ->persistent()
                    ->send();

                $this->halt();
            }
        }
    }
}
