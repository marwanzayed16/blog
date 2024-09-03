<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('categories', 'comments', 'author')->paginate(12);

        return response()->json([
            'status' => 'success',
            'data' => $posts->items(), // only the data
            'pagination' => [
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'next_page_url' => $posts->nextPageUrl(),
                'prev_page_url' => $posts->previousPageUrl(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => ['required'],
            'slug' => ['required', 'unique:posts,slug'],
            'body' => ['required'],
            'categories' => ['required', 'array', 'exists:categories,id'],
            'image' => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'description' => ['sometimes'],
        ]);

        $attributes['slug'] = \Str::slug($attributes['slug']);

        if (isset($attributes['image'])) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);

            $attributes['image'] = 'images/'.$imageName;
        }

        if (! isset($attributes['description'])) {
            $message = 'Create a brief description for the following content: '.$attributes['body'];

            $result = Gemini::geminiPro()->generateContent($message);

            $attributes['description'] = str_replace(['*', "\n"], '', $result->text());
        }

        $post = $request->user()->posts()->create(\Arr::except($attributes, ['categories']));

        $post->categories()->attach($attributes['categories']);

        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post = $post->load('categories', 'comments', 'author');

        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $attributes = $request->validate([
            'title' => ['sometimes', 'required'],
            'slug' => ['sometimes', 'required', 'unique:posts,slug,'.$post->id],
            'body' => ['sometimes', 'required'],
            'categories' => ['sometimes', 'required', 'array', 'exists:categories,id'],
            'image' => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        if (isset($attributes['slug'])) {
            $attributes['slug'] = \Str::slug($attributes['slug']);
        }

        if (isset($attributes['image'])) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);

            $attributes['image'] = 'images/'.$imageName;
        }

        $post->update(\Arr::except($attributes, ['categories']));

        if (isset($attributes['categories'])) {
            $post->categories()->sync($attributes['categories']);
        }

        return response()->json($post->load('categories', 'comments', 'author'), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->noContent();
    }
}
