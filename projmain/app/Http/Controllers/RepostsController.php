<?php

namespace App\Http\Controllers;

use App\Http\Requests\RepostRequest;
use App\Http\Service\RepostService;

class RepostsController extends Controller
{
    public function repost(RepostRequest $request, $type, $id)
    {
        (RepostService::resolveRepostableService($type))->repost($request->validated(), $id);

        if($type == 'posts') return back()->withSuccess('Post reposted successfully');
        else return back()->withSuccess('Reply reposted successfully');
    }
}
