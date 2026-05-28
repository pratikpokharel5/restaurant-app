<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Payment;
use App\Http\Resources\PaymentResource;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::with(['order', 'order.customer'])
            ->filter($request->only(['search']))
            ->latest()
            ->paginate(10);

        return PaymentResource::collection($payments)
            ->additional(['message' => 'Payments retrieved successfully.']);
    }
}
