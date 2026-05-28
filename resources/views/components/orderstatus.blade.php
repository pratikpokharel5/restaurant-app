@props(['status' => 'pending'])

@php
    $statusColors = [
        'pending' => 'bg-orange-200 text-orange-800',
        'preparing' => 'bg-purple-200 text-purple-800',
        'on_the_way' => 'bg-yellow-200 text-yellow-800',
        'delivered' => 'bg-green-200 text-green-800',
        'cancelled' => 'bg-red-100 text-red-800',
    ];
@endphp

<span class="{{ $statusColors[$status] }} rounded-full px-2 py-1">
    {{ Str::headline($status) }}
</span>
