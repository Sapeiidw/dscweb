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

            @role('super-admin')
            <div class="mt-4">
                <x-label for="role" value="Role" />
                <select name="role" id="role"
                    class="block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" >
                    @foreach ($roles as $role)
                        <option {{ $user->roles()->find($role->id) ? "selected" : "" }} value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>
                @error('role')
                    <span class="text-red-900 p-2">{{ $message }}</span>
                @enderror
            </div>
            @endrole

            <div class="mt-4">
                <x-label for="foto_profile" value="Profile" />
                <input class="block w-full mt-1" type="file" name="foto_profile" />
                @error('foto_profile')
                    <span class="text-red-900 p-2">{{ $message }}</span>
                @enderror
            </div>
            <x-button type="submit" class="mt-4">Update</x-button>
            <x-button type="reset" class="mt-4">Cancel</x-button>
        </form>
    </div>
    
</x-app-layout>
        
        
