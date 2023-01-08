<?php

    include "config.php";

    // exécution d'une requête à la base de données pour récupérer les informations souhaitées
    $result = mysqli_query($con, "SELECT team_name, penalties, hints, finishdate, enddate, result, score FROM gamecontrol");

    // création d'un tableau pour stocker les résultats de la requête
    $data = array();

    // ajout des résultats de la requête au tableau
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    // renvoi des données sous forme de JSON
    echo json_encode($data);