<x-app-layout>
    <x-alert />
    <div class="w-2/3 mx-auto">
        <form action="{{ route('playlist.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mt-4">
                <x-label for="name" value="Name" />
                <x-input class="block w-full mt-1" type="text" name="name" :value="old('name')"/>
                @error('name')
                    <span class="text-red-900 p-2">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-label for="description" value="Description" />
                <textarea name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-red-900 p-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-4">
                <x-label for="tag" value="Tag" />
                <select class="block w-full mt-1 js-example-basic-multiple" name="tags[]" multiple="multiple">
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                  </select>
                @error('tags')
                    <span class="text-red-900 p-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-4">
                <x-label for="thumbnail" value="Thumbnail" />
                <input class="block w-full mt-1" type="file" name="thumbnail" value="{{ old('thumbnail') }}" />
                @error('thumbnail')
                    <span class="text-red-900 p-2">{{ $message }}</span>
                @enderror
            </div>
            
            <x-button type="submit" class="mt-4">Create</x-button>
        </form>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.slim.min.js" integrity="sha512-6ORWJX/LrnSjBzwefdNUyLCMTIsGoNP6NftMy2UAm1JBm6PRZCO1d7OHBStWpVFZLO+RerTvqX/Z9mBFfCJZ4A==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
</x-app-layout>
        
        
