<?php

namespace App\Http\Service;

use App\Http\Service\Contracts\RepostInterface;
use Illuminate\Database\Eloquent\Collection;

class RepostService
{   
    public static function resolveRepostableService($type) : RepostInterface {
        switch($type) {
            case 'posts':
                return (new PostService);
                break;
            case 'postReplies':
                return (new PostReplyService);
                break;
            default:
                return false;
        }
    }

    public static function attach(&$posts) {
        $reposts = self::get($posts);
        $posts->map(function ($value) use ($reposts) {
            $repostValue = null;
            if($value->repostable_type) {
                foreach($reposts[$value->repostable_type] as $repost) {
                    if($repost->id == $value->repostable_id) {
                        $repostValue = $repost;
                        break;
                    }
                }
            }

            return $value->repost = $repostValue;
        });

        return $posts;
    }

    private static function get($posts) {
        return $posts->filter(function($value) {
            return $value->repostable_type !== null;
        })->groupBy('repostable_type')
        ->map(function ($value, $key) {
            $repostableIds = $value->pluck('repostable_id');

            return self::resolveRepostableService($key)->getRepostsData($repostableIds);
        });
    }
}