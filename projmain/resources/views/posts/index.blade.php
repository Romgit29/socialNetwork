@extends('layouts.app')

@section('content')
<div class="container" style='width: 600px;'>
    <div class="p-4 rounded contentBlock postsContainer">
        <div class="row">
            <h2 class="col d-flex justify-content-center">Feed</h2>
        </div>
        @include('posts.postsListComponent')
        @if ($errors->any())
            <div id='validationError' style='display:none;' >{{$errors->first()}}</div>
            <script>toastr.error(document.getElementById('validationError').innerHTML);</script>
        @endif
        <div class ='d-flex pagination'>
            {{$posts->links()}}
        </div>
    </div>
</div>
<script type="module" src="{{asset('js/showFullButtonLogic.js?v='.time())}}"></script>
@endsection