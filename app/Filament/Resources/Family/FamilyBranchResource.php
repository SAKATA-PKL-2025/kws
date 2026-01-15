<?php

namespace App\Filament\Resources\Family;

use App\Filament\Resources\Family\FamilyBranchResource\Pages;
use App\Filament\Resources\Family\FamilyBranchResource\RelationManagers;
use App\Models\FamilyBranch;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FamilyBranchResource extends Resource
{
    protected static ?string $model = FamilyBranch::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?string $navigationGroup = 'Manajemen Keluarga';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Cabang Keluarga';

    protected static ?string $modelLabel = 'Cabang Keluarga';

    protected static ?string $pluralModelLabel = 'Cabang Keluarga';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Cabang')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Cabang')
                            ->helperText('Contoh: Cabang Keturunan Anak Pertama'),
                        Forms\Components\TextInput::make('founder_name')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Pendiri')
                            ->helperText('Nama pendiri cabang ini'),
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Lokasi & Pengaturan')
                    ->schema([
                        Forms\Components\TextInput::make('location')
                            ->maxLength(255)
                            ->label('Lokasi Utama')
                            ->helperText('Lokasi geografis utama cabang ini'),
                        Forms\Components\TextInput::make('generation')
                            ->required()
                            ->numeric()
                            ->default(1)
                            ->label('Tingkat Generasi')
                            ->helperText('Generasi keberapa dari founder utama'),
                        Forms\Components\ColorPicker::make('color_code')
                            ->label('Warna Cabang')
                            ->default('#3B82F6')
                            ->helperText('Untuk visualisasi pohon keluarga'),
                    ])->columns(3),

                Forms\Components\Section::make('Administrasi')
                    ->schema([
                        Forms\Components\Select::make('admin_id')
                            ->label('Admin Cabang')
                            ->options(User::role('Admin Keluarga')->pluck('name', 'id'))
                            ->searchable()
                            ->helperText('Admin yang bertanggung jawab untuk cabang ini'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true)
                            ->helperText('Non-aktifkan jika cabang tidak lagi aktif'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Cabang')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('founder_name')
                    ->searchable()
                    ->sortable()
                    ->label('Pendiri'),
                Tables\Columns\ColorColumn::make('color_code')
                    ->label('Warna'),
                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->label('Lokasi')
                    ->icon('heroicon-m-map-pin'),
                Tables\Columns\TextColumn::make('generation')
                    ->numeric()
                    ->sortable()
                    ->label('Gen.')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('admin.name')
                    ->searchable()
                    ->label('Admin Cabang')
                    ->default('—'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Aktif')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('members_count')
                    ->numeric()
                    ->sortable()
                    ->label('Anggota')
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->label('Dibuat')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->placeholder('Semua cabang')
                    ->trueLabel('Hanya yang aktif')
                    ->falseLabel('Hanya yang non-aktif'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->size('sm')
                    ->color('gray')
                    ->button()
                    ->label('')
                    ->tooltip('Tindakan')
                    ->dropdownPlacement('bottom-end')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFamilyBranches::route('/'),
            'create' => Pages\CreateFamilyBranch::route('/create'),
            'edit' => Pages\EditFamilyBranch::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_active', true)->count();
    }
}
