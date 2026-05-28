@props(['search' => '', 'searchPlaceholder' => 'Search...', 'pagination' => null])

<div {{ $attributes }}>
    <form method="GET" class="flex items-center gap-x-5">
        <div class="relative w-64">
            <input type="text" name="search"
                class="peer w-full rounded-md border border-gray-200 bg-gray-50 py-2 pl-10 pr-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                placeholder="{{ $searchPlaceholder }}" value="{{ $search }}" />

            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 peer-focus:text-blue-600">
                <svg width="18" height="18" fill="none" stroke-width="2" viewBox="0 0 24 24"
                    stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                </svg>
            </div>
        </div>

        @if (isset($filters))
            {{ $filters }}
        @endif

        <div class="flex gap-x-2">
            <x-button type="submit">
                Apply Filters
            </x-button>

            <x-button as="link" href="{{ request()->url() }}" class="bg-gray-500 hover:bg-gray-600">
                Clear Filters
            </x-button>
        </div>
    </form>

    <div class="mt-3 overflow-x-auto">
        <table class="w-full border-collapse text-left">
            <thead>
                <tr>
                    {{ $header }}
                </tr>
            </thead>
            <tbody>
                {{ $slot }}

                @if ($pagination->isEmpty())
                    <tr>
                        <td colspan="100%" class="border border-gray-300 p-4 text-center text-gray-500">
                            No data found.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    @if ($pagination->isNotEmpty())
        <div class="mt-5">
            {{ $pagination->links() }}
        </div>
    @endif
</div>
