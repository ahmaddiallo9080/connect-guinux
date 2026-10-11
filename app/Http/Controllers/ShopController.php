<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount(['products' => fn ($q) => $q->active()])->orderBy('name')->get();
        $current = $request->filled('categorie') ? $categories->firstWhere('slug', $request->categorie) : null;

        $products = Product::active()->with('category')
            ->when($current, fn ($q) => $q->where('category_id', $current->id))
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = '%'.$request->q.'%';
                $q->where(fn ($w) => $w->where('name', 'like', $term)->orWhere('short_description', 'like', $term));
            })
            ->when($request->tri === 'prix_asc', fn ($q) => $q->orderBy('price'))
            ->when($request->tri === 'prix_desc', fn ($q) => $q->orderByDesc('price'))
            ->when(! in_array($request->tri, ['prix_asc', 'prix_desc']), fn ($q) => $q->orderByDesc('is_featured')->latest())
            ->paginate(12)->withQueryString();

        return view('shop.index', compact('products', 'categories', 'current'));
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        $related = Product::active()
            ->where('id', '!=', $product->id)
            ->when($product->category_id, fn ($q) => $q->where('category_id', $product->category_id))
            ->latest()->take(4)->get();

        return view('shop.show', compact('product', 'related'));
    }
}
