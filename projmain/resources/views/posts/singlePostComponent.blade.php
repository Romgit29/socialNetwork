<link rel="stylesheet" href="{{ asset('css/feed.css').'?v='.time() }}">
<?php
    $postable = $post;
    $corpedText = $post->text;
?>
<div class='singlePostBlock' liked='{{$post->liked_by_current_user}}' postId="{{$post->id}}">
    @include('posts.postHeadComponent')
    @include('posts.postContentComponent')
    <form class='postEditForm' id='postEditForm_{{$key}}' style='display: none;' method='POST' action="{{route('posts.update', ['post' => $post->id])}}">
        @include('posts.postEditComponent')
    </form>
    <?php 
        $postable = $post;
    ?>
    @include('posts.postButtonsBlock')
    @include('posts.addReplyComponent')
    <form method='POST' class='deleteForm' action="{{ route('posts.destroy', ['post' => $post]) }}">
        @method('delete')
        @csrf
    </form>
</div>