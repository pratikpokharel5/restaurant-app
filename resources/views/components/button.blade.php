@props(['as' => 'button'])

@php
    $class =
        'inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60';
@endphp

@if ($as === 'button')
    <button {{ $attributes->merge(['type' => 'button'])->twMerge($class) }}>
        {{ $slot }}
    </button>
@else
    <a {{ $attributes->merge(['href' => '#'])->twMerge($class) }}>
        {{ $slot }}
    </a>
@endif
