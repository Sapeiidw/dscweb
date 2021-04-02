@if (session('success'))
    {{ session('success') }}
@endif
<form action="{{ route('user.store') }}" method="post">
    @csrf
    <input type="text" name="name" value="{{ old('name') }}">
    @error('name')
        {{ $message }}
    @enderror
    <input type="email" name="email" value="{{ old('email') }}">
    @error('email')
        {{ $message }}
    @enderror
    <input type="password" name="password">
    @error('password')
        {{ $message }}
    @enderror
    <input type="password" name="password_confirmation">
    <button type="submit">Create</button>
</form>