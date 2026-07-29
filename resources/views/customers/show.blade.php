@extends('app')

@section('title', 'Customers')

@section('content')
    <section class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
        <x-goback href="{{ route('customers.index') }}">{{ $customer->name }}</x-goback>

        <div class="mt-6 grid gap-4 rounded-md border border-slate-200 bg-slate-50 p-4 sm:grid-cols-2 lg:grid-cols-3">
            <div>
                <div class="text-xs font-medium uppercase text-slate-500">Customer Id</div>
                <div class="mt-1 font-semibold text-slate-950">#{{ $customer->id }}</div>
            </div>

            <div>
                <div class="text-xs font-medium uppercase text-slate-500">Name</div>
                <div class="mt-1 font-semibold text-slate-950">{{ $customer->name }}</div>
            </div>

            <div>
                <div class="text-xs font-medium uppercase text-slate-500">Phone Number</div>
                <div class="mt-1 font-semibold text-slate-950">{{ $customer->phone }}</div>
            </div>

            <div>
                <div class="text-xs font-medium uppercase text-slate-500">Email</div>
                <div class="mt-1 font-semibold text-slate-950">{{ $customer->email ?? 'N/A' }}</div>
            </div>

            <div class="sm:col-span-2">
                <div class="text-xs font-medium uppercase text-slate-500">Address</div>
                <div class="mt-1 font-semibold text-slate-950">{{ $customer->address ?? 'N/A' }}</div>
            </div>

            <div>
                <div class="text-xs font-medium uppercase text-slate-500">Role</div>
                <div class="mt-1 font-semibold text-slate-950">
                    {{ ucfirst($customer->user_role) }}
                </div>
            </div>

            <div>
                <div class="text-xs font-medium uppercase text-slate-500">Customer Since</div>
                <div class="mt-1 font-semibold text-slate-950">
                    {{ $customer->created_at->format('M j, Y') }}
                    ({{ $customer->created_at->diffForHumans() }})
                </div>
            </div>
        </div>

        <div class="mt-6">
            <h2 class="text-lg font-bold text-slate-950">Recent Orders</h2>

            <div class="mt-3 overflow-hidden rounded-md border border-slate-200">
                <table class="w-full min-w-[640px] text-left">
                    <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Order</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Total</th>
                            <th class="px-4 py-3">Payment</th>
                            <th class="px-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($recentOrders as $order)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3">
                                    <div class="font-medium text-slate-950">#{{ $order->id }}</div>
                                    <div class="text-xs text-slate-500">{{ $order->created_at->format('M j, Y g:i A') }}
                                    </div>
                                </td>
                                <td class="px-4 py-3"><x-orderstatus :status="$order->status" /></td>
                                <td class="px-4 py-3 font-medium">{{ number_format($order->total_price, 2) }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="{{ $order->payment?->status ? 'text-emerald-700' : 'text-slate-500' }} font-medium">
                                        {{ $order->payment?->status ? 'Paid' : 'Not paid' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('orders.edit', $order) }}" class="text-blue-600 hover:text-blue-800">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-slate-500">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
