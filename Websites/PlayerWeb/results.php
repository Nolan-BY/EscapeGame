<?php
    session_start();
    if(!isset($_SESSION['user']) && !isset($_SESSION['result'])) {
        header("location: ../login.php");
    } elseif(isset($_SESSION['user']) && !isset($_SESSION['result'])) {
        header("location: ../board.php");
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg" href="./assets/favicon.svg">
    <link rel="stylesheet" href="./css/results.css"/>
    <link rel="stylesheet" href="./css/decors.css"/>
    <link rel="stylesheet" href="./css/footer.css"/>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
    </style>
    <title>IRSCN - Résultats</title>
</head>
<body>
    <header>
        <div class="nav-container">
            <div class="nav">
                <img class="logo" src="./assets/logo.svg" alt="" />
                <div class="nav-text">
                    <p>Résultats</p>
                </div>
            </div>
        </div>
    </header>
    <main>
        <p id="team">
            <?php 
                if(isset($_SESSION['team_name'])){
                    if($_SESSION['result'] == 'win') {
                        echo 'Bravo équipe &thinsp;<b>'.$_SESSION['team_name'].'</b> !';
                    } else {
                        echo 'Dommage équipe &thinsp;<b>'.$_SESSION['team_name'].'</b> !';
                    }
                }
            ?>
        </p>
        <p id="result_text">
            <?php 
                if(isset($_SESSION['team_name'])){
                    if($_SESSION['result'] == 'win') {
                        echo 'Vous avez gagné !';
                    } else {
                        echo 'Vous avez perdu !';
                    }
                } else {
                    echo 'Dommage, vous avez perdu !';
                }
            ?>
        </p>
        <p id="time"></p>
        <p id="penalties"></p>
        <p id="hints"></p>
        <p id="score"></p>
    </main>
    <footer style="position: relative;">
        <p>Copyright 2022 - Meilleur groupe du TP1</p>
    </footer>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    var result = '<?php echo $_SESSION['result']; ?>';

    // Need to retreive value from database based on enigmas success or fail
    var result_enigmas = 0;

    if(result == 'win') {
        document.getElementById('result_text').style.color = 'rgb(0, 117, 6)';
        result_enigmas += 20;
    } else if(result == 'lost') {
        document.getElementById('result_text').style.color = 'rgb(179, 0, 0)';
        result_enigmas -= 50;
    }

    var penalties = 0;
    var hints = 0;
    $.ajax({
        url:"./elements/penalties.php",
        async: false,
        success:function(data){
            penalties = data;
        }
    });

    $.ajax({
        url:"./elements/getHints.php",
        async: false,
        success:function(data){
            hints = 6-data;
        }
    });

    var start = new Date(Date.parse('<?php echo $_SESSION['finishdate']; ?>')).getTime();
    var end = new Date(Date.parse('<?php echo $_SESSION['result_date']; ?>')).getTime();
    var timeRemaining = (start - (penalties * 1000)) - end;
    var minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

    var score = Math.floor(((((minutes * 60) + seconds) * 100) / 600) + result_enigmas);

    if(score < 0) {
        score = 0;
    }

    if(seconds < 0) {
        seconds = 0;
    }
    if(minutes < 0) {
        minutes = 0;
    }

    if(seconds < 10) {
        seconds = `0${seconds}`
    }

    if(minutes > 1 && seconds > 1) {
        document.getElementById('time').innerHTML = `Il vous restait : &thinsp;<b>${minutes} minutes et ${seconds} secondes</b>`;
    } else if(minutes == 1 && seconds == 1) {
        document.getElementById('time').innerHTML = `Il vous restait : &thinsp;<b>${minutes} minute et ${seconds} seconde</b>`;
    } else if(minutes == 1 && seconds > 1) {
        document.getElementById('time').innerHTML = `Il vous restait : &thinsp;<b>${minutes} minute et ${seconds} secondes</b>`;
    } else if(minutes > 1 && seconds == 0) {
        document.getElementById('time').innerHTML = `Il vous restait : &thinsp;<b>${minutes} minutes</b>`;
    } else if(minutes == 1 && seconds == 0) {
        document.getElementById('time').innerHTML = `Il vous restait : &thinsp;<b>${minutes} minute</b>`;
    } else if(minutes == 0 && seconds > 1) {
        document.getElementById('time').innerHTML = `Il vous restait : &thinsp;<b>${seconds} secondes</b>`;
    } else if(minutes == 0 && seconds == 1) {
        document.getElementById('time').innerHTML = `Il vous restait : &thinsp;<b>${seconds} seconde</b>`;
    } else if(minutes == 0 && seconds == 0) {
        document.getElementById('time').innerHTML = '<b>Votre temps était écoulé !</b>';
    }

    document.getElementById('penalties').innerHTML = `Vous aviez : &thinsp;<b>${penalties} secondes</b>&thinsp; de pénalité !`;

    document.getElementById('hints').innerHTML = `Vous avez consommé : &thinsp;<b>${hints}</b>&thinsp; indices !`;

    document.getElementById('score').innerHTML = `Votre score final est de : &thinsp;<b>${score}</b>&thinsp; points !`;
</script>