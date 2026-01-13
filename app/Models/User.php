<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Mass-assignable attributes
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',                // admin, editor, user
        'can_comment',         // permission to comment
        'can_view_old_news',   // permission to view old news
        'is_blocked',          // blocked user
        'otp',                 // OTP code
        'otp_expires_at',      // OTP expiry timestamp
        'is_verified',         // email verified flag
    ];

    /**
     * Hidden attributes for serialization
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'can_comment' => 'boolean',
        'can_view_old_news' => 'boolean',
        'is_blocked' => 'boolean',
        'otp_expires_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

    /* ---------------------------------------------
       Role Helpers
    --------------------------------------------- */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEditor(): bool
    {
        return $this->role === 'editor';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /* ---------------------------------------------
       Permission Helpers
    --------------------------------------------- */

    public function canComment(): bool
    {
        return $this->can_comment && !$this->is_blocked;
    }

    public function canViewOldNews(): bool
    {
        return $this->can_view_old_news && !$this->is_blocked;
    }

    public function isBlocked(): bool
    {
        return $this->is_blocked;
    }

    public function isVerified(): bool
    {
        return $this->is_verified;
    }

    /* ---------------------------------------------
       Relationships
    --------------------------------------------- */

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}