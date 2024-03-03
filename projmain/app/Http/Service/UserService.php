<?php

namespace App\Http\Service;

use App\Models\BlockedUser;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public static function joinUserDataChunk($query, $field) {
        $query = $query->join('users', 'users.id', $field)
            ->join('profile_data', 'profile_data.user_id', 'users.id')
            ->leftjoin('pictures as profile_pic_thumbnails', 'profile_pic_thumbnails.id', 'profile_data.profile_pic_thumbnail');
        
        return $query;
    }

    public static function block($id) {
        if($id !== Auth::id()) {
            BlockedUser::firstOrCreate([
                'blocking_user_id' => Auth::id(),
                'blocked_user_id' => $id
            ]);
        }
    }

    public static function unblock($id) {
        BlockedUser::where([
            'blocking_user_id' => Auth::id(),
            'blocked_user_id' => $id
        ])->delete();
    }
}