<?php
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      session_start();
      include "config.php";

      $username = mysqli_real_escape_string($con, $_POST['username']);
      $password = mysqli_real_escape_string($con, $_POST['password']);
		
      $result = mysqli_fetch_array(mysqli_query($con, "SELECT count(*) as cntUser FROM users WHERE username='".$username."' AND password='".$password."'"));

      if($result['cntUser'] > 0){
         $_SESSION['team_name'] = $_POST['team_name'];
         mysqli_query($con,"UPDATE gamecontrol SET team_name='".$_SESSION['team_name']."' LIMIT 1");

         mysqli_query($con, "UPDATE gamecontrol SET result_enigmas=result_enigmas+5 LIMIT 1");

         $_SESSION['user'] = $_SESSION['team_name'];

         $hints = mysqli_fetch_array(mysqli_query($con, "SELECT hints FROM gamecontrol LIMIT 1"));
         $_SESSION['hints'] = intval($hints['hints']);
         $penalties = mysqli_fetch_array(mysqli_query($con, "SELECT penalties FROM gamecontrol LIMIT 1"));
         $_SESSION['penalties'] = intval($penalties['penalties']);

         date_default_timezone_set('Europe/Paris');
         $timeRemaining = ((strtotime($_SESSION['finishdate']) - $_SESSION['penalties']) - strtotime(date("r")));

         if (file_exists('/home/escape_game/logs/game-logs.json')) {
            $logsFile = fopen('/home/escape_game/logs/game-logs.json', 'r');
            $logsData = file_get_contents('/home/escape_game/logs/game-logs.json');

            $logs = json_decode($logsData, true);

            fclose($logsFile);

            $logs['logs'][] = array(
               "id" => 'Log'.strval($timeRemaining),
               "enigma" => "Login",
               "time" => date('H:i:s'),
               "status" => "Réussie",
               "time_left" => $timeRemaining,
               "penalties" => $_SESSION['penalties'],
               "hints" => $_SESSION['hints']
            );

            $logs['team_name'] = $_SESSION['team_name'];

            $logsFile = fopen('/home/escape_game/logs/game-logs.json', 'w');

            fwrite($logsFile, json_encode($logs));
            fclose($logsFile);
         }

         header("location: ../board.php");
      } else {
         mysqli_query($con, "UPDATE gamecontrol SET penalties=penalties+10 LIMIT 1");

         mysqli_query($con, "UPDATE gamecontrol SET result_enigmas=result_enigmas-10 LIMIT 1");

         $penalties = mysqli_fetch_array(mysqli_query($con, "SELECT penalties FROM gamecontrol LIMIT 1"));
         $_SESSION['penalties'] = intval($penalties['penalties']);
         $hints = mysqli_fetch_array(mysqli_query($con, "SELECT hints FROM gamecontrol LIMIT 1"));
         $_SESSION['hints'] = intval($hints['hints']);

         date_default_timezone_set('Europe/Paris');
         $timeRemaining = ((strtotime($_SESSION['finishdate']) - $_SESSION['penalties']) - strtotime(date("r")));

         if (file_exists('/home/escape_game/logs/game-logs.json')) {
            $logsFile = fopen('/home/escape_game/logs/game-logs.json', 'r');
            $logsData = file_get_contents('/home/escape_game/logs/game-logs.json');

            $logs = json_decode($logsData, true);

            fclose($logsFile);

            $logs['logs'][] = array(
               "id" => 'Log'.strval($timeRemaining),
               "enigma" => "Login",
               "time" => date('H:i:s'),
               "status" => "Échouée",
               "time_left" => $timeRemaining,
               "penalties" => $_SESSION['penalties'],
               "hints" => $_SESSION['hints']
            );

            $logsFile = fopen('/home/escape_game/logs/game-logs.json', 'w');

            fwrite($logsFile, json_encode($logs));
            fclose($logsFile);
         }

         header("location: ../login.php");
      }
   }