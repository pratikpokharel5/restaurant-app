<header
    class="fixed left-0 top-0 z-20 w-full border-b border-slate-200 bg-white/95 text-slate-900 shadow-sm backdrop-blur">
    <div class="flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8">
        <a href="{{ route('categories.index') }}"
            class="flex items-center gap-3 rounded-md font-semibold outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
            <span class="grid size-9 place-items-center rounded-md bg-blue-600 text-base text-white">
                <i class="fa-solid fa-utensils" aria-hidden="true"></i>
            </span>
            <span class="text-lg">Restaurant App</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="inline-flex items-center gap-2 rounded-md border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                <i class="fa-solid fa-arrow-right-from-bracket text-slate-500" aria-hidden="true"></i>
                Log Out
            </button>
        </form>
    </div>
</header>
