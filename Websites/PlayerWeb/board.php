<?php include('./elements/session.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg" href="./assets/favicon.svg">
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
            <br />&nbsp;<br />Les directives parviennent souvent par mail...
        </p>
        <form id='checkcode' action="./elements/WinOrLost.php" method="post">
            <input type="text" name="final_code" id="final_code" placeholder="Code secret" required>
            <input type="submit" id="valider" value="Valider">
        </form>
        <section id="mails">
            <p style="display: flex; margin: 0.5rem 1rem; font-size: 2rem; font-weight: 500;">Mails</p>
            <div class="mail">
                <div class="mail_header">
                    <p><b>Titre :</b> Catastrophe naturelle ! <b>[URGENT]</b>
                    <br><b>Exp. :</b> laetitia-rocher@irscn.fr (Responsable du pôle détection)&emsp;&emsp;<b>Dest. :</b> Équipe <?php echo $_SESSION['team_name']; ?>
                    <br><b>Date :</b> <?php echo date('d/m/Y H:i', strtotime($_SESSION['date']));?></p>
                </div>
                <div class="mail_corps">
                    <p>ATTENTION !
                    <br>&emsp;
                    <br>L'observatoire de l'IRSCN basé à Bourges a détecté qu'un tremblement de terre causé par une trop forte pression gazeuse souterraine allait se produire plus tard dans la journée !
                    <br>&emsp;
                    <br>Selon les instructions du plan de surveillance et d'action de l'IRSCN, vous devez entrer un code dans le champ de votre tableau de bord prévu à cet effet.
                    <br>Ce code aura pour effet d'ouvrir des trappes de dépressurisation afin d'empêcher ce tremblement de terre de survenir et d'entraîner une réaction en chaîne qui rendra la vie sur Terre impossible.
                    <br>&emsp;
                    <br>Conformément à la procédure, les scientifiques de l'IRSCN basé à Taiwan pourront vous envoyer les premières infos.
                    <br>Tant que ceux-ci seront touchés par un tremblement de terre artificiel que vous pouvez déclencher depuis vos bureaux, ils pourront effectuer des analyses et vous transmettre les premières infos.
                    <br>&emsp;
                    <br>Faites vite !
                    </p>
                </div>
            </div>
            <div class="mail">
                <div class="mail_header">
                    <p><b>Titre :</b> Attaques en phishing
                    <br><b>Exp. :</b> rene-fresne@irscn.fr (RSSI)&emsp;&emsp;<b>Dest. :</b> Tous
                    <br><b>Date :</b> 05/01/2023 09:25</p>
                </div>
                <div class="mail_corps">
                    <p>Bonjour,
                    <br>&emsp;
                    <br>De nombreuses attaques en phishing ont été détectées en ce moment sur les mails de l'IRSCN.
                    <br>&emsp;
                    <br>La DSI rappelle qu'AUCUN lien ne soit être ouvert et qu'AUCUNE pièce jointe ne doit être téléchargée depuis un mail qui ne provient pas de @irscn.fr ou qui ne provient pas d'un expéditeur vérifié !
                    <br>&emsp;
                    <br>Nous vous rappelons qu'il existe un service vers lequel vous pouvez envoyer les mails pour lesquels vous avez des doutes quant à la sécurité de leurs pièces jointes et liens et qui vous renvoie un avis après des tests poussés réalisés dans des environnements contrôlés.
                    <br>Vous pouvez aussi nous joindre le mail douteux que nous analyserons en personne si le service est inacessible ou si le doute persiste.
                    <br>&emsp;
                    <br>Dans TOUS LES CAS : demandez conseil et N'OUVREZ PAS de liens ou de pièces jointes non vérifiés sous peine d'une fermeture préventive du réseau voire de vol de données !
                    <br />&nbsp;<br />
                    <br>Cordialement,
                    <br>René Fresne, Responsable de la sécurité des systèmes d'information
                    </p>
                </div>
            </div>
            <div class="mail">
                <div class="mail_header">
                    <p><b>Titre :</b> Arbre de Noël et fêtes de fin d'année
                    <br><b>Exp. :</b> chandler-dupuy@irscn.fr (Secrétaire CSE)&emsp;&emsp;<b>Dest. :</b> Tous
                    <br><b>Date :</b> 05/11/2022 14:53</p>
                </div>
                <div class="mail_corps">
                    <p>Bonjour à tous,
                    <br>&emsp;
                    <br>Les fêtes de fin d'année arrivent et comme chaque année, l'IRSCN propose un événement pour tous les salariés de l'entreprise et leur famille.
                    <br>&emsp;
                    <br>Cette année, l'arbre de Noël se fera le 11 Décembre de 10h à 22h au parc du PAL privatisé pour l'occasion.
                    <br>Comme les années précédentes, la journée, le parc sera en visite libre pour tous, puis le soir un spectacle vous sera proposé ainsi qu'un buffet.
                    <br>&emsp;
                    <br>Nous vous attendons nombreux et nombreuses à cet événement de grande convivialité.
                    <br />&nbsp;<br />
                    <br>Cordialement,
                    <br>Chandler Dupuy
                    </p>
                </div>
            </div>
            <div class="mail" style="border-bottom: 0.2rem rgb(0, 0, 0) solid;">
                <div class="mail_header">
                    <p><b>Titre :</b> Machine à café
                    <br><b>Exp. :</b> christiane-guilmette@irscn.fr (DRH)&emsp;&emsp;<b>Dest. :</b> dep-jup1@deplistes.irscn.fr
                    <br><b>Date :</b> 20/10/2022 10:32</p>
                </div>
                <div class="mail_corps">
                    <p>Bonjour à toutes et à tous,
                    <br>&emsp;
                    <br>Je remarque que la machine à café de la salle Neptune est en panne depuis plusieurs jours. Or, celle-ci est essentielle au bon déroulement des réunions qui, vous le savez, sont périlleuses.
                    <br>&emsp;
                    <br>Je demande donc à toutes et à tous de participer à l'effort collectif en amenant des touillettes, gobelets, sucres et/ou sachets de café le temps que la machine soit réparée.
                    <br>&emsp;
                    <br>Merci à toutes les personnes qui contribueront à faire tenir les troupes lors de ces soporifiques réunions.
                    <br />&nbsp;<br />
                    <br>Cordialement,
                    <br>Christiane Guilmette
                    </p>
                </div>
            </div>
        </section>
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

        var countDownDate = new Date(Date.parse('<?php echo $_SESSION['date']; ?>')).getTime();
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
            document.getElementById('final_code').disabled = true;
            document.getElementById('valider').disabled = true;
            document.getElementById('indices').disabled = true;
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