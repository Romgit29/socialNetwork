<div class='mainText'>
    @include('posts.corpedTextComponent')
</div>
<textarea name='text' class='textareaGeneral defaultMarginTop editTextArea' style='display: none;' form='postEditForm_{{$key}}'></textarea>
@if($post->repost)
    <div class='repost defaultMarginTop'>
        <div class='verticalLine'></div>
        <div style='margin-left: 10px;'>
            <?php
                $postable = $post->repost;
                $corpedText = $post->repost->text;
            ?>
            @include('posts.postHeadComponent')
            @include('posts.corpedTextComponent')
        </div>
    </div>
@endif