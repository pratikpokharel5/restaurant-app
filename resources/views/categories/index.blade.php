@extends('app')

@section('title', 'Categories')

@section('content')
    <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-md">
        <div class="flex items-center justify-between">
            <h3 class="text-2xl font-bold">Categories</h3>

            <x-button as="link" href="{{ route('categories.create') }}">
                Create Category
            </x-button>
        </div>

        <x-datatable class="mt-3" search="{{ request('search') }}" search-placeholder="Search category..." :pagination="$categories">
            <x-slot:header>
                <th class="border border-gray-300 bg-gray-100 p-4">Name</th>
                <th class="border border-gray-300 bg-gray-100 p-4">Description</th>
                <th class="border border-gray-300 bg-gray-100 p-4">Actions</th>
            </x-slot:header>

            @foreach ($categories as $category)
                <tr>
                    <td class="border border-gray-300 p-4">{{ $category->name }}</td>

                    <td class="border border-gray-300 p-4">{{ $category->description ?? '-' }}</td>

                    <td class="border border-gray-300 p-4">
                        <a href="{{ route('categories.edit', $category) }}" class="text-blue-600 hover:underline">Edit</a>

                        <form class="ml-2 inline-block" method="POST"
                            action="{{ route('categories.destroy', $category) }}">
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
