@extends('app')

@section('title', 'Customers')

@section('content')
    <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-lg">
        <x-goback href="{{ route('customers.index') }}">View Customers</x-goback>

        <div class="mt-3 grid grid-cols-3 gap-5">
            <div>
                <div>Customer Id</div>
                <div class="mt-1 font-semibold">#{{ $customer->id }}</div>
            </div>

            <div>
                <div>Name</div>
                <div class="mt-1 font-semibold">{{ $customer->name }}</div>
            </div>

            <div>
                <div>Phone Number</div>
                <div class="mt-1 font-semibold">{{ $customer->phone }}</div>
            </div>

            <div>
                <div>Email</div>
                <div class="mt-1 font-semibold">{{ $customer->email ?? 'N/A' }}</div>
            </div>

            <div class="col-span-2">
                <div>Address</div>
                <div class="mt-1 font-semibold">{{ $customer->address ?? 'N/A' }}</div>
            </div>

            <div>
                <div>User Role</div>
                <div class="mt-1 font-semibold">
                    {{ ucfirst($customer->user_role) }}
                </div>
            </div>

            <div>
                <div>Customer Since</div>
                <div class="mt-1 font-semibold">
                    {{ $customer->created_at->format('Y-m-d') }}
                    ({{ $customer->created_at->diffForHumans() }})
                </div>
            </div>
        </div>
    @endsection
