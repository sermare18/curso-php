<?php

require "database.php";

#Obtenemos el contenido de la query-string, es decir los datos (el id del contacto a eliminar) de la url del boton de borrar contacto presente en home.php
#Esta variable superglobal no siempre tiene datos unicamente si nosotros así lo hemos configurado
#Nos guardamos el id del contacto a eliminar
$id = $_GET["id"];

#Comprobamos en la base de datos si el id existe
$statement = $conn->prepare("SELECT * FROM contacts WHERE id = :id");

$statement->bindParam(":id", $id);

$statement->execute();

# Si no existe devolvemos el error 404 NOT FOUND y finalizamos
if ($statement->rowCount() == 0){
  http_response_code(404);
  echo("HTTP 404 NOT FOUND");
  return;
} 

#Borramos de la base de datos el contacto protegiendonos de las inyecciones SQL (Esta vez de otra forma sin utilizar bindParam, en su lugar agregamos un array asociativo al parametro de execute)
$conn->prepare("DELETE FROM contacts WHERE id = :id")->execute([":id" => $id]);

#Redirigimos a home.php
header("Location: home.php");

?>
