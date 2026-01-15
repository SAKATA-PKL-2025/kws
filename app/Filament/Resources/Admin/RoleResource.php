<?php

namespace App\Filament\Resources\Admin;

use App\Filament\Resources\Admin\RoleResource\Pages;
use App\Filament\Resources\Admin\RoleResource\RelationManagers;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'Pengaturan';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Peran & Hak Akses';

    protected static ?string $modelLabel = 'Peran';

    protected static ?string $pluralModelLabel = 'Peran';

    public static function canViewAny(): bool
    {
        // Hanya Super Admin yang bisa akses menu Peran & Hak Akses
        /** @var \App\Models\User $user */
        $user = auth()->user();
        return $user->hasRole('Super Admin');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Peran')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->label('Nama Peran')
                            ->helperText('Contoh: Super Admin, Admin Keluarga'),
                        Forms\Components\TextInput::make('guard_name')
                            ->default('web')
                            ->required()
                            ->maxLength(255)
                            ->label('Guard Name')
                            ->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('Hak Akses')
                    ->schema([
                        Forms\Components\CheckboxList::make('permissions')
                            ->relationship('permissions', 'name')
                            ->columns(3)
                            ->searchable()
                            ->bulkToggleable()
                            ->label('Tentukan Hak Akses')
                            ->helperText('Pilih hak akses untuk peran ini'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Peran')
                    ->badge()
                    ->colors([
                        'danger' => 'Super Admin',
                        'warning' => 'Admin Keluarga',
                        'success' => 'Pengunjung',
                    ]),
                Tables\Columns\TextColumn::make('permissions_count')
                    ->counts('permissions')
                    ->label('Hak Akses')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('users_count')
                    ->counts('users')
                    ->label('Pengguna')
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->label('Dibuat')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                        ->visible(fn(Role $record): bool => !in_array($record->name, ['Super Admin', 'Admin Keluarga'])),
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
            ->defaultSort('name', 'asc');
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
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
