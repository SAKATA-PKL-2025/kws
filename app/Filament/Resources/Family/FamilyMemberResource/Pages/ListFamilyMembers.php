<?php

namespace App\Filament\Resources\Family\FamilyMemberResource\Pages;

use App\Filament\Resources\Family\FamilyMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFamilyMembers extends ListRecords
{
    protected static string $resource = FamilyMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
