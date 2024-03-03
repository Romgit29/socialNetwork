@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/default.css').'?v='.time() }}">
    <link rel="stylesheet" href="{{ asset('css/feed.css').'?v='.time() }}">
    <div class="postThreadConteiner">
        <?php
            $key=0;
            $postable = $post;
            $corpedText = $post->text;
        ?>
        <div class="dataBlockContainer">
            <div class="d-flex postBlock singlePostBlock" liked='{{$post->liked_by_current_user}}' postId='{{$post->id}}'>
                <div id="profilePicWrap">
                    <img src="{{asset('storage/' . ($post->profile_pic_path ?? 'img_static/defaultpp.jpg'))}}">
                </div>
                <div style='margin-left: 15px;'>
                    <div style='min-height: 120px;'>
                        <a href="{{route('users.profile', ['id' => $postable->user_id])}}">
                            {{$post->name}}
                        </a>
                        <div>
                            <a href="{{route('posts.show', ['post' => $post])}}">{{$post->created_at}}</a>
                        </div>
                        @include('posts.postContentComponent')
                        <form method='POST' id='postEditForm_{{$key}}' class='postEditForm' style='display: none;' action="{{route('posts.update', ['post' => $post->id])}}">
                            @include('posts.postEditComponent')
                        </form>
                    </div>
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
            </div>
        </div>
        <div class="dataBlockContainer" id='postReplieDataBlockContainer' style='margin-top: 10px;'>
            <div id='postRepliesContainer' style='width: 100%;'>
                @include('posts.postRepliesComponent')
            </div>
            <script>
                let postReplies = document.getElementsByClassName('postReply');
                if(postReplies.length > 0) {
                    document.querySelector('.postReplyHr').remove();
                } else {
                    document.querySelector('#postReplieDataBlockContainer').style.display = 'none';
                }
                
                let addReplyBlocks = document.getElementsByClassName('addReplyBlock');
                for(let addReplyBlock of addReplyBlocks) {
                    addReplyBlock.style.width = '600px';
                }
                let editBlocks = document.getElementsByClassName('editTextArea');
                for(let editBlock of editBlocks) {
                    editBlock.style.width = '600px';
                }
            </script>
        </div>
    </div>
    @if ($errors->any())
        <div id='validationError' style='display:none;' >{{$errors->first()}}</div>
        <script>toastr.error(document.getElementById('validationError').innerHTML);</script>
    @endif
    <div class ='d-flex pagination'>
        {{$postReplies->links()}}
    </div>
    @include('posts.deleteModal')
    @include('posts.repostModal')
    <script type="module" src="{{asset('js/showFullButtonLogic.js?v='.time())}}" defer></script>
    <script type="module" src="{{asset('js/posts.js?v='.time())}}" defer></script>
    <script type="module" src="{{asset('js/postsEdit.js?v='.time())}}" defer></script>
    <script type="module" src="{{asset('js/postRepliesEdit.js?v='.time())}}" defer></script>
@endsection