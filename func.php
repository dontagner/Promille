<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function getDBConnection() {
    $host = "localhost";
    $dbname = "promille";
    $username = "root";
    $password = "";

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Databasanslutning misslyckades: " . $conn->connect_error);
    }

    // Sätt teckenkodning
    $conn->set_charset("utf8");

    return $conn;
}
?>
