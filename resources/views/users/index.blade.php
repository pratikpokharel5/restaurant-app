@extends('app')

@section('title', 'Users')

@section('content')
    <section class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-950">Users</h1>
                <p class="mt-1 text-sm text-slate-500">Manage staff accounts that can access the admin app.</p>
            </div>

            @can('create', \App\Models\User::class)
                <x-button as="link" href="{{ route('users.create') }}">
                    <i class="fa-solid fa-plus mr-2" aria-hidden="true"></i>
                    Create Staff
                </x-button>
            @endcan
        </div>

        <x-datatable class="mt-3" search="{{ request('search') }}" search-placeholder="Search staff..." :pagination="$users">
            <x-slot:filters>
                <div class="w-full sm:w-64">
                    <x-select name="status" default-label="Filter by Status..." value="{{ request('status') }}">
                        <option value="active" @if (request('status') === 'active') selected @endif>Active</option>
                        <option value="archived" @if (request('status') === 'archived') selected @endif>Archived</option>
                    </x-select>
                </div>
            </x-slot:filters>

            <x-slot:header>
                <th class="px-4 py-3 font-semibold">Name</th>
                <th class="px-4 py-3 font-semibold">Email</th>
                <th class="px-4 py-3 font-semibold">Role</th>
                <th class="px-4 py-3 font-semibold">Status</th>
                <th class="px-4 py-3 font-semibold">Created</th>
                <th class="px-4 py-3 font-semibold">Actions</th>
            </x-slot:header>

            @foreach ($users as $user)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-4 font-medium text-slate-950">{{ $user->name }}</td>

                    <td class="px-4 py-4 text-slate-600">{{ $user->email }}</td>

                    <td class="px-4 py-4 text-slate-600">{{ ucfirst($user->role) }}</td>

                    <td class="px-4 py-4">
                        <span
                            class="{{ $user->isArchived() ? 'bg-slate-100 text-slate-600 ring-slate-200' : 'bg-emerald-50 text-emerald-700 ring-emerald-200' }} inline-flex rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset">
                            {{ $user->isArchived() ? 'Archived' : 'Active' }}
                        </span>
                    </td>

                    <td class="px-4 py-4 text-slate-600">{{ $user->created_at->format('M j, Y') }}</td>

                    <td class="px-4 py-4">
                        <a href="{{ route('users.show', $user) }}" class="text-blue-600 hover:text-blue-800">
                            View User
                        </a>
                    </td>
                </tr>
            @endforeach
        </x-datatable>
    </section>
@endsection
