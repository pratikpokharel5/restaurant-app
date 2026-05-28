@extends('app')

@section('title', 'Customers')

@section('content')
    <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-md">
        <h3 class="text-2xl font-bold">Customers</h3>

        <x-datatable class="mt-3" search="{{ request('search') }}" search-placeholder="Search customer..." :pagination="$customers">
            <x-slot:header>
                <th class="border border-gray-300 bg-gray-100 p-4">Name</th>
                <th class="border border-gray-300 bg-gray-100 p-4">Phone</th>
                <th class="border border-gray-300 bg-gray-100 p-4">Address</th>
                <th class="border border-gray-300 bg-gray-100 p-4">Actions</th>
            </x-slot:header>

            @foreach ($customers as $customer)
                <tr>
                    <td class="border border-gray-300 p-4">{{ $customer->name }}</td>

                    <td class="border border-gray-300 p-4">{{ $customer->phone }}</td>

                    <td class="border border-gray-300 p-4">{{ $customer->address ?? '--' }}</td>

                    <td class="border border-gray-300 p-4">
                        <a href="{{ route('customers.show', $customer) }}" class="text-blue-600 hover:underline">View</a>
                    </td>
                </tr>
            @endforeach
        </x-datatable>
    </div>
@endsection
