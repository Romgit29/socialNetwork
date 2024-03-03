<?php

namespace App\Http\Service\Contracts;

interface LikeInterface 
{
    public function like(int $id);

    public function unlike(int $id);

    public function likesCount(array $ids);
}