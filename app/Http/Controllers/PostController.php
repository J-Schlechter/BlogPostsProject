<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function createPost(Request $request)
    {
    $validatedData = $request->validate([
        'title' => 'required',
        'body' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif',
    ]);

    $validatedData['title'] = strip_tags($validatedData['title']);
    $validatedData['body'] = strip_tags($validatedData['body']);
    $validatedData['user_id'] = auth()->id();
    $imagePath = null;
    $imageName = time().'.'.$request->image->extension();
    $request->image->storeAs('images', $imageName);
    $post = new Post;
    $post->title = $request->input('title');
    $post->body = $request->input('body');
    $post->image_path = $imageName;
    
    //if ($request->hasFile('image')) {
    //    $imagePath = $request->file('image')->store('images', 'public');
     //   $validatedData['image_path'] = $imagePath;
    //} else {
    //    $imagePath = null;
    //}
    Log::info(json_encode($post->all()));
    Log::info(json_encode($request->all()));
    
    $post = Post::create($validatedData);
    Log::info(json_encode($post));
    dd($post);
    return redirect('/')->with('success', 'Post created successfully!')
    ->with('image', $imageName);
    }

    public function uploadImage(Request $request){
        if($request->hasFile('image')){
            $imageName = $request->file('image')->store('images','public');
            $request->image->storeAs('images', $imageName);
        }
    }


    public function showEditScreen(Post $post){ 
        if(auth()->user()->id !== $post['user_id']) {
            return redirect('/');
        }

        

        return view('edit-post', ['post' => $post]);
    }

    public function deletePost(Post $post){
        if(auth()->user()->id === $post['user_id']) {
            $post->delete();
        }
        return redirect('/');
        
        
    }
    public function updatePost(Post $post, Request $request){
        if(auth()->user()->id !== $post['user_id']) {
            return redirect('/');
        }

        

        $incommingFields = $request->validate([
            'title' =>'required',
            'body' =>'required'
        ]);

        $incommingFields['title'] = strip_tags($incommingFields['title']);
        $incommingFields['body'] = strip_tags($incommingFields['body']);
        $post->update($incommingFields);
        return redirect('/');
    }
}