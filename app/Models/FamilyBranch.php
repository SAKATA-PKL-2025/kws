<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyBranch extends Model
{
    use HasFactory, UuidTrait, SoftDeletes;

    protected $fillable = [
        'name',
        'founder_name',
        'description',
        'location',
        'generation',
        'color_code',
        'admin_id',
        'is_active',
        'members_count',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'generation' => 'integer',
        'members_count' => 'integer',
    ];

    /**
     * Admin yang bertanggung jawab untuk cabang ini
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * User yang membuat cabang ini
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Semua anggota keluarga di cabang ini
     */
    public function members(): HasMany
    {
        return $this->hasMany(FamilyMember::class, 'family_branch_id');
    }

    /**
     * Anggota yang sudah di-approve
     */
    public function approvedMembers(): HasMany
    {
        return $this->members()->where('status', 'approved');
    }

    /**
     * Anggota yang pending approval
     */
    public function pendingMembers(): HasMany
    {
        return $this->members()->where('status', 'pending');
    }

    /**
     * Update counter jumlah anggota
     */
    public function updateMembersCount(): void
    {
        $this->members_count = $this->approvedMembers()->count();
        $this->save();
    }
}
