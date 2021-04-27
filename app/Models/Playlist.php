<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Tags\HasTags;

class Playlist extends Model
{
    use HasFactory, HasTags;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'thumbnail',        
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function videos()
    {
        return $this->belongsToMany(Video::class,"playlist_video");
    }
}
