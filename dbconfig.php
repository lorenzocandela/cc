<?php
if (strpos($_SERVER['HTTP_HOST'], 'http://cc.lorenzoo.it') === 0) {
    $servername = "localhost";
    $username = "cc_user";
    $password = "lorenzo";
    $dbname = "cc";
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