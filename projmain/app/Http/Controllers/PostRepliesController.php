<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyPostReplyRequest;
use App\Http\Requests\EditPostReplyRequest;
use App\Http\Requests\StorePostReplyRequest;
use App\Http\Service\PostReplyService;
use Illuminate\Support\Facades\Auth;

class PostRepliesController extends Controller
{
    /**
     * Delete post reply.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param int $postReply
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyPostReplyRequest $request, $postReply) {
        PostReplyService::destroy($postReply);

        return back()->withSuccess('Reply deleted successfully');
    }

    /**
     * Store post reply.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostReplyRequest $request) {
        PostReplyService::store(array_merge($request->validated(), [
            'author_id' => Auth::id()
        ]));
        
        return back()->withSuccess('Reply added successfully');
    }

    /**
     * Update post reply.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditPostReplyRequest $request, $id)
    {
        PostReplyService::update($id, $request->validated());

        return back()->withSuccess(__('Reply updated successfully'));
    }
}