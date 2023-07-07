<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>View Comments</title>
</head>
<body>
    
    <h3>{{ $post->title}} </h3>
            <p>{{ $post->body }}</p>

    <div style="border: 3px solid black;">
        <form action="/viewcomments" method="POST">
        @csrf
        @foreach($comments as $comment)
        <div style="border: .5px solid black;">
            <p>{{ $comment['text']}} by {{$comment->user->name}}  </p>
        @endforeach    
        </form>
    </div>
    
           
</body>
</html>