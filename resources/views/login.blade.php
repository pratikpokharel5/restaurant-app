@extends('guest')

@section('title', 'Log In')

@section('content')
    <div class="grid min-h-screen place-items-center bg-slate-50 bg-cover bg-center px-4"
        style="background-image: url('/images/world_map.png')">
        <div class="w-full max-w-sm rounded-lg border border-slate-200 bg-white p-6 shadow-xl">
            <div class="text-center">
                <div class="mx-auto grid size-12 place-items-center rounded-md bg-blue-600 text-lg text-white">
                    <i class="fa-solid fa-utensils" aria-hidden="true"></i>
                </div>
                <h1 class="mt-4 text-xl font-bold text-slate-950">Restaurant App</h1>
                <p class="mt-1 text-sm text-slate-500">Sign in to manage kitchen operations.</p>
            </div>

            @if ($errors->has('email'))
                <x-alert class="mt-5">
                    {{ $errors->first('email') }}
                </x-alert>
            @endif

            <form class="mt-5" method="POST" action="{{ route('login.store') }}">
                @csrf
                <div>
                    <x-label for="email">Email</x-label>

                    <x-textfield id="email" type="email" name="email" placeholder="admin@test.com"
                        value="{{ old('email') }}" autocomplete="email" required autofocus />
                </div>

                <div class="mt-4">
                    <x-label for="password">Password</x-label>

                    <x-textfield id="password" type="password" name="password" placeholder="Password"
                        autocomplete="current-password" required />
                </div>

                <label class="mt-4 flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" value="1"
                        class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <i class="fa-solid fa-shield-halved text-slate-400" aria-hidden="true"></i>
                    Remember this device
                </label>

                <div class="mt-6">
                    <x-button type="submit" class="w-full">
                        <i class="fa-solid fa-right-to-bracket mr-2" aria-hidden="true"></i>
                        Log In
                    </x-button>
                </div>
            </form>
        </div>
    </div>
@endsection
