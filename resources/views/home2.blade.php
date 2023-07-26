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
  <div id="app">
    <div>
    <navbar></navbar>
    </div>
  </div>



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
  <div id="app">
    <div>
    <navbar></navbar>
    </div>
  </div>



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

  <script defer src="{{mix('js/app.js')}}"></script>
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
