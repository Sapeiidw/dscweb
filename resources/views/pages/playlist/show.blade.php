<x-app-layout>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <style>
        iframe {
            width: 100% !important;
            min-height: 360px;
        }
    </style>
    <x-slot name="header">
        playlist
    </x-slot>

    <div class="container mx-auto px-4 sm:px-8">
        <div class="py-8">
            <div class="container">
                @if (isset($video))
                    {!!  $video->code  !!}
                @else
                    <img src="{{ $playlist->thumbnail 
                        ? asset('storage/'.$playlist->thumbnail)
                        : "https://ui-avatars.com/api/?name=".$playlist->name
                    }}"
                    class="w-full h-64 object-cover">
                @endif  
                    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                        <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                            <table class="min-w-full leading-normal">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Eps
                                        </th>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Name
                                        </th>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider flex-wrap">
                                            Available For
                                        </th>
                                        <th
                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($playlist->videos as $item)
                                    <tr class="bg-white hover:bg-gray-50">
                                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                            {{ $item->episode }}
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 w-10 h-10">
                                                    <img class="w-full h-full rounded-full"
                                                        src="{{ $item->thumbnail 
                                                            ? asset('storage/'.$item->thumbnail)
                                                            : "https://ui-avatars.com/api/?name=".$item->name
                                                        }}"
                                                        alt="" />
                                                </div>
                                                <div class="ml-3">
                                                    <a href="{{ route('playlist.video',[$playlist->slug,$item->id]) }}" class="text-gray-900 whitespace-no-wrap">
                                                        {{ $item->name }} | {{ $item->duration }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                            {{-- @foreach ($playlist->tags as $tag)
                                                <span
                                                class="relative inline-block px-3 py-1 m-1 font-semibold text-indigo-900 leading-tight">
                                                <span aria-hidden
                                                    class="absolute inset-0 bg-indigo-200 opacity-50 rounded-full"></span>
                                                <span class="relative">{{ $tag->name }}</span>
                                                </span>
                                            @endforeach --}}
                                            <span
                                                class="relative inline-block px-3 py-1 m-1 font-semibold text-indigo-900 leading-tight">
                                                <span aria-hidden
                                                    class="absolute inset-0 bg-indigo-200 opacity-50 rounded-full"></span>
                                                <span class="relative">{{ $item->available_for }}</span>
                                                </span>
                                            
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                            
                                            <div class="flex flex-row w-20 justify-between">
                                            @if (auth()->user()->id === $playlist->user_id)
                                                @can('edit-video')
                                                <a href="{{ route('video.edit',$item->episode) }}" class="text-blue-900">Edit</a>    
                                                @endcan
                                                @can('delete-video')
                                                <form action="{{ route('video.destroy', $item->episode) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" onclick="return confirm('Are u Sure!!')" class="text-red-900">Delete</button>
                                                </form>
                                                @endcan
                                            @endif
                                                <a href="{{ route('playlist.video',[$playlist->slug,$item->episode]) }}" class="text-blue-900">View</a>
                                            </div>    
                                                
                                        </td>
                                    </tr>    
                                    @empty
                                       <tr>
                                           Data gak ada boss
                                        </tr> 
                                    @endforelse   
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
    