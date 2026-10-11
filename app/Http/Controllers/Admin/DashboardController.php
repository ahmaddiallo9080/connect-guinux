<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Message;
use App\Models\Product;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'stats' => [
                'products' => Product::count(),
                'active' => Product::active()->count(),
                'out_of_stock' => Product::where('stock', 0)->count(),
                'categories' => Category::count(),
                'unread' => Message::unread()->count(),
            ],
            'latestProducts' => Product::with('category')->latest()->take(5)->get(),
            'latestMessages' => Message::latest()->take(5)->get(),
        ]);
    }
}
