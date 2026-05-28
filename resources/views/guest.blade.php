<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant App | @yield('title', '')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <main class="text-sm">
        @yield('content')
    </main>

    @if (session('message'))
        <x-toast>
            {{ session('message') }}
        </x-toast>
    @endif
</body>

</html>
