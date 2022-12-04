<?php
    session_start();
    $host = "localhost:3306";
    $user = "control";
    $password = "controlsae310";
    $dbname = "sae310";

    $con = mysqli_connect($host, $user, $password,$dbname);
    if (!$con) {
        die("Erreur de connexion : " . mysqli_connect_error());
    }