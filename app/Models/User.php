<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\UuidTrait;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @mixin \Spatie\Permission\Traits\HasRoles
 * @method bool hasRole($roles, string $guard = null)
 * @method bool hasAnyRole($roles, string $guard = null)
 * @method bool hasAllRoles($roles, string $guard = null)
 */
class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, UuidTrait, HasRoles;

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole(['Super Admin', 'Admin Keluarga']);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_user_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function role_user(): BelongsTo
    {
        return $this->belongsTo(RoleUser::class);
    }
}
