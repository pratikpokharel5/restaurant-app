@extends('app')

@section('title', 'Menus')

@section('content')
    <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-md">
        <div class="flex items-center justify-between">
            <h3 class="text-2xl font-bold">Menus</h3>

            <x-button as="link" href="{{ route('menus.create') }}">
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
                <th class="border border-gray-300 bg-gray-100 p-4">Name</th>
                <th class="border border-gray-300 bg-gray-100 p-4">Category</th>
                <th class="border border-gray-300 bg-gray-100 p-4">Price</th>
                <th class="border border-gray-300 bg-gray-100 p-4">Active Status</th>
                <th class="border border-gray-300 bg-gray-100 p-4">Actions</th>
            </x-slot:header>

            @foreach ($menus as $menu)
                <tr>
                    <td class="border border-gray-300 p-4">{{ $menu->name }}</td>

                    <td class="border border-gray-300 p-4">{{ $menu->category->name ?? '-' }}</td>

                    <td class="border border-gray-300 p-4">{{ $menu->price }}</td>

                    <td class="border border-gray-300 p-4">
                        <span
                            class="{{ $menu->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-full px-3 py-1.5">
                            {{ $menu->is_available ? 'Active' : 'Inactive' }}
                        </span>
                    </td>

                    <td class="border border-gray-300 p-4">
                        <a href="{{ route('menus.edit', $menu) }}" class="text-blue-600 hover:underline">Edit</a>

                        <form class="ml-2 inline-block" method="POST" action="{{ route('menus.destroy', $menu) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="cursor-pointer text-red-500 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </x-datatable>
    </div>
@endsection
