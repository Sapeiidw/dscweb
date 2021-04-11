<x-app-layout>
    <x-alert />
    <div class="w-2/3 mx-auto">
        <form action="{{ route('role.update', $role->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="mt-4">
                <x-label for="name" value="Name" />
                <x-input class="block w-full mt-1" type="text" name="name" value="{{ $role->name }}"/>
                @error('name')
                    <span class="text-red-900 p-2">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-label for="permission" value="Name" />
                <select class="block w-full mt-1 js-example-basic-multiple" name="permissions[]" multiple="multiple">
                    @foreach ($permissions as $permission)
                        <option {{ $role->permissions()->find($permission->id) ? "selected" : "" }}  value="{{ $permission->name }}">{{ $permission->name }}</option>    
                    @endforeach
                  </select>
                @error('name')
                    <span class="text-red-900 p-2">{{ $message }}</span>
                @enderror
            </div>
            <x-button type="submit" class="mt-4">Update</x-button>
            <x-button type="reset" class="mt-4">Cancel</x-button>
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
        
        
