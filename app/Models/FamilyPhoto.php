<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'photo_path',
        'family_branch_id',
        'photo_date',
        'location',
        'uploaded_by',
        'is_public',
        'status',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'photo_date' => 'date',
        'is_public' => 'boolean',
        'approved_at' => 'datetime',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(FamilyBranch::class, 'family_branch_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
