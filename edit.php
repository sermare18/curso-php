<pre>
<?php 

require "database.php";

#Obtenemos el id del contacto que queremos editar
#La variable get no siempre tiene contenido en este caso si por el query-string
$id = $_GET["id"];

#Comprobamos en la base de datos si el id existe
$statement = $conn->prepare("SELECT * FROM contacts WHERE id = :id LIMIT 1"); //Ponemos LIMIT para que la función fetch nos devuelva un array en vez de una matriz con el FETCH_ASSOC 

$statement->bindParam(":id", $id);

$statement->execute();

# Si no existe devolvemos el error 404 NOT FOUND y finalizamos
if ($statement->rowCount() == 0){
  http_response_code(404);
  echo("HTTP 404 NOT FOUND");
  return;
} 

#Guardamos la información del contacto extraida de la base de datos en un array asociativo
$contact = $statement->fetch(PDO::FETCH_ASSOC);

#Creamos un error que enviaremos al cliente en caso de que rellene el formulario mal
$error = null;

if($_SERVER["REQUEST_METHOD"] == "POST") { //Aquí es donde nos envian datos a través del formulario.

  if(empty($_POST["name"]) || empty($_POST["phone_number"])){

    $error = "Please fill all the fields.";

  } elseif (strlen($_POST["phone_number"]) < 9) { //Validanos el número de telefono

    $error = "Phone number must be at least 9 characters.";

  } else { //Si el formulario se rellena correctamente

  $name = $_POST["name"]; //POST es otra variable superglobal, que contiene un array asociativo conformado por las peticiones POST
  $phoneNumber = $_POST["phone_number"]; //En las variables utilizamos nomenclatura camel case y en los campos de la base de datos siempre van con '_'

  #Insercción de contactos a la base de datos con protección de inyecciones SQL
  $statement = $conn->prepare("UPDATE contacts SET name = :name, phone_number = :phone_number WHERE id = :id");
  $statement->execute([
    ":id" => $id, 
    ":name" => $_POST["name"],
    ":phone_number" => $_POST["phone_number"]
  ]);

  #Después de almacenar el nuevo contacto queremos que el navegador nos rediriga a 'index.php'
  header("Location: index.php");
  }
}

?>
</pre>

<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- Bootstrap -->
      <link
          rel="stylesheet" 
          href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.2.3/darkly/bootstrap.min.css" 
          integrity="sha512-YRcmztDXzJQCCBk2YUiEAY+r74gu/c9UULMPTeLsAp/Tw5eXiGkYMPC4tc4Kp1jx/V9xjEOCVpBe4r6Lx6n5dA==" 
          crossorigin="anonymous" 
          referrerpolicy="no-referrer" 
      />

      <script
          defer
          src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" 
          integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" 
          crossorigin="anonymous"
      ></script>

      <!--Static content-->
      <link rel="stylesheet" href="./static/css/index.css">

      <title>Contacts App</title>
  </head>
  <body>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
          <div class="container-fluid">
            <a class="navbar-brand font-weight-bold" href="#">
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
                  <a class="nav-link" href="./index.php">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="./add.php">Add Contact</a>
                </li>
              </ul>
            </div>
          </div>
      </nav> 

      <main>
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
                  <form method="post" action="edit.php?id=<?= $contact["id"] ?>">  <!-- Volvemos a pasar el id del contacto a editar a el archivo que va a dar respuesta al formulario, en nuestro caso es el mismo archivo -->
                    <div class="mb-3 row">
                      <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
        
                      <div class="col-md-6">
                        <input value="<?= $contact["name"] ?>" id="name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>
                      </div>
                    </div>
        
                    <div class="mb-3 row">
                      <label for="phone_number" class="col-md-4 col-form-label text-md-end">Phone Number</label>
        
                      <div class="col-md-6">
                        <input value="<?= $contact["phone_number"] ?>" id="phone_number" type="tel" class="form-control" name="phone_number" required autocomplete="phone_number" autofocus>
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
      </main>
  </body>
</html>
