<div class='postableHead'>
    <div class="wrapperPPFeed">
        <!-- default pp path: img_static/defaultpp.jpg -->
        <img src="{{asset('storage/' . ($postable->profile_pic_path ?? 'img_static/defaultpp.jpg'))}}">
    </div>
    <div class='authorAndDate'>
        <div>
            <a href="{{route('users.profile', ['id' => $postable->user_id])}}">
                {{$postable->name}}
            </a>
        </div>
        <div>
            <a href="{{route('posts.show', ['post' => $postable->post_id ?? $postable])}}">{{$postable->created_at}}</a>
        </div>
    </div>
</div>