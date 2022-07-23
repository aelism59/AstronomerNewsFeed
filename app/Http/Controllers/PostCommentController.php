<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use BeyondCode\Comments\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Post $post) {
        return $post->comments;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post) {
        $data = $request->validate([
            'comment' => 'required',

        ]);

        return $post->comment($data['comment']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post, Comment $comment) {
        return $comment;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post, Comment $comment) {
        // only commentor can update comment
        if ($comment->user_id !== (Auth::user()->id)) {
            return response(['error' => 1, 'message' => 'You cannot edit this comment.'], 401);
        }

        $comment->comment = $comment->comment ?? $comment->comment;
        $comment->update();
        return $comment;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, Comment $comment) {
        // only commentor and admin can delete comment
        $commentor_roles = Auth::user()->roles->pluck('slug')->toArray();
        $admin_override = in_array('admin', $commentor_roles) || in_array('super-admin', $commentor_roles);

        if (($comment->user_id !== (Auth::user()->id) || $admin_override)) {
            //don't allow changing the admin slug, because it will make the routes inaccessbile due to faile ability check
            $comment->delete();

            return response(['error' => 0, 'comment' => 'comment has been deleted']);
        }

        return response(['error' => 1, 'message' => 'you cannot delete this comment'], 422);
    }

}
