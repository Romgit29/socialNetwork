<?php

namespace App\Http\Service\Contracts;

use Illuminate\Http\Request;

interface RepostInterface 
{
    public function getRepostsData(array $ids);

    public function repost(Request $request, int $id);
}