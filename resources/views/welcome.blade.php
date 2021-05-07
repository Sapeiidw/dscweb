@extends('layouts.user')

@section('content')
    
    {{-- harusnya slide --}}
    <div class="flex h-64 w-full rounded-md bg-gray-400">
                        
    </div>
    <div class="flex flex-row mt-4">
        <div class="w-3/4 min-h-screen">
            <div class="grid grid-cols-3 grid-flow-row gap-5">
                @foreach ($playlists as $playlist)
                <div class="flex flex-col">
                    <img class="rounded-lg w-full h-36 object-cover shadow-md"
                    src="{{ $playlist->thumbnail 
                        ? asset('storage/'.$playlist->thumbnail)
                        : "https://ui-avatars.com/api/?name=".$playlist->name
                    }}"
                    alt="">
                    <a href="{{ route('playlist.show', $playlist->slug) }}" class="text-gray-800 font-bold capitalize">{{ $playlist->name }}</a>
                    {{ \Illuminate\Support\Str::limit($playlist->description, 50, $end='...') }}
                </div>
                @endforeach
                
            </div>
        </div>
        <div class="w-1/4 min-h-screen">
            <div class="flex flex-wrap">
                @foreach ($tags as $tag)
                    <x-badge>{{ $tag->name }}</x-badge>
                @endforeach
            </div>
        </div>
    </div>
@endsection