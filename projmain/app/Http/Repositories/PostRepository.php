<?php

namespace App\Http\Repositories;

use App\Http\Service\UserService;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class PostRepository {
    public static function get($data = []) : Builder
    {
        $posts = Post::select(
            'posts.id',
            'users.id as user_id',
            'users.name',
            'posts.text',
            'posts.created_at',
            'profile_pic_thumbnails.path as profile_pic_path',
            'posts.repostable_id',
            'posts.repostable_type'
        );
        $posts = UserService::joinUserDataChunk($posts, 'posts.author_id');
        if(array_key_exists('author_id', $data)) $posts = $posts->where('posts.author_id', $data['author_id']);
        if(array_key_exists('ids', $data)) $posts = $posts->whereIn('posts.id', $data['ids']);
        if(array_key_exists('order', $data)) {
            if($data['order'] == 'latest') $posts = $posts->latest();
        }
        if(array_key_exists('with_replies', $data)) {
            $posts = $posts->with([
                'postReplies' => function ($postRepliesSub) {
                    $postRepliesSub = UserService::joinUserDataChunk($postRepliesSub, 'post_replies.author_id');
                    PostReplyRepository::limitByPost($postRepliesSub);
                    $postRepliesSub->select(
                        'post_replies.id',
                        'post_replies.post_id',
                        'post_replies.author_id as user_id',
                        'post_replies.text',
                        'post_replies.created_at',
                        'users.name',
                        'profile_pic_thumbnails.path as profile_pic_path'
                    )->withCount('likes')
                    ->withExists('likedByCurrentUser as liked_by_current_user')
                    ->orderBy('post_replies.id');
                }
            ]);
        }
        if(array_key_exists('with_likes', $data)) $posts = $posts->withCount('likes')
        ->withExists('likedByCurrentUser as liked_by_current_user');
        
        return $posts;
    }

    public static function getRepostsData($ids) : Collection{
        return self::get(['ids' => $ids])->get();
    }
}