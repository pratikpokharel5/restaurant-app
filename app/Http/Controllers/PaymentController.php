<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::with(['order.customer'])
            ->filter($request->only(['search']))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('payments.index', compact('payments'));
    }
}
