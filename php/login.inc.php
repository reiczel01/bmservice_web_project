<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST["login_btn"]))
{
    $username = $_POST["username"];
    $password = $_POST["password"];

    require_once 'dbHandler.inc.php';
    require_once 'functions.inc.php';

    if(emptyInputLogin($username, $password) !== false)
    {
        header("Location: ../login.php?error=emptyinput");
        exit();
    }

    loginUser($conn, $username, $password);
    require_once notification();
}
elseif(isset($_POST["signup_btn"]))
{
    header("Location: ../signup.php");
    exit();
}
else
{
    header("Location: ../login.php");
    exit();
}
