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
        header("location: ../login.php");
    } else {
        header("location: ../login.php");
        die();
    }