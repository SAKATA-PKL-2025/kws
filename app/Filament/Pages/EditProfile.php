<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class EditProfile extends Page implements HasForms
{
  use InteractsWithForms;

  protected static ?string $navigationIcon = 'heroicon-o-user-circle';

  protected static string $view = 'filament.pages.edit-profile';

  protected static ?string $navigationLabel = 'Profil Saya';

  protected static ?string $title = 'Edit Profil';

  protected static ?string $navigationGroup = 'Pengaturan';

  protected static ?int $navigationSort = 99;

  public ?array $data = [];

  public function mount(): void
  {
    $this->form->fill([
      'name' => Auth::user()->name,
      'email' => Auth::user()->email,
    ]);
  }

  public function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Section::make('Informasi Akun')
          ->description('Update informasi profil Anda')
          ->schema([
            Forms\Components\TextInput::make('name')
              ->label('Nama Lengkap')
              ->required()
              ->maxLength(255),
            Forms\Components\TextInput::make('email')
              ->label('Email')
              ->email()
              ->required()
              ->unique(table: 'users', column: 'email', ignoreRecord: true)
              ->maxLength(255),
          ])->columns(2),

        Forms\Components\Section::make('Ubah Password')
          ->description('Kosongkan jika tidak ingin mengubah password')
          ->schema([
            Forms\Components\TextInput::make('current_password')
              ->label('Password Saat Ini')
              ->password()
              ->revealable()
              ->rules(['required_with:new_password'])
              ->dehydrated(false),
            Forms\Components\TextInput::make('new_password')
              ->label('Password Baru')
              ->password()
              ->revealable()
              ->minLength(8)
              ->rules(['nullable', 'min:8'])
              ->dehydrated(false)
              ->live()
              ->afterStateUpdated(fn($state, Forms\Set $set) => $set('new_password_confirmation', null)),
            Forms\Components\TextInput::make('new_password_confirmation')
              ->label('Konfirmasi Password Baru')
              ->password()
              ->revealable()
              ->same('new_password')
              ->visible(fn(Forms\Get $get) => filled($get('new_password')))
              ->dehydrated(false),
          ])->columns(1),
      ])
      ->statePath('data');
  }

  public function save(): void
  {
    $data = $this->form->getState();

    /** @var \App\Models\User $user */
    $user = Auth::user();

    // Validasi password saat ini jika ingin mengubah password
    if (!empty($data['new_password'])) {
      if (empty($data['current_password'])) {
        Notification::make()
          ->danger()
          ->title('Password Saat Ini Diperlukan')
          ->body('Anda harus memasukkan password saat ini untuk mengubah password.')
          ->send();
        return;
      }

      if (!Hash::check($data['current_password'], $user->password)) {
        Notification::make()
          ->danger()
          ->title('Password Salah')
          ->body('Password saat ini yang Anda masukkan salah.')
          ->send();
        return;
      }

      if (empty($data['new_password_confirmation'])) {
        Notification::make()
          ->danger()
          ->title('Konfirmasi Password Diperlukan')
          ->body('Anda harus mengkonfirmasi password baru.')
          ->send();
        return;
      }

      // Update password
      $user->password = Hash::make($data['new_password']);
    }

    // Update nama dan email
    $user->name = $data['name'];
    $user->email = $data['email'];
    $user->save();

    Notification::make()
      ->success()
      ->title('Profil Berhasil Diperbarui')
      ->body('Informasi profil Anda telah berhasil diperbarui.')
      ->send();

    // Refresh form dengan data baru
    $this->form->fill([
      'name' => $user->name,
      'email' => $user->email,
      'current_password' => null,
      'new_password' => null,
      'new_password_confirmation' => null,
    ]);
  }
}
