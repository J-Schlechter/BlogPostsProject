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
    
       
    //$image_path = $imageName;
    
    if ($request->hasFile('image')) {

        $imageName = time().'.'.$request->image->extension();
        $imagePath = $request->file('image')->storeAs('public/images',$imageName);
        //dd($imagePath);
        $validatedData['title'] = strip_tags($validatedData['title']);
        $validatedData['body'] = strip_tags($validatedData['body']);
        $validatedData['user_id'] = auth()->id();
        $validatedData['image_path'] = $imageName;
        
        $post = Post::create($validatedData);
        
        return response()->json(['message' => 'Post successful'], 200);
        

    } else {
        $validatedData['title'] = strip_tags($validatedData['title']);
        $validatedData['body'] = strip_tags($validatedData['body']);
        $validatedData['user_id'] = auth()->id();
        $validatedData['image_path'] = null;
        
        $post = Post::create($validatedData);
        
        return response()->json(['message' => 'Post successful'], 200);
    }
    
    }

    public function uploadImage(Request $request){
        //if($request->hasFile('image')){
            //$file=$request->hasFile('photomode_06012021_211517.png');
            //d($request->image);
            
            
            $request->file('image')->store('public/images/');
            //print($name);
           // print(json_encode($request->image));


            
       // }
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
            return response()->json(['message' => 'Post deleted successfully']);
        }
        return response()->json(['message' => 'Post deleted successfully']);
        
        
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

    public function getPosts()
    {
        // Fetch posts from the database using the Post model
        $posts = Post::with('user')->get();

        // Return the posts as an array
        return $posts->toArray();
    }
}