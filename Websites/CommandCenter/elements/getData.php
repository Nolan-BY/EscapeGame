<?php

    include "config.php";

    // Database query to retrieve the desired information
    $result = mysqli_query($con, "SELECT team_name, penalties, hints, finishdate, enddate, result, score FROM gamecontrol");

    // Array creation to store query results
    $data = array();

    // Add query results to table
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Return data as JSON
    echo json_encode($data);