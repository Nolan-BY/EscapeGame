<?php

    include "config.php";
    $result = mysqli_fetch_array(mysqli_query($con, "SELECT penalties FROM gamecontrol LIMIT 1"));
    $_SESSION['penalties'] = $result['penalties'];
    echo $_SESSION['penalties'];