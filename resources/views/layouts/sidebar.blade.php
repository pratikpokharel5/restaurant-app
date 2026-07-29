@php
    $navItems = [
        ['name' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'fa-chart-line'],
        ['name' => 'Categories', 'route' => 'categories.index', 'icon' => 'fa-layer-group'],
        ['name' => 'Menus', 'route' => 'menus.index', 'icon' => 'fa-burger'],
        ['name' => 'Orders', 'route' => 'orders.index', 'icon' => 'fa-receipt'],
        ['name' => 'Customers', 'route' => 'customers.index', 'icon' => 'fa-users'],
        ['name' => 'Payments', 'route' => 'payments.index', 'icon' => 'fa-credit-card'],
        ['name' => 'Users', 'route' => 'users.index', 'icon' => 'fa-user-tie'],
    ];
@endphp

<nav class="border-b border-slate-200 bg-white lg:fixed lg:left-0 lg:top-16 lg:h-[calc(100vh-64px)] lg:w-64 lg:border-b-0 lg:border-r"
    aria-label="Primary">
    <div class="flex gap-1 overflow-x-auto px-4 py-3 lg:flex-col lg:overflow-x-visible lg:p-4">

        @foreach ($navItems as $item)
            @php
                $isActive = request()->routeIs(str_replace('.index', '.*', $item['route']));
            @endphp

            <a href="{{ route($item['route']) }}" aria-current="{{ $isActive ? 'page' : 'false' }}"
                @class([
                    'inline-flex items-center gap-3 whitespace-nowrap rounded-md px-3 py-2 font-medium outline-none transition focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 lg:w-full',
                    'bg-blue-50 text-blue-700' => $isActive,
                    'text-slate-600 hover:bg-slate-100 hover:text-slate-950' => !$isActive,
                ])>
                <i class="fa-solid {{ $item['icon'] }} w-4 text-center" aria-hidden="true"></i>
                {{ $item['name'] }}
            </a>
        @endforeach

    </div>
</nav>
