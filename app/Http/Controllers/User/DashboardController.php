<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Spatie\Tags\Tag;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $playlists = Playlist::with('tags','user','videos')
                ->where('name','like',"%{$request->search}%")
                ->paginate(21);;
        $tags = Tag::all();
        return view('welcome', compact('playlists','tags'));
    }
}
