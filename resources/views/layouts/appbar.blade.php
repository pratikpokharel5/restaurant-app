<header class="fixed left-0 top-0 z-10 w-full bg-blue-800 text-white">
    <div class="flex items-center justify-between py-3 pl-5 pr-10">
        <a href="{{ route('categories.index') }}" class="text-xl font-semibold">Restaurant App</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="rounded-md px-3 py-1 font-medium hover:bg-blue-600">
                Log Out
            </button>
        </form>
    </div>
</header>
