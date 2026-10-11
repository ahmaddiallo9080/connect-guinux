<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Product::active()->with('category')
            ->orderByDesc('is_featured')->latest()->take(8)->get();

        $categories = Category::withCount(['products' => fn ($q) => $q->active()])
            ->orderBy('name')->get();

        $productCount = Product::active()->count();

        return view('home', compact('featured', 'categories', 'productCount'));
    }

    public function services()
    {
        return view('services');
    }
}
