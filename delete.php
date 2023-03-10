<?php

require "database.php";

#Obtenemos los datos de la sesión
session_start();

if(!isset($_SESSION["user"])) { //Si no estamos logueados
  #Redirigimos a login.php
  header("Location: login.php");
  return; //Para no seguir ejecutando código de este archivo si no estamos autentificados
}

#Obtenemos el contenido de la query-string, es decir los datos (el id del contacto a eliminar) de la url del boton de borrar contacto presente en home.php
#Esta variable superglobal no siempre tiene datos unicamente si nosotros así lo hemos configurado
#Nos guardamos el id del contacto a eliminar
$id = $_GET["id"];

#Comprobamos en la base de datos si el id existe
$statement = $conn->prepare("SELECT * FROM contacts WHERE id = :id LIMIT 1");

$statement->bindParam(":id", $id);

$statement->execute();

# Si no existe devolvemos el error 404 NOT FOUND y finalizamos
if ($statement->rowCount() == 0){
  http_response_code(404);
  echo("HTTP 404 NOT FOUND");
  return;
} 

#Guardamos en contact la información del contacto que vamos a eliminar
$contact = $statement->fetch(PDO::FETCH_ASSOC);

#Incrementamos la seguridad para que un usuario no puede eliminar contactos de otro usuario a través del string-query
if($contact["user_id"] != $_SESSION['user']['id']){
  http_response_code(403); //Código que indica que no estás autorizado para hacer esta operación
  echo("HTTP 403 UNAUTHORIZED");
  return;
}

#Borramos de la base de datos el contacto protegiendonos de las inyecciones SQL (Esta vez de otra forma sin utilizar bindParam, en su lugar agregamos un array asociativo al parametro de execute)
$conn->prepare("DELETE FROM contacts WHERE id = :id")->execute([":id" => $id]);

#Creamos en la variable superglobal session un atributo que hace referencia a un mensaje flash
$_SESSION["flash"] = ["message" => "Contact {$contact['name']} deleted.", "type" => "danger"];

#Redirigimos a home.php
header("Location: home.php");

?>
