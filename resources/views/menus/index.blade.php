@extends('app')

@section('title', 'Menus')

@section('content')
    <section class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-950">Menus</h1>
                <p class="mt-1 text-sm text-slate-500">Manage sellable items, prices, and availability.</p>
            </div>

            <x-button as="link" href="{{ route('menus.create') }}">
                <i class="fa-solid fa-plus mr-2" aria-hidden="true"></i>
                Create Menu
            </x-button>
        </div>

        <x-datatable class="mt-3" search="{{ request('search') }}" search-placeholder="Search menu..." :pagination="$menus">
            <x-slot:filters>
                <div class="w-64">
                    <x-select name="is_available" default-label="Filter by Availability..."
                        value="{{ request('is_available') }}">
                        <option value="1" @if (request('is_available') == '1') selected @endif>Available</option>
                        <option value="0" @if (request('is_available') == '0') selected @endif>Not Available</option>
                    </x-select>
                </div>
            </x-slot:filters>

            <x-slot:header>
                <th class="px-4 py-3 font-semibold">Name</th>
                <th class="px-4 py-3 font-semibold">Category</th>
                <th class="px-4 py-3 font-semibold">Price</th>
                <th class="px-4 py-3 font-semibold">Availability</th>
                <th class="px-4 py-3 font-semibold">Actions</th>
            </x-slot:header>

            @foreach ($menus as $menu)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-4">
                        <div class="font-medium text-slate-950">{{ $menu->name }}</div>
                        <div class="mt-1 max-w-md truncate text-sm text-slate-500">{{ $menu->description }}</div>
                    </td>

                    <td class="px-4 py-4 text-slate-600">{{ $menu->category->name ?? 'Uncategorized' }}</td>

                    <td class="px-4 py-4 font-medium text-slate-950">{{ number_format($menu->price, 2) }}</td>

                    <td class="px-4 py-4">
                        <span
                            class="{{ $menu->is_available ? 'bg-emerald-50 text-emerald-700 ring-emerald-200' : 'bg-red-50 text-red-700 ring-red-200' }} inline-flex rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset">
                            {{ $menu->is_available ? 'Available' : 'Unavailable' }}
                        </span>
                    </td>

                    <td class="px-4 py-4">
                        <a href="{{ route('menus.edit', $menu) }}" class="text-blue-600 hover:text-blue-800">
                            Edit
                        </a>
                    </td>
                </tr>
            @endforeach
        </x-datatable>
    </section>
@endsection
