<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Family\FamilyPhotoResource;
use App\Models\FamilyPhoto;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class PendingPhotosWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Foto Menunggu Persetujuan';

    public static function canView(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return $user->hasRole('Super Admin') && FamilyPhoto::where('status', 'pending')->exists();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                FamilyPhoto::query()
                    ->where('status', 'pending')
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\ImageColumn::make('photo_path')
                    ->label('Foto')
                    ->disk('public')
                    ->size(50)
                    ->square(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->weight('bold')
                    ->limit(30),
                Tables\Columns\TextColumn::make('location')
                    ->label('Lokasi')
                    ->icon('heroicon-m-map-pin')
                    ->color('gray')
                    ->limit(20),
                Tables\Columns\TextColumn::make('uploader.name')
                    ->label('Diupload oleh')
                    ->color('gray'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->since()
                    ->color('gray'),
            ])
            ->actions([
                Tables\Actions\Action::make('review')
                    ->label('Review')
                    ->icon('heroicon-o-eye')
                    ->color('warning')
                    ->url(fn(FamilyPhoto $record): string => FamilyPhotoResource::getUrl('view', ['record' => $record])),
            ])
            ->emptyStateHeading('Tidak ada foto menunggu')
            ->emptyStateDescription('Semua foto sudah diproses.')
            ->emptyStateIcon('heroicon-o-photo')
            ->paginated(false);
    }
}
