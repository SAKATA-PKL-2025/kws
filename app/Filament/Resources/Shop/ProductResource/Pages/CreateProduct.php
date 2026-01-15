<?php

namespace App\Filament\Resources\Shop\ProductResource\Pages;

use App\Filament\Resources\Shop\ProductResource;
use App\Models\Product;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['author_id'] = auth()->user()->id;
        $data['status'] = Product::ACTIVE;
        $data['publish_date'] = now();
        $data['stock_status'] = $data['stock_status'] ? Product::STATUS_IN_STOCK : Product::STATUS_OUT_OF_STOCK;

        return $data;
    }
}
