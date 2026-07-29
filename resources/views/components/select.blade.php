@props(['value' => '', 'defaultLabel' => 'Select Option...', 'error' => null])

<select
    {{ $attributes->twMerge('w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-blue-500 focus:ring-blue-500', $error ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '') }}>
    <option value="" @if ($value == '') selected @endif disabled>{{ $defaultLabel }}</option>
    {{ $slot }}
</select>

@if ($error)
    <p class="mt-1 text-sm text-red-600">{{ $error }}</p>
@endif
