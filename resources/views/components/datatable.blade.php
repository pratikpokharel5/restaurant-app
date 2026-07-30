@props(['search' => '', 'searchPlaceholder' => 'Search...', 'pagination' => null])

<div {{ $attributes }}>
    <form method="GET" class="rounded-md border border-slate-200 bg-slate-50 p-3">
        <div class="grid gap-3 sm:grid-cols-2 lg:flex lg:flex-wrap lg:items-end">
            <div class="relative w-full lg:max-w-xs">
                <label for="datatable-search" class="sr-only">{{ $searchPlaceholder }}</label>
                <input type="text" name="search" id="datatable-search"
                    class="peer w-full rounded-md border border-slate-300 bg-white py-2 pl-10 pr-3 text-sm text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-blue-500 focus:ring-blue-500"
                    placeholder="{{ $searchPlaceholder }}" value="{{ $search }}" />

                <div
                    class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 peer-focus:text-blue-600">
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                </div>
            </div>

            @if (isset($filters))
                {{ $filters }}
            @endif
        </div>

        <div class="mt-3 grid gap-2 sm:flex sm:flex-wrap">
            <x-button type="submit" class="w-full sm:w-auto">
                <i class="fa-solid fa-filter mr-2" aria-hidden="true"></i>
                Apply Filters
            </x-button>

            <x-button as="link" href="{{ request()->url() }}"
                class="w-full border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 sm:w-auto">
                <i class="fa-solid fa-rotate-left mr-2" aria-hidden="true"></i>
                Clear Filters
            </x-button>
        </div>
    </form>

    <div class="mt-4 overflow-hidden rounded-md border border-slate-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[52rem] text-left">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        {{ $header }}
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    {{ $slot }}

                    @if ($pagination->isEmpty())
                        <tr>
                            <td colspan="100%" class="p-8 text-center text-slate-500">
                                No data found.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    @if ($pagination->isNotEmpty())
        <div class="mt-5">
            {{ $pagination->links() }}
        </div>
    @endif
</div>
