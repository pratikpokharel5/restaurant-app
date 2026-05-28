@extends('app')

@section('title', 'Payments')

@section('content')
    <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-md">
        <h3 class="text-2xl font-bold">Payments</h3>

        <x-datatable class="mt-3" search="{{ request('search') }}" search-placeholder="Search customer..." :pagination="$payments">
            <x-slot:header>
                <th class="border border-gray-300 bg-gray-100 p-4">Customer Name</th>
                <th class="border border-gray-300 bg-gray-100 p-4">Amount</th>
                <th class="border border-gray-300 bg-gray-100 p-4">Payment Method</th>
                <th class="border border-gray-300 bg-gray-100 p-4">Status</th>
                <th class="border border-gray-300 bg-gray-100 p-4">Actions</th>
            </x-slot:header>

            @foreach ($payments as $payment)
                <tr>
                    <td class="border border-gray-300 p-4">{{ $payment->order->customer->name }}</td>

                    <td class="border border-gray-300 p-4">{{ $payment->amount }}</td>

                    <td class="border border-gray-300 p-4">{{ ucfirst($payment->payment_method) }}</td>

                    <td class="border border-gray-300 p-4">
                        <span
                            class="{{ $payment->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-full px-3 py-1.5">
                            {{ $payment->status ? 'Paid' : 'Not Paid' }}
                        </span>
                    </td>

                    <td class="border border-gray-300 p-4">
                        <a href="{{ route('orders.edit', $payment->order_id) }}"
                            class="block text-blue-600 hover:underline">
                            View Order
                        </a>

                        <a href="{{ route('customers.show', $payment->order->customer->id) }}"
                            class="mt-2 block text-blue-600 hover:underline">
                            View Customer
                        </a>
                    </td>
                </tr>
            @endforeach
        </x-datatable>
    </div>
@endsection
