<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyPostRequest;
use App\Http\Requests\EditPostRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Service\PostReplyService;
use App\Http\Service\PostService;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    /**
     * Feed page data.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = PostService::get('lengthAwarePaginator', [
            'with_replies' => true,
            'with_likes' => true,
            'order' => 'latest'
        ]);
        
        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    /**
     * Store post.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        PostService::store([
            'text' => $request->input('text'),
            'author_id' => Auth::id()
        ]);
        
        return back()->withSuccess('Post added successfully');
    }

    /**
     * Post page data.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $postData = PostService::get('collection', [
            'ids' => [$id],
            'limit' => 1,
            'with_likes' => true
        ])->first();
        $postReplies = PostReplyService::get($id);
        
        return view('posts.show', [
            'post' => $postData,
            'postReplies'=> $postReplies
        ]);
    }

    /**
     * Update post.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param int $post
     * @return \Illuminate\Http\Response
     */
    public function update(EditPostRequest $request, int $post)
    {
        PostService::update($post, $request->validated());

        return back()->withSuccess(__('Post updated successfully.'));
    }

    /**
     * Delete post.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param int $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyPostRequest $request, $post)
    {
        PostService::destroy($post);
        if(preg_match('/posts\/[0-9]+/', $request->header('referer'))) return redirect()->route('users.profile', ['id' => Auth::id()])->withSuccess('Post deleted successfully');
        return redirect()->back()->withSuccess('Post deleted successfully');
    }
}