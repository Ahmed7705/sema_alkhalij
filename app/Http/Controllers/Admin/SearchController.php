<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Order;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $q = trim($request->input('q'));

        if (empty($q)) {
            return view('admin.search', [
                'q' => '',
                'users' => collect(),
                'orders' => collect(),
                'bookings' => collect(),
                'products' => collect(),
                'services' => collect(),
                'articles' => collect(),
            ]);
        }

        $users = User::where('name', 'like', "%{$q}%")
            ->orWhere('email', 'like', "%{$q}%")
            ->orWhere('phone', 'like', "%{$q}%")
            ->take(10)->get();

        $orders = Order::where('order_number', 'like', "%{$q}%")
            ->orWhere('customer_name', 'like', "%{$q}%")
            ->orWhere('phone', 'like', "%{$q}%")
            ->take(10)->get();

        $bookings = Booking::where('booking_number', 'like', "%{$q}%")
            ->orWhere('patient_name', 'like', "%{$q}%")
            ->orWhere('phone', 'like', "%{$q}%")
            ->take(10)->get();

        $products = Product::where('title', 'like', "%{$q}%")
            ->orWhere('sku', 'like', "%{$q}%")
            ->take(10)->get();

        $services = Service::where('title', 'like', "%{$q}%")
            ->take(10)->get();

        $articles = BlogPost::where('title', 'like', "%{$q}%")
            ->orWhere('excerpt', 'like', "%{$q}%")
            ->take(10)->get();

        return view('admin.search', compact('q', 'users', 'orders', 'bookings', 'products', 'services', 'articles'));
    }
}
