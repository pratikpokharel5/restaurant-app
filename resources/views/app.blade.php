<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant App | @yield('title', 'Categories')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.0/css/all.min.css">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 antialiased">
    @include('layouts.appbar')

    <div class="min-h-screen pt-16 text-sm lg:flex">
        @include('layouts.sidebar')

        <main class="min-w-0 grow p-4 sm:p-6 lg:ml-64 lg:p-8">
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
