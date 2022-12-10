<?php

    include "config.php";
    $penalties = mysqli_fetch_array(mysqli_query($con, "SELECT penalties FROM gamecontrol LIMIT 1"));
    $_SESSION['penalties'] = $penalties['penalties'];
    echo $_SESSION['penalties'];