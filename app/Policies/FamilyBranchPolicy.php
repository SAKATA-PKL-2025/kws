<?php

namespace App\Policies;

use App\Models\FamilyBranch;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FamilyBranchPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Semua authenticated user bisa melihat list cabang
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FamilyBranch $familyBranch): bool
    {
        // Semua authenticated user bisa melihat detail cabang
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Hanya Super Admin yang bisa membuat cabang baru
        return $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FamilyBranch $familyBranch): bool
    {
        // Hanya Super Admin yang bisa edit cabang
        return $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FamilyBranch $familyBranch): bool
    {
        // Hanya Super Admin yang bisa hapus cabang
        return $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FamilyBranch $familyBranch): bool
    {
        return $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FamilyBranch $familyBranch): bool
    {
        return $user->hasRole('Super Admin');
    }
}
