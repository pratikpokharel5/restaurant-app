@extends('app')

@section('title', 'Payments')

@section('content')
    <section class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-950">Payments</h1>
            <p class="mt-1 text-sm text-slate-500">Review paid and unpaid order payments.</p>
        </div>

        <x-datatable class="mt-3" search="{{ request('search') }}" search-placeholder="Search customer..." :pagination="$payments">
            <x-slot:header>
                <th class="px-4 py-3 font-semibold">Customer</th>
                <th class="px-4 py-3 font-semibold">Order</th>
                <th class="px-4 py-3 font-semibold">Amount</th>
                <th class="px-4 py-3 font-semibold">Method</th>
                <th class="px-4 py-3 font-semibold">Status</th>
                <th class="px-4 py-3 font-semibold">Actions</th>
            </x-slot:header>

            @foreach ($payments as $payment)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-4 font-medium text-slate-950">{{ $payment->order->customer->name }}</td>

                    <td class="px-4 py-4 text-slate-600">#{{ $payment->order_id }}</td>

                    <td class="px-4 py-4 font-semibold text-slate-950">{{ number_format($payment->amount, 2) }}</td>

                    <td class="px-4 py-4 text-slate-600">{{ ucfirst($payment->payment_method) }}</td>

                    <td class="px-4 py-4">
                        <span
                            class="{{ $payment->status ? 'bg-emerald-50 text-emerald-700 ring-emerald-200' : 'bg-red-50 text-red-700 ring-red-200' }} inline-flex rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset">
                            {{ $payment->status ? 'Paid' : 'Not Paid' }}
                        </span>
                    </td>

                    <td class="px-4 py-4">
                        <a href="{{ route('orders.edit', $payment->order_id) }}"
                            class="block text-blue-600 hover:text-blue-800">
                            View Order
                        </a>

                        <a href="{{ route('customers.show', $payment->order->customer->id) }}"
                            class="mt-3 block text-blue-600 hover:text-blue-800">
                            View Customer
                        </a>
                    </td>
                </tr>
            @endforeach
        </x-datatable>
    </section>
@endsection
