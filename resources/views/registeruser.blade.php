<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <title>Home</title>
</head>
<body style="background-image: url('https://cdn.pixabay.com/photo/2017/08/30/01/05/milky-way-2695569_1280.jpg');">
        
    <div class="container is-max-desktop pb-3">
        <div class="columns is-centered">
            <div class="column is-half">
                <h1 class = "title is-1" style="color: aliceblue">Register</h1>
        
        <div class="column">
        <form action="/register" method="POST">
        @csrf
            <input class = "input is-info" type="text" placeholder="name" name='name'>
            <br><br>
            <input class = "input is-info" type="email" placeholder="email" name='email'>
            <br><br>
            <input class = "input is-info" type="password" placeholder="password" name='password'>
            <br><br>
            <button class="button is-success">Register</button>
        </form>
        <div>
                    <form action="/logins" method="GET">
                    @csrf
                        <button class="button is-dark is-medium">Log In</button></label>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>