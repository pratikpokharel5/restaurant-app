@php
    $orderStatus = \App\Models\Order::statusLabels();
@endphp

@extends('app')

@section('title', 'Orders')

@section('content')
    <section class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-950">Orders</h1>
            <p class="mt-1 text-sm text-slate-500">Track preparation, delivery flow, and customer details.</p>
        </div>

        <x-datatable class="mt-3" search="{{ request('search') }}" search-placeholder="Search customer..." :pagination="$orders">
            <x-slot:filters>
                <div class="w-64">
                    <x-select name="status" default-label="Filter by Status..." value="{{ request('status') }}">
                        @foreach ($orderStatus as $value => $label)
                            <option value="{{ $value }}" @if (request('status') == $value) selected @endif>
                                {{ $label }}
                            </option>
                        @endforeach
                    </x-select>
                </div>
            </x-slot:filters>

            <x-slot:header>
                <th class="px-4 py-3 font-semibold">Order</th>
                <th class="px-4 py-3 font-semibold">Items</th>
                <th class="px-4 py-3 font-semibold">Total</th>
                <th class="px-4 py-3 font-semibold">Status</th>
                <th class="px-4 py-3 font-semibold">Actions</th>
            </x-slot:header>

            @foreach ($orders as $order)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-4">
                        <div class="font-semibold text-slate-950">#{{ $order->id }}</div>
                        <div class="mt-1 text-sm text-slate-600">{{ $order->customer->name }}</div>
                        <div class="mt-1 text-xs text-slate-500">{{ $order->created_at->format('M j, Y g:i A') }}</div>
                    </td>

                    <td class="px-4 py-4">
                        <div class="max-w-md space-y-1">
                            @foreach ($order->items->take(3) as $item)
                                <div class="flex justify-between gap-4 text-sm">
                                    <span
                                        class="truncate text-slate-700">{{ $item->menu->name ?? 'Archived menu item' }}</span>
                                    <span class="shrink-0 text-slate-500">x{{ $item->quantity }}</span>
                                </div>
                            @endforeach

                            @if ($order->items_count > 3)
                                <div class="text-xs font-medium text-slate-500">+{{ $order->items_count - 3 }} more items
                                </div>
                            @endif
                        </div>
                    </td>

                    <td class="px-4 py-4 font-semibold text-slate-950">{{ number_format($order->total_price, 2) }}</td>

                    <td class="px-4 py-4">
                        <x-orderstatus :status="$order->status" />
                    </td>

                    <td class="px-4 py-4">
                        <a href="{{ route('orders.edit', $order) }}" class="block text-blue-600 hover:text-blue-800">
                            View Order
                        </a>

                        <a href="{{ route('customers.show', $order->customer_id) }}"
                            class="mt-3 block text-blue-600 hover:text-blue-800">
                            View Customer
                        </a>
                    </td>
                </tr>
            @endforeach
        </x-datatable>
    </section>
@endsection
