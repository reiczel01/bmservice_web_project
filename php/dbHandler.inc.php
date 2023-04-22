<?php

$server = "db_web";
$dbUsername = "root";
$dbPassword = "my-new-password";
$dbName = "bmservice";

$conn = mysqli_connect($server, $dbUsername, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
