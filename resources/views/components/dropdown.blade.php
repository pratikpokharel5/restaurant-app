@props([
    'align' => 'right',
    'width' => 'w-56',
])

@php
    $panelAlignment = $align === 'left' ? 'left-0' : 'right-0';
@endphp

<div class="relative inline-block text-left" x-data="{ open: false }" @click.outside="open = false"
    @keydown.escape.window="open = false">
    <button type="button"
        {{ $trigger->attributes->merge([
            'x-on:click' => 'open = ! open',
            'x-bind:aria-expanded' => 'open.toString()',
        ]) }}
        aria-haspopup="true">
        {{ $trigger }}
    </button>

    <div class="{{ $panelAlignment }} {{ $width }} absolute z-30 mt-2 rounded-md border border-slate-200 bg-white p-1 text-sm text-slate-700 shadow-lg ring-1 ring-black/5"
        x-show="open" x-cloak x-transition.origin.top.right role="menu">
        {{ $slot }}
    </div>
</div>
