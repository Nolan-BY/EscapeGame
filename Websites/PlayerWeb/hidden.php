<?php include('./elements/session.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg" href="./assets/favicon.svg">
    <link rel="stylesheet" href="./css/hidden.css"/>
    <link rel="stylesheet" href="./css/decors.css"/>
    <link rel="stylesheet" href="./css/footer.css"/>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
    </style>
    <title>IRSCN - Numéro d'urgence</title>
</head>
<body>
    <header>
        <div class="nav-container">
            <div class="nav">
                <img class="logo" src="./assets/logo.svg" alt="" />
                <div class="nav-text">
                    <p>Numéro d'urgence</p>
                    <div class="vertical-bar" style="margin: 0 5rem 0 5rem;"></div>
                    <div class="countdown">10</div>
                </div>
                <p class="penalties">- x secondes</p>
                <button id="indices" onclick="requestHint()" type="button">6/6 indices</button>
            </div>
        </div>
    </header>
    <main>
        <p id="tel_text">En cas d'urgence grave, un numéro direct pour l'observatoire de l'IRSCN est disponible sur cette page.
            <br />&nbsp;<br />Veullez ne pas encombrer la ligne en cas d'urgence et ne pas appeler si la situation ne le requiert pas.
        </p>
        <p id='tel'>06 56 76 78 61</p>
    </main>
    <footer style="position: relative;">
        <p>Copyright 2022 - Meilleur groupe du TP1</p>
    </footer>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script type="text/javascript">
    var minutes = 0;
    var seconds = 0;
    var previouspenalties = 0;
    var hints = 0;
    var updateSecInt;

    $.ajax({
        url:"./elements/getHints.php",
        async: false,
        success:function(data){
            hints = data;
            document.getElementById('indices').innerText = `${hints}/6 indices`;
            if(hints != 0) {
                document.getElementById('indices').disabled = false;
            }
        }
    });

    updateSecInt = setInterval(updateSec, 1000);
    updateSec()

    function updateSec() {
        var penalties = 0;
        $.ajax({
            url:"./elements/penalties.php",
            async: false,
            success:function(data){
                penalties = data;
            }
        });

        if(penalties > previouspenalties) {
            document.body.style.backgroundColor = "rgba(198, 77, 77, 0.67)";
        } else {
            document.body.style.backgroundColor = "rgba(131, 131, 131, 0.671)";
        }

        var countDownDate = new Date(Date.parse('<?php echo $_SESSION['finishdate']; ?>')).getTime();
        var now = new Date().getTime();
        var timeRemaining = (countDownDate - (penalties * 1000)) - now;

        minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
        seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

        if(seconds < 10) {
            seconds = `0${seconds}`
        }

        if(timeRemaining > 0) {
            document.getElementsByClassName("countdown")[0].innerText = `${minutes}:${seconds}`;
        } else {
            document.getElementsByClassName("countdown")[0].innerText = "Vous avez perdu !";
            document.body.style.backgroundColor = "rgba(198, 77, 77, 0.67)";
            clearInterval(updateSecInt);
            window.location.replace("./elements/WinOrLost.php");
        }

        if(penalties >= 1) {
            document.getElementsByClassName("penalties")[0].innerText = `${penalties} secondes de pénalité`;
            document.getElementsByClassName("penalties")[0].style.color = "rgb(179, 0, 0)";
        } else {
            document.getElementsByClassName("penalties")[0].innerText = `${penalties} seconde de pénalité`;
            document.getElementsByClassName("penalties")[0].style.color = "rgb(23, 201, 0)";
        }

        previouspenalties = penalties;
    }

    function requestHint() {
        document.getElementById('indices').disabled = true;
        $.ajax({
            url:"./elements/setHints.php",
            async: false,
            success:function(data){
                hints = data;
                document.getElementById('indices').innerText = `${hints}/6 indices`;
                if(hints == 0) {
                    document.getElementById('indices').disabled = true;
                } else {
                    document.getElementById('indices').disabled = false;
                }
            }
        });
    }
</script>