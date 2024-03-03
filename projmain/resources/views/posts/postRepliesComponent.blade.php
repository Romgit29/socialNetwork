@foreach ($postReplies as $replyKey => $postReply)
    <div class='postReplyHr'>
        <hr style='margin-top: 12px; margin-bottom: 12px;'>
    </div>
    <div class='postReply' postReplyId="{{$postReply->id}}" liked="{{$postReply->liked_by_current_user}}">
        <?php
            $postable = $postReply;
            $corpedText = $postReply->text;
        ?>
        @include('posts.postHeadComponent')
        <textarea name='text' class='textareaGeneral defaultMarginTop editTextArea' style='display: none;' form='replyEditForm_{{$key}}_{{$replyKey}}'></textarea>
        <div class='replyContent'>
            <div class='mainText'>
                @include('posts.corpedTextComponent')
            </div>
        </div>
        <form method='POST' class='replyEditForm' id='replyEditForm_{{$key}}_{{$replyKey}}' style='display: none;' action="{{route('postReplies.update', ['postReply' => $postReply->id])}}">
            @include('posts.postEditComponent')
        </form>
        <?php 
            $postable = $postReply;
        ?>
        @include('posts.postButtonsBlock')
        @include('posts.addReplyComponent')
        <form method='POST' class='deleteForm' action="{{route('postReplies.destroy', ['postReply' => $postReply])}}">
            @method('delete')
            @csrf
        </form>
    </div>
@endforeach
<script type="module" src="{{asset('js/replies.js?v='.time())}}" defer></script>