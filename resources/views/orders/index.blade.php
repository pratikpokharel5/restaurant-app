@php
    $orderStatus = [
        'pending' => 'Pending',
        'preparing' => 'Preparing',
        'on_the_way' => 'On the Way',
        'delivered' => 'Delivered',
        'cancelled' => 'Cancelled',
    ];
@endphp

@extends('app')

@section('title', 'Orders')

@section('content')
    <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-md">
        <h3 class="text-2xl font-bold">Orders</h3>

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
                <th class="border border-gray-300 bg-gray-100 p-4">Customer Name</th>
                <th class="border border-gray-300 bg-gray-100 p-4">Order Items</th>
                <th class="border border-gray-300 bg-gray-100 p-4">Order Status</th>
                <th class="border border-gray-300 bg-gray-100 p-4">Actions</th>
            </x-slot:header>

            @foreach ($orders as $order)
                <tr>
                    <td class="border border-gray-300 p-4">{{ $order->customer->name }}</td>

                    <td class="border border-gray-300 p-4">
                        <table class="w-full rounded-md border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr class="text-left">
                                    <th class="p-2 font-medium">Menu Item</th>
                                    <th class="p-2 font-medium">Qty</th>
                                    <th class="p-2 font-medium">Price</th>
                                    <th class="p-2 font-medium">Total</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td class="border-t border-gray-200 p-2">{{ $item->menu->name }}</td>
                                        <td class="border-t border-gray-200 p-2">{{ $item->quantity }}</td>
                                        <td class="border-t border-gray-200 p-2">{{ $item->unit_price }}</td>
                                        <td class="border-t border-gray-200 p-2">
                                            {{ number_format($item->quantity * $item->unit_price, 2) }}
                                        </td>
                                    </tr>
                                @endforeach

                                <tr>
                                    <td colspan="3" class="border-t border-gray-200 p-2 font-semibold">Total</td>
                                    <td class="border-t border-gray-200 p-2 font-semibold">
                                        {{ number_format($order->items->sum(fn($item) => $item->quantity * $item->unit_price), 2) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>

                    <td class="border border-gray-300 p-4">
                        <x-orderstatus :status="$order->status" />
                    </td>

                    <td class="border border-gray-300 p-4">
                        <a href="{{ route('orders.edit', $order) }}" class="block text-blue-600 hover:underline">
                            View Order
                        </a>

                        <a href="{{ route('customers.show', $order->customer_id) }}"
                            class="mt-2 block text-blue-600 hover:underline">
                            View Customer
                        </a>
                    </td>
                </tr>
            @endforeach
        </x-datatable>
    </div>
@endsection
