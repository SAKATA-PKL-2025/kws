<?php

namespace App\Filament\Widgets;

use App\Models\FamilyMember;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;

class RecentMembersWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Anggota Keluarga Terbaru';

    protected static ?string $pollingInterval = null;

    protected function paginateTableQuery(Builder $query): Paginator | CursorPaginator
    {
        return $query->paginate(
            perPage: ($this->getTableRecordsPerPage() === 'all') ? $query->count() : $this->getTableRecordsPerPage(),
            pageName: $this->getTablePaginationPageName(),
        );
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                FamilyMember::query()
                    ->where('status', 'approved')
                    ->latest()
            )
            ->columns([
                Tables\Columns\ImageColumn::make('profile_photo')
                    ->label('')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl(fn($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->full_name) . '&color=7F9CF5&background=EBF4FF'),
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Nama Lengkap')
                    ->weight('bold')
                    ->description(fn(FamilyMember $record): string => $record->nickname ? '"' . $record->nickname . '"' : ''),
                Tables\Columns\TextColumn::make('gender')
                    ->label('Gender')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => $state === 'male' ? 'L' : 'P')
                    ->color(fn(string $state): string => $state === 'male' ? 'info' : 'danger'),
                Tables\Columns\TextColumn::make('generation')
                    ->label('Generasi')
                    ->badge()
                    ->formatStateUsing(fn(?int $state): string => $state ? 'Gen. ' . $state : '-')
                    ->color('success'),
                Tables\Columns\TextColumn::make('birth_date')
                    ->label('Lahir')
                    ->date('d M Y')
                    ->color('gray'),
                Tables\Columns\IconColumn::make('is_alive')
                    ->label('Hidup')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ditambahkan')
                    ->since()
                    ->color('gray'),
            ])
            ->emptyStateHeading('Belum ada anggota')
            ->emptyStateDescription('Mulai tambahkan anggota keluarga.')
            ->emptyStateIcon('heroicon-o-user-plus')
            ->paginated([10, 25, 50, 100])
            ->defaultPaginationPageOption(10);
    }
}
