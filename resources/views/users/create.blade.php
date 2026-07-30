@extends('app')

@section('title', 'Create Staff')

@section('content')
    <section class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
        <x-goback href="{{ route('users.index') }}">Create Staff</x-goback>

        <form class="mt-6 grid gap-5 md:grid-cols-2" method="POST" action="{{ route('users.store') }}">
            @csrf

            <div>
                <x-label for="name">Name</x-label>

                <x-textfield id="name" name="name" placeholder="Staff name" value="{{ old('name') }}"
                    :error="$errors->first('name')" required />
            </div>

            <div>
                <x-label for="email">Email</x-label>

                <x-textfield id="email" type="email" name="email" placeholder="staff@example.com"
                    value="{{ old('email') }}" :error="$errors->first('email')" required />
            </div>

            <div>
                <x-label for="password">Password</x-label>

                <x-textfield id="password" type="password" name="password" placeholder="Password" :error="$errors->first('password')"
                    required />
            </div>

            <div>
                <x-label for="password_confirmation">Confirm Password</x-label>

                <x-textfield id="password_confirmation" type="password" name="password_confirmation"
                    placeholder="Confirm password" required />
            </div>

            <div class="md:col-span-2">
                <x-button type="submit">
                    <i class="fa-solid fa-check mr-2" aria-hidden="true"></i>
                    Create Staff
                </x-button>
            </div>
        </form>
    </section>
@endsection
