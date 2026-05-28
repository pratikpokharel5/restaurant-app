@props(['as' => 'button'])

@php
    $class =
        'flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 font-medium text-white hover:bg-blue-700';
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
