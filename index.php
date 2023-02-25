<?php

#Importamos la base de datos
require "database.php";

#Si llegamos aquí quiere decir que tenemos disponible la variable de conexión a la base de datos 'conn'
$contacts = $conn->query("SELECT * FROM contacts");

?>

<!-- Reutilizamos código -->
<?php require "partials/header.php"; ?>

<div class="container pt-4 p-3">
    <div class="row">
    <?php if ($contacts->rowCount() == 0): ?>
        <div class="col-md-4 mx-auto">
            <div class="card card-body text-center">
                <p>No contacts saved yet</p>
                <a href="./add.php">Add one!</a>
            </div>
        </div>
    <?php endif ?>

    <?php foreach($contacts as $contact) : ?>
        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="card-title text-capitalize"><?= $contact["name"] ?></h3>
                    <p class="m-2"><?= $contact["phone_number"] ?></p>
                    <a href="edit.php?id=<?= $contact["id"] ?>" class="btn btn-secondary mb-2">Edit Contact</a>
                    <!-- Esto se hace para mandar información desde la propia url, se llama query string-->
                    <a href="delete.php?id=<?= $contact["id"] ?>" class="btn btn-danger mb-2">Delete Contact</a>
                </div>
        </div>
    </div>
    <?php endforeach ?>

</div>

<?php require "partials/footer.php"; ?>
