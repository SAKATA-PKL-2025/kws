<?php

namespace App\Filament\Resources\Family\FamilyPhotoResource\Pages;

use App\Filament\Resources\Family\FamilyPhotoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFamilyPhoto extends EditRecord
{
  protected static string $resource = FamilyPhotoResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\ViewAction::make(),
      Actions\DeleteAction::make(),
    ];
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
