<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <title>Edit Post</title>
</head>
<body>
    <div class="columns is-mobile">
        <div class="column is-half is-offset-one-quarter">    
    <h2 class = "title is-2">Edit Post</h2>
    
    <form action ="/edit-post/{{$post->id}}" method="POST">
    @csrf
    @method('PUT')
        <span class="tag is-black"> Title: <input class="input is-black" type = "text" name = "title" value = " {{$post->title}}"></span>
        <br><br><textarea cols="50" rows="8" name = "body">{{$post->body}}  </textarea>
        <br><br><button class="button is-success">Save changes</button>
    </form>

</body>
</html>