<?php

namespace App\Http\Repositories;

use App\Http\Service\UserService;
use App\Models\PostReply;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class PostReplyRepository {
    public static function get($data) : Builder {
        if(array_key_exists('post_id', $data)) $result = PostReply::where('post_id', $data['post_id']);
        if(array_key_exists('ids', $data)) $result = PostReply::whereIn("post_replies.id", $data['ids']);
        $result = UserService::joinUserDataChunk($result, 'post_replies.author_id')
        ->select(
            'post_replies.id', 
            'post_replies.text', 
            'post_replies.created_at', 
            'post_replies.author_id as user_id', 
            'users.name', 
            'profile_pic_thumbnails.path as profile_pic_path',
            'post_replies.post_id'
        );

        return $result;
    }

    public static function getRepostsData($ids) : Collection {
        return self::get(['ids' => $ids])->get();
    }

    /**
     * Chunk for limiting replies number returned per post.
     */
    public static function limitByPost(&$query): void
    {
        $numericOrder = PostReply::select('id', DB::raw('ROW_NUMBER() OVER (PARTITION BY post_id ORDER BY id DESC) AS post_reply_number'))
        ->toSql();

        $query->join(DB::raw("({$numericOrder}) as post_reply_numbers"), 'post_replies.id', 'post_reply_numbers.id')
        ->where('post_reply_numbers.post_reply_number', '<', 4);
    }
}