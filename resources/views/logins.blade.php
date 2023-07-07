<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log In</title>
</head>
<body>

    <div style = 'display:flex; justify-content:center;'>
        <h2>Log In</h2>
        <p></p>
        <form action="/login" method="POST">
        @csrf
        <div class="field">
            <label class="label">Name</label>
            <div class="control">
              <input class="input" type="text" placeholder="e.g Alex Smith" name = 'loginname'>
            </div>
          </div>
          
          <div class="field">
            <label class="label">Password</label>
            <div class="control">
              <input class="input" type="password"  name='loginpassword'>
            </div>
          </div>
            
            <button>Log In</button>
        </form>
    </div>
   
           
</body>
</html>