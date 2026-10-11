<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('name')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:100', 'unique:categories,name']], [], ['name' => 'nom']);
        Category::create($data);

        return back()->with('success', 'Catégorie ajoutée.');
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:100', 'unique:categories,name,'.$category->id]], [], ['name' => 'nom']);
        $category->update($data);

        return back()->with('success', 'Catégorie renommée.');
    }

    public function destroy(Category $category)
    {
        $category->delete(); // les produits liés passent « sans catégorie »

        return back()->with('success', 'Catégorie supprimée.');
    }
}
