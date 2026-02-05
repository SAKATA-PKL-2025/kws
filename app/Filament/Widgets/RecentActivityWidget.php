<?php

namespace App\Filament\Widgets;

use App\Models\FamilyMember;
use App\Models\FamilyPhoto;
use Filament\Widgets\Widget;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;

class RecentActivityWidget extends Widget
{
  protected static string $view = 'filament.widgets.recent-activity';

  protected static ?int $sort = 5;

  protected int | string | array $columnSpan = 'full';

  #[Url(as: 'activityPage')]
  public int $page = 1;

  public int $perPage = 10;

  public array $perPageOptions = [10, 25, 50, 100];

  public function updatedPerPage(): void
  {
    $this->page = 1;
  }

  public function previousPage(): void
  {
    $this->page = max(1, $this->page - 1);
  }

  public function nextPage(): void
  {
    $this->page++;
  }

  public function gotoPage(int $page): void
  {
    $this->page = $page;
  }

  public function getViewData(): array
  {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    $isSuperAdmin = $user->hasRole('Super Admin');

    // Ambil SEMUA anggota keluarga terbaru
    $recentMembers = FamilyMember::with(['father', 'mother', 'approver'])
      ->latest()
      ->get()
      ->map(function ($member) {
        return [
          'type' => 'member',
          'id' => $member->id,
          'title' => $member->full_name,
          'subtitle' => $member->nickname ? '"' . $member->nickname . '"' : 'Gen. ' . $member->generation,
          'status' => $member->status,
          'image' => $member->profile_photo,
          'created_at' => $member->created_at,
          'approved_by' => $member->approver?->name,
          'approved_at' => $member->approved_at,
        ];
      });

    // Ambil SEMUA foto terbaru
    $recentPhotos = FamilyPhoto::with(['uploader', 'approver'])
      ->latest()
      ->get()
      ->map(function ($photo) {
        return [
          'type' => 'photo',
          'id' => $photo->id,
          'title' => $photo->title,
          'subtitle' => $photo->location ?? 'Tidak ada lokasi',
          'status' => $photo->status,
          'image' => $photo->photo_path,
          'created_at' => $photo->created_at,
          'approved_by' => $photo->approver?->name,
          'approved_at' => $photo->approved_at,
          'uploader' => $photo->uploader?->name,
        ];
      });

    // Gabungkan dan urutkan berdasarkan created_at
    $allActivities = $recentMembers->concat($recentPhotos)
      ->sortByDesc('created_at')
      ->values();

    $total = $allActivities->count();

    // Paginate manually
    $activities = new LengthAwarePaginator(
      $allActivities->forPage($this->page, $this->perPage)->values(),
      $total,
      $this->perPage,
      $this->page,
    );

    return [
      'activities' => $activities,
      'isSuperAdmin' => $isSuperAdmin,
    ];
  }
}
