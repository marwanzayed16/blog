<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Post $post, Request $request)
    {
        $attributes = $request->validate([
            'body' => 'required',
        ]);

        $post->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $attributes['body'],
        ]);

        return response()->noContent();
    }
}
