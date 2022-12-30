<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg" href="./assets/favicon.svg">
    <link rel="stylesheet" href="./css/main.css"/>
    <link rel="stylesheet" href="./css/decors.css"/>
    <link rel="stylesheet" href="./css/footer.css"/>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
    </style>
    <title>Escape Game - Dashboard</title>
</head>
<body>
    <header>
        <div class="nav-container">
            <div class="nav">
                <img class="logo" src="./assets/logo.svg" alt="" />
                <div class="nav-text">
                    <p>Tableau de bord des maîtres du jeu</p>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div id="timer_container">
            <p id="timer_panel_title">Timer</p>
            <section id="timer_panel">
                <p id="timer"></p>
            </section>
        </div>

        <div id="logs_container">
            <p id="logs_title">Logs</p>
            <section id="logs"></section>
        </div>

        <div id="hints_container">
            <p id="hints_panel_title">Indices</p>
            <section id="hints_panel">
                <div id="hints_alert">
                    <p>Un indice est demandé !</p>
                </div>
                <p id="hints"></p>
            </section>
        </div>

        <div id="penalties_container">
            <p id="penalties_panel_title">Pénalités</p>
            <section id="penalties_panel">
                <p id="penalties"></p>
            </section>
        </div>

        <div id="results_container">
            <section id="results"></section>
        </div>
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
    var previoushints;
    var updateSecInt;
    var logs_ids = [];

    updateSecInt = setInterval(updateSec, 1000);
    updateSec()

    function updateSec() {
        var team_name;
        var penalties;
        var hints;
        var finishdate;
        var enddate;
        var result;

        $.ajax({
            url:"./elements/getData.php",
            async: false,
            success:function(PHPdata){
                let data = JSON.parse(PHPdata)
                team_name = data[0].team_name;
                penalties = Number(data[0].penalties);
                hints = Number(data[0].hints);
                finishdate = data[0].finishdate;
                enddate = data[0].enddate;
                result = data[0].result;
            }
        });

        if (result == "none") {
            if (hints != 0) {
                if (hints == 1) {
                    document.getElementById('hints').innerText = `${hints} indice restant`;
                } else {
                    document.getElementById('hints').innerText = `${hints} indices restants`;
                }
                document.getElementById('hints').style.color = "black";
                document.getElementById('hints').style.fontWeight = "normal";
            } else {
                document.getElementById('hints').innerText = "Aucun indice restant !";
                document.getElementById('hints').style.color = "red";
                document.getElementById('hints').style.fontWeight = "bold";
            }

            if (previoushints > hints) {
                document.getElementById('hints_alert').style.animation = "alert 5s linear";
                setTimeout(() => {
                    document.getElementById('hints_alert').style.animation = "none";
                }, 5000);
            }

            document.getElementById('penalties').innerText = `${penalties} secondes de pénalité`;

            // var countDownDate = new Date(Date.parse(finishdate)).getTime();
            // var now = new Date().getTime();
            // var timeRemaining = (countDownDate - (penalties * 1000)) - now;

            // minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
            // seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

            // if(seconds < 10) {
            //     seconds = `0${seconds}`
            // }

            // if(timeRemaining > 0) {
            //     document.getElementsByClassName("countdown")[0].innerText = `${minutes}:${seconds}`;
            // } else {
            //     document.getElementsByClassName("countdown")[0].innerText = `L'équipe ${team_name} a perdu !`;
            //     document.body.style.backgroundColor = "rgba(198, 77, 77, 0.67)";
            //     document.getElementById('final_code').disabled = true;
            //     document.getElementById('valider').disabled = true;
            //     document.getElementById('indices').disabled = true;
            //     clearInterval(updateSecInt);
            //     window.location.replace("./elements/WinOrLost.php");
            // }

            // if(penalties >= 1) {
            //     document.getElementsByClassName("penalties")[0].innerText = `${penalties} secondes de pénalité`;
            //     document.getElementsByClassName("penalties")[0].style.color = "rgb(179, 0, 0)";
            // } else {
            //     document.getElementsByClassName("penalties")[0].innerText = `${penalties} seconde de pénalité`;
            //     document.getElementsByClassName("penalties")[0].style.color = "rgb(23, 201, 0)";
            // }

            previoushints = hints;

            // Chargement du fichier JSON
            fetch('game1-logs.json')
                .then(response => response.json())
                .then(data => {
                    var time_left_minutes = 0;
                    var time_left_seconds = 0;

                    // Récupération de la liste "logs"
                    const logs = data.logs;

                    // Pour chaque entrée dans la liste "logs"
                    logs.forEach(log => {
                        if (!logs_ids.includes(log.id)) {
                            // Création de l'élément div "log"
                            const logElement = document.createElement('div');
                            logElement.classList.add('log');
                            logElement.id = log.id;

                            // Création des éléments div "general", "enigma" et "game_stats"
                            const generalElement = document.createElement('div');
                            generalElement.classList.add('general');
                            const enigmaElement = document.createElement('div');
                            enigmaElement.classList.add('enigma');
                            const gameStatsElement = document.createElement('div');
                            gameStatsElement.classList.add('game_stats');

                            // Création des éléments p pour chaque entrée de données
                            const team_nameParagraph = document.createElement('p');
                            team_nameParagraph.style.fontWeight = "bold";
                            const dateParagraph = document.createElement('p');
                            const enigmaParagraph = document.createElement('p');
                            const statusParagraph = document.createElement('p');
                            const timeLeftParagraph = document.createElement('p');
                            const penaltiesParagraph = document.createElement('p');
                            const hintsParagraph = document.createElement('p');

                            // Création des nœuds de texte pour chaque entrée de données
                            const team_nameText = document.createTextNode("Équipe : " + data.team_name);
                            const dateText = document.createTextNode(log.date);

                            const enigmaText = document.createTextNode(log.enigma);
                            enigmaParagraph.style.fontWeight = "bold";

                            const statusText = document.createTextNode(log.status);
                            statusParagraph.style.fontWeight = "bold";
                            if (log.status == "Échouée") {
                                statusParagraph.style.color = "red";
                            } else if (log.status == "Demande") {
                                statusParagraph.style.color = "blue";
                            } else {
                                statusParagraph.style.color = "green";
                            }

                            time_left_minutes = Math.floor((log.time_left % (1000 * 60 * 60)) / (1000 * 60));
                            time_left_seconds = Math.floor((log.time_left % (1000 * 60)) / 1000);
                            const timeLeftText = document.createTextNode(time_left_minutes + ":" + time_left_seconds);

                            const penaltiesText = document.createTextNode("Pénalités : " + log.penalties + "s");
                            const hintsText = document.createTextNode(log.hints + " indices restants");

                            // Ajout des nœuds de texte aux éléments p correspondants
                            team_nameParagraph.appendChild(team_nameText);
                            dateParagraph.appendChild(dateText);
                            enigmaParagraph.appendChild(enigmaText);
                            statusParagraph.appendChild(statusText);
                            timeLeftParagraph.appendChild(timeLeftText);
                            penaltiesParagraph.appendChild(penaltiesText);
                            hintsParagraph.appendChild(hintsText);

                            // Ajout des nœuds de texte aux éléments div correspondants
                            generalElement.appendChild(team_nameParagraph);
                            generalElement.appendChild(dateParagraph);
                            enigmaElement.appendChild(enigmaParagraph);
                            enigmaElement.appendChild(statusParagraph);
                            enigmaElement.appendChild(timeLeftParagraph);
                            gameStatsElement.appendChild(penaltiesParagraph);
                            gameStatsElement.appendChild(hintsParagraph);

                            // Ajout des éléments enfants à l'élément "log"
                            logElement.appendChild(generalElement);
                            logElement.appendChild(enigmaElement);
                            logElement.appendChild(gameStatsElement);

                            // Ajout de l'élément "log" à la section d'ID "logs"
                            document.getElementById('logs').appendChild(logElement);
                            logElement.style.animation = "log 0.5s linear forwards";

                            logs_ids.push(log.id);

                            var logs_section = document.getElementById("logs");
                            logs_section.scrollTop = logs_section.scrollHeight;
                        }
                    });
                    for (let i = 0; i < logs_ids.length; i++) {
                        // Si l'identifiant n'est pas présent dans la liste "logs"
                        if (!logs.some(log => log.id === logs_ids[i])) {
                            // Récupération du div
                            const div = document.getElementById(logs_ids[i]);

                            // Si le div existe
                            if (div) {
                                // Récupération du parent du div
                                const parent = div.parentNode;

                                // Suppression du div
                                parent.removeChild(div);

                                // Suppression de l'identifiant de la liste "list"
                                logs_ids.splice(i, 1);

                                // Décrémentation de l'indice
                                i--;
                            }
                            var logs_section = document.getElementById("logs");
                            logs_section.scrollTop = logs_section.scrollHeight;
                        }
                    }
                });
        }
    }
</script>