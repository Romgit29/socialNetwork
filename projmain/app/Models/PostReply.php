<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\LikableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostReply extends Model
{
    use HasFactory, LikableTrait;

    protected $table = 'post_replies';

    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function post() : BelongsTo{
        return $this->belongsTo(Post::class);
    }
}
