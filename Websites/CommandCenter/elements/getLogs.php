<?php

    if (file_exists('/home/sae310/logs/game-logs.json')) {
        echo(json_encode(json_decode(file_get_contents('/home/sae310/logs/game-logs.json'), true)));
    } else {
        echo json_encode(['error' => 'Unable to decode JSON data']);
    }