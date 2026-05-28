<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['items.menu', 'customer'])
            ->filter($request->only(['search', 'status']))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('orders.index', compact('orders'));
    }

    public function edit(Order $order)
    {
        $order = $order->load(['items.menu', 'customer', 'payment']);

        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    Order::STATUS_PENDING,
                    Order::STATUS_PREPARING,
                    Order::STATUS_ON_THE_WAY,
                    Order::STATUS_DELIVERED,
                    Order::STATUS_CANCELLED,
                ]),
            ],
            'notes' => ['nullable', 'string'],
        ]);

        if (
            $order->status !== $validated['status'] &&
            ! $order->canTransitionTo($validated['status'])
        ) {
            return back()->with([
                'message' => "Invalid order transition.",
            ]);
        }

        DB::transaction(function () use ($order, $validated) {
            $order->update($validated);

            if ($order->status === Order::STATUS_DELIVERED && $order->payment) {
                $order->payment->update(['status' => true]);
            }
        });

        $order = $order->refresh()->load(['items.menu', 'customer', 'payment']);

        return redirect()->route('orders.edit', $order)->with([
            'message' => "Order updated successfully.",
        ]);
    }
}
