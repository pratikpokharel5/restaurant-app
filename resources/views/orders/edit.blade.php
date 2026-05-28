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
    <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-lg">
        <div class="flex items-center justify-between">
            <x-goback href="{{ route('orders.index') }}">View Orders</x-goback>

            <div>
                <x-button as="link" href="{{ route('customers.show', $order->customer_id) }}">
                    View Customer
                </x-button>
            </div>
        </div>

        <div class="mt-3 grid grid-cols-3 gap-x-5 gap-y-3">
            <div>
                <div>Order Id</div>
                <div class="mt-1 font-semibold">#{{ $order->id }}</div>
            </div>

            <div>
                <div>Customer Name</div>
                <div class="mt-1 font-semibold">{{ $order->customer->name }}</div>
            </div>

            <div>
                <div>Order Status</div>
                <div class="mt-2 font-semibold">
                    <x-orderstatus :status="$order->status" />
                </div>
            </div>

            <div>
                <div>Total Price</div>
                <div class="mt-1 font-semibold">{{ $order->total_price }}</div>
            </div>

            <div>
                <div>Order Date</div>
                <div class="mt-1 font-semibold">
                    {{ $order->created_at->format('Y-m-d \a\t H:i a') }}
                </div>
            </div>

            <div>
                <div>Order Last Updated</div>
                <div class="mt-1 font-semibold">
                    {{ $order->updated_at->format('Y-m-d \a\t H:i a') }}
                </div>
            </div>

            <div class="col-span-3">
                <div>Notes</div>
                <div class="mt-1 font-semibold">
                    {{ $order->notes ?? 'N/A' }}
                </div>
            </div>
        </div>

        <div class="mt-5">
            <h4 class="mb-3 text-lg font-bold">Order Items</h4>

            <table class="w-full rounded-md border border-gray-200">
                <thead class="bg-gray-50">
                    <tr class="text-left">
                        <th class="p-2">Id</th>
                        <th class="p-2">Menu Item</th>
                        <th class="p-2">Qty</th>
                        <th class="p-2">Price</th>
                        <th class="p-2">Total</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td class="border-t border-gray-200 p-2">{{ $item->id }}</td>
                            <td class="border-t border-gray-200 p-2">{{ $item->menu->name }}</td>
                            <td class="border-t border-gray-200 p-2">{{ $item->quantity }}</td>
                            <td class="border-t border-gray-200 p-2">{{ $item->unit_price }}</td>
                            <td class="border-t border-gray-200 p-2">
                                {{ number_format($item->quantity * $item->unit_price, 2) }}
                            </td>
                        </tr>
                    @endforeach

                    <tr>
                        <td class="border-t border-gray-200 p-2 font-semibold"></td>
                        <td class="border-t border-gray-200 p-2 font-semibold"></td>
                        <td class="border-t border-gray-200 p-2 font-semibold"></td>
                        <td class="border-t border-gray-200 p-2 font-semibold">Total</td>
                        <td class="border-t border-gray-200 p-2 font-semibold">
                            {{ number_format($order->items->sum(fn($item) => $item->quantity * $item->unit_price), 2) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if ($order->status !== 'delivered' && $order->status !== 'cancelled')
            <form class="mt-5" method="POST" action="{{ route('orders.update', $order) }}">
                @csrf
                @method('PUT')
                <h4 class="mb-3 text-lg font-bold">Change Order Status</h4>

                <div class="w-64">
                    <x-select name="status" value="{{ $order->status }}">
                        @foreach ($orderStatus as $status => $label)
                            <option value="{{ $status }}" @if ($order->status == $status) selected @endif>
                                {{ $label }}
                            </option>
                        @endforeach
                    </x-select>
                </div>

                <div class="mt-5">
                    <x-label for="notes">Notes</x-label>

                    <x-textarea id="notes" name="notes" rows="5">{{ $order->notes }}</x-textarea>
                </div>

                <div class="mt-5">
                    <x-button type="submit">Update Order Status</x-button>
                </div>
            </form>
        @endif

        @if ($order->status === 'delivered')
            <div class="mt-5">
                <h4 class="mb-3 text-lg font-bold">Payment Information</h4>

                <div class="mt-4 grid grid-cols-3 gap-x-5 gap-y-3">
                    <div>
                        <div>Payment Id</div>
                        <div class="mt-1 font-semibold">#{{ $order->payment->id }}</div>
                    </div>

                    <div>
                        <div>Order Id</div>
                        <div class="mt-1 font-semibold">#{{ $order->id }}</div>
                    </div>

                    <div>
                        <div>Customer Name</div>
                        <div class="mt-1 font-semibold">{{ $order->customer->name }}</div>
                    </div>

                    <div>
                        <div>Total Price</div>
                        <div class="mt-1 font-semibold">{{ $order->payment->amount }}</div>
                    </div>

                    <div>
                        <div>Payment Status</div>
                        <div class="mt-2 font-semibold">
                            <span
                                class="{{ $order->payment->status ? 'bg-green-200 text-green-800' : 'bg-red-300 text-red-800' }} rounded-full px-2 py-1">
                                {{ $order->payment->status ? 'Paid' : 'Not Paid' }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <div>Payment Method</div>
                        <div class="mt-1 font-semibold">{{ ucfirst($order->payment->payment_method) }}</div>
                    </div>

                    <div>
                        <div>Payment Date</div>
                        <div class="mt-1 font-semibold">
                            {{ $order->payment->created_at->format('Y-m-d \a\t H:i a') }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
