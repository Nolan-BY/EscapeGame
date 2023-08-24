<?php

    session_start();

    include "config.php";

    $game_logs = '/home/escape_game/logs/game-logs.json';

    copy($game_logs, '/home/escape_game/logs-archives/'.$_SESSION['team_name'].'-logs.json');
    unlink($game_logs);

    if (isset($_SESSION['score'])) {
        unset($_SESSION['score']);
        mysqli_query($con,"UPDATE gamecontrol SET score='0' LIMIT 1");
    }

    mysqli_query($con, "UPDATE gamecontrol SET result_enigmas='0' LIMIT 1");

    if (isset($_SESSION['final_code'])) {
        unset($_SESSION['final_code']);
        mysqli_query($con,"UPDATE gamecontrol SET final_code='30035' LIMIT 1");
    }

    if (isset($_SESSION['penalties'])) {
        unset($_SESSION['penalties']);
        mysqli_query($con,"UPDATE gamecontrol SET penalties='0' LIMIT 1");
    }

    if (isset($_SESSION['hints'])) {
        unset($_SESSION['hints']);
        mysqli_query($con,"UPDATE gamecontrol SET hints='6' LIMIT 1");
    }

    if (isset($_SESSION["finishdate"])) {
        unset($_SESSION["finishdate"]);
        mysqli_query($con,"UPDATE gamecontrol SET finishdate='none' LIMIT 1");
    }

    if (isset($_SESSION["final_code"])) {
        unset($_SESSION["final_code"]);
    }

    if(isset($_SESSION['team_name'])) {
        unset($_SESSION['team_name']);
        mysqli_query($con,"UPDATE gamecontrol SET team_name='none' LIMIT 1");
    }

    if(isset($_SESSION['result_date'])) {
        unset($_SESSION['result_date']);
        mysqli_query($con,"UPDATE gamecontrol SET enddate='none' LIMIT 1");
    }

    if(isset($_SESSION['result'])) {
        unset($_SESSION['result']);
        mysqli_query($con,"UPDATE gamecontrol SET result='none' LIMIT 1");
    }

    if(isset($_SESSION['user'])) {
        unset($_SESSION['user']);
    }

    session_destroy();
    header("location: ../index.php");