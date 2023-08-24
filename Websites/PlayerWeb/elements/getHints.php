<?php

    include "config.php";
    $hints = mysqli_fetch_array(mysqli_query($con, "SELECT hints FROM gamecontrol LIMIT 1"));
    $_SESSION['hints'] = intval($hints['hints']);
    echo $_SESSION['hints'];