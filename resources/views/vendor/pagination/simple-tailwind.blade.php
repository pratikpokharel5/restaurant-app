@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}"
        class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        @if ($paginator->onFirstPage())
            <span
                class="inline-flex min-h-9 items-center gap-2 rounded-md border border-slate-200 bg-slate-100 px-3 py-2 text-sm font-medium text-slate-400">
                <i class="fa-solid fa-chevron-left text-xs" aria-hidden="true"></i>
                Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                class="inline-flex min-h-9 items-center gap-2 rounded-md border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                <i class="fa-solid fa-chevron-left text-xs" aria-hidden="true"></i>
                Previous
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                class="inline-flex min-h-9 items-center gap-2 rounded-md border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                Next
                <i class="fa-solid fa-chevron-right text-xs" aria-hidden="true"></i>
            </a>
        @else
            <span
                class="inline-flex min-h-9 items-center gap-2 rounded-md border border-slate-200 bg-slate-100 px-3 py-2 text-sm font-medium text-slate-400">
                Next
                <i class="fa-solid fa-chevron-right text-xs" aria-hidden="true"></i>
            </span>
        @endif
    </nav>
@endif
