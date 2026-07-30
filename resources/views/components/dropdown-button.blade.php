<button type="submit"
    {{ $attributes->twMerge('inline-flex w-full items-center gap-3 whitespace-nowrap rounded-md px-3 py-2 text-left text-sm font-medium text-slate-600 outline-none transition hover:bg-slate-100 hover:text-slate-950 focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2') }}
    role="menuitem">
    {{ $slot }}
</button>
