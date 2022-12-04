<?php
    session_start();
    if(isset($_SESSION['user'])){
        header("location: ../board.php");
        die();
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg" href="./assets/logo.svg">
    <script type="text/javascript" src="./js/cowntdown.js"></script>
    <link rel="stylesheet" href="./css/login.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
    </style>
    <title>CNRS - Login</title>
</head>
<body>
    <header>
        <div class="nav-container">
            <div class="nav">
                <a href="./index.php" class="logo">
                    <img src="./assets/logo.svg" alt="" />
                </a>
                <div class="nav-text">
                    <p>Accès au tableau de bord privé du CNRS</p>
                    <div class="vertical-bar" style="margin-right: 4%;"></div>
                    <div class="countdown">10:00:00</div>
                </div>
            </div>
        </div>
    </header>
    <main>
        <?php
            include ('./elements/access.php');
            if (isset($failed)) { ?>
                <p id="error"><?php echo $error; ?></p>
            <?php }
        ?>
        <form action="./elements/access.php" method="post">
            <input type="text" name="username" id="username" placeholder="Identifiant" required>
            <input type="password" name="password" id="password" placeholder="Mot de passe" required>
            <input type="text" name="team_name" id="team-name" placeholder="Nom d'équipe" required>
            <input type="submit" id="connecter" value="Se connecter">
        </form>
    </main>
    <footer>
        <p>Copyright 2022 - Meilleur groupe du TP1</p>
    </footer>
</body>
</html>
<script type="text/javascript">
    <?php include ('./elements/countdown.php'); ?>
    var timeRemaining = <?php echo $_SESSION['countdown']; ?>;
    var downloadTimer = setInterval(function () {
        if (timeRemaining > 0) {
            document.getElementsByClassName("countdown")[0].innerText = `${timeRemaining} secs left`;
            <?php $_SESSION['countdown'] -= 1; ?>;
            timeRemaining = <?php echo $_SESSION['countdown']; ?>;
        }

        if (timeRemaining <= 0) {
            clearInterval(downloadTimer);
            document.getElementsByClassName("countdown")[0].innerText = "Time's up!";
        }
    }, 1000);
</script>