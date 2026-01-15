<?php

namespace App\Filament\Resources\Family\FamilyPhotoResource\Pages;

use App\Filament\Resources\Family\FamilyPhotoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFamilyPhotos extends ListRecords
{
  protected static string $resource = FamilyPhotoResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }
}
