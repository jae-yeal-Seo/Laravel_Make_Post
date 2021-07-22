<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function postCommentStore(Request $request, $id)
    {

        $content = $request->content;

        $comment = new Comment();
        $comment->content = $content;
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $id;


        $request->validate([
            'content' => 'required'
        ]);

        $comment->save();
        return redirect()->route('post.show', ['id' => $id, 'page' => $request->page]);
    }
}
