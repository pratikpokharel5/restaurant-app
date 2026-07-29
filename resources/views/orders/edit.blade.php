@php
    $orderStatus = \App\Models\Order::statusLabels();
    $nextStatuses = $order->nextStatuses();
@endphp

@extends('app')

@section('title', 'Orders')

@section('content')
    <section class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <x-goback href="{{ route('orders.index') }}">Order #{{ $order->id }}</x-goback>

            <div>
                <x-button as="link" href="{{ route('customers.show', $order->customer_id) }}">
                    <i class="fa-solid fa-user mr-2" aria-hidden="true"></i>
                    View Customer
                </x-button>
            </div>
        </div>

        <div class="mt-6 grid gap-4 rounded-md border border-slate-200 bg-slate-50 p-4 sm:grid-cols-2 lg:grid-cols-3">
            <div>
                <div class="text-xs font-medium uppercase text-slate-500">Customer</div>
                <div class="mt-1 font-semibold text-slate-950">{{ $order->customer->name }}</div>
            </div>

            <div>
                <div class="text-xs font-medium uppercase text-slate-500">Status</div>
                <div class="mt-2 font-semibold">
                    <x-orderstatus :status="$order->status" />
                </div>
            </div>

            <div>
                <div class="text-xs font-medium uppercase text-slate-500">Total</div>
                <div class="mt-1 font-semibold text-slate-950">{{ number_format($order->total_price, 2) }}</div>
            </div>

            <div>
                <div class="text-xs font-medium uppercase text-slate-500">Created</div>
                <div class="mt-1 font-semibold text-slate-950">
                    {{ $order->created_at->format('M j, Y g:i A') }}
                </div>
            </div>

            <div>
                <div class="text-xs font-medium uppercase text-slate-500">Last Updated</div>
                <div class="mt-1 font-semibold text-slate-950">
                    {{ $order->updated_at->format('M j, Y g:i A') }}
                </div>
            </div>

            <div class="sm:col-span-2 lg:col-span-3">
                <div class="text-xs font-medium uppercase text-slate-500">Notes</div>
                <div class="mt-1 font-semibold text-slate-950">
                    {{ $order->notes ?? 'N/A' }}
                </div>
            </div>
        </div>

        <div class="mt-5">
            <h2 class="mb-3 text-lg font-bold text-slate-950">Order Items</h2>

            <div class="overflow-hidden rounded-md border border-slate-200">
                <table class="w-full min-w-[640px] text-left">
                    <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Id</th>
                            <th class="px-4 py-3">Menu Item</th>
                            <th class="px-4 py-3">Qty</th>
                            <th class="px-4 py-3">Price</th>
                            <th class="px-4 py-3">Total</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @foreach ($order->items as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-slate-500">#{{ $item->id }}</td>
                                <td class="px-4 py-3 font-medium text-slate-950">
                                    {{ $item->menu->name ?? 'Archived menu item' }}</td>
                                <td class="px-4 py-3">{{ $item->quantity }}</td>
                                <td class="px-4 py-3">{{ number_format($item->unit_price, 2) }}</td>
                                <td class="px-4 py-3 font-medium">
                                    {{ number_format($item->quantity * $item->unit_price, 2) }}
                                </td>
                            </tr>
                        @endforeach

                        <tr class="bg-slate-50">
                            <td class="px-4 py-3 font-semibold" colspan="4">Total</td>
                            <td class="px-4 py-3 font-semibold">
                                {{ number_format($order->items->sum(fn($item) => $item->quantity * $item->unit_price), 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        @if (count($nextStatuses) > 0)
            <form class="mt-6 rounded-md border border-slate-200 bg-slate-50 p-4" method="POST"
                action="{{ route('orders.update', $order) }}">
                @csrf
                @method('PUT')
                <h2 class="mb-3 text-lg font-bold text-slate-950">Change Order Status</h2>

                <div class="max-w-sm">
                    <x-label for="status">Next status</x-label>
                    <x-select id="status" name="status" default-label="Select next status..."
                        value="{{ old('status') }}" :error="$errors->first('status')" required>
                        @foreach ($nextStatuses as $status)
                            <option value="{{ $status }}" @if (old('status') === $status) selected @endif>
                                {{ $orderStatus[$status] }}</option>
                        @endforeach
                    </x-select>
                </div>

                <div class="mt-5">
                    <x-label for="notes">Notes</x-label>

                    <x-textarea id="notes" name="notes" rows="5"
                        :error="$errors->first('notes')">{{ old('notes', $order->notes) }}</x-textarea>
                </div>

                <div class="mt-5">
                    <x-button type="submit">
                        <i class="fa-solid fa-arrows-rotate mr-2" aria-hidden="true"></i>
                        Update Order Status
                    </x-button>
                </div>
            </form>
        @endif

        @if ($order->payment)
            <div class="mt-5">
                <h2 class="mb-3 text-lg font-bold text-slate-950">Payment Information</h2>

                <div class="grid gap-4 rounded-md border border-slate-200 bg-slate-50 p-4 sm:grid-cols-2 lg:grid-cols-3">
                    <div>
                        <div class="text-xs font-medium uppercase text-slate-500">Payment Id</div>
                        <div class="mt-1 font-semibold text-slate-950">#{{ $order->payment->id }}</div>
                    </div>

                    <div>
                        <div class="text-xs font-medium uppercase text-slate-500">Amount</div>
                        <div class="mt-1 font-semibold text-slate-950">{{ number_format($order->payment->amount, 2) }}
                        </div>
                    </div>

                    <div>
                        <div class="text-xs font-medium uppercase text-slate-500">Status</div>
                        <div class="mt-2 font-semibold">
                            <span
                                class="{{ $order->payment->status ? 'bg-emerald-50 text-emerald-700 ring-emerald-200' : 'bg-red-50 text-red-700 ring-red-200' }} inline-flex rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset">
                                {{ $order->payment->status ? 'Paid' : 'Not Paid' }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <div class="text-xs font-medium uppercase text-slate-500">Method</div>
                        <div class="mt-1 font-semibold text-slate-950">{{ ucfirst($order->payment->payment_method) }}</div>
                    </div>

                    <div>
                        <div class="text-xs font-medium uppercase text-slate-500">Payment Date</div>
                        <div class="mt-1 font-semibold text-slate-950">
                            {{ $order->payment->created_at->format('M j, Y g:i A') }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>
@endsection
