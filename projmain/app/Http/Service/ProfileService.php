<?php

namespace App\Http\Service;

use Illuminate\Support\Facades\DB;
use App\Http\Service\ImageService;
use App\Http\Repositories\ProfileRepository;
use Illuminate\Http\Request;

class ProfileService
{
    public static function edit(Request $request, $id){
        $imageService = new ImageService();
        $profileData = self::get($id);
        $user = $profileData->user;
        $oldProfilePicThumbnail = $profileData->profilePicThumbnail;

        DB::beginTransaction();
        try {
            $user->name = $request->input('name');
            if($request->has('newProfilePic')){
                if($profileData->profile_pic_thumbnail) {
                    $imageService->delete([$oldProfilePicThumbnail]);
                }
                $profilePic = self::saveProfilePicture($imageService, $request->file('newProfilePicThumbnail'), $request->file('newProfilePic'), $id);
                $profileData->profile_pic = $profilePic['profile_pic'];
                $profileData->profile_pic_thumbnail = $profilePic['profile_pic_thumbnail'];
            } else if ($request->boolean('deleteProfilePic')) {
                if($profileData->profile_pic_thumbnail) $imageService->delete([$oldProfilePicThumbnail]);
                $profileData->profile_pic_thumbnail = null;
                $profileData->profile_pic = null;
            }
            $profileData->status = $request->input('status');
            $user->save();
            $profileData->save();
        } catch(\Throwable $th) {
            $imageService->deleteSavedImages();
            throw $th;
        }
        DB::commit();

        return true;
    }

    private static function saveProfilePicture(ImageService $imageService, $profilePicThumbnail, $profilePicFull, $userId) {
        $profilePicThumbnailId = $imageService->store([$profilePicThumbnail], 1, $userId)[0]->id;
        $profilePicFullId = $imageService->store([$profilePicFull], 3, $userId)[0]->id;
        
        return [
            'profile_pic' => $profilePicFullId,
            'profile_pic_thumbnail' => $profilePicThumbnailId
        ];
    }

    public static function get($id) {
        return ProfileRepository::get($id);
    }
}