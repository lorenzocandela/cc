<?php
if (strpos($_SERVER['HTTP_HOST'], 'lorenzocandela.netsons.org') === 0) {
    $servername = "localhost";
    $username = "droraxjt_wp82";
    $password = "Ciaociam23.01";
    $dbname = "droraxjt_wp82";
} else {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_negozio";
}

// conn
$conn = new mysqli($servername, $username, $password, $dbname);

// check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>