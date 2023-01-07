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
        <section id="upper">
            <div id="timer_container">
                <p id="timer_panel_title">Timer</p>
                <section id="timer_panel">
                    <p id="timer">Attente démarrage...</p>
                </section>
            </div>
        </section>

        <section id="lower">
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
        </section>

        <div id="results_container" style="display: none;">
            <p id="results_panel_title">Résultats</p>
            <section id="results_panel">
                <p id="results_team">TEST</p>
                <p id="results_status">Gagné</p>
                <p id="results_timeleft">222</p>
                <p id="results_penalties">222</p>
                <p id="results_hints">Placeholder</p>
                <p id="results_score">222</p>
            </section>
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

        console.log(result);

        if (result == "none") {
            document.getElementById("results_container").style.display = "none";
            if (finishdate != "none") {
                var countDownDate = new Date(Date.parse(finishdate)).getTime();
                var now = new Date().getTime();
                var timeRemaining = (countDownDate - (penalties * 1000)) - now;

                minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

                if(seconds < 10) {
                    seconds = `0${seconds}`
                }

                if(timeRemaining > 0) {
                    document.getElementById("timer").innerText = `${minutes}:${seconds}`;
                } else {
                    document.getElementById("timer").innerText = "Le temps est écoulé !";
                }
            } else {
                document.getElementById("timer").innerText = "Attente démarrage...";
            }

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

            previoushints = hints;
            logs()

        } else {

            logs()
            document.getElementById("results_container").style.display = "flex";

            // Need to retreive value from database based on enigmas success or fail
            var result_enigmas = 0;

            document.getElementById('results_team').innerHTML = `Équipe &thinsp;<b>${team_name}</b>`;

            if(result == 'win') {
                document.getElementById('results_status').innerHTML = "Victoire !";
                document.getElementById('results_status').style.color = 'rgb(0, 117, 6)';
                result_enigmas += 20;
            } else if(result == 'lost') {
                document.getElementById('results_status').innerHTML = "Défaite !";
                document.getElementById('results_status').style.color = 'rgb(179, 0, 0s)';
                result_enigmas -= 50;
            }
            
            var start = new Date(Date.parse(finishdate)).getTime();
            var end = new Date(Date.parse(enddate)).getTime();
            var timeRemaining = (start - (penalties * 1000)) - end;
            var minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

            if(seconds < 0) {
                seconds = 0;
            }
            if(minutes < 0) {
                minutes = 0;
            }

            var score = Math.floor(((((minutes * 60) + seconds) * 100) / 600) + result_enigmas);

            if(score < 0) {
                score = 0;
            }

            if(seconds < 10) {
                seconds = `0${seconds}`
            }

            if(minutes > 1 && seconds > 1) {
                document.getElementById('results_timeleft').innerHTML = `Il restait : &thinsp;<b>${minutes} minutes et ${seconds} secondes</b>`;
            } else if(minutes == 1 && seconds == 1) {
                document.getElementById('results_timeleft').innerHTML = `Il restait : &thinsp;<b>${minutes} minute et ${seconds} seconde</b>`;
            } else if(minutes == 1 && seconds > 1) {
                document.getElementById('results_timeleft').innerHTML = `Il restait : &thinsp;<b>${minutes} minute et ${seconds} secondes</b>`;
            } else if(minutes > 1 && seconds == 0) {
                document.getElementById('results_timeleft').innerHTML = `Il restait : &thinsp;<b>${minutes} minutes</b>`;
            } else if(minutes == 1 && seconds == 0) {
                document.getElementById('results_timeleft').innerHTML = `Il restait : &thinsp;<b>${minutes} minute</b>`;
            } else if(minutes == 0 && seconds > 1) {
                document.getElementById('results_timeleft').innerHTML = `Il restait : &thinsp;<b>${seconds} secondes</b>`;
            } else if(minutes == 0 && seconds == 1) {
                document.getElementById('results_timeleft').innerHTML = `Il restait : &thinsp;<b>${seconds} seconde</b>`;
            } else if(minutes == 0 && seconds == 0) {
                document.getElementById('results_timeleft').innerHTML = '<b>Le temps était écoulé !</b>';
            }

            if (penalties == 0) {
                document.getElementById('results_penalties').innerHTML = "Il n'y avait &thinsp;<b>aucun temps</b>&thinsp; de pénalité !";
            } else {
                document.getElementById('results_penalties').innerHTML = `Il y avait : &thinsp;<b>${penalties} secondes</b>&thinsp; de pénalité !`;
            }

            document.getElementById('results_score').innerHTML = `Le score final est de : &thinsp;<b>${score}</b>&thinsp; points !`;

            if (hints != 0) {
                if (6 - hints == 1) {
                    document.getElementById('results_hints').innerHTML = `&thinsp;<b>${6 - hints}</b>&thinsp; indice a été consommé !`;
                } else if (hints == 6) {
                    document.getElementById('results_hints').innerHTML = "<b>Aucun</b>&thinsp; indice n'a été consommé !";
                } else {
                    document.getElementById('results_hints').innerHTML = `&thinsp;<b>${6 - hints}</b>&thinsp; indices ont été consommés !`;
                }
            } else {
                document.getElementById('results_hints').innerText = "Il ne restait aucun indice !";
                document.getElementById('results_hints').style.color = "red";
                document.getElementById('results_hints').style.fontWeight = "bold";
            }
        }
    }

    function logs() {
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
</script>