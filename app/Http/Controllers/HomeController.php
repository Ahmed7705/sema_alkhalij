<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Service;
use App\Models\Product;
use App\Models\SiteStat;
use App\Models\Review;
use App\Models\Certification;
use App\Models\Partner;
use App\Models\BlogPost;
use App\Models\Faq;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('type', 'service')->get();
        
        $featuredServices = Service::where('is_active', true)
            ->where('is_featured', true)
            ->with('category')
            ->take(6)
            ->get();

        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->with('category')
            ->take(4)
            ->get();

        $siteStats = SiteStat::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $reviews = Review::where('is_approved', true)
            ->take(6)
            ->get();

        $certifications = Certification::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $partners = Partner::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $latestPosts = BlogPost::where('is_published', true)
            ->with('category')
            ->latest('published_at')
            ->take(3)
            ->get();

        $faqs = Faq::where('is_active', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        return view('welcome', compact(
            'categories',
            'featuredServices',
            'featuredProducts',
            'siteStats',
            'reviews',
            'certifications',
            'partners',
            'latestPosts',
            'faqs'
        ));
    }
}
