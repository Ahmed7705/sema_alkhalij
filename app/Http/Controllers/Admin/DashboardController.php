<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Order;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display the Admin Analytics & Control Dashboard.
     */
    public function index()
    {
        $totalBookingsCount = Booking::count();
        $totalOrdersCount = Order::count();
        $totalUsersCount = User::count();

        $servicesRevenue = Booking::sum('total_price');
        $ordersRevenue = Order::sum('total_price');
        $totalRevenue = $servicesRevenue + $ordersRevenue;

        $recentBookings = Booking::with('service')->latest()->take(5)->get();
        $recentOrders = Order::with('items')->latest()->take(5)->get();

        $topServices = Service::withCount('bookings')->orderBy('bookings_count', 'desc')->take(5)->get();
        $topProducts = Product::orderBy('stock', 'asc')->take(5)->get();

        // Chart.js monthly dataset
        $chartMonths = ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];
        $chartDataServices = [1200, 1900, 3000, 5000, 4200, 6800, 7500, (int)$servicesRevenue, 0, 0, 0, 0];
        $chartDataProducts = [800, 1200, 2100, 3400, 2900, 4500, 5200, (int)$ordersRevenue, 0, 0, 0, 0];

        return view('admin.dashboard', compact(
            'totalBookingsCount',
            'totalOrdersCount',
            'totalUsersCount',
            'totalRevenue',
            'servicesRevenue',
            'ordersRevenue',
            'recentBookings',
            'recentOrders',
            'topServices',
            'topProducts',
            'chartMonths',
            'chartDataServices',
            'chartDataProducts'
        ));
    }
}
