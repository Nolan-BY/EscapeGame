<?php

    session_start();

    if (!isset($_SESSION['penalties'])) {
        include "config.php";
        $result = mysqli_fetch_array(mysqli_query($con, "SELECT penalties FROM gamecontrol LIMIT 1"));
        $_SESSION['penalties'] = $result['penalties'];
    }

    if (!isset($_SESSION['date'])) {
        date_default_timezone_set('Europe/Paris');
        $_SESSION['date'] = date("r", strtotime("+100 sec"));
    }

    if (!isset($_SESSION['final_code'])) {
        $_SESSION['final_code'] = 30035;
    }