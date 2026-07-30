<header
    class="fixed left-0 top-0 z-20 w-full border-b border-slate-200 bg-white/95 text-slate-900 shadow-sm backdrop-blur">
    <div class="flex h-16 items-center justify-between gap-3 px-4 sm:px-6 lg:px-8">
        <a href="{{ route('dashboard') }}"
            class="flex min-w-0 items-center gap-3 rounded-md font-semibold outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
            <span class="grid size-9 place-items-center rounded-md bg-blue-600 text-base text-white">
                <i class="fa-solid fa-utensils" aria-hidden="true"></i>
            </span>
            <span class="truncate text-lg">Restaurant App</span>
        </a>

        <x-dropdown>
            <x-slot:trigger
                class="inline-flex items-center gap-2 rounded-md bg-white px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                <span class="grid size-7 place-items-center rounded-full bg-slate-100">
                    <i class="fa-solid fa-user" aria-hidden="true"></i>
                </span>
                <span class="hidden max-w-40 truncate sm:inline">{{ auth()->user()->name }}</span>
                <i class="fa-solid fa-chevron-down text-xs" aria-hidden="true"></i>
            </x-slot:trigger>

            <x-dropdown-link href="{{ route('profile.edit') }}">
                <i class="fa-solid fa-user-gear w-4 text-center" aria-hidden="true"></i>
                My Profile
            </x-dropdown-link>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-dropdown-button>
                    <i class="fa-solid fa-arrow-right-from-bracket w-4 text-center" aria-hidden="true"></i>
                    Log Out
                </x-dropdown-button>
            </form>
        </x-dropdown>
    </div>
</header>
