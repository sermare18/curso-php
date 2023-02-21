<?php $contacts = ["Pepe", "Antonio", "Nate"]; ?>
<?php //<?= Para que me devuelva un valor  ?>
<?php foreach($contacts as $contact) { ?>
  <?php if ($contact != "Pepe") { ?>
    <div><?= $contact ?></div>  
  <?php } ?>
<?php } ?>

<?php
/* Lo de arriba es equivalente a esto utilizando la función print() */
foreach($contacts as $contact){
  if ($contact != "Pepe"){
    print("<div>$contact</div>" . PHP_EOL);
  }
}

?>
