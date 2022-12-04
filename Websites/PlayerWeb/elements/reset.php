<?php

    session_start();

    if (!isset($_SESSION["date"])) {
        header("location: ../error.php");
    } else {
        unset($_SESSION["date"]);
        header("location: ../index.php");
    }

    if(isset($_SESSION['user'])){
        session_destroy();
        header("location: ../index.php");
    } else {
        header("location: ../index.php");
        die();
    }