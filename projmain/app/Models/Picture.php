<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    protected $guarderd = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function profileData() {
        return $this->belongsTo(ProfileData::class, 'id', 'profile_pic_thumbnail');
    }

    use HasFactory;
}