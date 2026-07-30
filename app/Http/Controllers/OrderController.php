<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Order::class);

        $orders = Order::with([
            'customer',
            'items' => fn ($query) => $query
                ->with('menu')
                ->orderBy('id')
                ->limit(3),
        ])
            ->withCount('items')
            ->filter($request->only(['search', 'status', 'order_date']))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('orders.index', compact('orders'));
    }

    public function edit(Order $order)
    {
        $this->authorize('update', $order);

        $order = $order->load(['items.menu', 'customer', 'payment']);

        return view('orders.edit', compact('order'));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $validated = $request->validated();

        if ($order->status === $validated['status']) {
            unset($validated['status']);
        } elseif (! $order->canTransitionTo($validated['status'])) {
            return back()
                ->withErrors(['status' => 'This order cannot move to the selected status.'])
                ->withInput();
        }

        DB::transaction(function () use ($order, $validated) {
            $order->update($validated);

            if ($order->status === Order::STATUS_DELIVERED && $order->payment) {
                $order->payment->update(['status' => true]);
            }
        });

        return redirect()->route('orders.edit', $order)->with([
            'message' => 'Order updated successfully.',
        ]);
    }
}
