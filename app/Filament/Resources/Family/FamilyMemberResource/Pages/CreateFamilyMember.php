<?php

namespace App\Filament\Resources\Family\FamilyMemberResource\Pages;

use App\Filament\Resources\Family\FamilyMemberResource;
use App\Models\FamilyMember;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class CreateFamilyMember extends CreateRecord
{
    protected static string $resource = FamilyMemberResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
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

        if (!empty($data['is_twin']) && empty($data['twin_count'])) {
            $data['twin_count'] = 2;
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        $state = $this->form->getState();
        if (empty($state['is_twin'])) {
            return;
        }

        if ($this->record && empty($this->record->twin_order)) {
            $this->record->update(['twin_order' => 1]);
        }

        $additionalTwins = $state['additional_twins'] ?? [];
        foreach ($additionalTwins as $index => $twinData) {
            $order = $index + 2;
            $fullName = $twinData['full_name'] ?? null;
            if (!$fullName) {
                continue;
            }

            FamilyMember::create([
                'full_name' => $fullName,
                'nickname' => $twinData['nickname'] ?? null,
                'gender' => $twinData['gender'] ?? ($state['gender'] ?? null),
                'birth_date' => $twinData['birth_date'] ?? ($state['birth_date'] ?? null),
                'birth_place' => $twinData['birth_place'] ?? ($state['birth_place'] ?? null),
                'death_date' => null,
                'death_place' => null,
                'is_alive' => $state['is_alive'] ?? true,
                'father_id' => $this->record?->father_id,
                'mother_id' => $this->record?->mother_id,
                'spouse_id' => null,
                'spouse_is_external' => false,
                'spouse_name' => null,
                'generation' => $this->record?->generation,
                'child_order' => $this->record?->child_order,
                'is_twin' => true,
                'twin_order' => $order,
                'marital_status' => 'single',
                'status' => $this->record?->status,
                'rejection_reason' => null,
                'submitted_by' => $this->record?->submitted_by,
                'approved_by' => $this->record?->approved_by,
                'approved_at' => $this->record?->approved_at,
                'is_public' => $this->record?->is_public,
                'is_founder' => false,
                'created_by' => $this->record?->created_by,
            ]);
        }
    }

    protected function beforeCreate(): void
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
