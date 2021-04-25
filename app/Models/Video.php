<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','slug','code','duration','episode','available_for',
    ];

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class,"playlist_video");
    }
}
