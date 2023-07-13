<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <title>Home</title>
</head>
<body>
    
    @auth
    <nav class="navbar " role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
          <a class="navbar-item" href="https://bulma.io">
            <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28">
          
            </a>      
          <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="true" data-target="navbarBasicExample">
            
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
          </a>
        
      
        <div id="navbarBasicExample" class="navbar-menu">
          <div class="navbar-start">
            <a class="navbar-item" href="/">Home</a>
            <a class="navbar-item" href="#">View Your Posts</a>
            <div class="navbar-item has-dropdown is-hoverable">
              <a class="navbar-link">More</a>
              <div class="navbar-dropdown">
                <a class="navbar-item" href="#">About</a>
                <a class="navbar-item" href="#">Jobs</a>
                <a class="navbar-item" href="#">Contact</a>
                <hr class="navbar-divider">
                <a class="navbar-item" href="#">Report an issue</a>
              </div>
            </div>
          </div>
      
          <div class="navbar-end">
            <div class="navbar-item">
                
                    
                    <div class="buttons" >
                        <form action = "/logout" method = "POST">
                          @csrf
                            <button class="button is-light" onclick="/logout">
                            Log Out
                            </button>
                        </form>
                        
                </div>
                
              </div>
            </div>
          </div>
        </div>
      </div>
      </nav>
      <br>
      <p style="text-align:right;"><b> Welcome {{Auth::user()->name}} </b></p>




    
    
    
    
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
            <div>
                

                <figure class="image is-128x128">
                     <img src = "{{ url('storage/images/'.$post->image_path)}}"> 
                     {{-- <img src = 'https://bulma.io/images/placeholders/128x128.png'> --}}
                </figure>
            </div>
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