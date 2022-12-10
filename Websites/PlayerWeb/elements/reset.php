<?php

    session_start();

    include "config.php";

    if (isset($_SESSION['penalties'])) {
        unset($_SESSION['penalties']);
        mysqli_query($con,"UPDATE gamecontrol SET penalties='0' LIMIT 1");
    }

    if (isset($_SESSION['hints'])) {
        unset($_SESSION['hints']);
        mysqli_query($con,"UPDATE gamecontrol SET hints='6' LIMIT 1");
    }

    if (isset($_SESSION["date"])) {
        unset($_SESSION["date"]);
    }

    if (isset($_SESSION["final_code"])) {
        unset($_SESSION["final_code"]);
    }

    if(isset($_SESSION['team_name'])) {
        unset($_SESSION['team_name']);
    }

    if(isset($_SESSION['user'])) {
        unset($_SESSION['user']);
    }

    session_destroy();
    header("location: ../index.php");