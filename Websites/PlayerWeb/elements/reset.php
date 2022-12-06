<?php

    session_start();

    if (isset($_SESSION['penalties'])) {
        include "config.php";
        unset($_SESSION['penalties']);
        mysqli_query($con,"UPDATE gamecontrol SET penalties='0' LIMIT 1");
    }

    if (isset($_SESSION["date"])) {
        unset($_SESSION["date"]);
    }

    if (isset($_SESSION["final_code"])) {
        unset($_SESSION["final_code"]);
    }

    if(isset($_SESSION['user'])){
        unset($_SESSION['user']);
    }

    session_destroy();
    header("location: ../index.php");

    // WHERE penalties=(SELECT penalties FROM gamecontrol LIMIT 1)