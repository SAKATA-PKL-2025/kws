<?php

namespace App\Filament\Resources\Family;

use App\Filament\Resources\Family\FamilyMemberResource\Pages;
use App\Filament\Resources\Family\FamilyMemberResource\RelationManagers;
use App\Models\FamilyMember;
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
                            ->placeholder('Pilih jenis kelamin')
                            ->selectablePlaceholder(false)
                            ->options([
                                'male' => 'Laki-laki',
                                'female' => 'Perempuan',
                            ])
                            ->label('Jenis Kelamin'),
                        Forms\Components\Toggle::make('is_twin')
                            ->label('Anak Kembar')
                            ->helperText('Aktifkan jika anak ini kembar')
                            ->reactive()
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if (!$state) {
                                    $set('twin_count', null);
                                    $set('additional_twins', []);
                                }
                            }),
                        Forms\Components\TextInput::make('twin_count')
                            ->numeric()
                            ->label('Jumlah Kembar')
                            ->minValue(2)
                            ->helperText('Isi jumlah anak kembar (minimal 2)')
                            ->visible(fn(Forms\Get $get) => $get('is_twin'))
                            ->required(fn(Forms\Get $get) => $get('is_twin'))
                            ->reactive()
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                $count = max(2, (int) $state);
                                $current = $get('additional_twins') ?? [];
                                $target = max(0, $count - 1);

                                if (count($current) < $target) {
                                    $current = array_pad($current, $target, []);
                                } elseif (count($current) > $target) {
                                    $current = array_slice($current, 0, $target);
                                }

                                $set('additional_twins', $current);
                            })
                            ->live(),
                        Forms\Components\Repeater::make('additional_twins')
                            ->label('Data Anak Kembar Lainnya')
                            ->schema([
                                Forms\Components\TextInput::make('full_name')
                                    ->label('Nama Lengkap')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('nickname')
                                    ->label('Nama Panggilan')
                                    ->maxLength(255),
                                Forms\Components\Select::make('gender')
                                    ->label('Jenis Kelamin')
                                    ->placeholder('Pilih jenis kelamin')
                                    ->selectablePlaceholder(false)
                                    ->options([
                                        'male' => 'Laki-laki',
                                        'female' => 'Perempuan',
                                    ]),
                            ])
                            ->columns(2)
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                $count = max(2, count($state) + 1);
                                $set('twin_count', $count);
                            })
                            ->visible(fn(Forms\Get $get) => $get('is_twin'))
                            ->dehydrated(false),
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

                Forms\Components\Section::make('Relasi Keluarga')
                    ->description('Isi data orang tua hanya jika anggota ini adalah anak dari pasangan yang sudah ada')
                    ->schema([
                        Forms\Components\TextInput::make('generation')
                            ->required()
                            ->numeric()
                            ->default(1)
                            ->label('Generasi Ke-')
                            ->minValue(1)
                            ->disabled(function () {
                                /** @var \App\Models\User|null $user */
                                $user = Auth::user();
                                return !$user?->hasRole('Super Admin');
                            })
                            ->dehydrated(),
                        Forms\Components\Placeholder::make('parent_info')
                            ->label('')
                            ->content('⚠️ Kosongkan field Ayah dan Ibu jika anggota ini adalah pendiri keluarga atau belum diketahui orang tuanya')
                            ->columnSpanFull(),
                        Forms\Components\Select::make('father_id')
                            ->label('Ayah (Opsional)')
                            ->relationship('father', 'full_name', fn(Builder $query) => $query->where('gender', 'male'))
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->helperText('Pilih ayah hanya jika sudah menikah')
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                if ($state) {
                                    $father = FamilyMember::find($state);

                                    // Check if father is married
                                    if ($father && !in_array($father->marital_status, ['married', 'widowed'])) {
                                        Notification::make()
                                            ->warning()
                                            ->title('Ayah Belum Menikah')
                                            ->body("Ayah yang dipilih ({$father->full_name}) belum menikah. Anda tidak dapat menambahkan anak untuk orang yang belum menikah.")
                                            ->persistent()
                                            ->send();

                                        $set('father_id', null);
                                        $set('mother_id', null);
                                        return;
                                    }

                                    if ($father && $father->spouse_id) {
                                        $set('mother_id', $father->spouse_id);
                                    }

                                    // Auto-suggest next child order
                                    self::suggestChildOrder($state, 'father', $set);
                                }

                                self::updateGenerationFromParents($set, $get);
                            }),
                        Forms\Components\Select::make('mother_id')
                            ->label('Ibu (Opsional)')
                            ->relationship('mother', 'full_name', fn(Builder $query) => $query->where('gender', 'female'))
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->helperText('Pilih ibu hanya jika sudah menikah')
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                if ($state) {
                                    $mother = FamilyMember::find($state);

                                    // Check if mother is married
                                    if ($mother && !in_array($mother->marital_status, ['married', 'widowed'])) {
                                        Notification::make()
                                            ->warning()
                                            ->title('Ibu Belum Menikah')
                                            ->body("Ibu yang dipilih ({$mother->full_name}) belum menikah. Anda tidak dapat menambahkan anak untuk orang yang belum menikah.")
                                            ->persistent()
                                            ->send();

                                        $set('mother_id', null);
                                        $set('father_id', null);
                                        return;
                                    }

                                    if ($mother && $mother->spouse_id) {
                                        $set('father_id', $mother->spouse_id);
                                    }

                                    // Auto-suggest next child order
                                    self::suggestChildOrder($state, 'mother', $set);
                                }

                                self::updateGenerationFromParents($set, $get);
                            }),
                        Forms\Components\TextInput::make('child_order')
                            ->numeric()
                            ->label('Anak Ke-')
                            ->minValue(1)
                            ->helperText('Urutan anak dari pasangan. Akan otomatis terisi berdasarkan jumlah anak yang sudah ada.')
                            ->live()
                            ->reactive()
                            ->dehydrated(true),
                    ])->columns(2),

                Forms\Components\Section::make('Status Pernikahan')
                    ->description('Isi status pernikahan dan pasangan. Anda tidak perlu langsung menambahkan anak - bisa dilakukan nanti.')
                    ->schema([
                        Forms\Components\Select::make('marital_status')
                            ->required()
                            ->placeholder('Pilih status pernikahan')
                            ->selectablePlaceholder(false)
                            ->options([
                                'single' => 'Belum Menikah',
                                'married' => 'Menikah',
                                'divorced' => 'Cerai',
                                'widowed' => 'Janda/Duda',
                            ])
                            ->default('single')
                            ->label('Status Pernikahan')
                            ->reactive()
                            ->live(),
                        Forms\Components\Placeholder::make('spouse_note')
                            ->label('')
                            ->content('ℹ️ Jika sudah menikah, data anak bisa ditambahkan nanti dengan membuat anggota baru dan memilih orang tua mereka')
                            ->visible(fn(Forms\Get $get) => $get('marital_status') === 'married')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('spouse_name')
                            ->label('Nama Pasangan')
                            ->maxLength(255)
                            ->helperText('Masukkan nama pasangan dari luar keluarga')
                            ->required(
                                fn(Forms\Get $get) =>
                                $get('marital_status') === 'married'
                            )
                            ->visible(fn(Forms\Get $get) => $get('marital_status') === 'married'),
                        Forms\Components\TextInput::make('former_spouse_name')
                            ->statePath('spouse_name')
                            ->label('Nama Mantan/Almarhum')
                            ->maxLength(255)
                            ->helperText('Masukkan nama mantan pasangan atau almarhum')
                            ->required(fn(Forms\Get $get) => in_array($get('marital_status'), ['divorced', 'widowed']))
                            ->visible(fn(Forms\Get $get) => in_array($get('marital_status'), ['divorced', 'widowed'])),
                        Forms\Components\TextInput::make('spouse_phone')
                            ->label('No. Telepon Pasangan')
                            ->numeric()
                            ->inputMode('numeric')
                            ->extraInputAttributes([
                                'pattern' => '[0-9]*',
                                'oninput' => "this.value = this.value.replace(/[^0-9]/g, '')",
                            ])
                            ->rule('regex:/^\d+$/')
                            ->validationMessages([
                                'regex' => 'No. Telepon hanya boleh angka.',
                            ])
                            ->maxLength(20)
                            ->visible(
                                fn(Forms\Get $get) =>
                                $get('marital_status') === 'married'
                            ),
                        Forms\Components\TextInput::make('spouse_email')
                            ->label('Email Pasangan')
                            ->email()
                            ->maxLength(255)
                            ->visible(
                                fn(Forms\Get $get) =>
                                $get('marital_status') === 'married'
                            ),
                        Forms\Components\TextInput::make('spouse_occupation')
                            ->label('Pekerjaan Pasangan')
                            ->maxLength(255)
                            ->visible(
                                fn(Forms\Get $get) =>
                                $get('marital_status') === 'married'
                            ),
                        Forms\Components\DatePicker::make('marriage_date')
                            ->label('Tanggal Menikah')
                            ->displayFormat('d/m/Y')
                            ->visible(fn(Forms\Get $get) => $get('marital_status') === 'married'),
                        Forms\Components\DatePicker::make('marital_end_date')
                            ->label('Tanggal Cerai/Wafat')
                            ->displayFormat('d/m/Y')
                            ->visible(fn(Forms\Get $get) => in_array($get('marital_status'), ['divorced', 'widowed'])),
                        Forms\Components\Textarea::make('marital_end_note')
                            ->label('Catatan Status')
                            ->rows(3)
                            ->helperText('Catatan singkat terkait status cerai atau janda/duda')
                            ->visible(fn(Forms\Get $get) => in_array($get('marital_status'), ['divorced', 'widowed'])),
                    ])->columns(2),

                Forms\Components\Section::make('Kontak & Domisili')
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->numeric()
                            ->inputMode('numeric')
                            ->extraInputAttributes([
                                'pattern' => '[0-9]*',
                                'oninput' => "this.value = this.value.replace(/[^0-9]/g, '')",
                            ])
                            ->rule('regex:/^\d+$/')
                            ->validationMessages([
                                'regex' => 'No. Telepon hanya boleh angka.',
                            ])
                            ->maxLength(20)
                            ->label('No. Telepon'),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255)
                            ->label('Email'),
                        Forms\Components\TextInput::make('occupation')
                            ->maxLength(255)
                            ->label('Pekerjaan')
                            ->nullable(),
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
                            ->visible(function () {
                                /** @var \App\Models\User|null $user */
                                $user = Auth::user();
                                return $user?->hasRole('Super Admin') ?? false;
                            }),
                    ])->columns(2)
                    ->visible(function () {
                        /** @var \App\Models\User|null $user */
                        $user = Auth::user();
                        return $user?->hasRole('Super Admin') ?? false;
                    }),
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
                return $query;
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
                Tables\Columns\TextColumn::make('generation')
                    ->numeric()
                    ->sortable()
                    ->label('Gen.')
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('child_info')
                    ->label('Anak Ke-')
                    ->getStateUsing(function (FamilyMember $record): ?string {
                        if (!$record->child_order) {
                            return '-';
                        }
                        $info = $record->child_order;
                        if ($record->is_twin && $record->twin_order) {
                            $info .= ' (Kembar ' . $record->twin_order . ')';
                        }
                        return $info;
                    })
                    ->badge()
                    ->color(fn(FamilyMember $record) => $record->is_twin ? 'warning' : 'info')
                    ->toggleable(),
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
                Tables\Columns\TextColumn::make('marital_status')
                    ->label('Status Nikah')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'single' => 'Belum Menikah',
                        'married' => 'Menikah',
                        'divorced' => 'Cerai',
                        'widowed' => 'Janda/Duda',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'single' => 'gray',
                        'married' => 'success',
                        'divorced' => 'warning',
                        'widowed' => 'danger',
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('spouse_display')
                    ->label('Pasangan')
                    ->getStateUsing(function (FamilyMember $record): ?string {
                        return $record->spouse_name ?: '-';
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
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

    public static function resolveGeneration(?string $fatherId, ?string $motherId, bool $isFounder = false): int
    {
        if ($isFounder) {
            return 1;
        }

        $parentIds = array_filter([$fatherId, $motherId]);
        if (empty($parentIds)) {
            return 1;
        }

        $parentGeneration = FamilyMember::query()
            ->whereIn('id', $parentIds)
            ->max('generation');

        return $parentGeneration ? $parentGeneration + 1 : 1;
    }

    private static function updateGenerationFromParents(Forms\Set $set, Forms\Get $get): void
    {
        $generation = self::resolveGeneration(
            $get('father_id'),
            $get('mother_id'),
            (bool) $get('is_founder')
        );

        $set('generation', $generation);
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

    /**
     * Auto-suggest child order based on existing children
     */
    protected static function suggestChildOrder($parentId, $parentType, $set): void
    {
        if (!$parentId) {
            return;
        }

        $column = $parentType === 'father' ? 'father_id' : 'mother_id';

        // Count existing children
        $existingChildren = FamilyMember::where($column, $parentId)->count();

        // Suggest next order
        $nextOrder = $existingChildren + 1;

        $set('child_order', $nextOrder);

        // Show notification
        if ($existingChildren > 0) {
            Notification::make()
                ->info()
                ->title('Anak Ke-' . $nextOrder)
                ->body('Orang tua ini sudah memiliki ' . $existingChildren . ' anak. Anak baru akan menjadi anak ke-' . $nextOrder . '.')
                ->send();
        }
    }
}
