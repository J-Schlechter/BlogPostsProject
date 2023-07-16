<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <title>Edit Post</title>
</head>


<body style="background-image: url('https://cdn.pixabay.com/photo/2017/08/30/01/05/milky-way-2695569_1280.jpg');">
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
    <div class="columns">
        <div class="column  is-offset-one-quarter is-half">    
          
    <h2 class = "title is-2" style="color: aliceblue">Edit Your Post</h2>
    <form action ="/edit-post/{{$post->id}}" method="POST">
    @csrf
    @method('PUT')
    <div class ="field">
      
        <span style="color: aliceblue"> Title: <input class="input is-three-quarters" type = "text" name = "title" value = " {{$post->title}}"></span>
        <br><br><textarea class= "textarea" name = "body">{{$post->body}}  </textarea>
        <br><br><button class="button is-success">Save changes</button>
    </form>
    </div>
        </div>
    </div>
    
    

    
</body>
</html>

 

