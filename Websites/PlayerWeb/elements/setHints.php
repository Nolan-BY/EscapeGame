<?php

    include "config.php";
    $hints = mysqli_fetch_array(mysqli_query($con, "SELECT hints FROM gamecontrol LIMIT 1"));
    $_SESSION['hints'] = $hints['hints'];
    if($hints['hints'] > 0) {
        mysqli_query($con, "UPDATE gamecontrol SET hints=hints-1 LIMIT 1");
        mysqli_query($con, "UPDATE gamecontrol SET penalties=penalties+10 LIMIT 1");
    }
    $hints = mysqli_fetch_array(mysqli_query($con, "SELECT hints FROM gamecontrol LIMIT 1"));
    $_SESSION['hints'] = $hints['hints'];
    echo $_SESSION['hints'];