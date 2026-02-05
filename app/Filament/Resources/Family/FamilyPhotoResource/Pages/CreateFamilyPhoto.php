<?php

namespace App\Filament\Resources\Family\FamilyPhotoResource\Pages;

use App\Filament\Resources\Family\FamilyPhotoResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateFamilyPhoto extends CreateRecord
{
  protected static string $resource = FamilyPhotoResource::class;

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $data['uploaded_by'] = Auth::id();
    
    // Super Admin: auto approve
    // Admin Keluarga: pending, butuh approval
    /** @var \App\Models\User $user */
    $user = Auth::user();

    if ($user->hasRole('Super Admin')) {
      $data['status'] = 'approved';
      $data['approved_by'] = Auth::id();
      $data['approved_at'] = now();
    } else {
      $data['status'] = 'pending';
      $data['approved_by'] = null;
      $data['approved_at'] = null;
    }

    // Set is_public default to true if not set (for non-Super Admin)
    if (!isset($data['is_public'])) {
      $data['is_public'] = true;
    }

    return $data;
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
