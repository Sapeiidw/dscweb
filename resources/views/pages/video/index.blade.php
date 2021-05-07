<x-app-layout>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <x-slot name="header">
        video
    </x-slot>

    <div class="container mx-auto px-4 sm:px-8">
        <div class="py-8">
            <div>
                <h2 class="text-2xl font-semibold leading-tight">videos</h2>
            </div>
            <form action="{{ route('video.index') }}" class="my-2 flex sm:flex-row flex-col items-center justify-between">
                <div class="block relative">
                    <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current text-gray-500">
                            <path
                                d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z">
                            </path>
                        </svg>
                    </span>
                    <input placeholder="Search" name="search"
                        class="appearance-none rounded border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
                </div>
                <div class="block relative">
                    <a href="{{ route('video.create') }}" class="h-full py-2 px-5 bg-gray-800 text-gray-50 hover:bg-gray-900 rounded ml-2">Add video</a>
                </div>
            </form>
            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <x-tr>
                                <x-th>
                                    Video
                                </x-th>
                                <x-th>
                                    Name
                                </x-th>
                                <x-th>
                                    Playlist
                                </x-th>
                                <x-th>
                                    Action
                                </x-th>
                            </x-tr>
                        </thead>
                        <tbody>
                            @forelse ($videos as $item)
                            <x-tr>
                                <x-td>
                                    {!! $item->code !!}
                                </x-td>

                                <x-td>
                                    <a href="{{ route('video.show',$item->id) }}" class="text-gray-900 whitespace-no-wrap">
                                        {{ $item->name }}
                                    </a>
                                </x-td>
                                
                                <x-td>
                                    @foreach ($item->playlists as $playlist)
                                        {{ $playlist->name }}
                                    @endforeach
                                </x-td>
                                <x-td>
                                    <div class="flex flex-row w-20 justify-between">
                                        @can('edit-video')
                                        <a href="{{ route('video.edit',$item->id) }}" class="text-blue-900">Edit</a>    
                                        @endcan
                                        @can('delete-video')
                                        <form action="{{ route('video.destroy', $item->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" onclick="return confirm('Are u Sure!!')" class="text-red-900">Delete</button>
                                        </form>
                                        @endcan
                                        
                                    </div>
                                </x-td>
                            </x-tr>    
                            @empty
                               <x-tr>
                                   Data gak ada boss
                                </x-tr> 
                            @endforelse   
                        </tbody>
                    </table>
                    <div class="p-2">
                        {{ $videos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
    