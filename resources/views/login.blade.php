@extends('guest')

@section('title', 'Log In')

@section('content')
    <div class="grid min-h-screen place-items-center" style="background: url('/images/world_map.png')">
        <div class="w-96 rounded-lg border border-gray-200 bg-white p-5 shadow-lg">
            <div class="text-center text-xl font-semibold">Restaurant App</div>

            @if ($errors->has('email'))
                <x-alert class="mt-3">
                    {{ $errors->first('email') }}
                </x-alert>
            @endif

            <form class="mt-3" method="POST" action="{{ route('login.store') }}">
                <div>
                    <x-label for="email">Email</x-label>

                    <x-textfield id="email" type="email" name="email" placeholder="Email" />
                </div>

                <div class="mt-3">
                    <x-label for="password">Password</x-label>

                    <x-textfield id="password" type="password" name="password" placeholder="Password" />
                </div>

                <div class="mt-5">
                    <x-button type="submit" class="w-full">Log In</x-button>
                </div>
            </form>
        </div>
    </div>
@endsection
