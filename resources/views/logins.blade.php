<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <title>Log In</title>
</head>
<body style="background-image: url('https://cdn.pixabay.com/photo/2017/08/30/01/05/milky-way-2695569_1280.jpg');">
    <div class="container is-max-desktop pb-3">
        <div class="columns is-centered">
            <div class="column is-half">
                <h1 class = "title is-1" style="color: aliceblue">Log In</h1>
        <form action="/login" method="POST">
        @csrf
            <input class= "input" type="text" placeholder="name" name='name' style = "width: 33%">
            <br><br>
            <input class = "input" type="password" placeholder="password" name='password' style = "width: 33%">
            <br><br>
            @if ($error = $errors->first('password'))
            <article class="message is-danger">
                <div class="message-header">
                  <p>{{ $error }}</p>
                
                </div>
            </article>
            @endif
            <div class = "field">
                <div class = "control">
                    <button class = "button is-success">Log In</button>
                </div>
            </div>
        </form>
        <div class="control">
        <form action="/registernew" method="GET">
            @csrf
                <button class="button is-dark is-medium">Register</button></label>
            </form>
        </div>
    </div>
</div>
</div>
           
</body>
</html>