<div class='addReplyBlock' style='display: none;'>
    <form method='POST' action="{{ route('postReplies.store') }}">
        @method('post')
        @csrf
        <textarea name='text' class='textareaGeneral'></textarea>
        <input name='post_id' type='hidden' value='{{$post->id}}'></input>
        <div class='defaultMarginTop linearButtonsBlock'>
            <button class="btn btn-primary btn-sm defaultButton addReplyButton" type="submit">Send</button>
            <button class='btn btn-danger btn-sm defaultButton discardReplyAddingButton' type='button'>Close</button>
        </div>
    </form>
</div>