<?php

namespace App\Http\Service;

use App\Http\Service\Traits\CrudableTrait;
use App\Models\Picture;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class ImageService
{
    use CrudableTrait;

    const MODEL = Picture::class;
    private $storedFilesPaths;

    public function __construct()
    {
        $this->storedFilesPaths = [];
    }

    public function saveToStorage(UploadedFile $image, $typeId) {
        $path = Config::get('image.imageTypeStoragePath')[$typeId];
        $image->store('public/images/' . $path);
        array_push($this->storedFilesPaths, $path);
        $path = 'images/' . $path . '/' . $image->hashName();

        return $path;
    }

    public function store(array $images, $typeId, $userId) {
        $date = date('Y-m-d H:i:s');
        $imagesDBData = [];
        $picturePaths = [];
        foreach($images as $image) {
            $path = $this->saveToStorage($image, $typeId);
            array_push($imagesDBData, [
                'user_id' => $userId,
                'picture_type_id' => $typeId,
                'path' => $path,
                'created_at' => $date,
                'updated_at' => $date
            ]);
            array_push($picturePaths, $path);
        }
        $result = Picture::insert($imagesDBData);
        $result = Picture::whereIn('path', $picturePaths)
        ->select('id')
        ->get();

        return $result;
    }

    public function delete($pictures) {
        $pictures = collect($pictures);
        $picrueIds = $pictures->pluck('id');
        $picruePaths = $pictures->pluck('path')->toArray();
        self::destroy($picrueIds, true);
        self::deleteFromStorage($picruePaths);

        return true;
    }

    public function deleteSavedImages() {
        return self::deleteFromStorage($this->storedFilesPaths);
    }

    public static function deleteFromStorage(array $paths) {
        foreach($paths as $path) {
            unlink(storage_path('app/public/' . $path));
        }
    }
}