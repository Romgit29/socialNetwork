<?php

namespace App\Http\Service;

use App\Http\Service\Contracts\RepostInterface;
use App\Http\Repositories\PostRepository;
use App\Http\Service\Contracts\LikeInterface;
use App\Http\Service\Traits\CrudableTrait;
use App\Http\Service\Traits\LikableTrait;
use App\Http\Service\Traits\RepostableTrait;
use App\Models\Post;

class PostService implements RepostInterface, LikeInterface
{
    use LikableTrait, RepostableTrait, CrudableTrait;
    
    const MODEL = Post::class;
    const TYPE = 'posts';

    public static function get(string $resultClass, array $data = [])
    {
        $posts = PostRepository::get($data);
        switch ($resultClass) {
            case 'collection':
                $posts = $posts->get();
            break;
            case 'lengthAwarePaginator':
                $posts = $posts->paginate(10);
            break;
            default:
                return false;
        }
        RepostService::attach($posts);
        
        return $posts;
    }

    public function getRepostsData($ids) {
        return PostRepository::getRepostsData($ids);
    }
}