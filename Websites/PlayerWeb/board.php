<?php include('./elements/session.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg" href="./assets/favicon.svg">
    <script type="text/javascript" src="./js/cowntdown.js"></script>
    <link rel="stylesheet" href="./css/board.css"/>
    <link rel="stylesheet" href="./css/decors.css"/>
    <link rel="stylesheet" href="./css/footer.css"/>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
    </style>
    <title>IRSCN - Dashboard</title>
</head>
<body>
    <header>
        <div class="nav-container">
            <div class="nav">
                <img class="logo" src="./assets/logo.svg" alt="" />
                <div class="nav-text">
                    <p>Tableau de bord</p>
                    <div class="vertical-bar" style="margin: 0 5rem 0 5rem;"></div>
                    <div class="countdown">10</div>
                </div>
                <p class="penalties">- x secondes</p>
                <button id="indices" onclick="requestHint()" type="button">6/6 indices</button>
            </div>
        </div>
    </header>
    <main>
        <p id="intro_text">Un gigantesque tremblement de terre a été détecté et se produira dans les prochaines minutes !
            <br>L'Institut de Recherche Scientifique sur les Catastrophes Naturelles a mis au point un dispositif permettant de contrer cette menace !
            <br />&nbsp;<br />Seul le bon code rentré dans le champ ci-dessous pourra activer ce système et sauver l'humanité !
            <br>Plusieurs dispositifs de sécurité ont été mis en place afin de garantir que le système ne puisse pas être abusé.
            <br />&nbsp;<br />Les directives parviennent souvent par mail...</p>
        <form onsubmit="checkCode()" method="post">
            <input type="text" name="final_code" id="final_code" placeholder="Code secret" required>
            <input type="submit" id="valider" value="Valider">
        </form>
        <section id="mails">
            <div class="mail">
                <div class="mail_header">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec nibh nulla, sagittis in augue euismod, ornare semper nibh. Praesent aliquet magna vitae risus gravida, sed ultricies dolor maximus.</p>
                </div>
                <div class="mail_corps">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec nibh nulla, sagittis in augue euismod, ornare semper nibh. Praesent aliquet magna vitae risus gravida, sed ultricies dolor maximus. Donec maximus lectus quis ligula egestas, ac fringilla urna vestibulum. Mauris est lectus, dictum eget efficitur vitae, convallis a ante. In ut dolor eu justo aliquam posuere. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis vitae mi non leo finibus ultricies vel sit amet tellus. Ut leo nisi, aliquet non gravida sed, sollicitudin in tortor. Suspendisse sit amet ligula a tortor scelerisque rutrum. </p>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>Copyright 2022 - Meilleur groupe du TP1</p>
    </footer>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script type="text/javascript">
    var previouspenalties = 0;
    function countdown() {
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

        var countDownDate = new Date(Date.parse('<?php echo $_SESSION['date']; ?>')).getTime();
        var now = new Date().getTime();
        var timeRemaining = (countDownDate - (penalties * 1000)) - now;

        var minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

        if(seconds < 10) {
            seconds = `0${seconds}`
        }

        if(timeRemaining > 0) {
            document.getElementsByClassName("countdown")[0].innerText = `${minutes}:${seconds}`;
        } else {
            document.getElementsByClassName("countdown")[0].innerText = "Le temps est écoulé !";
            document.body.style.backgroundColor = "rgba(198, 77, 77, 0.67)";
            document.getElementById('final_code').disabled = true;
            document.getElementById('valider').disabled = true;
            document.getElementById('indices').disabled = true;
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

    setInterval(countdown, 1000);
    countdown()
</script>