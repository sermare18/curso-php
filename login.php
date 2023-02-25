<?php 

require "database.php";

#Creamos un error que enviaremos al cliente en caso de que rellene el formulario mal
$error = null;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Aunque hayamos hecho validación con el html, el cliente no siempre es un navegador (p.e: curl)
  // y por lo tanto puede esquivar ese tipo de validación, por lo que la validación 'buena'
  // la tendremos que poner aquí
  if (empty($_POST["email"]) || empty($_POST["password"])) {
    $error = "Please fill all the fields.";
  } else if (!str_contains($_POST["email"], "@")) {
    $error = "Email format is incorrect.";
  } else {
    #Comprobamos si este usuario ya existe en la base de datos
    $statemet = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
    $statemet->bindParam(":email", $_POST["email"]);
    $statemet->execute();

    #Si el usuario que quiere iniciar sesión no existe
    if ($statemet->rowCount() == 0) {
      $error = "Invalid credentials.";
    } else { //Si si que se trata de un usuario que esta registrado en la base de datos
      #Obtenemos los datos del usuario en un array asociativo
      $user = $statemet->fetch(PDO::FETCH_ASSOC);

      #Verificamos que la contraseña que nos han dado es la correcta
      #Si la contraseña no es la correcta al correo asociado mandamos el siguiente error
      if (!password_verify($_POST["password"], $user["password"])) { //Esta función comprueba si el hash de la contraseña de la base de datos coincide con la contraseña que introduce el usuario en el formulario
        $error = "Invalid credentials.";
      } else { //En este caso la contraseña y el correo coinciden 
        #Creamos una sesión para el usuario en concreto
        session_start(); //Si no tienes una sesión asociada te crea una sesión en el servidor; en caso de que la tengas el navegador manda la cookie al servidor para que este pueda acceder a la sesión.

        #Indicamos a la variable superglobal $_SESION el contenido que nostros queremos que almacene
        #Eliminamos el campo passwor de la variabale $user ya que no lo necesitamos
        unset($user["password"]);

        #Guardamos en la variable $_SESSION["user"] toda la información del usuario logeado excepto su contraseña
        $_SESSION["user"] = $user;

        header("Location: home.php");
      }
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
        <div class="card-header">Login</div>
        <div class="card-body">
          <?php
          if ($error): //Lo mismo que ($error != null), es decir si tenemos errores ?>
            <p class="text-danger">
              <?= $error ?>
            </p>
          <?php endif ?>
          <form method="post" action="./login.php">  <!-- Como método http utiliza 'POST' para enviar, action hace referencia al archivo que va a dar respuesta a este formulario-->

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
