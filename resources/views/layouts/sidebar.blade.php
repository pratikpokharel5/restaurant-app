@php
    $navItems = [
        ['name' => 'Categories', 'route' => 'categories.index'],
        ['name' => 'Menus', 'route' => 'menus.index'],
        ['name' => 'Orders', 'route' => 'orders.index'],
        ['name' => 'Customers', 'route' => 'customers.index'],
        ['name' => 'Payments', 'route' => 'payments.index'],
    ];
@endphp

<nav class="h-[calc(100vh-56px)] w-64 shrink-0">
    <div
        class="fixed left-0 top-14 flex h-[calc(100vh-56px)] w-64 flex-col border-r border-gray-200 bg-white py-5 shadow-lg">

        @foreach ($navItems as $item)
            @php
                $isActive = request()->routeIs(str_replace('.index', '.*', $item['route']));
            @endphp

            <a href="{{ route($item['route']) }}" @class([
                'px-5 py-2',
                'bg-blue-100 text-blue-800 border-r-4 font-medium border-blue-600' => $isActive,
                'text-gray-700 hover:bg-gray-100' => !$isActive,
            ])>
                {{ $item['name'] }}
            </a>
        @endforeach

    </div>
</nav>
