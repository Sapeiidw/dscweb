<x-app-layout>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <x-slot name="header">
        tag
    </x-slot>

    <div class="container mx-auto px-4 sm:px-8">
        <div class="py-8">
            <div>
                <h2 class="text-2xl font-semibold leading-tight">tags</h2>
            </div>
            <form action="{{ route('tag.index') }}" class="my-2 flex sm:flex-row flex-col items-center justify-between">
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
                    <a href="{{ route('tag.create') }}" class="h-full py-2 px-5 bg-gray-800 text-gray-50 hover:bg-gray-900 rounded ml-2">Add tag</a>
                </div>
            </form>
            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Name
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tags as $item)
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                    <span
                                    class="relative inline-block px-3 py-1 font-semibold text-indigo-900 leading-tight">
                                    <span aria-hidden
                                        class="absolute inset-0 bg-indigo-200 opacity-50 rounded-full"></span>
                                    <span class="relative">{{ $item->name }}</span>
                                    </span>
                                </td>
                                
                                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                    <div class="flex flex-row w-20 justify-between">
                                        @can('edit-tag')
                                        <a href="{{ route('tag.edit',$item->id) }}" class="text-blue-900">Edit</a>    
                                        @endcan
                                        @can('delete-tag')
                                        <form action="{{ route('tag.destroy', $item->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" onclick="return confirm('Are u Sure!!')" class="text-red-900">Delete</button>
                                        </form>
                                        @endcan
                                        
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
                    <div class="p-2">
                        {{ $tags->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
    