<?php
    if(!array_key_exists('countdown', $_SESSION)){
        $_SESSION['countdown'] = 100;
    }

    if(!isset($_SESSION['countdown'])) {
        $_SESSION['countdown'] = 100;
    }