<?php

    include "config.php";

    if (!isset($_SESSION['penalties'])) {
        $penalties = mysqli_fetch_array(mysqli_query($con, "SELECT penalties FROM gamecontrol LIMIT 1"));
        $_SESSION['penalties'] = $penalties['penalties'];
    }

    if (!isset($_SESSION['hints'])) {
        $hints = mysqli_fetch_array(mysqli_query($con, "SELECT hints FROM gamecontrol LIMIT 1"));
        $_SESSION['hints'] = $hints['hints'];
    }

    if (!isset($_SESSION['finishdate'])) {
        date_default_timezone_set('Europe/Paris');
        $_SESSION['finishdate'] = date("r", strtotime("+1200 sec"));
        mysqli_query($con,"UPDATE gamecontrol SET finishdate='".$_SESSION['finishdate']."' LIMIT 1");

        date_default_timezone_set('Europe/Paris');
        $timeRemaining = ((strtotime($_SESSION['finishdate']) - $penalties['penalties']) - strtotime(date("r")));

        $game_logs = '/home/sae310/logs/game-logs.json';
        $logsFile = fopen($game_logs, 'w');

        $logs = array(
            "team_name" => "not_set",
            "logs" => [ array(
                "id" => 'Init'.strval($timeRemaining),
                "enigma" => "Init",
                "time" => date('H:i:s'),
                "status" => "Résolue",
                "time_left" => $timeRemaining,
                "penalties" => $penalties['penalties'],
                "hints" => $hints['hints']
                )
            ]
        );

        fwrite($logsFile, json_encode($logs));
        fclose($logsFile);
    }

    if (!isset($_SESSION['final_code'])) {
        $_SESSION['final_code'] = 30035;
    }