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
    $members = FamilyMember::with(['father', 'mother', 'children', 'branch'])
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
}
