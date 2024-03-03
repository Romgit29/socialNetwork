<?php

namespace App\Http\Service\Traits;

use App\Http\Service\PostService;
use Illuminate\Support\Facades\Auth;

trait RepostableTrait {
    public function repost($request, $id)
    {
        PostService::store(array_merge($request, [
            'repostable_id' => $id,
            'repostable_type' => self::TYPE,
            'author_id' => Auth::id()
        ]));
    }
}