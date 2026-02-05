<?php

namespace App\Filament\Resources\Family;

use App\Filament\Resources\Family\FamilyPhotoResource\Pages;
use App\Models\FamilyPhoto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FamilyPhotoResource extends Resource
{
  protected static ?string $model = FamilyPhoto::class;

  protected static ?string $navigationIcon = 'heroicon-o-photo';

  protected static ?string $navigationGroup = 'Manajemen Keluarga';

  protected static ?int $navigationSort = 3;

  protected static ?string $navigationLabel = 'Album Foto';

  protected static ?string $modelLabel = 'Foto Keluarga';

  protected static ?string $pluralModelLabel = 'Album Foto';

  public static function form(Form $form): Form
  {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    $isSuperAdmin = $user->hasRole('Super Admin');

    return $form
      ->schema([
        Forms\Components\Section::make('Informasi Foto')
          ->schema([
            Forms\Components\FileUpload::make('photo_path')
              ->label('Upload Foto')
              ->image()
              ->directory('family-photos')
              ->disk('public')
              ->visibility('public')
              ->imagePreviewHeight('250')
              ->maxSize(5120) // 5MB
              ->required()
              ->columnSpanFull()
              ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
              ->downloadable()
              ->openable()
              ->preserveFilenames()
              ->helperText('Format: JPG, PNG, JPEG. Maksimal 5MB'),
            Forms\Components\TextInput::make('title')
              ->required()
              ->maxLength(255)
              ->label('Judul Foto')
              ->placeholder('Contoh: Reuni Keluarga 2024'),
            Forms\Components\Textarea::make('description')
              ->label('Deskripsi')
              ->rows(3)
              ->placeholder('Ceritakan tentang foto ini...'),
          ])->columns(2),

        Forms\Components\Section::make('Detail Foto')
          ->schema([
            Forms\Components\DatePicker::make('photo_date')
              ->label('Tanggal Foto Diambil')
              ->displayFormat('d/m/Y')
              ->default(now())
              ->helperText('Kapan foto ini diambil'),
            Forms\Components\TextInput::make('location')
              ->maxLength(255)
              ->label('Lokasi')
              ->placeholder('Contoh: Jakarta, Yogyakarta'),
          ])->columns(3),

        Forms\Components\Section::make('Pengaturan Publikasi')
          ->schema([
            Forms\Components\Toggle::make('is_public')
              ->label('Tampilkan di Website Publik')
              ->default(true)
              ->helperText('Jika dinonaktifkan, foto tidak akan ditampilkan di website publik'),
          ])
          ->visible($isSuperAdmin),

        Forms\Components\Section::make('Informasi Penolakan')
          ->schema([
            Forms\Components\Placeholder::make('rejection_reason')
              ->label('Alasan Penolakan')
              ->content(fn(?FamilyPhoto $record): string => $record?->rejection_reason ?? '-')
              ->columnSpanFull(),
          ])
          ->visible(fn(?FamilyPhoto $record) => $record?->status === 'rejected' && $record?->rejection_reason)
          ->columnSpanFull(),
      ]);
  }

  public static function table(Table $table): Table
  {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    $isSuperAdmin = $user->hasRole('Super Admin');

    return $table
      ->columns([
        Tables\Columns\ImageColumn::make('photo_path')
          ->label('Foto')
          ->disk('public')
          ->circular()
          ->size(60)
          ->defaultImageUrl(url('/images/no-image.png')),
        Tables\Columns\TextColumn::make('title')
          ->searchable()
          ->sortable()
          ->label('Judul')
          ->weight('bold')
          ->wrap(),
        Tables\Columns\TextColumn::make('photo_date')
          ->date('d/m/Y')
          ->sortable()
          ->label('Tanggal Foto'),
        Tables\Columns\TextColumn::make('location')
          ->searchable()
          ->label('Lokasi')
          ->icon('heroicon-m-map-pin')
          ->default('—'),
        Tables\Columns\IconColumn::make('is_public')
          ->boolean()
          ->label('Publik')
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
          ->icon(fn(string $state): string => match ($state) {
            'pending' => 'heroicon-o-clock',
            'approved' => 'heroicon-o-check-circle',
            'rejected' => 'heroicon-o-x-circle',
          })
          ->formatStateUsing(fn(string $state): string => match ($state) {
            'pending' => 'Menunggu',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
          })
          ->description(function (FamilyPhoto $record) use ($isSuperAdmin): ?string {
            if (!$isSuperAdmin && $record->status === 'rejected' && $record->rejection_reason) {
              return 'Alasan: ' . $record->rejection_reason;
            }
            if ($record->status === 'approved' && $record->approved_at) {
              return $record->approved_at->format('d/m/Y H:i');
            }
            return null;
          }),
        Tables\Columns\TextColumn::make('uploader.name')
          ->label('Diupload Oleh')
          ->toggleable(isToggledHiddenByDefault: true),
        Tables\Columns\TextColumn::make('created_at')
          ->dateTime('d/m/Y H:i')
          ->sortable()
          ->label('Tanggal Upload')
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
        Tables\Filters\TernaryFilter::make('is_public')
          ->label('Status Publikasi')
          ->placeholder('Semua')
          ->trueLabel('Publik')
          ->falseLabel('Privat'),
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
            ->visible(fn(FamilyPhoto $record) => $isSuperAdmin && $record->status === 'pending')
            ->action(function (FamilyPhoto $record) {
              $record->update([
                'status' => 'approved',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
                'is_public' => $record->is_public ?? true, // Ensure is_public is set
              ]);

              Notification::make()
                ->success()
                ->title('Foto Disetujui')
                ->body("Foto '{$record->title}' telah disetujui dan akan muncul di website publik.")
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
                ->rows(4)
                ->placeholder('Tuliskan alasan mengapa foto ini ditolak...')
                ->helperText('Alasan ini akan dilihat oleh Admin Keluarga'),
            ])
            ->visible(fn(FamilyPhoto $record) => $isSuperAdmin && $record->status === 'pending')
            ->action(function (FamilyPhoto $record, array $data) {
              $record->update([
                'status' => 'rejected',
                'approved_by' => Auth::id(),
                'rejection_reason' => $data['rejection_reason'],
              ]);

              Notification::make()
                ->warning()
                ->title('Foto Ditolak')
                ->body("Foto '{$record->title}' telah ditolak.")
                ->send();
            }),
          Tables\Actions\Action::make('resubmit')
            ->label('Kirim Ulang')
            ->icon('heroicon-o-arrow-path')
            ->color('warning')
            ->requiresConfirmation()
            ->modalHeading('Kirim Ulang Foto')
            ->modalDescription(fn(FamilyPhoto $record) => 'Foto ini sebelumnya ditolak dengan alasan: "' . $record->rejection_reason . '". Apakah Anda yakin ingin mengirim ulang untuk review?')
            ->modalSubmitActionLabel('Ya, Kirim Ulang')
            ->visible(fn(FamilyPhoto $record) => !$isSuperAdmin && $record->status === 'rejected')
            ->action(function (FamilyPhoto $record) {
              $record->update([
                'status' => 'pending',
                'approved_by' => null,
                'approved_at' => null,
                'rejection_reason' => null,
              ]);

              Notification::make()
                ->success()
                ->title('Foto Dikirim Ulang')
                ->body("Foto '{$record->title}' telah dikirim ulang untuk review.")
                ->send();
            }),
          Tables\Actions\DeleteAction::make()
            ->after(function (FamilyPhoto $record) {
              if ($record->photo_path) {
                Storage::disk('public')->delete($record->photo_path);
              }
            }),
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
          Tables\Actions\DeleteBulkAction::make()
            ->after(function ($records) {
              foreach ($records as $record) {
                if ($record->photo_path) {
                  Storage::disk('public')->delete($record->photo_path);
                }
              }
            }),
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
      'index' => Pages\ListFamilyPhotos::route('/'),
      'create' => Pages\CreateFamilyPhoto::route('/create'),
      'view' => Pages\ViewFamilyPhoto::route('/{record}'),
      'edit' => Pages\EditFamilyPhoto::route('/{record}/edit'),
    ];
  }

  public static function getNavigationBadge(): ?string
  {
    /** @var \App\Models\User $user */
    $user = Auth::user();

    if ($user->hasRole('Super Admin')) {
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

    return 'info';
  }
}
