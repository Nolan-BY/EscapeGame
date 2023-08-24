<?php
    session_start();
    include "config.php";
    date_default_timezone_set('Europe/Paris');
    $_SESSION['result_date'] = date("r");
    mysqli_query($con,"UPDATE gamecontrol SET enddate='".$_SESSION['result_date']."' LIMIT 1");

    $hints = mysqli_fetch_array(mysqli_query($con, "SELECT hints FROM gamecontrol LIMIT 1"));
    $_SESSION['hints'] = intval($hints['hints']);
    $penalties = mysqli_fetch_array(mysqli_query($con, "SELECT penalties FROM gamecontrol LIMIT 1"));
    $_SESSION['penalties'] = intval($penalties['penalties']);

    date_default_timezone_set('Europe/Paris');
    $timeRemaining = ((strtotime($_SESSION['finishdate']) - $_SESSION['penalties']) - strtotime(date("r")));

    mysqli_query($con, "UPDATE gamecontrol SET result_enigmas=result_enigmas-50 LIMIT 1");

    if($_SESSION['final_code'] == $_POST['final_code']) {
        mysqli_query($con, "UPDATE gamecontrol SET result_enigmas=result_enigmas+70 LIMIT 1");
    }

    $result_enigmas = mysqli_fetch_array(mysqli_query($con, "SELECT result_enigmas FROM gamecontrol LIMIT 1"));

    $minutes = floor(($timeRemaining / 60));
    $seconds = $timeRemaining % 60;
    $score = floor((((($minutes * 60) + $seconds) * 100) / 1200) + $result_enigmas["result_enigmas"] - (5 * ($hints['hints'])));

    if ($score < 0) {
        $score = 0;
    }

    $_SESSION['score'] = $score;
    
    mysqli_query($con,"UPDATE gamecontrol SET score='".$score."' LIMIT 1");

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_SESSION['final_code'] == $_POST['final_code']) {
            $_SESSION['result'] = 'win';

            if (file_exists('/home/escape_game/logs/game-logs.json')) {
                $logsFile = fopen('/home/escape_game/logs/game-logs.json', 'r');
                $logsData = file_get_contents('/home/escape_game/logs/game-logs.json');

                $logs = json_decode($logsData, true);

                fclose($logsFile);

                $logs['logs'][] = array(
                    "id" => 'FCode'.strval($timeRemaining),
                    "enigma" => "Code Final",
                    "time" => date('H:i:s'),
                    "status" => "Réussie",
                    "time_left" => $timeRemaining,
                    "penalties" => $_SESSION['penalties'],
                    "hints" => $_SESSION['hints'],
                    "score" => $score
                );

                $logsFile = fopen('/home/escape_game/logs/game-logs.json', 'w');

                fwrite($logsFile, json_encode($logs));
                fclose($logsFile);
            }
        } else {
            $_SESSION['result'] = 'lost';

            if (file_exists('/home/escape_game/logs/game-logs.json')) {
                $logsFile = fopen('/home/escape_game/logs/game-logs.json', 'r');
                $logsData = file_get_contents('/home/escape_game/logs/game-logs.json');

                $logs = json_decode($logsData, true);

                fclose($logsFile);

                $logs['logs'][] = array(
                    "id" => 'FCode'.strval($timeRemaining),
                    "enigma" => "Code Final",
                    "time" => date('H:i:s'),
                    "status" => "Échouée",
                    "time_left" => $timeRemaining,
                    "penalties" => $_SESSION['penalties'],
                    "hints" => $_SESSION['hints'],
                    "score" => $score
                );

                $logsFile = fopen('/home/escape_game/logs/game-logs.json', 'w');

                fwrite($logsFile, json_encode($logs));
                fclose($logsFile);
            }
        }
    } else {
        $_SESSION['result'] = 'lost';

        if (file_exists('/home/escape_game/logs/game-logs.json')) {
            $logsFile = fopen('/home/escape_game/logs/game-logs.json', 'r');
            $logsData = file_get_contents('/home/escape_game/logs/game-logs.json');

            $logs = json_decode($logsData, true);

            fclose($logsFile);

            $logs['logs'][] = array(
                "id" => 'FCode'.strval($timeRemaining),
                "enigma" => "Code Final",
                "time" => date('H:i:s'),
                "status" => "Échouée",
                "time_left" => $timeRemaining,
                "penalties" => $_SESSION['penalties'],
                "hints" => $_SESSION['hints'],
                "score" => $score
            );

            $logsFile = fopen('/home/escape_game/logs/game-logs.json', 'w');

            fwrite($logsFile, json_encode($logs));
            fclose($logsFile);
        }
    }
    header("location: ../results.php");
    mysqli_query($con,"UPDATE gamecontrol SET result='".$_SESSION['result']."' LIMIT 1");