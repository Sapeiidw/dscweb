@if (session('success'))
    <div class="w-2/3 mx-auto bg-green-100 text-green-900 p-3 rounded-lg my-4">{{ session('success') }}</div>
@endif