<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('posts')->get();

        return response()->json([
            'status' => 'success',
            'data' => $categories, // only the data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required'],
            'slug' => ['required', 'unique:categories,slug'],
        ]);

        $attributes['slug'] = \Str::slug($attributes['slug']);

        return Category::create($attributes);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $category->load('posts');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $attributes = $request->validate([
            'name' => ['sometimes', 'required'],
            'slug' => ['sometimes', 'required', 'unique:categories,slug,'.$category->id],
        ]);

        if (isset($attributes['slug'])) {
            $attributes['slug'] = \Str::slug($attributes['slug']);
        }

        $category->update($attributes);

        return $category;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->noContent();
    }
}
