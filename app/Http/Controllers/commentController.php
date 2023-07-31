<?php

namespace App\Http\Controllers;


//use App\Models\Post;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class CommentController extends Controller
{
    public function createComment($post_id, Request $request){
        $incommingFields = $request->validate([
            
            
            'text' =>'required',

        ]);

        
        $incommingFields['text'] = strip_tags($incommingFields['text']);
        $incommingFields['user_id'] = auth()->id();
        $incommingFields['post_id'] = $post_id;
        $comment = Comment::create($incommingFields);
        //dd($comment);
        return response()->json($comment, 201);
      

    }

        public function viewComments($postId)
    {
        $post = Post::find($postId);
        $comments = Comment::where('post_id', $postId)->get();
        
        // Return the comments data as JSON
        return response()->json($comments);
    }
    

    public function destroy(Comment $comment)
    {
        if (auth()->user()->id === $comment->user_id) {
            $comment->delete();
        }

        return redirect('/');
    }

}