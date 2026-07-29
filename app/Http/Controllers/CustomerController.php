<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::filter($request->only('search'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('customers.index', compact('customers'));
    }

    public function show(Customer $customer)
    {
        $recentOrders = $customer->orders()
            ->with('payment')
            ->latest()
            ->limit(10)
            ->get();

        return view('customers.show', compact('customer', 'recentOrders'));
    }
}
