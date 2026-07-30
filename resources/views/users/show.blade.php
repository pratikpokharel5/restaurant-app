@extends('app')

@section('title', 'View User')

@section('content')
    <section class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <x-goback href="{{ route('users.index') }}">
                    View User
                </x-goback>

                <p class="mt-1 text-sm text-slate-500">Review staff details, reset password, and manage access.</p>
            </div>

            <span
                class="{{ $user->isArchived() ? 'bg-slate-100 text-slate-600 ring-slate-200' : 'bg-emerald-50 text-emerald-700 ring-emerald-200' }} inline-flex w-fit rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset">
                {{ $user->isArchived() ? 'Archived' : 'Active' }}
            </span>
        </div>

        <div class="mt-6 grid gap-5 md:grid-cols-2">
            <div>
                <x-label for="name">Name</x-label>
                <x-textfield id="name" value="{{ $user->name }}" disabled
                    class="cursor-not-allowed bg-slate-100 text-slate-500" />
                <p class="mt-1 text-sm text-slate-500">Staff name cannot be changed from this page.</p>
            </div>

            <div>
                <x-label for="email">Email</x-label>
                <x-textfield id="email" type="email" value="{{ $user->email }}" disabled
                    class="cursor-not-allowed bg-slate-100 text-slate-500" />
                <p class="mt-1 text-sm text-slate-500">Staff email cannot be changed from this page.</p>
            </div>
        </div>

        <form class="mt-6 grid gap-5 border-t border-slate-200 pt-5 md:grid-cols-2" method="POST"
            action="{{ route('users.password.update', $user) }}">
            @csrf
            @method('PATCH')

            <div class="md:col-span-2">
                <h2 class="text-base font-semibold text-slate-950">Reset Password</h2>
                <p class="mt-1 text-sm text-slate-500">Set a new password for this staff user.</p>
            </div>

            <div>
                <x-label for="password">New Password</x-label>
                <x-textfield id="password" type="password" name="password" autocomplete="new-password" :error="$errors->first('password')"
                    required />
            </div>

            <div>
                <x-label for="password_confirmation">Confirm New Password</x-label>
                <x-textfield id="password_confirmation" type="password" name="password_confirmation"
                    autocomplete="new-password" required />
            </div>

            <div class="md:col-span-2">
                <x-button type="submit">
                    <i class="fa-solid fa-key mr-2" aria-hidden="true"></i>
                    Reset Password
                </x-button>
            </div>
        </form>

        <div class="mt-6 border-t border-slate-200 pt-5">
            <h2 class="text-base font-semibold text-slate-950">Access</h2>
            <p class="mt-1 text-sm text-slate-500">
                {{ $user->isArchived() ? 'Restore access so this staff user can sign in again.' : 'Archive access so this staff user can no longer sign in.' }}
            </p>

            @if ($user->isArchived())
                @can('restore', $user)
                    <form class="mt-4" method="POST" action="{{ route('users.restore', $user) }}">
                        @csrf
                        @method('PATCH')

                        <x-button type="submit" class="bg-emerald-600 hover:bg-emerald-700 focus-visible:ring-emerald-500"
                            onclick="return confirm('Restore this staff user? They will be able to sign in again.')">
                            <i class="fa-solid fa-user-check mr-2" aria-hidden="true"></i>
                            Restore User
                        </x-button>
                    </form>
                @endcan
            @else
                @can('archive', $user)
                    <form class="mt-4" method="POST" action="{{ route('users.archive', $user) }}">
                        @csrf
                        @method('PATCH')

                        <x-button type="submit" class="bg-red-600 hover:bg-red-700 focus-visible:ring-red-500"
                            onclick="return confirm('Archive this staff user? They will no longer be able to sign in.')">
                            <i class="fa-solid fa-user-slash mr-2" aria-hidden="true"></i>
                            Archive User
                        </x-button>
                    </form>
                @endcan
            @endif
        </div>
    </section>
@endsection
