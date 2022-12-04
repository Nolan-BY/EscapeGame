<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg" href="./assets/logo.svg">
    <link rel="stylesheet" href="./css/main.css" />
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
        <div class="alerte-info" style="display: flex;">
            <div class="alerte-info-container">
                <div class="logo-alerte-info">
                    <img src="../assets/alert.png" alt="" />
                    <p style="margin-top: 0;">Alerte Info</p>
                </div>
                <p class="alerte-info-description">Une catastrophe naturelle est sur le point de se produire !<br>Tous les scientifiques sont priés de se connecter via la page de Login !</p>
            </div>
        </div>
    </header>
    <main>
        <!-- Les logins sont souvents oubliés... -->
        <section class="quick-cards">
            <!-- Pour éviter une catastrophe, il existe des codes de secours encryptés UNIQUEMENT utilisables par les chercheurs de l'IUT R&T ! -->
            <div class="card" id="first-card" style="background-image: url('./assets/faille.jpg');">
                <a href="./error.php">
                    <p class="card-category">Tremblements de terre</p>
                    <p class="card-title">S'informer et prévenir les catastrophes</p>
                    <img src="./assets/arrow.svg" alt="">
                </a>
            </div>
            <div class="card" style="background-image: url('./assets/iut.png');">
                <a href="./error.php">
                    <p class="card-category">Recherche</p>
                    <!-- Login : 69757463686572636865757273 -->
                    <!-- Mot de passe : 6e6f5f65617274687175616b65 -->
                    <p class="card-title">Les étudiants de l'IUT R&T en première ligne</p>
                    <img src="./assets/arrow.svg" alt="">
                </a>
            </div>
        </section>
    </main>
    <footer>
        <p>Copyright 2022 - Meilleur groupe du TP1</p>
    </footer>
</body>
</html>