@extends('app')

@section('title', 'Customers')

@section('content')
    <section class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-950">Customers</h1>
            <p class="mt-1 text-sm text-slate-500">Look up customer contact details and order history.</p>
        </div>

        <x-datatable class="mt-3" search="{{ request('search') }}" search-placeholder="Search customer..." :pagination="$customers">
            <x-slot:header>
                <th class="px-4 py-3 font-semibold">Name</th>
                <th class="px-4 py-3 font-semibold">Phone</th>
                <th class="px-4 py-3 font-semibold">Address</th>
                <th class="px-4 py-3 font-semibold">Actions</th>
            </x-slot:header>

            @foreach ($customers as $customer)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-4">
                        <div class="font-medium text-slate-950">{{ $customer->name }}</div>
                        <div class="mt-1 text-sm text-slate-500">{{ $customer->email ?? 'No email' }}</div>
                    </td>

                    <td class="px-4 py-4 text-slate-600">{{ $customer->phone }}</td>

                    <td class="max-w-md px-4 py-4 text-slate-600">{{ $customer->address ?? '-' }}</td>

                    <td class="px-4 py-4">
                        <a href="{{ route('customers.show', $customer) }}" class="text-blue-600 hover:text-blue-800">
                            View
                        </a>
                    </td>
                </tr>
            @endforeach
        </x-datatable>
    </section>
@endsection
