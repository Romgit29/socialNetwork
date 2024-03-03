<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\PostReply;
use App\Models\User;

class PostReplyPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function store(User $user): bool
    {
        $post = Post::find(request()->input('post_id'));
        return !$user->isBlockedByUser($post->author_id);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PostReply $postReply): bool
    {
        $postAuthor = $postReply->post->user_id;
        return ($postReply->author_id == $user->id && !$user->isBlockedByUser($postAuthor));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PostReply $postReply): bool
    {
        $postAuthor = $postReply->post->user_id;
        return ($postAuthor == $user->id || $postReply->author_id == $user->id);
    }
}
