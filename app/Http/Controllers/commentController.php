<?php

namespace App\Http\Controllers;


//use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class CommentController extends Controller
{
    public function createComment(Request $request){
        $incommingFields = $request->validate([
            
            'post_id'=> 'required|exists:posts,id',
            'text' =>'required',

        ]);

        
        $incommingFields['text'] = strip_tags($incommingFields['text']);
        $incommingFields['user_id'] = auth()->id();
        Log::info(json_encode($request->all()));
        Comment::create($incommingFields);
        return redirect('/');
      

    }

    public function destroy(Comment $comment)
    {
        if (auth()->user()->id === $comment->user_id) {
            $comment->delete();
        }

        return redirect('/');
    }

}
