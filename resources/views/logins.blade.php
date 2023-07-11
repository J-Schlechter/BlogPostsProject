<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <title>Log In</title>
</head>
<body>

    <div class="columns is-mobile">
        <div class="column is-half is-offset-half">
        <h2 class = "title is-2">Log In</h2>
        <form action="/login" method="POST">
        @csrf
            <input class= "input" type="text" placeholder="name" name='loginname' style = "width: 33%">
            <br><br>
            <input class = "input" type="password" placeholder="password" name='loginpassword' style = "width: 33%">
            <br><br>
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
           
</body>
</html>