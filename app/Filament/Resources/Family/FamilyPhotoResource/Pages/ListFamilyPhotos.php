<?php

namespace App\Filament\Resources\Family\FamilyPhotoResource\Pages;

use App\Filament\Resources\Family\FamilyPhotoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class ListFamilyPhotos extends ListRecords
{
  protected static string $resource = FamilyPhotoResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make()
        ->successNotification(
          Notification::make()
            ->success()
            ->title('Foto Berhasil Diupload')
            ->body(function () {
              /** @var \App\Models\User $user */
              $user = Auth::user();
              if ($user->hasRole('Super Admin')) {
                return 'Foto telah disetujui dan akan muncul di website publik.';
              }
              return 'Foto Anda sedang menunggu verifikasi dari Super Admin.';
            })
        ),
    ];
  }

  public function getHeaderWidgetsColumns(): int | array
  {
    return 1;
  }

  protected function getHeaderWidgets(): array
  {
    return [
      \App\Filament\Resources\Family\FamilyPhotoResource\Widgets\PendingPhotosInfoWidget::class,
    ];
  }
}
