<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Category;

class ServiceController extends Controller
{
    /**
     * Display medical services catalog with category filter & search.
     */
    public function index(Request $request)
    {
        $selectedCategorySlug = $request->query('category');
        $searchQuery = $request->query('search');

        $categories = Category::where('type', 'service')->get();

        $query = Service::where('is_active', true)->with('category');

        if ($selectedCategorySlug) {
            $query->whereHas('category', function ($q) use ($selectedCategorySlug) {
                $q->where('slug', $selectedCategorySlug);
            });
        }

        if ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('title', 'like', "%{$searchQuery}%")
                  ->orWhere('short_description', 'like', "%{$searchQuery}%")
                  ->orWhere('description', 'like', "%{$searchQuery}%");
            });
        }

        $services = $query->paginate(12)->withQueryString();

        return view('services', compact('services', 'categories', 'selectedCategorySlug', 'searchQuery'));
    }

    /**
     * Display specific medical service details.
     */
    public function show($slug)
    {
        $service = Service::where('slug', $slug)
            ->where('is_active', true)
            ->with('category')
            ->firstOrFail();

        $relatedServices = Service::where('category_id', $service->category_id)
            ->where('id', '!=', $service->id)
            ->where('is_active', true)
            ->take(3)
            ->get();

        return view('service-detail', compact('service', 'relatedServices'));
    }
}
