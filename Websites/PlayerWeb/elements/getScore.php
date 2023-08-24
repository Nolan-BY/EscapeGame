<?php

    include "config.php";
    $score = mysqli_fetch_array(mysqli_query($con, "SELECT score FROM gamecontrol LIMIT 1"));
    $_SESSION['score'] = intval($score['score']);
    echo $_SESSION['score'];