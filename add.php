<?php 

require "database.php";

#Creamos un error que enviaremos al cliente en caso de que rellene el formulario mal
$error = null;

#Variables superglobales, disponibles en cualquier web que utilice php.

#Variable _SERVER: Contiene información acerca de la petición HTTP que nos manda el usuario.
//var_dump($_SERVER);
//die();
if($_SERVER["REQUEST_METHOD"] == "POST") { //Aquí es donde nos envian datos a través del formulario.

  if(empty($_POST["name"]) || empty($_POST["phone_number"])){

    $error = "Please fill all the fields.";

  } elseif (strlen($_POST["phone_number"]) < 9) { //Validanos el número de telefono

    $error = "Phone number must be at least 9 characters.";

  } else { //Si el formulario se rellena correctamente

  $name = $_POST["name"]; //POST es otra variable superglobal, que contiene un array asociativo conformado por las peticiones POST
  $phoneNumber = $_POST["phone_number"]; //En las variables utilizamos nomenclatura camel case y en los campos de la base de datos siempre van con '_'

  #Insercción de contactos a la base de datos
  $statement = $conn->prepare("INSERT INTO contacts (name, phone_number) VALUES (:name, :phone_number)");

  #Para prevenir inyecciones SQL
  $statement->bindParam(":name", $_POST["name"]);
  $statement->bindParam(":phone_number", $_POST["phone_number"]);

  #Ejecutamos la sentencia
  $statement->execute();

  #Después de almacenar el nuevo contacto queremos que el navegador nos rediriga a 'index.php'
  header("Location: index.php");
  }
}

?>
<!-- Reutilizamos código -->
<?php require "partials/header.php"; ?>

<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Add New Contact</div>
        <div class="card-body">
          <?php
          if ($error): //Lo mismo que ($error != null), es decir si tenemos errores ?>
            <p class="text-danger">
              <?= $error ?>
            </p>
          <?php endif ?>
          <form method="post" action="./add.php">  <!-- Como método http utiliza 'POST' para enviar, action hace referencia al archivo que va a dar respuesta a este formulario-->
            <div class="mb-3 row">
              <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

              <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="phone_number" class="col-md-4 col-form-label text-md-end">Phone Number</label>

              <div class="col-md-6">
                <input id="phone_number" type="tel" class="form-control" name="phone_number" required autocomplete="phone_number" autofocus>
              </div>
            </div>

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
