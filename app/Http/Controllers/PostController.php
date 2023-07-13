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
        //Log::info(json_encode($post->image_path));
        return redirect('/')->with('image', $imagePath);
        

    } else {
        $imagePath = null;
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