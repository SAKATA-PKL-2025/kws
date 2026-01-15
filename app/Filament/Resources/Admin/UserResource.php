<?php

namespace App\Filament\Resources\Admin;

use App\Filament\Resources\Admin\UserResource\Pages;
use App\Filament\Resources\Admin\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'Users';

    public static function canViewAny(): bool
    {
        // Hanya Super Admin yang bisa akses menu Users
        /** @var \App\Models\User $user */
        $user = auth()->user();
        return $user->hasRole('Super Admin');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('User Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Full Name'),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->label('Email Address'),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->required(fn(string $context): bool => $context === 'create')
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => filled($state))
                            ->maxLength(255)
                            ->label('Password')
                            ->helperText('Leave blank to keep current password'),
                        Forms\Components\DateTimePicker::make('email_verified_at')
                            ->label('Email Verified At')
                            ->default(now()),
                    ])->columns(2),

                Forms\Components\Section::make('Role & Permissions')
                    ->schema([
                        Forms\Components\Select::make('roles')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->required()
                            ->label('Roles')
                            ->helperText('Select one or more roles for this user'),
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
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->label('Email')
                    ->icon('heroicon-m-envelope'),
                Tables\Columns\TextColumn::make('roles.name')
                    ->badge()
                    ->colors([
                        'danger' => 'Super Admin',
                        'warning' => 'Admin Keluarga',
                        'success' => 'Pengunjung',
                    ])
                    ->label('Peran'),
                Tables\Columns\IconColumn::make('email_verified_at')
                    ->boolean()
                    ->label('Terverifikasi')
                    ->sortable()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->label('Dibuat')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->label('Diperbarui')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('roles')
                    ->relationship('roles', 'name')
                    ->label('Filter Berdasarkan Peran')
                    ->multiple()
                    ->preload(),
                Tables\Filters\Filter::make('verified')
                    ->query(fn(Builder $query): Builder => $query->whereNotNull('email_verified_at'))
                    ->label('Hanya Terverifikasi'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('reset_password')
                        ->label('Reset Password')
                        ->icon('heroicon-o-key')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->modalHeading('Reset Password User')
                        ->modalDescription('Password baru akan di-generate secara otomatis. Pastikan Anda mencatat password baru dan memberikannya kepada user.')
                        ->modalSubmitActionLabel('Reset Password')
                        ->visible(fn(User $record): bool => !$record->hasRole('Super Admin'))
                        ->action(function (User $record) {
                            // Generate password baru yang mudah diingat
                            $kata = ['Keluarga', 'Silsilah', 'Cabang', 'Anggota', 'Pohon', 'Warisan', 'Generasi', 'Leluhur'];
                            $angka = rand(100, 999);
                            $tahun = date('Y');

                            $newPassword = $kata[array_rand($kata)] . $angka;
                            // Update password user
                            $record->update([
                                'password' => \Illuminate\Support\Facades\Hash::make($newPassword),
                            ]);

                            // Tampilkan notifikasi dengan password baru
                            \Filament\Notifications\Notification::make()
                                ->success()
                                ->title('Password Berhasil Direset!')
                                ->body("Nama: {$record->name}\nEmail: {$record->email}\n\nPASSWORD BARU: {$newPassword}\n\nCatat password ini dan berikan kepada user.")
                                ->persistent()
                                ->duration(null)
                                ->send();

                            // Juga kirim ke session untuk ditampilkan di modal
                            session()->flash('new_password', $newPassword);
                            session()->flash('user_name', $record->name);
                            session()->flash('user_email', $record->email);
                        })
                        ->after(function () {
                            // Redirect ke halaman yang sama untuk menampilkan modal dengan password
                            if (session()->has('new_password')) {
                                \Filament\Notifications\Notification::make()
                                    ->warning()
                                    ->title('SIMPAN PASSWORD INI!')
                                    ->body("User: " . session('user_name') . "\nEmail: " . session('user_email') . "\n\nPASSWORD BARU:\n" . session('new_password') . "\n\nPassword ini hanya ditampilkan sekali!")
                                    ->persistent()
                                    ->duration(null)
                                    ->send();
                            }
                        }),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
