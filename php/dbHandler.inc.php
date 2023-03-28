<?php

$server = "db_web";
$dbUsername = "root";
$dbPassword = "my-new-password";
$dbName = "mbservice";

$conn = mysqli_connect($server, $dbUsername, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
