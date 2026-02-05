<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Family\FamilyMemberResource;
use App\Filament\Resources\Family\FamilyPhotoResource;
use App\Models\FamilyMember;
use App\Models\FamilyPhoto;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class PendingApprovalsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Menunggu Persetujuan';

    public static function canView(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return $user->hasRole('Super Admin');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                FamilyMember::query()
                    ->where('status', 'pending')
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\ImageColumn::make('profile_photo')
                    ->label('')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl(fn($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->full_name) . '&color=7F9CF5&background=EBF4FF'),
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Nama')
                    ->weight('bold')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->label('Gender')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => $state === 'male' ? 'Laki-laki' : 'Perempuan')
                    ->color(fn(string $state): string => $state === 'male' ? 'info' : 'danger'),
                Tables\Columns\TextColumn::make('generation')
                    ->label('Generasi')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diajukan')
                    ->since()
                    ->color('gray'),
            ])
            ->actions([
                Tables\Actions\Action::make('review')
                    ->label('Review')
                    ->icon('heroicon-o-eye')
                    ->color('warning')
                    ->url(fn(FamilyMember $record): string => FamilyMemberResource::getUrl('view', ['record' => $record])),
            ])
            ->emptyStateHeading('Tidak ada yang menunggu')
            ->emptyStateDescription('Semua pengajuan anggota baru sudah diproses.')
            ->emptyStateIcon('heroicon-o-check-circle')
            ->paginated(false);
    }
}
