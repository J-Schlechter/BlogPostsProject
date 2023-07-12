<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <title>Edit Post</title>
</head>


<body bgcolor="">

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
            <a class="navbar-item" href="#">Home</a>
            <a class="navbar-item" href="#">Documentation</a>
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
              <div class="buttons">
                <a class="button is-primary">
                  <strong>Sign up</strong>
                </a>
                <a class="button is-light">
                  Log in
                </a>
              </div>
            </div>
          </div>
        </div>
    </div>
      </nav>



    <div class="columns is-mobile">
        <div class="column  is-offset-one-quarter">    
    <h2 class = "title is-2">Edit Post</h2>
    <div class = "column is-three-quarters">
    <form action ="/edit-post/{{$post->id}}" method="POST">
    @csrf
    @method('PUT')
    
        <span> Title: <input class="input is-black is-three-quarters" type = "text" name = "title" value = " {{$post->title}}"></span>
        <br><br><textarea cols="50" rows="8" name = "body">{{$post->body}}  </textarea>
        <br><br><button class="button is-success">Save changes</button>
    </form>
    </div>
        </div>
    </div>
    
    

    
</body>
</html>

 

