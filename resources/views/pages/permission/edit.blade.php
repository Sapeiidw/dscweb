<x-app-layout>
    <x-alert />
    <div class="w-2/3 mx-auto">
        <form action="{{ route('permission.update', $permission->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="mt-4">
                <x-label for="email" value="Name" />
                <x-input class="block w-full mt-1" type="text" name="name" value="{{ $permission->name }}"/>
                @error('name')
                    <span class="text-red-900 p-2">{{ $message }}</span>
                @enderror
            </div>
            <x-button type="submit" class="mt-4">Update</x-button>
            <x-button type="reset" class="mt-4">Cancel</x-button>
        </form>
    </div>
</x-app-layout>
        
        
