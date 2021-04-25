@props(['active'])

@php
$classes = ($active ?? false)
            ? 'w-full p-3 font-medium capitalize bg-gray-900 text-gray-50 transition-all ease-in-out duration-500'
            : 'w-full p-3 text-gray-400 font-medium capitalize hover:bg-gray-900 hover:text-gray-50 transition-all ease-in-out duration-500';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
