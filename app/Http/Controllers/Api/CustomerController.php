<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customer;
use App\Http\Resources\CustomerResource;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::filter($request->only('search'))
            ->latest()
            ->paginate(10);

        return CustomerResource::collection($customers)
            ->additional(['message' => 'Customers retrieved successfully.']);
    }

    public function show(Customer $customer)
    {
        return (new CustomerResource($customer))
            ->additional(['message' => 'Customer retrieved successfully.']);
    }
}
