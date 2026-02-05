<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\FamilyBranch;
use App\Models\FamilyMember;
use App\Models\FamilyPhoto;
use Illuminate\Http\Request;

class PublicController extends Controller
{
  public function index()
  {
    // Ambil semua anggota keluarga yang public dan approved
    // PENTING: Jangan eager load 'children' karena akan menyebabkan circular reference
    $members = FamilyMember::with(['father', 'mother', 'branch'])
      ->where('is_public', true)
      ->where('status', 'approved')
      ->orderBy('generation')
      ->orderBy('child_order')
      ->get();

    $branches = FamilyBranch::where('is_active', true)
      ->withCount(['members' => function ($query) {
        $query->where('is_public', true)->where('status', 'approved');
      }])
      ->get();

    return view('public.index', compact('members', 'branches'));
  }

  public function about()
  {
    return view('public.about');
  }

  public function gallery()
  {
    $photos = FamilyPhoto::with(['branch'])
      ->where('is_public', true)
      ->where('status', 'approved')
      ->orderBy('photo_date', 'desc')
      ->orderBy('created_at', 'desc')
      ->get();

    $branches = FamilyBranch::where('is_active', true)->get();

    return view('public.gallery', compact('photos', 'branches'));
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
