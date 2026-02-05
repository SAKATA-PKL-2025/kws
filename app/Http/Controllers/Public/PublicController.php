<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\FamilyMember;
use App\Models\FamilyPhoto;
use Illuminate\Http\Request;

class PublicController extends Controller
{
  public function index()
  {
    // Ambil semua anggota keluarga yang public dan approved
    // Load father_id & mother_id untuk membangun tree
    $members = FamilyMember::select([
      'id',
      'full_name',
      'nickname',
      'gender',
      'birth_date',
      'death_date',
      'is_alive',
      'generation',
      'child_order',
      'profile_photo',
      'marital_status',
      'spouse_id',
      'father_id',
      'mother_id'
    ])
      ->where('is_public', true)
      ->where('status', 'approved')
      ->orderBy('generation')
      ->orderBy('child_order')
      ->get();

    return view('public.index', compact('members'));
  }

  public function about()
  {
    return view('public.about');
  }

  public function gallery(Request $request)
  {
    $query = FamilyPhoto::where('is_public', true)
      ->where('status', 'approved');

    // Filter by year
    if ($request->filled('year')) {
      $query->whereYear('photo_date', $request->year);
    }

    // Filter by month
    if ($request->filled('month')) {
      $query->whereMonth('photo_date', $request->month);
    }

    // Search by title or description
    if ($request->filled('search')) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->where('title', 'like', '%' . $search . '%')
          ->orWhere('description', 'like', '%' . $search . '%')
          ->orWhere('location', 'like', '%' . $search . '%');
      });
    }

    $photos = $query->orderBy('photo_date', 'desc')
      ->orderBy('created_at', 'desc')
      ->paginate(8);

    // Get available years for filter
    $years = FamilyPhoto::where('is_public', true)
      ->where('status', 'approved')
      ->whereNotNull('photo_date')
      ->selectRaw('YEAR(photo_date) as year')
      ->distinct()
      ->orderBy('year', 'desc')
      ->pluck('year');

    return view('public.gallery', compact('photos', 'years'));
  }

  public function search(Request $request)
  {
    $query = $request->get('q', '');

    if (strlen($query) < 2) {
      return response()->json([]);
    }

    $members = FamilyMember::with(['branch'])
      ->where('is_public', true)
      ->where('status', 'approved')
      ->where(function ($q) use ($query) {
        $q->where('full_name', 'like', "%{$query}%")
          ->orWhere('nickname', 'like', "%{$query}%")
          ->orWhere('birth_place', 'like', "%{$query}%")
          ->orWhere('city', 'like', "%{$query}%");
      })
      ->limit(10)
      ->get()
      ->map(function ($member) {
        return [
          'id' => $member->id,
          'full_name' => $member->full_name,
          'nickname' => $member->nickname,
          'gender' => $member->gender,
          'birth_date' => $member->birth_date ? $member->birth_date->format('d M Y') : null,
          'branch_name' => $member->branch?->name,
          'branch_color' => $member->branch?->color_code,
          'is_alive' => $member->is_alive,
          'profile_photo' => $member->profile_photo,
          'generation' => $member->generation,
        ];
      });

    return response()->json($members);
  }
}
