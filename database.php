<?php 

#Definimos donde se encuentra el host de la base de datos
$host = "localhost";

#Definimos la base de datos sobre la cual deseamos trabajar
$database = "contacts_app";

#Definimos el usuario con el cual nos conectamos a la base de datos
$user = "root";

#Definimos la contraseña del usuario
$password = "";

#PDO es una librería de PHP que nos permite comunicarnos con bases de datos
try{
  $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
  #En PHP con '->' accedemos a los métodos y atrivutos de los objetos.
  #El método 'query' es propio de los objetos PDO y permite hacer consultas sql sobre ellos
  #'print_r' invoca al método 'toString' de los objetos
  // foreach ($conn->query("SHOW DATABASES") as $row){
  //   print_r($row);
  // }
  // die();
} catch (PDOException $e) {
  die("PDO Connection Error: " . $e->getMessage());
}

?>
