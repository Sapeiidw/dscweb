<div class="w-1/5 min-h-screen py-5 bg-gray-800 flex flex-col ">
    <x-sidebar-link :active="request()->routeIs('dashboard')"  :href="route('dashboard')">dashboard</x-sidebar-link>
    <x-sidebar-link :active="request()->routeIs('user.*')"  :href="route('user.index')">user</x-sidebar-link>
    <x-sidebar-link :active="request()->routeIs('role.*')"  :href="route('role.index')">role</x-sidebar-link>
    <x-sidebar-link :active="request()->routeIs('permission.*')"  :href="route('permission.index')">permission</x-sidebar-link>
    <x-sidebar-link :active="request()->routeIs('playlist.*')"  :href="route('playlist.index')">playlist</x-sidebar-link>
    <x-sidebar-link :active="request()->routeIs('video.*')"  :href="route('video.index')">video</x-sidebar-link>
    <x-sidebar-link :active="request()->routeIs('tag.*')"  :href="route('tag.index')">tag</x-sidebar-link>
</div>