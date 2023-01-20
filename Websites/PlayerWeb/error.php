<?php
   session_start();
    if(isset($_SESSION['result'])) {
        header("location: ../results.php");
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg" href="./assets/favicon.svg">
    <link rel="stylesheet" href="./css/error.css" />
    <link rel="stylesheet" href="./css/decors.css"/>
    <link rel="stylesheet" href="./css/footer.css"/>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
    </style>
    <title>IRSCN - Erreur</title>
</head>
<body>
    <div class="logo">
        <img src="./assets/logo.svg" alt="" />
    </div>
    <div class="text">
        <p>Une erreur est survenue en essayant de charger cette page<br>Essayez une autre page</p>
    </div>
    <footer>
        <p style="margin-bottom: 0;">Copyright 2023 - Meilleur groupe du TP1<br><p style="font-size: 0.5rem;">Ou le code source de la page...</p></p>
    </footer>
</body>
</html>