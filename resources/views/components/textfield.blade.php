@props(['error' => null])

<input
    {{ $attributes->merge(['type' => 'text'])->twMerge(
            'block w-full rounded-md border bg-gray-50 px-3 py-2 text-sm border-gray-300 focus:border-blue-500 focus:ring-blue-500',
            $error ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '',
        ) }}>

@if ($error)
    <p class="mt-1 px-2 text-red-500">{{ $error }}</p>
@endif
