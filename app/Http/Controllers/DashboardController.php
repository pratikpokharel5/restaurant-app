<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $today = now()->startOfDay();

        $orderStatusCounts = Order::query()
            ->select('status', DB::raw('count(*) as aggregate'))
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        $summary = [
            'today_orders' => Order::where('created_at', '>=', $today)->count(),
            'today_revenue' => Payment::where('status', true)
                ->where('created_at', '>=', $today)
                ->sum('amount'),
            'unpaid_payments' => Payment::where('status', false)->count(),
            'active_menus' => Menu::where('is_available', true)->count(),
            'customers' => Customer::count(),
        ];

        $recentOrders = Order::with(['customer', 'payment'])
            ->latest()
            ->limit(5)
            ->get();

        $recentPayments = Payment::with(['order.customer'])
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.index', [
            'summary' => $summary,
            'orderStatusCounts' => $orderStatusCounts,
            'recentOrders' => $recentOrders,
            'recentPayments' => $recentPayments,
        ]);
    }
}
