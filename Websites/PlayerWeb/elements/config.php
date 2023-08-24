<?php
    $host = "127.0.0.1:3306";
    $user = "controlEG";
    $password = "controlEGPa55";
    $dbname = "escape_game_DB";

    $con = mysqli_connect($host, $user, $password, $dbname);
    if (!$con) {
        die("Connection error : " . mysqli_connect_error());
    }