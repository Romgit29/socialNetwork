@foreach ($posts as $key => $post)
    <div class='row dataBlockContainer defaultMarginTop postBlock'>
        <div class='d-flex' style='flex-direction:column'>
            @include('posts.singlePostComponent')
            <div id='postReplies_{{$key}}'>
                <?php
                    $postReplies = $post->postReplies;
                ?>
                @include('posts.postRepliesComponent')
            </div>
        </div>
    </div>
@endforeach
@if(!Auth::check())
    <script>
        redirectOnLikes = document.querySelectorAll('.redirectOnLike');
        for(let redirectOnLike of redirectOnLikes) {
            redirectOnLike.setAttrubute('authorizeOnClick');
        }
    </script>
@endif
@include('posts.deleteModal')
@include('posts.repostModal')
<script type="module" src="{{asset('js/posts.js?v='.time())}}" defer></script>
<script type="text/javascript" src="{{asset('js/postsEdit.js?v='.time())}}" defer></script>
<script type="text/javascript" src="{{asset('js/postRepliesEdit.js?v='.time())}}" defer></script>