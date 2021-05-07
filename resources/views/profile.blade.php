<x-app-layout>
    <x-alert />
    <div class="w-2/3 mx-auto">
        <h1 class="mt-5 text-lg text-gray-600">Profile</h1>
        <form action="{{ route('user.update', auth()->user()->id) }}" method="post" enctype="multipart/form-data"
            class="p-3 my-2 bg-white shadow rounded">
            @csrf
            @method('put')
            <div class="mt-4">
                <x-label for="email" value="Name" />
                <x-input class="block w-full mt-1" type="text" name="name" value="{{ auth()->user()->name }}"/>
                @error('name')
                    <span class="text-red-900 p-2">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="mt-4">
                <x-label for="email" value="Email" />
                <x-input class="block w-full mt-1" type="email" name="email" value="{{ auth()->user()->email }}" />
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
                        <option {{ auth()->user()->roles()->find($role->id) ? "selected" : "" }} value="{{ $role->name }}">{{ $role->name }}</option>
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

        <h1 class="mt-5 text-lg text-gray-600">Change Password</h1>
        <form action="{{ route('change_password', auth()->user()->id) }}" method="post"
            class="p-3 my-2 bg-white shadow rounded">
            @csrf
            <div class="mt-4">
                <x-label for="password" value="Old Password" />
                <x-input class="block w-full mt-1" type="password" name="old_password" />
                @error('old_password')
                    <span class="text-red-900 p-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-4">
                <x-label for="password" value="New Password" />
                <x-input class="block w-full mt-1" type="password" name="password" />
                @error('password')
                    <span class="text-red-900 p-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-4">
                <x-label for="password" value="Confirm New Password" />
                <x-input class="block w-full mt-1" type="password" name="password_confirmation" />
                @error('password_confirmation')
                    <span class="text-red-900 p-2">{{ $message }}</span>
                @enderror
            </div>
            <x-button type="submit" class="mt-4">Update</x-button>
            <x-button type="reset" class="mt-4">Cancel</x-button>
        </form>
        <h1 class="mt-5 text-lg text-gray-600">Subscription</h1>
        <div class="p-3 my-2 bg-white shadow rounded">
            
            @if (auth()->user()->subscribed('primary'))
                <form action="/unsubscribe" method="post">
                    @csrf
                    <x-button type="submit" onclick="return confirm('Unsubscribe are u sure??')">Subscribed</x-button>
                </form>
            @else
                <a href="payment" class="py-2 px-4 bg-red-500 text-white rounded-md text-xs uppercase tracking-wider font-semibold">Subscribe</a>
                @if (auth()->user()->subscription('primary') and auth()->user()->subscription('primary')->cancelled())
                    <div class="text-gray-800 mt-2">
                        <p>Your subscription is cancelled and it will end at 
                            <span class="text-gray-900 font-bold">{{ auth()->user()->subscription('primary')->ends_at }}</span> 
                            so u can still enjoy the premium stuff. Thanks!!</p>
                    </div>
                @endif
            @endif
        </div>
    </div>
    
</x-app-layout>