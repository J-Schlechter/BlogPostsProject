<form action="/create-post" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label for="title">Post Title:</label>
        <input type="text" id="title" name="title" placeholder="Your post's title" required>
    </div>

    <div>
        <label for="body">Post Body:</label>
        <textarea id="body" name="body" placeholder="Write your post here!" required></textarea>
    </div>
    
    <div class="file is-normal">
        <label class="file-label">
          <input class="file-input" type="file" name="image">
          <span class="file-cta">
            <span class="file-icon">
              <i class="fas fa-upload"></i>
            </span>
            <span class="file-label">
              Normal file…
            </span>
          </span>
        </label>
      </div>
    

    
    

    <button type="submit">Create Post</button>
</form>
