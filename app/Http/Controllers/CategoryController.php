<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('categories.index', [
            'categories' => Auth::user()->categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            ['name' => ['required', 'min:3', 'max:100']]
        );

        Category::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View
    {
        Gate::authorize('manage-category', $category);

        return view('categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        Gate::authorize('manage-category', $category);

        $request->validate(
            ['name' => ['required', 'min:3', 'max:100']]
        );

        $category->update(['name' => $request->name]);

        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        Gate::authorize('manage-category', $category);

        $category->delete();

        return redirect()->route('categories.index');
    }
}
