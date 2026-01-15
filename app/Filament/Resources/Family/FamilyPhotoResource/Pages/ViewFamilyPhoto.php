<?php

namespace App\Filament\Resources\Family\FamilyPhotoResource\Pages;

use App\Filament\Resources\Family\FamilyPhotoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFamilyPhoto extends ViewRecord
{
  protected static string $resource = FamilyPhotoResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\EditAction::make(),
    ];
  }
}
