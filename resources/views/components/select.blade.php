@props(['value' => '', 'defaultLabel' => 'Select Option...', 'error' => null])

<select
    {{ $attributes->twMerge('w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500', $error ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '') }}>
    <option value="" @if ($value == '') selected @endif disabled>{{ $defaultLabel }}</option>
    {{ $slot }}
</select>

@if ($error)
    <p class="mt-1 px-2 text-red-500">{{ $error }}</p>
@endif
