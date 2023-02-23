<?php

if(file_exists("contacts.json")){
    #Decodificamos el archivo 'contacts.json' para pasarlo a un array
    #  -> La función 'file_get_contents' convierte el archivo a un string
    #  -> La función 'json_decode' transforma el string en un array asociativo, o a lo que corresponda como una lista
    $contacts = json_decode(file_get_contents("contacts.json"), true);
} else {
    $contacts = [];
}

?>

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
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./add.php">Add Contact</a>
                </li>
                </ul>
            </div>
            </div>
        </nav> 

        <main>
            <div class="container pt-4 p-3">
                <div class="row">
                <?php if (count($contacts) == 0): ?>
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
                                <a href="#" class="btn btn-secondary mb-2">Edit Contact</a>
                                <a href="#" class="btn btn-danger mb-2">Delete Contact</a>
                            </div>
                    </div>
                </div>
                <?php endforeach ?>

            </div>
        </main>
    </body>
</html>
