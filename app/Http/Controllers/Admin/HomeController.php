<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Product statistics
        $productStats = [
            'total' => Product::count(),
            'active' => Product::active()->count(),
            'inactive' => Product::inactive()->count(),
        ];

        // Order statistics
        $today = now()->toDateString();
        $orderStats = [
            'total' => Order::count(),
            'today' => Order::whereDate('created_at', $today)->count(),
            'today_pending' => Order::whereDate('created_at', $today)->where('status', 'pending')->count(),
            'today_processing' => Order::whereDate('created_at', $today)->where('status', 'processing')->count(),
            'today_shipped' => Order::whereDate('created_at', $today)->where('status', 'shipped')->count(),
            'today_delivered' => Order::whereDate('created_at', $today)->where('status', 'delivered')->count(),
            'today_cancelled' => Order::whereDate('created_at', $today)->where('status', 'cancelled')->count(),
            'today_revenue' => Order::whereDate('created_at', $today)->where('status', 'delivered')->sum('total_amount'),
        ];

        // Weekly sales data for charts
        $weeklySales = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->where('status', 'delivered')
            ->whereBetween('created_at', [now()->subDays(7), now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date');

        // Monthly sales data for charts
        $monthlySales = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->where('status', 'delivered')
            ->whereBetween('created_at', [now()->subDays(30), now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date');

        // Order status distribution for pie chart
        $orderStatusDistribution = Order::selectRaw('status, COUNT(*) as count')
            ->whereDate('created_at', $today)
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // Top selling products (all time)
        $topProducts = Product::withCount([
            'orderItems as orders_count' => function ($query) {
                $query->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->where('orders.status', 'delivered');
            }
        ])
            ->orderBy('orders_count', 'desc')
            ->take(5)
            ->get();

        // Monthly top selling products
        $monthlyTopProducts = Product::withCount([
            'orderItems as orders_count' => function ($query) {
                $query->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->where('orders.status', 'delivered')
                    ->where('orders.created_at', '>=', now()->subDays(30));
            }
        ])
            ->orderBy('orders_count', 'desc')
            ->take(5)
            ->get();

        // Monthly revenue
        $monthlyRevenue = Order::where('status', 'delivered')
            ->where('created_at', '>=', now()->subDays(30))
            ->sum('total_amount');

        return view('admin.index', compact(
            'productStats',
            'orderStats',
            'weeklySales',
            'monthlySales',
            'orderStatusDistribution',
            'topProducts',
            'monthlyTopProducts',
            'monthlyRevenue'
        ));
    }
}