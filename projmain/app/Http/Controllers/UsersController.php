<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditProfileRequest;
use App\Http\Service\PostService;
use App\Http\Service\ProfileService;
use App\Http\Service\UserService;

class UsersController extends Controller
{
    public function profile($id)
    {
        $profileData = ProfileService::get($id);
        $posts = PostService::get('lengthAwarePaginator', [
            'author_id' => $id,
            'with_replies' => true,
            'with_likes' => true,
            'order' => 'latest'
        ]);

        return view('users.profile')->with([
            'posts' => $posts,
            'profileData' => $profileData
        ]);
    }

    public function editProfile(EditProfileRequest $request, $id) {
        ProfileService::edit($request, $id);

        return back()->withSuccess('Profile updated successfully');
    }

    public function block($id) {
        UserService::block($id);

        return back()->withSuccess('User blocked successfully');
    }

    public function unblock($id) {
        UserService::unblock($id);

        return back()->withSuccess('User unblocked successfully');
    }
}