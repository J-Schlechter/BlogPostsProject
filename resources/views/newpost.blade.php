<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <title>New Post</title>
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
  <br>
  <div class="container is-max-desktop pb-3">
    <div class="notification is-primary">
      <h1 class="title is-1"> Write a new post </h1>
      <div style="background-color: gray; padding: 20px; margin:20px; border: 1px solid black;">
  <form action="/create-post" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="columns is-centered">
      <div class="column is-half">
    <div class ="field">
      
        <input class= "input pb-2" type="text" id="title" name="title" placeholder="Your post's title" style = "width: 70%" required>
    </div>

    <div class ="field">
        <textarea class= "textarea" id="body" name="body" placeholder="Write your post here!" style = "width: 65%" required></textarea>
    </div>
    <div class ="field">
    <div id="file-js-example" class="file has-name">
      <label class="file-label">
        <input class="file-input" type="file" name="image">
        <span class="file-cta">
          <span class="file-icon">
            <i class="fas fa-upload"></i>
          </span>
          <span class="file-label">
            Choose a file…
          </span>
        </span>
        <span class="file-name">
          No file uploaded
        </span>
      </label>
    </div>
    </div>
    <script>
      const fileInput = document.querySelector('#file-js-example input[type=file]');
      fileInput.onchange = () => {
        if (fileInput.files.length > 0) {
          const fileName = document.querySelector('#file-js-example .file-name');
          fileName.textContent = fileInput.files[0].name;
        }
      }
    </script>
    <button class = "button is-success" type="submit">Create Post</button>
</form>
  </div>
    </div>
  </div>
    </div>
  </div>
</body>
</html>




