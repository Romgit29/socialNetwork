<?php

namespace App\Models\Traits;

use App\Models\Like;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Auth;

trait LikableTrait {
    public function likes() : MorphMany{
        return $this->morphMany(Like::class, 'likable');
    }

    public function likedByCurrentUser() : MorphOne {
        return $this->morphOne(Like::class, 'likable')
        ->where('likes.user_id', Auth::id());
    }
}