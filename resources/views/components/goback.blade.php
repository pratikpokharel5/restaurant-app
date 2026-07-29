@props(['href' => '#'])

<div class="flex items-center gap-x-2">
    <a href="{{ $href }}"
        class="-ml-2 rounded-full p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
        aria-label="Go back">
        <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
    </a>

    <h1 class="text-xl font-bold text-slate-950 sm:text-2xl">
        {{ $slot }}
    </h1>
</div>
