<template>
    @foreach($posts as $post)
  <div class="container is-max-desktop pb-3">
    <!-- Notification box for each post -->
    <div class="notification is-primary">
      <div style="background-color: gray; padding: 20px; margin:20px; border: 1px solid black;">
        <!-- Post title -->
        <h1 class='title'> $post['title']</h1>
        <!-- Author's name -->
        <p><b>by $post->user->name</b></p>
        <br>
        <!-- Post body -->
        <h2 class="subtitle"> $post['body'] </h2>
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
                <label for="author"> Commenting as auth()->user()->name </label>
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
</template>


<script>
export default{

}
</script>