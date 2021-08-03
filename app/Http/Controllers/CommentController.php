<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function postCommentStore(Request $request, $id)
    {

        $content = $request->content;

        $comment = new Comment();
        $comment->user_id = Auth::user()->id;
        $comment->content = $content;
        $comment->post_id = $id;


        $request->validate([
            'content' => 'required'
        ]);

        $comment->save();
        return redirect()->route('post.show', ['comments' => $comment, 'page' => $request->page, 'id' => $id]);
    }
    public function edit(Request $request, $post, $commentid)
    {
        // $id를 이용해서 객체를 만들고
        // $request에 있는 editedcomment를 이용해서 내용을 수정한다.

        $comment = Comment::find($commentid);
        $comment->content = $request->editedcomment;
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $post;

        // $request->validate([
        //     'content' => 'required'
        // ]);

        $comment->save();
        return redirect()->route('post.show', ['page' => $request->page, 'id' => $post]);
    }
    public function delete(Request $request, $post, $commentid)
    {
        $comment = Comment::find($commentid);
        $comment->delete();

        return redirect()->route('post.show', ['page' => $request->page, 'id' => $post]);
    }
}
