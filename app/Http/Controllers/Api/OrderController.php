<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use App\Models\Order;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['items.menu', 'customer'])
            ->filter($request->only(['status', 'search']))
            ->latest()
            ->paginate(10);

        return OrderResource::collection($orders)
            ->additional(['message' => 'Orders retrieved successfully.']);
    }

    public function show(Order $order)
    {
        $order->load(['items.menu', 'customer', 'payment']);

        return (new OrderResource($order))
            ->additional(['message' => 'Order retrieved successfully.']);
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => [
                'sometimes',
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
            isset($validated['status']) &&
            $order->status !== $validated['status'] &&
            ! $order->canTransitionTo($validated['status'])
        ) {
            return response()->json([
                'message' => 'Invalid order status transition.',
            ], 422);
        }

        DB::transaction(function () use ($order, $validated) {
            $order->update($validated);

            if ($order->status === Order::STATUS_DELIVERED && $order->payment) {
                $order->payment->update(['status' => true]);
            }
        });

        $newOrder = $order->refresh()->load(['items.menu', 'customer', 'payment']);

        return (new OrderResource($newOrder))
            ->additional(['message' => 'Order updated successfully.']);
    }
}
