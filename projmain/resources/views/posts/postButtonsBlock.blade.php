<div class='defaultMarginTop linearButtonsBlock d-flex'>
    <button class="btn btn-primary btn-sm postButton likeButton" user_is_authorized="{{Auth::check()}}">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="white" viewBox="0 0 24 24">
            <path d="M12 4.435c-1.989-5.399-12-4.597-12 3.568 0 4.068 3.06 9.481 12 14.997 8.94-5.516 12-10.929 12-14.997 0-8.118-10-8.999-12-3.568z" />
        </svg>
        <div class="likesCount">
            {{$postable->likes_count}}
        </div>
        <form method='post' class='likeForm' domain="{{Config::get('app.url')}}">
            @csrf
        </form>
    </button>
    <button class="btn btn-primary btn-sm postButton repostButton">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="white" viewBox="0 0 24 24">
            <path d="M5 10v7h10.797l1.594 2h-14.391v-9h-3l4-5 4 5h-3zm14 4v-7h-10.797l-1.594-2h14.391v9h3l-4 5-4-5h3z" />
        </svg>
    </button>
    <button class="btn btn-primary btn-sm postButton addReplyButton">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="white" viewBox="0 0 24 24">
            <path d="M12 1c-6.338 0-12 4.226-12 10.007 0 2.05.739 4.063 2.047 5.625l-1.993 6.368 6.946-3c1.705.439 3.334.641 4.864.641 7.174 0 12.136-4.439 12.136-9.634 0-5.812-5.701-10.007-12-10.007zm0 1c6.065 0 11 4.041 11 9.007 0 4.922-4.787 8.634-11.136 8.634-1.881 0-3.401-.299-4.946-.695l-5.258 2.271 1.505-4.808c-1.308-1.564-2.165-3.128-2.165-5.402 0-4.966 4.935-9.007 11-9.007zm-5 7.5c.828 0 1.5.672 1.5 1.5s-.672 1.5-1.5 1.5-1.5-.672-1.5-1.5.672-1.5 1.5-1.5zm5 0c.828 0 1.5.672 1.5 1.5s-.672 1.5-1.5 1.5-1.5-.672-1.5-1.5.672-1.5 1.5-1.5zm5 0c.828 0 1.5.672 1.5 1.5s-.672 1.5-1.5 1.5-1.5-.672-1.5-1.5.672-1.5 1.5-1.5z" />
        </svg>
    </button>
    @if(Auth::check() && ($postable->user_id == Auth::id() || Auth::user()->hasRole('admin')))
        <button class="btn btn-primary btn-sm postButton editButton">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="white">
                <path d="M1,22V4A1,1,0,0,1,2,3H12a1,1,0,0,1,0,2H3V21H19V12a1,1,0,0,1,2,0V22a1,1,0,0,1-1,1H2A1,1,0,0,1,1,22ZM11.293,8.626l7.333-7.333a1,1,0,0,1,1.414,0l2.667,2.666a1,1,0,0,1,0,1.415l-7.334,7.333a1,1,0,0,1-.707.293H12a1,1,0,0,1-1-1V9.333A1,1,0,0,1,11.293,8.626ZM13,11h1.252l6.334-6.333L19.333,3.414,13,9.748Z"></path>
            </svg>
        </button>
        <button class="btn btn-danger btn-sm postButton deleteButton">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="white" viewBox="0 0 17 17"> 
                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/> <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
            </svg>
        </button>
    @endif
</div>