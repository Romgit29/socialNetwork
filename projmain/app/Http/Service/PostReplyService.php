<?php

namespace App\Http\Service;

use App\Http\Repositories\PostReplyRepository;
use App\Http\Service\Traits\CrudableTrait;
use App\Http\Service\Traits\LikableTrait;
use App\Http\Service\Traits\RepostableTrait;
use App\Http\Service\Contracts\LikeInterface;
use App\Http\Service\Contracts\RepostInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\PostReply;

class PostReplyService implements LikeInterface, RepostInterface
{
    use CrudableTrait, LikableTrait, RepostableTrait;

    const MODEL = PostReply::class;
    const TYPE = 'postReplies';

    public static function get($postId) : LengthAwarePaginator {
        return PostReplyRepository::get(['post_id' => $postId])
        ->paginate(10);
    }

    public function getRepostsData($ids) {
        return PostReplyRepository::getRepostsData($ids);
    }
}