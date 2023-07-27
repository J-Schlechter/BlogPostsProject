<template>
  <nav class="navbar is-primary" role="navigation" aria-label="main navigation">
    <!-- Navbar brand/logo -->
    <div class="navbar-brand">
      <a class="navbar-item" href="/">
        <figure class="image-is-520x520">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTO8oyb6fe_lzSVWIrAhdO9rCWCWeVzkkREuUvx6lVZXZq-ZvgVP4yF85RmE0FstWdhSJ4&usqp=CAU">
        </figure>
      </a>
      <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="true" data-target="navbarBasicExample">
        <!-- Hamburger icon for mobile navigation -->
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>
    </div>

    <!-- Navbar menu items -->
    <div id="navbaBlog" class="navbar-menu">
      <div class="navbar-start">
        <a class="navbar-item" href="/">Home</a>
        <a class="navbar-item">|</a>
        <a class="navbar-item js-modal-trigger" data-target="modal-js-newPost">New Post</a>

      </div>
      <div class="navbar-end">
        <!-- Display the authenticated user's name -->
        <div class="navbar-item">
          
        </div>
        <div class="navbar-item">
          <!-- Logout button -->
          <div class="buttons">
            <form action="/logout" method="POST">
              
              <button class="button is-danger" onclick="/logout">
                Log Out
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
export default{

}
</script>