@if (session('success'))
    {{ session('success') }}
@endif
<form action="{{ route('user.update', $user->id) }}" method="post">
    @csrf
    @method('put')
    <input type="text" name="name" value="{{ $user->name }}">
    @error('name')
        {{ $message }}
    @enderror
    <input type="email" name="email" value="{{ $user->email }}">
    @error('email')
        {{ $message }}
    @enderror
    <button type="submit">Update</button>
    <button type="reset">Cancel</button>
</form>