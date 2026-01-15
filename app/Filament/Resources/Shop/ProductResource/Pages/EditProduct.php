<?php

namespace App\Filament\Resources\Shop\ProductResource\Pages;

use App\Filament\Resources\Shop\ProductResource;
use App\Models\Product;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data["stock_status"] = $data["stock_status"] == Product::STATUS_IN_STOCK ? true : false;

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data["stock_status"] = $data["stock_status"] ? Product::STATUS_IN_STOCK : Product::STATUS_OUT_OF_STOCK;

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
