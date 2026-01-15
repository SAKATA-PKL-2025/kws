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
    $data['status'] = 'approved'; // Auto approve for admins
    $data['approved_by'] = Auth::id();
    $data['approved_at'] = now();

    return $data;
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
