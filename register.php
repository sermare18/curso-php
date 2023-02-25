<?php 

require "database.php";

#Creamos un error que enviaremos al cliente en caso de que rellene el formulario mal
$error = null;


if($_SERVER["REQUEST_METHOD"] == "POST") { 
  // Aunque hayamos hecho validación con el html, el cliente no siempre es un navegador (p.e: curl)
  // y por lo tanto puede esquivar ese tipo de validación, por lo que la validación 'buena'
  // la tendremos que poner aquí
  if(empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["password"]) ){
    $error = "Please fill all the fields.";
  } else if(!str_contains($_POST["email"], "@")){ 
    $error = "Email format is incorrect.";
  } else { //Aquí escribimos el código para alamacenar a los usuarios
    #Comprobamos si este usuario ya existe en la base de datos
    $statemet = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $statemet->bindParam(":email", $_POST["email"]);
    $statemet->execute();

    #Si ya existe le mandamos un error
    if ($statemet->rowCount() > 0){
      $error = "This email is already taken.";
    } else { //Se trata de un usuario nuevo
      $conn
        ->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)")
        ->execute([
          ":name" => $_POST["name"],
          ":email" => $_POST["email"],
          ":password" => password_hash($_POST["password"], PASSWORD_BCRYPT) //Las contraseñas hay que encriptarlas con un hash siempre
        ]);

        #Añadimos al usuario recien creado a una sesión (Es decir, al registrarnos nos logeamos automáticamente)

        #Buscamos al usuario recién creado en la base de datos
        $statemet = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $statemet->bindParam(":email", $_POST["email"]);
        $statemet->execute();

        #Guardamos los datos del usuario en la variable $user en forma de array asociativo
        $user = $statemet->fetch(PDO::FETCH_ASSOC);

        #Si no tienes una sesión asociada te crea una sesión en el servidor
        #En caso de que la tengas el navegador (cliente) manda la cookie al servidor para que este pueda acceder a la sesión.
        session_start(); 

        #Guardamos en la variable superglobal $_SESSION los datos que queramos almacenar durante la sesion
        unset($user["password"]);
        $_SESSION["user"] = $user;

        #Rederigimos al nuevo usuario a home.php
        header("Location: home.php");
    }
  }
}

?>
<!-- Reutilizamos código -->
<?php require "partials/header.php"; ?>

<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Register</div>
        <div class="card-body">
          <?php
          if ($error): //Lo mismo que ($error != null), es decir si tenemos errores ?>
            <p class="text-danger">
              <?= $error ?>
            </p>
          <?php endif ?>
          <form method="post" action="./register.php">  <!-- Como método http utiliza 'POST' para enviar, action hace referencia al archivo que va a dar respuesta a este formulario-->

            <!-- Sección nombre -->
            <div class="mb-3 row">
              <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

              <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>
              </div>
            </div>

            <!-- Sección email -->
            <div class="mb-3 row">
              <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

              <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus>
              </div>
            </div>
            
            <!-- Sección contraseña -->
            <div class="mb-3 row">
              <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>

              <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" required autocomplete="password" autofocus>
              </div>
            </div>

            <!-- Sección boton de submit -->
            <div class="mb-3 row">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Reutilizamos código -->
<?php require "partials/footer.php"; ?>
