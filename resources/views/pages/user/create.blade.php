<x-app-layout>
    <x-alert />
    <div class="w-2/3 mx-auto">
        <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mt-4">
                <x-label for="email" value="Name" />
                <x-input class="block w-full mt-1" type="text" name="name" :value="old('name')"/>
                @error('name')
                    <span class="text-red-900 p-2">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="mt-4">
                <x-label for="email" value="Email" />
                <x-input class="block w-full mt-1" type="email" name="email" :value="old('email')" />
                @error('email')
                    <span class="text-red-900 p-2">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />
    
                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
                @error('password')
                    <span class="text-red-900 p-2">{{ $message }}</span>
                @enderror
            </div>
    
            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />
    
                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="mt-4">
                <x-label for="foto_profile" value="Profile" />
                <input class="block w-full mt-1" type="file" name="foto_profile" value="{{ old('foto_profile') }}" />
                @error('foto_profile')
                    <span class="text-red-900 p-2">{{ $message }}</span>
                @enderror
            </div>
            <x-button type="submit" class="mt-4">Create</x-button>
        </form>
    </div>
    
</x-app-layout>
        
        
