<?php

namespace App\Http\Repositories;

use App\Models\ProfileData;
use Illuminate\Support\Facades\Auth;

class ProfileRepository {
    public static function get($id) {
        return ProfileData::where('user_id', $id)
        ->with([
            'user' => function($query) {
                $query->withExists('blockedByCurrentUser as blocked_by_current_user');
            }, 
            'profilePicThumbnail'
        ])->first();
    }
}