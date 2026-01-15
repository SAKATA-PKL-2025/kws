<?php

namespace App\Filament\Resources\Family;

use App\Filament\Resources\Family\FamilyMemberResource\Pages;
use App\Filament\Resources\Family\FamilyMemberResource\RelationManagers;
use App\Models\FamilyMember;
use App\Models\FamilyBranch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class FamilyMemberResource extends Resource
{
    protected static ?string $model = FamilyMember::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Manajemen Keluarga';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Anggota Keluarga';

    protected static ?string $modelLabel = 'Anggota Keluarga';

    protected static ?string $pluralModelLabel = 'Anggota Keluarga';

    public static function form(Form $form): Form
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $isSuperAdmin = $user->hasRole('Super Admin');
        $adminBranch = $isSuperAdmin ? null : FamilyBranch::where('admin_id', $user->id)->first();

        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dasar')
                    ->schema([
                        Forms\Components\TextInput::make('full_name')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Lengkap'),
                        Forms\Components\TextInput::make('nickname')
                            ->maxLength(255)
                            ->label('Nama Panggilan'),
                        Forms\Components\Select::make('gender')
                            ->required()
                            ->options([
                                'male' => 'Laki-laki',
                                'female' => 'Perempuan',
                            ])
                            ->label('Jenis Kelamin'),
                        Forms\Components\Toggle::make('is_alive')
                            ->label('Masih Hidup')
                            ->default(true)
                            ->reactive(),
                    ])->columns(2),

                Forms\Components\Section::make('Informasi Kelahiran & Kematian')
                    ->schema([
                        Forms\Components\DatePicker::make('birth_date')
                            ->label('Tanggal Lahir')
                            ->displayFormat('d/m/Y'),
                        Forms\Components\TextInput::make('birth_place')
                            ->maxLength(255)
                            ->label('Tempat Lahir'),
                        Forms\Components\DatePicker::make('death_date')
                            ->label('Tanggal Wafat')
                            ->displayFormat('d/m/Y')
                            ->visible(fn(Forms\Get $get) => !$get('is_alive')),
                        Forms\Components\TextInput::make('death_place')
                            ->maxLength(255)
                            ->label('Tempat Wafat')
                            ->visible(fn(Forms\Get $get) => !$get('is_alive')),
                    ])->columns(2),

                Forms\Components\Section::make('Cabang & Relasi Keluarga')
                    ->schema([
                        Forms\Components\Select::make('family_branch_id')
                            ->label('Cabang Keluarga')
                            ->relationship('branch', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->default($adminBranch?->id)
                            ->disabled(!$isSuperAdmin),
                        Forms\Components\Select::make('father_id')
                            ->label('Ayah')
                            ->relationship('father', 'full_name', fn(Builder $query) => $query->where('gender', 'male'))
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('mother_id')
                            ->label('Ibu')
                            ->relationship('mother', 'full_name', fn(Builder $query) => $query->where('gender', 'female'))
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('generation')
                            ->required()
                            ->numeric()
                            ->default(1)
                            ->label('Generasi Ke-'),
                        Forms\Components\TextInput::make('child_order')
                            ->numeric()
                            ->label('Anak Ke-'),
                    ])->columns(2),

                Forms\Components\Section::make('Status Pernikahan')
                    ->schema([
                        Forms\Components\Select::make('marital_status')
                            ->required()
                            ->options([
                                'single' => 'Belum Menikah',
                                'married' => 'Menikah',
                                'divorced' => 'Cerai',
                                'widowed' => 'Janda/Duda',
                            ])
                            ->default('single')
                            ->label('Status Pernikahan')
                            ->reactive(),
                        Forms\Components\Select::make('spouse_id')
                            ->label('Pasangan')
                            ->relationship('spouse', 'full_name')
                            ->searchable()
                            ->preload()
                            ->visible(fn(Forms\Get $get) => in_array($get('marital_status'), ['married', 'widowed'])),
                        Forms\Components\DatePicker::make('marriage_date')
                            ->label('Tanggal Menikah')
                            ->displayFormat('d/m/Y')
                            ->visible(fn(Forms\Get $get) => in_array($get('marital_status'), ['married', 'divorced', 'widowed'])),
                    ])->columns(2),

                Forms\Components\Section::make('Kontak & Domisili')
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(255)
                            ->label('No. Telepon'),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255)
                            ->label('Email'),
                        Forms\Components\TextInput::make('occupation')
                            ->maxLength(255)
                            ->label('Pekerjaan'),
                        Forms\Components\Textarea::make('address')
                            ->label('Alamat')
                            ->rows(2),
                        Forms\Components\TextInput::make('city')
                            ->maxLength(255)
                            ->label('Kota'),
                        Forms\Components\TextInput::make('province')
                            ->maxLength(255)
                            ->label('Provinsi'),
                    ])->columns(2),

                Forms\Components\Section::make('Foto & Biografi')
                    ->schema([
                        Forms\Components\FileUpload::make('profile_photo')
                            ->image()
                            ->directory('family-members')
                            ->label('Foto Profil'),
                        Forms\Components\Textarea::make('biography')
                            ->label('Biografi')
                            ->rows(3)
                            ->helperText('Cerita singkat tentang anggota keluarga ini'),
                    ])->columns(1),

                Forms\Components\Section::make('Pengaturan Lainnya')
                    ->schema([
                        Forms\Components\Toggle::make('is_public')
                            ->label('Tampilkan di Website Publik')
                            ->default(true)
                            ->helperText('Jika dinonaktifkan, data tidak akan ditampilkan di website publik'),
                        Forms\Components\Toggle::make('is_founder')
                            ->label('Pendiri/Founder Keluarga')
                            ->default(false)
                            ->visible($isSuperAdmin),
                    ])->columns(2)
                    ->visible($isSuperAdmin),
            ]);
    }

    public static function table(Table $table): Table
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $isSuperAdmin = $user->hasRole('Super Admin');

        return $table
            ->modifyQueryUsing(function (Builder $query) use ($user, $isSuperAdmin) {
                // Super Admin bisa lihat semua
                if ($isSuperAdmin) {
                    return $query;
                }

                // Admin Keluarga hanya lihat anggota di cabangnya
                $adminBranch = FamilyBranch::where('admin_id', $user->id)->first();
                if ($adminBranch) {
                    return $query->where('family_branch_id', $adminBranch->id);
                }

                // Fallback: jangan tampilkan apa-apa
                return $query->whereRaw('1 = 0');
            })
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Lengkap')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('nickname')
                    ->searchable()
                    ->label('Panggilan'),
                Tables\Columns\TextColumn::make('gender')
                    ->label('Jenis Kelamin')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'male' => 'info',
                        'female' => 'danger',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'male' => 'L',
                        'female' => 'P',
                    }),
                Tables\Columns\TextColumn::make('branch.name')
                    ->label('Cabang')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('generation')
                    ->numeric()
                    ->sortable()
                    ->label('Gen.')
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('birth_date')
                    ->date('d/m/Y')
                    ->sortable()
                    ->label('Tgl Lahir')
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_alive')
                    ->boolean()
                    ->label('Hidup')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    }),
                Tables\Columns\TextColumn::make('submitter.name')
                    ->label('Diajukan Oleh')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('approved_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->label('Tgl Disetujui')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->label('Dibuat')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('family_branch_id')
                    ->relationship('branch', 'name')
                    ->label('Filter Cabang')
                    ->preload()
                    ->visible($isSuperAdmin),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    ])
                    ->label('Filter Status'),
                Tables\Filters\TernaryFilter::make('is_alive')
                    ->label('Status Hidup')
                    ->placeholder('Semua')
                    ->trueLabel('Masih Hidup')
                    ->falseLabel('Sudah Wafat'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('approve')
                        ->label('Setujui')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn(FamilyMember $record) => $isSuperAdmin && $record->status === 'pending')
                        ->action(function (FamilyMember $record) {
                            $record->update([
                                'status' => 'approved',
                                'approved_by' => Auth::id(),
                                'approved_at' => now(),
                            ]);

                            Notification::make()
                                ->success()
                                ->title('Anggota Keluarga Disetujui')
                                ->body("Anggota {$record->full_name} telah disetujui.")
                                ->send();
                        }),
                    Tables\Actions\Action::make('reject')
                        ->label('Tolak')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->form([
                            Forms\Components\Textarea::make('rejection_reason')
                                ->label('Alasan Penolakan')
                                ->required()
                                ->rows(3),
                        ])
                        ->visible(fn(FamilyMember $record) => $isSuperAdmin && $record->status === 'pending')
                        ->action(function (FamilyMember $record, array $data) {
                            $record->update([
                                'status' => 'rejected',
                                'rejection_reason' => $data['rejection_reason'],
                                'approved_by' => Auth::id(),
                            ]);

                            Notification::make()
                                ->warning()
                                ->title('Anggota Keluarga Ditolak')
                                ->body("Anggota {$record->full_name} telah ditolak.")
                                ->send();
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
            'index' => Pages\ListFamilyMembers::route('/'),
            'create' => Pages\CreateFamilyMember::route('/create'),
            'view' => Pages\ViewFamilyMember::route('/{record}'),
            'edit' => Pages\EditFamilyMember::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->hasRole('Super Admin')) {
            // Super Admin lihat jumlah pending
            return static::getModel()::where('status', 'pending')->count() ?: null;
        }

        // Admin Keluarga lihat total anggota di cabangnya
        $adminBranch = FamilyBranch::where('admin_id', $user->id)->first();
        if ($adminBranch) {
            return static::getModel()::where('family_branch_id', $adminBranch->id)->count() ?: null;
        }

        return null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->hasRole('Super Admin')) {
            $pendingCount = static::getModel()::where('status', 'pending')->count();
            return $pendingCount > 0 ? 'warning' : null;
        }

        return 'success';
    }
}
