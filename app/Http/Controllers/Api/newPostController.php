<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class newPostController extends Controller
{
    public function createPost(Request $request)
    {
        $validatedData = $request->validate([
            
            'title' => 'required',
            'body' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif',

        ]);


        $imageName = time().'.'.$request->image->extension();
        $imagePath = $request->file('image')->storeAs('public/images',$imageName);
        //dd($imagePath);
        $validatedData['title'] = strip_tags($validatedData['title']);
        $validatedData['body'] = strip_tags($validatedData['body']);
        $validatedData['user_id'] = auth()->id();
        $validatedData['image_path'] = $imageName;
        
        return Post::create($validatedData);
    }
}
