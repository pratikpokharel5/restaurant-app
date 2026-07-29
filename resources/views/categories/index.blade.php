@extends('app')

@section('title', 'Categories')

@section('content')
    <section class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-950">Categories</h1>
                <p class="mt-1 text-sm text-slate-500">Group menu items for faster staff lookup.</p>
            </div>

            <x-button as="link" href="{{ route('categories.create') }}">
                <i class="fa-solid fa-plus mr-2" aria-hidden="true"></i>
                Create Category
            </x-button>
        </div>

        <x-datatable class="mt-3" search="{{ request('search') }}" search-placeholder="Search category..."
            :pagination="$categories">
            <x-slot:filters>
                <div class="w-64">
                    <x-select name="status" default-label="Filter by Status..." value="{{ request('status') }}">
                        <option value="active" @if (request('status') === 'active') selected @endif>Active</option>
                        <option value="inactive" @if (request('status') === 'inactive') selected @endif>Inactive</option>
                    </x-select>
                </div>
            </x-slot:filters>

            <x-slot:header>
                <th class="px-4 py-3 font-semibold">Name</th>
                <th class="px-4 py-3 font-semibold">Description</th>
                <th class="px-4 py-3 font-semibold">Status</th>
                <th class="px-4 py-3 font-semibold">Actions</th>
            </x-slot:header>

            @foreach ($categories as $category)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-4 font-medium text-slate-950">{{ $category->name }}</td>

                    <td class="max-w-xl px-4 py-4 text-slate-600">{{ $category->description ?? '-' }}</td>

                    <td class="px-4 py-4">
                        <span
                            class="{{ $category->isArchived() ? 'bg-slate-100 text-slate-600 ring-slate-200' : 'bg-emerald-50 text-emerald-700 ring-emerald-200' }} inline-flex rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset">
                            {{ $category->isArchived() ? 'Inactive' : 'Active' }}
                        </span>
                    </td>

                    <td class="px-4 py-4">
                        <a href="{{ route('categories.edit', $category) }}" class="text-blue-600 hover:text-blue-800">
                            Edit
                        </a>
                    </td>
                </tr>
            @endforeach
        </x-datatable>
    </section>
@endsection
