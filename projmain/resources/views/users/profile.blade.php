@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/default.css').'?v='.time() }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css').'?v='.time() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <div id='defaultStoragePath' style='display:none;'>{{asset('storage/')}}</div>
    <div class="container" style='width: 600px;'>
        <div id='picCorpModal'>
            <div id='picCorpModal_corpArea'>
                <div id='corpSquare'>
                    <div class='cornerCircle' id='picCorpModal_corpSquare_circleTopLeft'></div>
                    <div class='cornerCircle' id='picCorpModal_corpSquare_circleBottomLeft'></div>
                    <div class='cornerCircle' id='picCorpModal_corpSquare_circleBottomRight'></div>
                    <div class='cornerCircle' id='picCorpModal_corpSquare_circleTopRight'></div>
                </div>
                <div id='picCorpModal_img'></div>
            </div>
            <div id='picCorpModal_buttonsBlock'>
                <div class="btn btn-primary btn-sm" id='picCorpModal_saveButton' style='width: 150px;'>Save</div>
                <div class="btn btn-danger btn-sm" id='picCorpModal_closeButton' style='width: 150px;'>Close</div>
            </div>
        </div>
        <div class='row'>
            <div id='profileData'>
                <div id="imageUploadButtons" style='display:flex; position: absolute; z-index: 1; background: #36393e; padding: 3px; border-radius: 3px; display: none;'>
                        <button class='btn btn-primary postButton' style='width: 25px; height: 25px; border: 1px solid grey;'>
                            <label for="ppInput" style='cursor: pointer;'>
                                <svg fill="#000000" height="14px" width="14px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 495 495">
                                    <path id="XMLID_448_" d="M445.767,308.42l-53.374-76.49v-20.656v-11.366V97.241c0-6.669-2.604-12.94-7.318-17.645L312.787,7.301 C308.073,2.588,301.796,0,295.149,0H77.597C54.161,0,35.103,19.066,35.103,42.494V425.68c0,23.427,19.059,42.494,42.494,42.494 h159.307h39.714c1.902,2.54,3.915,5,6.232,7.205c10.033,9.593,23.547,15.576,38.501,15.576c26.935,0-1.247,0,34.363,0 c14.936,0,28.483-5.982,38.517-15.576c11.693-11.159,17.348-25.825,17.348-40.29v-40.06c16.216-3.418,30.114-13.866,37.91-28.811 C459.151,347.704,457.731,325.554,445.767,308.42z M170.095,414.872H87.422V53.302h175.681v46.752 c0,16.655,13.547,30.209,30.209,30.209h46.76v66.377h-0.255v0.039c-17.685-0.415-35.529,7.285-46.934,23.46l-61.586,88.28 c-11.965,17.134-13.387,39.284-3.722,57.799c7.795,14.945,21.692,25.393,37.91,28.811v19.842h-10.29H170.095z M410.316,345.771 c-2.03,3.866-5.99,6.271-10.337,6.271h-0.016h-32.575v83.048c0,6.437-5.239,11.662-11.659,11.662h-0.017H321.35h-0.017 c-6.423,0-11.662-5.225-11.662-11.662v-83.048h-32.574h-0.016c-4.346,0-8.308-2.405-10.336-6.271 c-2.012-3.866-1.725-8.49,0.783-12.07l61.424-88.064c2.189-3.123,5.769-4.984,9.57-4.984h0.017c3.802,0,7.38,1.861,9.568,4.984 l61.427,88.064C412.04,337.28,412.328,341.905,410.316,345.771z"></path>
                                </svg>
                            </label>
                        </button>
                        <button class='btn btn-danger postButton' id='deleteProfilePicButton' style='margin-left: 5px;'>
                            <svg xmlns="http://www.w3.org/2000/svg"  width="14" height="14" fill="red" viewBox="0 0 70 70">
                                <path d="M32 2a30 30 0 1 0 30 30A30 30 0 0 0 32 2zm0 7a22.89 22.89 0 0 1 13.598 4.454L13.453 45.597A22.996 22.996 0 0 1 32 9zm0 46a22.89 22.89 0 0 1-13.598-4.454l32.145-32.143A22.996 22.996 0 0 1 32 55z" fill="#202020"></path>
                            </svg>
                        </button>
                    <input id='ppInput' type='file' accept=".jpeg,.jpg,.png" name='newProfilePic' style='display: none;' form='editProfileForm'>
                    <input id='ppCorped' type='file' name='newProfilePicThumbnail' style='display: none;' form='editProfileForm'>
                    <input id='deleteProfilePicInput' name='deleteProfilePic' style='display: none;' form='editProfileForm'>
                </div>
                <div id="profilePicWrap">
                    <img id='profilePic' src="{{asset('storage/' . ($profileData->profilePicThumbnail->path ?? 'img_static/defaultpp.jpg'))}}">
                </div>
                <div style='display:flex; flex-direction: column; padding-left: 10px; width:100%;'>
                    <div style='min-height: 150px;'>
                        <div id='profileData_name'>
                            {{$profileData->user->name}}
                        </div>
                        <div id='profileData_status' style='position: relative;'>
                            <?php 
                                $corpedText = $profileData->status;
                            ?>
                            @include('posts.corpedTextComponent')
                        </div>
                        <div class='defaultMarginTop' style='display: flex;'>
                            <button class="btn btn-primary btn-sm defaultButton" type='submit' form='editProfileForm' style='display: none;' id='applyEdit'>Apply</button>
                            <button class="btn btn-danger btn-sm defaultButton" style='display: none; margin-left:5px;' id='discardEdit'>Discard</button>
                        </div>
                    </div>
                    <div class='defaultMarginTop' id='profileData_buttonsBlock'>
                        @if($profileData->user_id !== Auth::id())
                            @if($profileData->user->blocked_by_current_user)
                                <form method='POST' action="{{ route('users.unblock', ['id' => $profileData->user->id]) }}">
                                    @csrf
                                    @method('delete')
                                    <button type='submit' class="btn btn-primary btn-sm defaultButton" id='blockButton'>Unblock</button>
                                </form>
                            @else
                                <form method='POST' action="{{ route('users.block', ['id' => $profileData->user->id]) }}">
                                    @method('post')
                                    @csrf
                                    <button type='submit' class="btn btn-danger btn-sm defaultButton" id='blockButton'>Block</button>
                                </form>
                            @endif
                        @endif
                        @if($profileData->user_id == Auth::id() || (Auth::user() && Auth::user()->hasRole('admin')))
                            <button class="btn btn-primary btn-sm defaultButton" id='editProfile'>Edit</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Фотки -->
        <!-- <div class="row border rounded" style='padding-top:12px; padding-bottom:12px; margin-top:10px;'>
            <div class='col'>
                <img style='width:150px; height:150px;' src="{{asset('storage/img/defaultpp.jpg')}}" alt="">
            </div>
        </div>
        <div class="row border rounded" style='padding:6px; margin-top:6px;'>
            <div class="col col-6 p-0 d-flex" style='padding-right:3px;'>
                <div style='padding-right:3px; width: 100%;'>
                    <a class="btn btn-primary btn-sm w-100" href="#" style='width:auto;'>Add photo</a>
                </div>
            </div>
            <div class="col col-6 p-0 d-flex" style='padding-left:3px;'>
                <div style='padding-left:3px; width: 100%;'>
                    <a class="btn btn-primary btn-sm w-100" href="#" style='width:auto;'>Show photos</a>
                </div>
            </div>
        </div> -->
        @if($profileData->user_id == Auth::id())
            <div class="row">
                <textarea class='textareaGeneral' placeholder='Text' name='text' form='postStore'></textarea>
                <div class="col p-0 defaultMarginTop">
                    <form method='POST' id='postStore' action="{{ route('posts.store') }}">
                        <button type='submit' class="btn btn-primary btn-sm" style='width: 80px;'>Add post</button>
                        @method('post')
                        @csrf
                    </form>
                </div>
            </div>
        @endif
        @if ($errors->any())
            <div id='validationError' style='display:none;' >{{$errors->first()}}</div>
            <script>toastr.error(document.getElementById('validationError').innerHTML);</script>
        @endif
        @include('posts.postsListComponent')
        <div class ='d-flex pagination'>
            {{$posts->links()}}
        </div>
    </div>
    <form method='POST' name='editProfileForm' id='editProfileForm' enctype="multipart/form-data" action="{{ route('users.editProfile', ['id' => $profileData->user_id]) }}">
        @method('put')
        @csrf
    </form>
    <script type="module" src="{{asset('js/showFullButtonLogic.js?v='.time())}}"></script>
    <script type="module" src="{{asset('js/profile.js?v='.time())}}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
@endsection