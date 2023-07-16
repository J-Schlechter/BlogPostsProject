<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <title>View Comments</title>
</head>
<body style="background-image: url('https://cdn.pixabay.com/photo/2017/08/30/01/05/milky-way-2695569_1280.jpg');">
    @auth
    <nav class="navbar is-primary " role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
          <a class="navbar-item" href="/">
            <figure class = "image-is-520x520">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTO8oyb6fe_lzSVWIrAhdO9rCWCWeVzkkREuUvx6lVZXZq-ZvgVP4yF85RmE0FstWdhSJ4&usqp=CAU">
            </figure>
            </a>      
          <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="true" data-target="navbarBasicExample">
            
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
          </a>
        </div>
      
        <div id="navbaBlog" class="navbar-menu">
          <div class="navbar-start">
            <a class="navbar-item" href="/">Home</a>
            <a class = "navbar-item">|</a>
            <a class="navbar-item" href="/newpost">New Post</a>
          </div>
          <div class="navbar-end">
            <div class = "navbar-item">
              <b> Welcome {{Auth::user()->name}} </b>
            </div>
            <div class="navbar-item">   
                    <div class="buttons" >
                        <form action = "/logout" method = "POST">
                          @csrf
                            <button class="button is-danger" onclick="/logout">
                            Log Out
                            </button>
                        </form>    
                </div>
              </div>
            </div>
          </div>
        
      </nav>
    <div  class = "container  ">
        <section class="section" >
            <h3 class = "title" style="color: aliceblue">{{ $post->title}} by {{$post->user->name}} </h3>
            <p style="color: aliceblue">{{ $post->body }}</p>
            <br>
            @if($post->image_path !== null)
                <figure class="image is-128x128">
                     <img src = "{{ url('storage/images/'.$post->image_path)}}"> 
                     {{-- <img src = 'https://bulma.io/images/placeholders/128x128.png'> --}}
                </figure>
              @else
              @endif
        </section>
    </div>
    <div >
        <section class = "section mx"> 
        <form action="/viewcomments" method="POST">

        @csrf
        
        <h2 class="title is-2" style="color: aliceblue"><br>Comments:<br></h2>
        @foreach($comments as $comment)
        <div class="card is-small ">
            <div>
            <header class="card-header">
                <h6 class="title">{{$comment->user->name}}</h6>
            </header>
            <div class="card-content py-3">
              <div class="content">
                <h5>{{ $comment['text']}}</h5>
              </div>
            </div>
          </div>
        </div>
        <br>
            {{--  --}}
            
                      
        @endforeach    
        </form>
    </div>
    @else
    <nav class="navbar is-primary " role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
          <a class="navbar-item" href="/">
            <figure class = "image-is-520x520">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTO8oyb6fe_lzSVWIrAhdO9rCWCWeVzkkREuUvx6lVZXZq-ZvgVP4yF85RmE0FstWdhSJ4&usqp=CAU">
            </figure>
            </a>      
          <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="true" data-target="navbarBasicExample">
            
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
          </a>
        </div>
      
        <div id="navbaBlog" class="navbar-menu">
          <div class="navbar-start">
            <a class="navbar-item" href="/">Home</a>
            <a class = "navbar-item">|</a>
            <a class="navbar-item" href="/registernew">Register</a>
          </div>
          <div class="navbar-end">
            <div class = "navbar-item">
              <b> No user signed in </b>
            </div>
            <div class="navbar-item">   
                    <div class="buttons" >
                        <form action = "/logins" method = "GET">
                          @csrf
                            <button class="button is-info">
                            Log In
                            </button>
                        </form>    
                </div>
              </div>
            </div>
          </div>
        
      </nav>

    <div  class = "container  ">
        <section class="section" >
            <h3 class = "title" style="color: aliceblue">{{ $post->title}} by {{$post->user->name}} </h3>
            <p style="color: aliceblue">{{ $post->body }}</p>
            <br>
            @if($post->image_path !== null)
                <figure class="image is-128x128">
                     <img src = "{{ url('storage/images/'.$post->image_path)}}"> 
                     {{-- <img src = 'https://bulma.io/images/placeholders/128x128.png'> --}}
                </figure>
              @else
              @endif
        </section>
    </div>
    <div >
        <section class = "section mx"> 
        <form action="/viewcomments" method="POST">

        @csrf
        
        <h2 class="title is-2" style="color: aliceblue"><br>Comments:<br></h2>
        @foreach($comments as $comment)
        <div class="card is-small ">
            <div>
            <header class="card-header">
                <h6 class="title">{{$comment->user->name}}</h6>
            </header>
            <div class="card-content py-3">
              <div class="content">
                <h5>{{ $comment['text']}}</h5>
              </div>
            </div>
          </div>
        </div>
        <br>
            {{--  --}}
            
                      
        @endforeach    
        </form>
    </div>



    @endauth
               
</body>
</html>

