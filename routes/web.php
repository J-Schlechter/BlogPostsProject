<?php

use App\Http\Controllers\commentController;
use App\Http\Controllers\PostController;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    //$posts = auth()->user()->usersPosts()->latest()->get();
    $posts = Post::withCount('comments')
        ->orderBy('comments_count', 'desc')
        ->get();
    
    //$posts = Post::where('user_id', auth()->id())->get();
    return view('home', ['posts' => $posts]);
    //return view('home');
});


Route::get('/yourPosts', function () {
    
    $posts = Post::where('user_id', auth()->id())->get();
    return view('users-posts', ['posts' => $posts]);
    //return view('home');
});



Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);


Route::post('/upload-image', [PostController::class, 'uploadImage']);
Route::post('/create-post', [PostController::class, 'createPost', 'as' => 'create-post']);
Route::get('/edit-post/{post}', [PostController::class, 'showEditScreen']);
Route::put('/edit-post/{post}', [PostController::class, 'updatePost']);
Route::delete('/delete-post/{post}', [PostController::class, 'deletePost']);


Route::post('/comment', [commentController::class,'createComment']);
Route::get('/viewComments/{post_id}', [commentController::class,'viewComments']);    

Route::get('/logins', function() {
    return view('logins');
    });

Route::get('/registernew', function() {
    return view('registeruser');
    });

Route::get('/newpost', function() {
        return view('newpost');
    });


