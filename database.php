<?php
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "inventory_system";
    $conn = "";

    try {
        $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    } catch (mysqli_sql_exception) {
        echo "Error connecting to Database <br>";
    }

    if ($conn) {
        echo "CONNECTED TO DB <br>";
    }

?>