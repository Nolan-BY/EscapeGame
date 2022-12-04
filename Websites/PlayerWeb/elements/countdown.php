<?php

    if (!isset($_SESSION['date'])) {
        date_default_timezone_set('Europe/Paris');
        $_SESSION['date'] = date("r", strtotime("+100 sec"));
    }
