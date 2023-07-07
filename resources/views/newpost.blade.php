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
    
    <div>
        
        <label for="image">Upload Image:</label>
        <input type="file" name="image">
    </div>
    

    
    <div>
        @if (session('imagePath'))
            <img src="{{ asset('storage/' . session('imagePath')) }}" alt="Uploaded Image" width="200">
        @endif
    </div>

    <button type="submit">Create Post</button>
</form>
