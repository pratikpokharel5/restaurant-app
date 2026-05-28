<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant App | @yield('title', 'Categories')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    @include('layouts.appbar')

    <div class="flex pt-14 text-sm">
        @include('layouts.sidebar')

        <main class="grow p-5">
            @yield('content')
        </main>
    </div>

    @if (session('message'))
        <x-toast>
            {{ session('message') }}
        </x-toast>
    @endif
</body>

</html>
