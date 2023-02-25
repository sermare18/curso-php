<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <!-- Para las rutas aunque aqí estemos en la carpeta partial tenemos que pensar en que al hacer el require nos encontraremos en otro sitio y plantear las rutas desde ese otro sitio -->
      <a class="navbar-brand font-weight-bold" href="index.php">
          <img class="mr-2" src="./static/img/logo.png" />
          ContactsApp
      </a>
      <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
      >
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" href="home.php">Home</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="add.php">Add Contact</a>
          </li>
          </ul>
      </div>
    </div>
</nav> 
