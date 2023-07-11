<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
</head>
<body>
    
    @auth
    <p><b> Welcome {{Auth::user()->name}} </b></p>
    <p style="text-align:right;"> You are logged in! </p>
    <form style="text-align:right;" action = "/logout" method = "POST">
        @csrf
        <button> Log Out </button>
    </form>

    <div style="border: 3px solid black;">
        <h2> Write a Post </h2>
        <form action = "/newpost" method = "GET">
        @csrf
            <p><button>New Post</button>
        </form>
    </div>

    <div style="border: 3px solid black;">
        <h2> All Posts </h2>
        @foreach($posts as $post)
        <div style="background-color: gray; padding: 20px; margin:20px; border: 1px solid black;">
            <h3>{{ $post['title']}} by {{$post->user->name}} </h3>
            <p>{{ $post['body'] }}</p>
            <form action = "edit-post/{{$post->id}}" method="GET">
                @csrf
                <button>Edit Post</button>
            </form>
            <p><a href="/edit-post/{{ $post->id }}"> Edit </a></p>
            <form action = "/delete-post/{{ $post->id }}" method = "POST">
            @csrf
                @method('DELETE')
                <p><button>Delete Post</button>
            </form>
            <div style="text-align:right; padding: 200px" >
                <h5> Write a Comment </h5>
                <form action = "/comment" method = "POST">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <label for="author"> Commenting as {{auth()->user()->name}} </label>                                     
                    <textarea name="text"></textarea>
                    <p><button>Comment</button>                       
                </form>
                <form action = "/viewComments/{{$post->id}}" method = "GET">
                    
                    <button>View comments for this post</button>
                    
                    <input type="hidden" name="post_id" value="{{ $post->id }}"> 
                </form>
               
                    
            </div>
            
        </div>

        

        @endforeach
    </div>

    @else
    <script>window.location = "/logins";</script>
    @endauth
           
</body>
</html>