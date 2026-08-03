<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display the medical products catalog.
     */
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)->with('category');

        $selectedCategory = $request->query('category');
        $searchKeyword = $request->query('search');
        $sortOrder = $request->query('sort', 'newest');

        // Category Filter
        if ($selectedCategory && $selectedCategory !== 'all') {
            $query->whereHas('category', function ($q) use ($selectedCategory) {
                $q->where('slug', $selectedCategory);
            });
        }

        // Text Search
        if ($searchKeyword) {
            $query->where(function ($q) use ($searchKeyword) {
                $q->where('title', 'like', "%{$searchKeyword}%")
                  ->orWhere('short_description', 'like', "%{$searchKeyword}%")
                  ->orWhere('description', 'like', "%{$searchKeyword}%")
                  ->orWhere('sku', 'like', "%{$searchKeyword}%");
            });
        }

        // Sorting
        switch ($sortOrder) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        $categories = Category::where('type', 'product')
            ->whereHas('products')
            ->get();

        return view('products', compact('products', 'categories', 'selectedCategory', 'searchKeyword', 'sortOrder'));
    }

    /**
     * Display a specific medical product detail.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with('category')
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('product-detail', compact('product', 'relatedProducts'));
    }
}
