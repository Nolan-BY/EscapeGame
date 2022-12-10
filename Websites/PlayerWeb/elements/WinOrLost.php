<?php
    session_start();
    include "config.php";
    date_default_timezone_set('Europe/Paris');
    $_SESSION['result_date'] = date("r");
    mysqli_query($con,"UPDATE gamecontrol SET enddate='".$_SESSION['result_date']."' LIMIT 1");
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_SESSION['final_code'] == $_POST['final_code']) {
            $_SESSION['result'] = 'win';
        } else {
            $_SESSION['result'] = 'lost';
        }
        header("location: ../results.php");
    } else {
        $_SESSION['result'] = 'lost';
        header("location: ../results.php");
    }
    mysqli_query($con,"UPDATE gamecontrol SET result='".$_SESSION['result']."' LIMIT 1");