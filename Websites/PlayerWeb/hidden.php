<?php include('./elements/session.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg" href="./assets/logo.svg">
    <script type="text/javascript" src="./js/cowntdown.js"></script>
    <link rel="stylesheet" href="./css/board.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
    </style>
    <title>IRSCN - Secret</title>
</head>
<body>
    <header>
        <div class="nav-container">
            <div class="nav">
                <img class="logo" src="./assets/logo.svg" alt="" />
                <div class="nav-text">
                    <div class="countdown">10</div>
                </div>
            </div>
        </div>
    </header>
    <main>
        <p>Code Infrarouge secret pour le coffre fort</p>
    </main>
    <footer>
        <p>Copyright 2022 - Meilleur groupe du TP1</p>
    </footer>
</body>
</html>
<script type="text/javascript">
    function countdown() {
        var countDownDate = new Date(Date.parse('<?php echo $_SESSION['date']; ?>')).getTime();
        var now = new Date().getTime();
        var timeRemaining = countDownDate - now;

        var minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

        if(timeRemaining > 0) {
            document.getElementsByClassName("countdown")[0].innerText = `${minutes}:${seconds}`;
        } else {
            document.getElementsByClassName("countdown")[0].innerText = "Time's up!";
        }
    }

    setInterval(countdown, 1000);
    countdown()
</script>