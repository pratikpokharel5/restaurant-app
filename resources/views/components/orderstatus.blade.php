@props(['status' => 'pending'])

@php
    $statusColors = [
        'pending' => 'bg-amber-50 text-amber-700 ring-amber-200',
        'preparing' => 'bg-indigo-50 text-indigo-700 ring-indigo-200',
        'on_the_way' => 'bg-cyan-50 text-cyan-700 ring-cyan-200',
        'delivered' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
        'cancelled' => 'bg-red-50 text-red-700 ring-red-200',
    ];
@endphp

<span
    class="{{ $statusColors[$status] ?? 'bg-slate-50 text-slate-700 ring-slate-200' }} inline-flex rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset">
    {{ Str::headline($status) }}
</span>
