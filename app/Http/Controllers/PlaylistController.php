<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $playlists = Playlist::with('user','tags')
                    ->where('name','like',"%{$request->search}%")
                    ->paginate(15);
        return view('pages.playlist.index', compact('playlists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        return view('pages.playlist.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:playlists,name',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:png,jpg,jpeg',
            'tags' => 'nullable|array',
        ]);

        $playlist = Playlist::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'thumbnail' => $request->thumbnail ? request()->file('thumbnail')->store('image/playlist') : null,
            'user_id' => auth()->user()->id,
        ]);
        $playlist->tags()->sync($request->tags);

        return back()->with('success','Playlist was created!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function show(Playlist $playlist)
    {
        return view('pages.playlist.index',compact('playlist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Playlist $playlist)
    {
        $tags = Tag::all();
        return view('pages.playlist.edit',compact('playlist','tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Playlist $playlist)
    {
        $request->validate([
            'name' => 'required|string|unique:playlists,name,'.$playlist->id,
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:png,jpg,jpeg',
        ]);

        if ($request->thumbnail) {
            Storage::delete($playlist->thumbnail);
            $thumbnail = request()->file('thumbnail')->store('image/playlist');
        } elseif($request->thumbnail == null) {
            $thumbnail = $playlist->thumbnail;
        } else {
            $thumbnail = null;
        }
        
        $playlist->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'thumbnail' => $thumbnail,
        ]);
        $playlist->tags()->sync($request->tags);

        return back()->with('success','Playlist was updated!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Playlist $playlist)
    {
        Storage::delete($playlist->thumbnail);
        $playlist->tags()->detach();
        $playlist->delete();
        return back()->with('success','Playlist was deleted!!');
    }
}
