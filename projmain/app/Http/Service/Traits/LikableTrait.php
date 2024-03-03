<?php

namespace App\Http\Service\Traits;

use App\Http\Service\LikesService;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait LikableTrait {
    public function like(int $id)
    {
        LikesService::store([
            'likable_id' => $id,
            'likable_type' => self::MODEL,
            'user_id' => Auth::id()
        ]);

        return true;
    }

    public function unlike(int $id) {
        return Like::where([
            ['likable_id', $id],
            ['likable_type', self::MODEL],
            ['user_id', Auth::id()]
        ])->delete();
    }

    public function likesCount(array $ids): array {
        $result = Like::where('likable_type', self::MODEL)
        ->whereIn('likable_id', $ids)
        ->select('likable_id', DB::raw('count(likable_id) as count'))
        ->groupBy('likable_id')
        ->get();
        $resultIds = $result->pluck('likable_id')->toArray();
        $result = $result->toArray();
        $diff = array_diff($ids, $resultIds);
        $diff = array_map(function($value) {
            return [
                'likable_id' => $value,
                'count' => 0
            ];
        }, $diff);
        $result = array_merge($result, $diff);

        return $result;
    }
}