<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $videos = Video::with('playlists')
                ->where('name','like',"%{$request->search}%")
                ->paginate(15);
    
        return view('pages.video.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $playlists = Playlist::all();
        return view('pages.video.create', compact('playlists'));
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
            'name' => 'required|string',
            'code' => 'required|unique:videos,code',
            'duration' => 'required|string',
            'playlists' => 'required',
            'episode' => 'required|numeric',
            'available_for' => 'required'
        ]);

        $video = Video::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'code' => $request->code,
            'duration' => $request->duration,
            'episode' => $request->episode,
            'available_for' => $request->available_for,
        ]);
        
        $video->playlists()->sync($request->playlists);
        
        return back()->with('success','Video was Created!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        if ($video->avaliable_for == "free") {
            $video->with('playlist');
            return view('pages.video.show', compact('video'));
        } else {
            if(auth()->user()->can("watch-premium")) {
                $video->with('playlist');
                return view('pages.video.show', compact('video'));
            }
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        $playlists = Playlist::all();
        return view('pages.video.edit', compact('video','playlists'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|unique:videos,code,'.$video->id,
            'duration' => 'required|string',
            'episode' => 'required|numeric',
            'available_for' => 'required|string',
            'playlist' => 'nullable|array',            
        ]);

        $video->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'code' => $request->code,
            'duration' => $request->duration,
            'episode' => $request->episode,
            'available_for' => $request->available_for,
        ]);
        $video->playlists()->sync($request->playlists);

        return back()->with('success','Video was Updated!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        $video->delete();
        
        return back()->with('success','Video was Deleted!!');
    }
}
