<?php

namespace App\Http\Controllers;

use App\Http\Service\LikesService;

class LikesController extends Controller
{
    public function like($type, $id)
    {
        $likesService = (LikesService::resolveServiceFromType($type));
        $likesService->like($id);
        $likesCount = $likesService->likesCount([$id]);
        
        return getSuccess(['likes_count' => $likesCount[0]['count']]);
    }

    public function unlike($type, $id)
    {
        $likesService = (LikesService::resolveServiceFromType($type));
        $likesService->unlike($id);
        $likesCount = $likesService->likesCount([$id]);

        return getSuccess(['likes_count' => $likesCount[0]['count']]);
    }
}
