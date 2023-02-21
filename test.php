<?php

$contacts = ["Pepe", "Antonio", "Nate"]; //Las variables siempre comienzan por '$'

/* Bucle for each*/
foreach($contacts as $contact){
  print("<div>$contact</div>" . PHP_EOL); //El '.' es para concatenar, semejante a '+' en otros lenguajes
}

?>

<!-- Todo lo que vaya despues de '?>' se interpreta como html y se imprime incluido este comentario -->
<div>
  <p>Hola Mundo</p>
</div>
