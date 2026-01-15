<?php

namespace App\Policies;

use App\Models\FamilyMember;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FamilyMemberPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Semua authenticated user bisa melihat list anggota keluarga
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FamilyMember $familyMember): bool
    {
        // Semua authenticated user bisa melihat detail anggota
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Super Admin dan Admin Keluarga bisa menambah anggota
        return $user->hasAnyRole(['Super Admin', 'Admin Keluarga']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FamilyMember $familyMember): bool
    {
        // Super Admin bisa edit semua
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        // Admin Keluarga hanya bisa edit anggota di cabangnya sendiri
        if ($user->hasRole('Admin Keluarga')) {
            // Cari cabang yang di-manage oleh admin ini
            $adminBranch = \App\Models\FamilyBranch::where('admin_id', $user->id)->first();

            if ($adminBranch && $familyMember->family_branch_id === $adminBranch->id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FamilyMember $familyMember): bool
    {
        // Super Admin bisa hapus semua
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        // Admin Keluarga hanya bisa hapus anggota di cabangnya sendiri
        if ($user->hasRole('Admin Keluarga')) {
            $adminBranch = \App\Models\FamilyBranch::where('admin_id', $user->id)->first();

            if ($adminBranch && $familyMember->family_branch_id === $adminBranch->id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can approve the model.
     */
    public function approve(User $user, FamilyMember $familyMember): bool
    {
        // Hanya Super Admin yang bisa approve
        return $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can reject the model.
     */
    public function reject(User $user, FamilyMember $familyMember): bool
    {
        // Hanya Super Admin yang bisa reject
        return $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FamilyMember $familyMember): bool
    {
        return $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FamilyMember $familyMember): bool
    {
        return $user->hasRole('Super Admin');
    }
}
