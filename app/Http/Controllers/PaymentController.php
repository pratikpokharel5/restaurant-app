<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::with(['order.customer'])
            ->filter($request->only(['search', 'status', 'payment_date']))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('payments.index', compact('payments'));
    }
}
