@props(['error' => null])

<textarea
    {{ $attributes->twMerge('block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-blue-500 focus:ring-blue-500', $error ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '') }}>{{ $slot }}</textarea>

@if ($error)
    <p class="mt-1 text-sm text-red-600">{{ $error }}</p>
@endif
