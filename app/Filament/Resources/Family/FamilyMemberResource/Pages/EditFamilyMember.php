<?php

namespace App\Filament\Resources\Family\FamilyMemberResource\Pages;

use App\Filament\Resources\Family\FamilyMemberResource;
use App\Models\FamilyMember;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditFamilyMember extends EditRecord
{
    protected static string $resource = FamilyMemberResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['generation'] = FamilyMemberResource::resolveGeneration(
            $data['father_id'] ?? null,
            $data['mother_id'] ?? null,
            (bool) ($data['is_founder'] ?? false)
        );

        if (in_array($data['marital_status'] ?? null, ['married', 'widowed'], true)) {
            $data['spouse_is_external'] = true;
            $data['spouse_id'] = null;
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function beforeSave(): void
    {
        $hasFather = !empty($this->data['father_id']);
        $hasMother = !empty($this->data['mother_id']);
        $isFounder = (bool) ($this->data['is_founder'] ?? false);

        if (!$isFounder && !$hasFather && !$hasMother) {
            Notification::make()
                ->danger()
                ->title('Orang Tua Wajib Diisi')
                ->body('Jika bukan pendiri, pilih minimal Ayah atau Ibu agar generasi bisa dihitung otomatis.')
                ->persistent()
                ->send();

            $this->halt();
        }

        // Validate if parent is married ONLY when parent is specified
        if (!$hasFather && !$hasMother) {
            // No parents specified (only valid for founder), no validation needed
            return;
        }

        // If parent is specified, validate they are married
        if ($hasFather) {
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

        if ($hasMother) {
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
