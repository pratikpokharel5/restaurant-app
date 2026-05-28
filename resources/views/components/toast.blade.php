<div
    class="z-100 fixed bottom-2 left-1/2 flex -translate-x-1/2 items-center gap-x-3 rounded-lg bg-blue-600 px-5 py-3 text-white shadow-md">
    <div class="flex items-center gap-x-2">
        <div>
            <svg fill="currentColor" width="22" height="22" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path
                    d="M13,9H11V7H13M13,17H11V11H13M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />
            </svg>
        </div>

        <div>
            {{ $slot }}
        </div>
    </div>

    <div>
        <button type="button" class="rounded px-2 py-1 hover:bg-blue-500"
            onclick="this.parentElement.parentElement.remove()">
            OK
        </button>
    </div>
</div>
