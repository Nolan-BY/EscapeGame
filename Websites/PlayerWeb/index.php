<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg" href="./assets/logo.svg">
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="./css/decorative.css" />
    <link rel="stylesheet" href="./css/alerte.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
    </style>
    <title>CNRS</title>
</head>
<body>
    <header>
        <div class="nav-container">
            <div class="nav">
                <a href="./" class="logo">
                    <img src="./assets/logo.svg" alt="" />
                </a>
                <div class="nav-buttons">
                    <a href="./error.php">Le CNRS</a>
                    <a href="./error.php">La Recherche</a>
                    <a href="./error.php">Innovation</a>
                    <a href="./error.php">International</a>
                    <div class="vertical-bar" style="margin-right: 4%;"></div>
                    <a target="_blank" href="./login.php">Login</a>
                </div>
            </div>
        </div>
        <?php include './elements/alert.php';?>
    </header>
</body>
</html>