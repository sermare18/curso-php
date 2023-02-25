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
        <?php $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);  //Para evitar que nos pasen un query string ?>
        <!-- Solo ejecutamos el script 'welcome.js' si nos encontramos en algunas de estas uri -->
        <?php if($uri == "/contacts-app/" || $uri == "/contacts-app/index.php"):?>
            <script defer src="./static/js/welcome.js"></script>
        <?php endif ?>

        <title>Contacts App</title>
    </head>
    <body>
        
      <!-- Reutilizamos código -->
      <?php require "navbar.php"; ?>

        <main>

        <!-- Content Here -->
