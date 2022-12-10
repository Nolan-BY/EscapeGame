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

    if (!isset($_SESSION['date'])) {
        date_default_timezone_set('Europe/Paris');
        $_SESSION['date'] = date("r", strtotime("+600 sec"));
        mysqli_query($con,"UPDATE gamecontrol SET startdate='".$_SESSION['date']."' LIMIT 1");
    }

    if (!isset($_SESSION['final_code'])) {
        $_SESSION['final_code'] = 30035;
    }