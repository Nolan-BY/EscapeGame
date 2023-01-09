<?php

    include "config.php";
    session_start();
    $hints = mysqli_fetch_array(mysqli_query($con, "SELECT hints FROM gamecontrol LIMIT 1"));
    $_SESSION['hints'] = $hints['hints'];
    if($hints['hints'] > 0) {
        mysqli_query($con, "UPDATE gamecontrol SET hints=hints-1 LIMIT 1");
        mysqli_query($con, "UPDATE gamecontrol SET penalties=penalties+10 LIMIT 1");
    }

    $hints = mysqli_fetch_array(mysqli_query($con, "SELECT hints FROM gamecontrol LIMIT 1"));
    $_SESSION['hints'] = $hints['hints'];

    $penalties = mysqli_fetch_array(mysqli_query($con, "SELECT penalties FROM gamecontrol LIMIT 1"));
    $_SESSION['penalties'] = $penalties['penalties'];

    date_default_timezone_set('Europe/Paris');
    $timeRemaining = ((strtotime($_SESSION['finishdate']) - $penalties['penalties']) - strtotime(date("r")));

    if (file_exists('/home/sae310/logs/game-logs.json')) {
        $logsFile = fopen('/home/sae310/logs/game-logs.json', 'r');
        $logsData = file_get_contents('/home/sae310/logs/game-logs.json');

        $logs = json_decode($logsData, true);

        fclose($logsFile);

        $logs['logs'][] = array(
            "id" => 'Hint'.strval($timeRemaining),
            "enigma" => "Indice",
            "time" => date('H:i:s'),
            "status" => "Demande",
            "time_left" => $timeRemaining,
            "penalties" => $_SESSION['penalties'],
            "hints" => $_SESSION['hints']
        );

        $logsFile = fopen('/home/sae310/logs/game-logs.json', 'w');

        fwrite($logsFile, json_encode($logs));
        fclose($logsFile);
    }

    echo $_SESSION['hints'];