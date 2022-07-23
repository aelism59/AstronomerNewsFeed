<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        return Post::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $data = $request->validate([
            'title' => 'required|string',
            'contents' => 'required|string',
            'tag' => 'optional|string',

        ]);

        return Post::create([
            'title' => $data['title'],
            'contents' => $data['contents'],
            'tag' => $data['tag'] ?? null,
            'author_id' => Auth::user()->id,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post) {
        return $post;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post = null) {
        if (! $post) {
            return response(['error' => 1, 'message' => 'Post doesn\'t exist'], 404);
        }

        $post->title = $request->title ?? $post->title;
        $post->contents = $request->contents ?? $post->contents;
        $post->tag = $request->tag ?? $post->tag;
        $post->author_id = $request->author_id ?? $post->author_id;
        $post->update();

        return $post;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $role) {
        $role->delete();
        return response(['error' => 0, 'message' => 'role has been deleted']);
    }

}
