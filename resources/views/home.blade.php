<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Metadata -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Bulma CSS stylesheet -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">

  <!-- Page title -->
  <title>Home</title>
</head>

<body style="background-image: url('https://cdn.pixabay.com/photo/2017/08/30/01/05/milky-way-2695569_1280.jpg');">

  <!-- Navigation for authenticated users -->
  @auth
  <nav class="navbar is-primary" role="navigation" aria-label="main navigation">
    <!-- Navbar brand/logo -->
    <div class="navbar-brand">
      <a class="navbar-item" href="/">
        <figure class="image-is-520x520">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTO8oyb6fe_lzSVWIrAhdO9rCWCWeVzkkREuUvx6lVZXZq-ZvgVP4yF85RmE0FstWdhSJ4&usqp=CAU">
        </figure>
      </a>
      <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="true" data-target="navbarBasicExample">
        <!-- Hamburger icon for mobile navigation -->
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>
    </div>

    <!-- Navbar menu items -->
    <div id="navbaBlog" class="navbar-menu">
      <div class="navbar-start">
        <a class="navbar-item" href="/">Home</a>
        <a class="navbar-item">|</a>
        <a class="navbar-item" href="/newpost">New Post</a>
      </div>
      <div class="navbar-end">
        <!-- Display the authenticated user's name -->
        <div class="navbar-item">
          <b> Welcome {{Auth::user()->name}} </b>
        </div>
        <div class="navbar-item">
          <!-- Logout button -->
          <div class="buttons">
            <form action="/logout" method="POST">
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

  <!-- Breadcrumbs -->
  <nav class="breadcrumb is-centered" aria-label="breadcrumbs">
    <ul>
      <li class="is-active"><a href="#" aria-current="page">All Posts</a></li>
      <li><a href="/yourPosts">Your posts</a></li>
    </ul>
  </nav>

  <!-- Loop through posts and display each post -->
  @foreach($posts as $post)
  <div class="container is-max-desktop pb-3">
    <!-- Notification box for each post -->
    <div class="notification is-primary">
      <div style="background-color: gray; padding: 20px; margin:20px; border: 1px solid black;">
        <!-- Post title -->
        <h1 class='title'>{{ $post['title']}}</h1>
        <!-- Author's name -->
        <p><b>by {{$post->user->name}}</b></p>
        <br>
        <!-- Post body -->
        <h2 class="subtitle">{{ $post['body'] }}</h2>
        <!-- Edit Post and Delete Post buttons -->
        @if($post->user_id === Auth::user()->id)
        <form action="edit-post/{{$post->id}}" method="GET">
          @csrf
          <button class="button is-warning">Edit Post</button>
        </form>
        <br>
        <button class="js-modal-trigger button is-danger" data-target="modal-js-delete">
          Delete Post
        </button>
        @endif
        <!-- Display post image if available -->
        <div>
          @if($post->image_path !== null)
          <br>
          <figure class="image is-128x128">
            <img src="{{ url('storage/images/'.$post->image_path)}}">
          </figure>
          @else
          @endif
        </div>
        <!-- Comment form -->
        <div class="columns is-mobile">
          <div class="column is-4 is-offset-8">
            <div style="text-align:right">
              <form action="/comment" method="POST">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <label for="author"> Commenting as {{auth()->user()->name}} </label>
                <textarea class="textarea is-small has-fixed-size" name="text" rows="3"
                  placeholder="Write a Comment"></textarea>
                <br>
                <p><button class="button is-success">Comment</button>
                </p>
              </form>
              <br>
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
  <!-- End of post loop -->
  @else
  <!-- Navigation for non-authenticated users -->
  <nav class="navbar is-primary" role="navigation" aria-label="main navigation">
    <!-- Navbar brand/logo -->
    <div class="navbar-brand">
      <a class="navbar-item" href="/">
        <figure class="image-is-520x520">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTO8oyb6fe_lzSVWIrAhdO9rCWCWeVzkkREuUvx6lVZXZq-ZvgVP4yF85RmE0FstWdhSJ4&usqp=CAU">
        </figure>
      </a>
      <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="true" data-target="navbarBasicExample">
        <!-- Hamburger icon for mobile navigation -->
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>
    </div>

    <!-- Navbar menu items -->
    <div id="navbaBlog" class="navbar-menu">
      <div class="navbar-start">
        <a class="navbar-item" href="/">Home</a>
        <a class="navbar-item">|</a>
        <a class="navbar-item" href="/registernew">Register</a>
      </div>
      <div class="navbar-end">
        <!-- Message for non-authenticated users -->
        <div class="navbar-item">
          <b> No user signed in </b>
        </div>
        <div class="navbar-item">
          <!-- Log in button for non-authenticated users -->
          <div class="buttons">
            <form action="/logins" method="GET">
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

  <!-- Breadcrumbs -->
  <nav class="breadcrumb is-centered" aria-label="breadcrumbs">
    <ul>
      <li class="is-active"><a href="#" aria-current="page">All Posts</a></li>
    </ul>
  </nav>

  <!-- Loop through posts and display each post -->
  @foreach($posts as $post)
  <div class="container is-max-desktop pb-3">
    <!-- Notification box for each post -->
    <div class="notification is-primary">
      <div style="background-color: gray; padding: 20px; margin:20px; border: 1px solid black;">
        <!-- Post title -->
        <h1 class='title'>{{ $post['title']}}</h1>
        <!-- Author's name -->
        <p><b>by {{$post->user->name}}</b></p>
        <br>
        <!-- Post body -->
        <h2 class="subtitle">{{ $post['body'] }}</h2>
        <!-- Display post image if available -->
        <div>
          @if($post->image_path !== null)
          <figure class="image is-128x128">
            <img src="{{ url('storage/images/'.$post->image_path)}}">
          </figure>
          @else
          @endif
        </div>
        <div style="text-align:right">
          <!-- Log in button for non-authenticated users -->
          <form action="/logins" method="GET">
            @csrf
            <button class="button is-info">
              Log in to comment
            </button>
            <br><br>
            <form action="/viewComments/{{$post->id}}" method="GET">
              <!-- View comments button -->
              <button class="button is-info">View comments for this post</button>
              <input type="hidden" name="post_id" value="{{ $post->id }}">
            </form>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endforeach
  <!-- End of post loop -->
  @endauth

  <!-- Modal for post deletion confirmation -->
  <div id="modal-js-delete" class="modal">
    <div class="modal-background"></div>

    <div class="modal-content">
      <div class="box">
        <h1>Are you sure you want to delete your post?</h1>
        <!-- Delete post form -->
        <form action="/delete-post/{{ $post->id }}" method="POST">
          @csrf
          @method('DELETE')
          <button class="button is-danger">Delete Post</button>
        </form>
      </div>
    </div>

    <button class="modal-close is-large" aria-label="close"></button>
  </div>

  <!-- JavaScript code for modal behavior -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Functions to open and close a modal
      function openModal($el) {
        $el.classList.add('is-active');
      }

      function closeModal($el) {
        $el.classList.remove('is-active');
      }

      function closeAllModals() {
        (document.querySelectorAll('.modal') || []).forEach(($modal) => {
          closeModal($modal);
        });
      }

      // Add a click event on buttons to open a specific modal
      (document.querySelectorAll('.js-modal-trigger') || []).forEach(($trigger) => {
        const modal = $trigger.dataset.target;
        const $target = document.getElementById(modal);

        $trigger.addEventListener('click', () => {
          openModal($target);
        });
      });

      // Add a click event on various child elements to close the parent modal
      (document.querySelectorAll('.modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button') || []).forEach(($close) => {
        const $target = $close.closest('.modal');

        $close.addEventListener('click', () => {
          closeModal($target);
        });
      });

      // Add a keyboard event to close all modals
      document.addEventListener('keydown', (event) => {
        if (event.code === 'Escape') {
          closeAllModals();
        }
      });
    });
  </script>
</body>

</html>
