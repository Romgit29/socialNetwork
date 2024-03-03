<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProfileData extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'profile_pic', 'profile_pic_thumbnail', 'background_image', 'status', 'created_at', 'updated_at'];

    public function profilePic()
    {
        return $this->hasOne(Picture::class, 'id', 'profile_pic');
    }

    public function profilePicThumbnail()
    {
        return $this->hasOne(Picture::class, 'id', 'profile_pic_thumbnail');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
