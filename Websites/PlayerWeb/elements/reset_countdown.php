<?php

    if(isset($_SESSION['countdown'])) {
        unset($_SESSION['countdown']);
        header("location: ../index.php");
    }

    if(!isset($_SESSION['countdown'])) {
        header("location: ../error.php");
    }