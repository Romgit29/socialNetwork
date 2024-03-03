<?php

namespace App\Http\Service;

use App\Http\Service\Contracts\LikeInterface;
use App\Http\Service\Traits\CrudableTrait;
use App\Models\Like;

class LikesService
{
    use CrudableTrait;

    const MODEL = Like::class;
    
    public static function resolveServiceFromType($type) : LikeInterface {
        switch($type) {
            case 'posts':
                return (new PostService);
                break;
            case 'postReplies':
                return (new PostReplyService);
                break;
        }
    }
}