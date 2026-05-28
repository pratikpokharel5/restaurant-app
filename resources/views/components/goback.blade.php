@props(['href' => '#'])

<div class="flex items-center gap-x-1">
    <a href={{ $href }} class="-ml-2 cursor-pointer rounded-full p-2 hover:bg-gray-100">
        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z" />
        </svg>
    </a>

    <h3 class="text-2xl font-bold">
        {{ $slot }}
    </h3>
</div>
