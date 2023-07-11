<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <title>Home</title>
</head>
<body>
        
    <div class="columns is-mobile">
        <div class="column is-half is-offset-one-quarter">
        <h2 class = "title is-2">Register</h2>
        
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
    </div>
    </div>
</body>
</html>