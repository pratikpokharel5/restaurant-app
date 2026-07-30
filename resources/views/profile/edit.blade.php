@extends('app')

@section('title', 'My Profile')

@section('content')
    <section class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
        <x-goback href="{{ url()->previous() }}">
            My Profile
        </x-goback>

        <p class="mt-1 text-sm text-slate-500">Update your account name and password.</p>

        <form class="mt-6 grid gap-5 md:grid-cols-2" method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div>
                <x-label for="name">Name</x-label>
                <x-textfield id="name" name="name" value="{{ old('name', auth()->user()->name) }}" autocomplete="name"
                    :disabled="auth()->user()->isAdmin()" :required="!auth()->user()->isAdmin()" :error="$errors->first('name')" @class([
                        'cursor-not-allowed bg-slate-100 text-slate-500' => auth()->user()->isAdmin(),
                    ]) />

                @if (auth()->user()->isAdmin())
                    <p class="mt-1 text-sm text-slate-500">Name cannot be changed.</p>
                @endif
            </div>

            <div>
                <x-label for="email">Email</x-label>
                <x-textfield id="email" type="email" value="{{ auth()->user()->email }}" disabled
                    class="cursor-not-allowed bg-slate-100 text-slate-500" />
                <p class="mt-1 text-sm text-slate-500">Email cannot be changed.</p>
            </div>

            <div class="border-t border-slate-200 pt-5 md:col-span-2">
                <h2 class="text-base font-semibold text-slate-950">Change Password</h2>
                <p class="mt-1 text-sm text-slate-500">Leave these fields empty to keep your current password.</p>
            </div>

            <div>
                <x-label for="current_password">Current Password</x-label>
                <x-textfield id="current_password" type="password" name="current_password" autocomplete="current-password"
                    :error="$errors->first('current_password')" />
            </div>

            <div>
                <x-label for="password">New Password</x-label>
                <x-textfield id="password" type="password" name="password" autocomplete="new-password" :error="$errors->first('password')" />
            </div>

            <div>
                <x-label for="password_confirmation">Confirm New Password</x-label>
                <x-textfield id="password_confirmation" type="password" name="password_confirmation"
                    autocomplete="new-password" />
            </div>

            <div class="md:col-span-2">
                <x-button type="submit">
                    <i class="fa-solid fa-floppy-disk mr-2" aria-hidden="true"></i>
                    Save Changes
                </x-button>
            </div>
        </form>
    </section>
@endsection
