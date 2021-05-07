@props(['active'])

@php
$classes = ($active ?? false)
            ? "opacity-1"
            : "opacity-0"
@endphp
<style>
    #sidebar-link {
        transition: all ease-in-out 0.2s;
    }
    #sidebar-link svg {
        fill: white;
    }
    #sidebar-link:hover div svg {
        fill: black;
    }
    #sidebar-link:hover label {
        color: black!important;
    }
    #sidebar-link:hover svg#bool {
        opacity: 1;
        fill: white;
    }
</style>
<a id="sidebar-link" {{ $attributes->merge(['class' => 'w-full h-20 relative']) }}>
    <div class="relative z-10 flex flex-col items-center justify-center w-full h-full pt-1">
        {{ $slot }}
    </div>
    <svg {{  
        $attributes->merge(['id'=>'bool','class' => "{$classes} absolute top-0 bottom-0 right-0 z-0 transition ease-in-out duration-200",
        'width'=>"71", 'height'=>"84", 'viewBox'=>"0 0 71 84", 'fill'=>"none", 'xmlns'=>"http://www.w3.org/2000/svg" ]) }}> 
        <path d="M0 42C0 25.1534 13.7388 11.4966 30.6864 11.4966H60.1695H71V39.0095V72.5034L30.6864 72.5034C13.7388 72.5034 0 58.8466 0 42Z" />
        <path d="M71 1.3288C71 7.30987 64.3814 10.8985 60.1695 11.4966H71C71 11.4966 71 -4.65226 71 1.3288Z" />
        <path d="M71 1.3288C71 7.30987 64.3814 10.8985 60.1695 11.4966H71C71 11.4966 71 -4.65226 71 1.3288Z" />
        <path d="M71 1.3288C71 7.30987 64.3814 10.8985 60.1695 11.4966H71C71 11.4966 71 -4.65226 71 1.3288Z" />
        <path d="M0 42C0 58.8466 13.7388 72.5034 30.6864 72.5034L60.1695 72.5034H71V39.0095V11.4966H30.6864C13.7388 11.4966 0 25.1534 0 42Z" />
        <path d="M71 82.6712C71 76.6901 64.3814 73.1015 60.1695 72.5034H71C71 72.5034 71 88.6523 71 82.6712Z" />
        <path d="M71 82.6712C71 76.6901 64.3814 73.1015 60.1695 72.5034H71C71 72.5034 71 88.6523 71 82.6712Z" />
        <path d="M71 82.6712C71 76.6901 64.3814 73.1015 60.1695 72.5034H71C71 72.5034 71 88.6523 71 82.6712Z" />
    </svg>
</a>
