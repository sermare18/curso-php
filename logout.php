<?php
#Obtenemos los datos de la sesión en curso
session_start();

#Destruimos la sesión en curso
session_destroy();

#Redirigimos a index.php
header("Location: index.php");
