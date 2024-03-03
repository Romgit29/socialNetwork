<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $guard_name = 'api';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    public function profileData() {
        return $this->hasOne(ProfileData::class);
    }

    public function pictures() {
        return $this->hasMany(Picture::class);
    }

    public function blockedByCurrentUser() {
        return $this->hasOne(BlockedUser::class, 'blocked_user_id')
        ->where('blocking_user_id', Auth::id());
    }

    public function isBlockedByUser($id) {
        return $this->hasOne(BlockedUser::class, 'blocked_user_id')
        ->where('blocking_user_id', $id)
        ->exists();
    }
}
