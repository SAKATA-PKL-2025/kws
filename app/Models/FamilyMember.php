<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class FamilyMember extends Model
{
    use HasFactory, UuidTrait, SoftDeletes;

    protected $fillable = [
        'full_name',
        'nickname',
        'gender',
        'birth_date',
        'birth_place',
        'death_date',
        'death_place',
        'is_alive',
        'family_branch_id',
        'father_id',
        'mother_id',
        'spouse_id',
        'spouse_is_external',
        'spouse_name',
        'spouse_phone',
        'spouse_email',
        'spouse_occupation',
        'marital_end_date',
        'marital_end_note',
        'generation',
        'child_order',
        'is_twin',
        'twin_order',
        'marital_status',
        'marriage_date',
        'phone',
        'email',
        'occupation',
        'address',
        'city',
        'province',
        'country',
        'profile_photo',
        'biography',
        'status',
        'rejection_reason',
        'submitted_by',
        'approved_by',
        'approved_at',
        'is_public',
        'is_founder',
        'created_by',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'death_date' => 'date',
        'marriage_date' => 'date',
        'marital_end_date' => 'date',
        'approved_at' => 'datetime',
        'is_alive' => 'boolean',
        'is_public' => 'boolean',
        'is_founder' => 'boolean',
        'spouse_is_external' => 'boolean',
        'is_twin' => 'boolean',
        'generation' => 'integer',
        'child_order' => 'integer',
        'twin_order' => 'integer',
    ];

    protected $appends = ['age', 'display_name'];

    /**
     * Cabang keluarga
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(FamilyBranch::class, 'family_branch_id');
    }

    /**
     * Ayah
     */
    public function father(): BelongsTo
    {
        return $this->belongsTo(FamilyMember::class, 'father_id');
    }

    /**
     * Ibu
     */
    public function mother(): BelongsTo
    {
        return $this->belongsTo(FamilyMember::class, 'mother_id');
    }

    /**
     * Pasangan
     */
    public function spouse(): BelongsTo
    {
        return $this->belongsTo(FamilyMember::class, 'spouse_id');
    }

    /**
     * Anak-anak (sebagai ayah)
     */
    public function childrenAsFather(): HasMany
    {
        return $this->hasMany(FamilyMember::class, 'father_id');
    }

    /**
     * Anak-anak (sebagai ibu)
     */
    public function childrenAsMother(): HasMany
    {
        return $this->hasMany(FamilyMember::class, 'mother_id');
    }

    /**
     * Semua anak (gabungan)
     */
    public function children()
    {
        if ($this->gender === 'male') {
            return $this->childrenAsFather();
        }
        return $this->childrenAsMother();
    }

    /**
     * User yang submit (Admin Keluarga)
     */
    public function submitter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    /**
     * User yang approve (Super Admin)
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * User yang membuat
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope: Hanya yang sudah di-approve
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope: Pending approval
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Public only
     */
    public function scopePublic(Builder $query): Builder
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope: Masih hidup
     */
    public function scopeAlive(Builder $query): Builder
    {
        return $query->where('is_alive', true);
    }

    /**
     * Scope: Founder keluarga
     */
    public function scopeFounders(Builder $query): Builder
    {
        return $query->where('is_founder', true);
    }

    /**
     * Get umur
     */
    public function getAgeAttribute(): ?int
    {
        if (!$this->birth_date) {
            return null;
        }

        $endDate = $this->is_alive ? now() : $this->death_date;
        return $this->birth_date->diffInYears($endDate);
    }

    /**
     * Get display name (nickname atau full name)
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->nickname ?: $this->full_name;
    }

    /**
     * Get spouse name (handle both internal and external spouse)
     */
    public function getSpouseNameAttribute(): ?string
    {
        if ($this->spouse_is_external && $this->spouse_name) {
            return $this->spouse_name;
        }

        // Cek apakah relasi sudah di-load untuk menghindari N+1
        if ($this->spouse_id && $this->relationLoaded('spouse')) {
            return $this->spouse?->full_name;
        }

        return null;
    }

    /**
     * Auto-update branch members count setelah approve
     */
    protected static function booted()
    {
        static::updated(function (FamilyMember $member) {
            if ($member->isDirty('status') && $member->status === 'approved') {
                $member->branch?->updateMembersCount();
            }
        });

        static::deleted(function (FamilyMember $member) {
            $member->branch?->updateMembersCount();
        });
    }
}
