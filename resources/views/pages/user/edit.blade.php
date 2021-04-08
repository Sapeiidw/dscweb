<x-app-layout>
    <x-alert />
    <div class="w-2/3 mx-auto">
        <form action="{{ route('user.update', $user->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="mt-4">
                <x-label for="email" value="Name" />
                <x-input class="block w-full mt-1" type="text" name="name" value="{{ $user->name }}"/>
                @error('name')
                    <span class="text-red-900 p-2">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="mt-4">
                <x-label for="email" value="Email" />
                <x-input class="block w-full mt-1" type="email" name="email" value="{{ $user->email }}" />
                @error('email')
                    <span class="text-red-900 p-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-4">
                <x-label for="foto_profile" value="Profile" />
                <input class="block w-full mt-1" type="file" name="foto_profile" />
                @error('foto_profile')
                    <span class="text-red-900 p-2">{{ $message }}</span>
                @enderror
            </div>
            <x-button type="submit" class="mt-4">Update</x-button>
            <x-button type="submit" class="mt-4">Cancel</x-button>
        </form>
    </div>
    
</x-app-layout>
        
        
