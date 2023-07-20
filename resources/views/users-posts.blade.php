<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- External CSS framework - Bulma -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    
    <!-- Title of the web page -->
    <title>Home</title>
</head>
<body style="background-image: url('https://cdn.pixabay.com/photo/2017/08/30/01/05/milky-way-2695569_1280.jpg');">
   
    <!-- Check if the user is authenticated (logged in) -->
    @auth
    <!-- Navigation bar for authenticated users -->
    <nav class="navbar is-primary" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <!-- Logo or brand icon -->
            <a class="navbar-item" href="/">
                <figure class="image-is-520x520">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTO8oyb6fe_lzSVWIrAhdO9rCWCWeVzkkREuUvx6lVZXZq-ZvgVP4yF85RmE0FstWdhSJ4&usqp=CAU" alt="Logo">
                </figure>
            </a>
            <!-- Navbar burger for mobile navigation -->
            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="true" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>
        <!-- Navbar menu with navigation links -->
        <div id="navbaBlog" class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item" href="/">Home</a>
                <a class="navbar-item">|</a>
                <a class="navbar-item" href="/newpost">New Post</a>
            </div>
            <div class="navbar-end">
                <div class="navbar-item">
                    <!-- Display the user's name as a welcome message -->
                    <b> Welcome {{Auth::user()->name}} </b>
                </div>
                <div class="navbar-item">
                    <div class="buttons">
                        <!-- Form to log out the user -->
                        <form action="/logout" method="POST">
                            @csrf
                            <button class="button is-danger">Log Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Breadcrumb navigation to show the user's position in the hierarchy -->
    <nav class="breadcrumb is-centered" aria-label="breadcrumbs">
        <ul>
            <li><a href="/">All Posts</a></li>
            <li class="is-active"><a href="/yourPosts" aria-current="page">Your posts</a></li>
        </ul>
    </nav>
    <!-- Loop to display all blog posts of the current user -->
    @foreach($posts as $post)
    <div class="container is-max-desktop pb-3">
        <!-- Notification box to highlight the blog post -->
        <div class="notification is-primary">
            <!-- Gray background and styling for the blog post content -->
            <div style="background-color: gray; padding: 20px; margin: 20px; border: 1px solid black;">
                <!-- Title of the blog post and the name of the post author -->
                <h1 class="title">{{ $post['title']}} by {{$post->user->name}}</h1>
                <br>
                <!-- Blog post body -->
                <h2 class="subtitle">{{ $post['body'] }}</h2>

                <!-- Form to edit the blog post -->
                <form action="edit-post/{{$post->id}}" method="GET">
                    @csrf
                    <button class="button is-warning">Edit Post</button>
                </form>

                <!-- Form to delete the blog post -->
                <form action="/delete-post/{{ $post->id }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="button is-danger">Delete Post</button>
                </form>

                <!-- Display the post's image if available -->
                <div>
                    @if($post->image_path !== null)
                    <figure class="image is-128x128">
                        <img src="{{ url('storage/images/'.$post->image_path)}}" alt="Post Image">
                    </figure>
                    @else
                    <!-- Display a placeholder image if no image is available -->
                    @endif
                </div>

                <!-- Comment section -->
                <div class="columns is-mobile">
                    <div class="column is-4 is-offset-8">
                        <div style="text-align:right" >
                            <!-- Form to add a comment -->
                            <form action="/comment" method="POST">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <label for="author"> Commenting as {{auth()->user()->name}} </label>
                                <textarea class="textarea is-small has-fixed-size" name="text" rows="3" placeholder="Write a Comment"></textarea>
                                <br>
                                <p><button class="button is-success">Comment</button></p>
                            </form>

                            <!-- Form to view comments for the post -->
                            <form action="/viewComments/{{$post->id}}" method="GET">
                                <button class="button is-info">View comments for this post</button>
                                <input type="hidden" name="post_id" value="{{ $post->id }}"> 
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <!-- End of the loop to display blog posts -->
    </div>

    <!-- If the user is not authenticated, redirect them to the login page -->
    @else
    <script>window.location = "/logins";</script>
    @endauth
</body>
</html>
