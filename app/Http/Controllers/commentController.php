<?php

namespace App\Http\Controllers;

use App\Http\Requests\commentRequest;
use App\Models\Comment;
use App\Models\Post;


class CommentController extends Controller
{
    public function store(Post $post, commentRequest $request)
    {   
        $validatedData = $request->validated();
        $comment = new Comment();

        $comment->post_id = $post->id;
        $comment->author = auth()->user();
        $comment->text = $validatedData['text'];
        $comment->save();
        

        

        $validatedData['user_id'] = auth()->id();

        Comment::create($validatedData);

        return redirect()->back();
    }

    public function destroy(Comment $comment)
    {
        if (auth()->user()->id === $comment->user_id) {
            $comment->delete();
        }

        return redirect()->back();
    }

}
