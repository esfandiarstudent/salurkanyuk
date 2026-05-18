<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('donationItems')->paginate(12);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        abort_unless(Auth::user()->isAdmin(), 403);
        return view('categories.create');
    }

    public function store(Request $request)
    {
        abort_unless(Auth::user()->isAdmin(), 403);
        $request->validate([
            'name'        => 'required|string|max:100',
            'icon'        => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        Category::create($request->only('name', 'icon', 'description'));
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Category $category)
    {
        abort_unless(Auth::user()->isAdmin(), 403);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        abort_unless(Auth::user()->isAdmin(), 403);
        $request->validate([
            'name'        => 'required|string|max:100',
            'icon'        => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);
        $category->update($request->only('name', 'icon', 'description'));
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Category $category)
    {
        abort_unless(Auth::user()->isAdmin(), 403);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
