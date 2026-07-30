@php
    $statusLabels = \App\Models\Order::statusLabels();

    $cards = [
        [
            'label' => 'Today Orders',
            'value' => number_format($summary['today_orders']),
            'icon' => 'fa-receipt',
            'href' => route('orders.index', ['order_date' => now()->toDateString()]),
        ],
        [
            'label' => 'Today Revenue',
            'value' => number_format($summary['today_revenue'], 2),
            'icon' => 'fa-sack-dollar',
            'href' => route('payments.index', ['status' => 1, 'payment_date' => now()->toDateString()]),
        ],
        [
            'label' => 'Unpaid Payments',
            'value' => number_format($summary['unpaid_payments']),
            'icon' => 'fa-circle-exclamation',
            'href' => route('payments.index', ['status' => 0]),
        ],
        [
            'label' => 'Active Menus',
            'value' => number_format($summary['active_menus']),
            'icon' => 'fa-burger',
            'href' => route('menus.index', ['is_available' => 1]),
        ],
        [
            'label' => 'Customers',
            'value' => number_format($summary['customers']),
            'icon' => 'fa-users',
            'href' => route('customers.index'),
        ],
    ];
@endphp

@extends('app')

@section('title', 'Dashboard')

@section('content')
    <div class="min-w-0 space-y-6">
        <section class="min-w-0">
            <div>
                <h1 class="text-xl font-bold text-slate-950 sm:text-2xl">Dashboard</h1>
                <p class="mt-1 text-sm text-slate-500">A quick operational summary for the current restaurant shift.</p>
            </div>

            <div class="mt-4 grid min-w-0 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ($cards as $card)
                    <a href="{{ $card['href'] }}"
                        class="min-w-0 rounded-lg border border-slate-200 bg-white p-4 shadow-sm transition hover:border-blue-200 hover:bg-blue-50/30 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-sm font-medium text-slate-500">{{ $card['label'] }}</div>
                                <div class="mt-2 text-xl font-bold text-slate-950 sm:text-2xl">{{ $card['value'] }}</div>
                            </div>

                            <div class="grid size-10 place-items-center rounded-md bg-blue-50 text-blue-700">
                                <i class="fa-solid {{ $card['icon'] }}" aria-hidden="true"></i>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        <div class="grid min-w-0 gap-6 xl:grid-cols-[minmax(0,1fr)_22rem]">
            <section class="min-w-0 rounded-lg border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-950">Recent Orders</h2>
                        <p class="mt-1 text-sm text-slate-500">Latest customer orders across all statuses.</p>
                    </div>

                    <a href="{{ route('orders.index') }}" class="shrink-0 text-sm text-blue-600 hover:text-blue-800">View all</a>
                </div>

                <div class="mt-4 w-full min-w-0 overflow-x-auto rounded-md border border-slate-200">
                    <table class="w-full min-w-[44rem] text-left">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="px-4 py-3 font-semibold">Order</th>
                                <th class="px-4 py-3 font-semibold">Customer</th>
                                <th class="px-4 py-3 font-semibold">Total</th>
                                <th class="px-4 py-3 font-semibold">Status</th>
                                <th class="px-4 py-3 font-semibold">Payment</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($recentOrders as $order)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3">
                                        <a href="{{ route('orders.edit', $order) }}"
                                            class="font-medium text-blue-600 hover:text-blue-800">#{{ $order->id }}</a>
                                        <div class="mt-1 text-xs text-slate-500">{{ $order->created_at->format('M j, g:i A') }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-slate-700">{{ $order->customer->name }}</td>
                                    <td class="px-4 py-3 font-medium text-slate-950">{{ number_format($order->total_price, 2) }}</td>
                                    <td class="px-4 py-3"><x-orderstatus :status="$order->status" /></td>
                                    <td class="px-4 py-3">
                                        <span class="{{ $order->payment?->status ? 'text-emerald-700' : 'text-slate-500' }} font-medium">
                                            {{ $order->payment?->status ? 'Paid' : 'Not paid' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-slate-500">No recent orders found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="min-w-0 rounded-lg border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
                <h2 class="text-lg font-bold text-slate-950">Order Status</h2>
                <p class="mt-1 text-sm text-slate-500">Current order distribution.</p>

                <div class="mt-4 space-y-3">
                    @foreach ($statusLabels as $status => $label)
                        @php
                            $count = (int) ($orderStatusCounts[$status] ?? 0);
                            $total = max($orderStatusCounts->sum(), 1);
                            $width = ($count / $total) * 100;
                        @endphp

                        <div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="font-medium text-slate-700">{{ $label }}</span>
                                <span class="text-slate-500">{{ $count }}</span>
                            </div>
                            <div class="mt-2 h-2 rounded-full bg-slate-100">
                                <div class="h-2 rounded-full bg-blue-600" style="width: {{ $width }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <section class="min-w-0 rounded-lg border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-bold text-slate-950">Recent Payments</h2>
                    <p class="mt-1 text-sm text-slate-500">Latest payment records from orders.</p>
                </div>

                <a href="{{ route('payments.index') }}" class="shrink-0 text-sm text-blue-600 hover:text-blue-800">View all</a>
            </div>

            <div class="mt-4 w-full min-w-0 overflow-x-auto rounded-md border border-slate-200">
                <table class="w-full min-w-[44rem] text-left">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Customer</th>
                            <th class="px-4 py-3 font-semibold">Order</th>
                            <th class="px-4 py-3 font-semibold">Amount</th>
                            <th class="px-4 py-3 font-semibold">Method</th>
                            <th class="px-4 py-3 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($recentPayments as $payment)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 font-medium text-slate-950">{{ $payment->order->customer->name }}</td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('orders.edit', $payment->order_id) }}"
                                        class="text-blue-600 hover:text-blue-800">#{{ $payment->order_id }}</a>
                                </td>
                                <td class="px-4 py-3 font-medium text-slate-950">{{ number_format($payment->amount, 2) }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ ucfirst($payment->payment_method) }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="{{ $payment->status ? 'bg-emerald-50 text-emerald-700 ring-emerald-200' : 'bg-red-50 text-red-700 ring-red-200' }} inline-flex rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset">
                                        {{ $payment->status ? 'Paid' : 'Not Paid' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-slate-500">No payments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
