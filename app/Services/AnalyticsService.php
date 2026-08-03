<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Booking;
use App\Models\User;
use App\Models\Product;
use App\Models\Service;
use App\Models\CallbackRequest;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    /**
     * Get high-level executive dashboard summary metrics.
     */
    public static function getExecutiveSummary(): array
    {
        $ordersTotal = Order::where('payment_status', 'paid')->sum('total_price');
        $bookingsTotal = Booking::where('payment_status', 'paid')->sum('total_price');

        return [
            'total_revenue' => number_format($ordersTotal + $bookingsTotal, 2),
            'total_orders' => Order::count(),
            'total_bookings' => Booking::count(),
            'active_customers' => User::where('role', 'customer')->count(),
            'pending_callbacks' => CallbackRequest::where('status', 'pending')->count(),
            'low_stock_products' => Product::where('stock', '<=', 5)->count(),
        ];
    }

    /**
     * Get monthly chart dataset for Chart.js (Revenue & Bookings trend over last 6 months).
     */
    public static function getMonthlyChartData(): array
    {
        $labels = [];
        $revenueData = [];
        $bookingsData = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $labels[] = $month->translatedFormat('F Y');

            $start = $month->copy()->startOfMonth();
            $end = $month->copy()->endOfMonth();

            $orderRev = Order::whereBetween('created_at', [$start, $end])->sum('total_price');
            $bookingRev = Booking::whereBetween('created_at', [$start, $end])->sum('total_price');
            $revenueData[] = (float) ($orderRev + $bookingRev);

            $bookingsCount = Booking::whereBetween('created_at', [$start, $end])->count();
            $bookingsData[] = $bookingsCount;
        }

        return [
            'labels' => $labels,
            'revenue' => $revenueData,
            'bookings' => $bookingsData,
        ];
    }
}
