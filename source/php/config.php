<?php
    //Start connection to the server
    define("DB_SERVER", "localhost");
    define("DB_USERNAME", "root");
    define("DB_PASSWORD", "");
    define("DB_NAME", "clever_campus");

    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    //check for connection
    if ($link === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    } 
    //connect if successfull
        // echo "Connect successfully. Host info: " . mysqli_get_host_info($link);

        
    // mysqli_close($link);
?>