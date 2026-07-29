<div class="fixed bottom-4 left-1/2 z-50 flex max-w-[calc(100vw-2rem)] -translate-x-1/2 items-center gap-x-3 rounded-md bg-slate-900 px-4 py-3 text-sm font-medium text-white shadow-lg"
    role="status">
    <div class="flex items-center gap-x-2">
        <i class="fa-solid fa-circle-info" aria-hidden="true"></i>

        <div>
            {{ $slot }}
        </div>
    </div>

    <div>
        <button type="button"
            class="rounded px-2 py-1 hover:bg-white/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-white"
            onclick="this.parentElement.parentElement.remove()">
            OK
        </button>
    </div>
</div>
