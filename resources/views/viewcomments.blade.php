<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <title>View Comments</title>
</head>
<body>
    <div  class = "container  ">
        <section class="section is-centered" >
            <h3 class = "title">{{ $post->title}} by {{$post->user->name}} </h3>
            <p>{{ $post->body }}</p>
        </section>
    </div>
    <div >
        <section class = "section mx"> 
        <form action="/viewcomments" method="POST">
        @csrf
        
        <h2 class="title is-2"><br>Comments:<br></h2>
        @foreach($comments as $comment)
            <h6 class="title">{{$comment->user->name}}</h6>
            <h5 class="subtitle">{{ $comment['text']}}</h5>
                      
        @endforeach    
        </form>
    </div>
    </div> 
    </div>
               
</body>
</html>

