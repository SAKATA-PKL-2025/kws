<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class AdminFaq extends Page
{
  protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

  protected static string $view = 'filament.pages.admin-faq';

  protected static ?string $navigationLabel = 'Bantuan & FAQ';

  protected static ?string $title = 'Bantuan & FAQ Admin';

  protected static ?int $navigationSort = 99;

  protected static ?string $navigationGroup = 'Bantuan';
}
